<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.09.17
 * Time: 06:24
 */

namespace CoreBundle\Listener\EventListener;

use CoreBundle\Entity\Config;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class LocaleEventListener
 * @package CoreBundle\Listener\EventListener
 */
class LocaleEventListener implements EventSubscriberInterface
{
    /** @var TranslatorInterface */
    private $translator;

    /** @var array */
    private $languages;

    /** @var  RouterInterface */
    private $router;

    /** @var EntityManagerInterface */
    private $em;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * LocaleEventListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param TranslatorInterface $translator
     * @param RouterInterface $router
     * @param EntityManagerInterface $em
     * @param array $languages
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        TranslatorInterface $translator,
        RouterInterface $router,
        EntityManagerInterface $em,
        array $languages
    )
    {
        $this->translator = $translator;
        $this->router = $router;
        $this->em = $em;
        $this->languages = $languages;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (strpos($request->getUri(), $this->router->generate('sonata_admin_redirect')) !== false) {
            $this->setAdminLocale($request);
            return;
        }
        $locale = $request->attributes->get('_locale');
        if (!$locale) {
            $locale = $request->getDefaultLocale();
        }
        if (!in_array($locale, $this->languages)) {
            $event->setResponse(new RedirectResponse(str_replace(
                '/' . $locale . '/',
                '/' . $request->getDefaultLocale() . '/',
                $request->getUri())));
            return;
        }
        $request->setLocale($locale);
        $this->translator->setLocale($locale);
    }

    /**
     * @param Request $request
     */
    private function setAdminLocale(Request $request): void
    {
        $session = $request->getSession();
        $locale = $session->get('_locale');
        if (!$locale) {
            /** @var Config $config */
            $config = $this->em->getRepository(Config::class)->findOneBy(['user' => $this->tokenStorage->getToken()->getUser()]);
            $locale = $config->getLocale();
            $session->set('_locale', $locale);
        }
        $request->setLocale($locale);
        $this->translator->setLocale($locale);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => [['onKernelRequest', 7]],
        );
    }
}
