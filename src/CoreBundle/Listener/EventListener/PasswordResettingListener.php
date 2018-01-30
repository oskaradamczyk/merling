<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 10.11.17
 * Time: 22:34
 */

namespace CoreBundle\Listener\EventListener;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class PasswordResettingListener
 * @package CoreBundle\Listener\EventListener
 */
class PasswordResettingListener
{
    /** @var RouterInterface */
    private $router;

    /** @var SessionInterface */
    private $session;

    /** @var TranslatorInterface */
    private $translator;

    /** @var int */
    private $ttl;

    /** @var string */
    private $superAdminEmail;

    /**
     * PasswordResettingListener constructor.
     * @param RouterInterface $router
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     * @param int $ttl
     * @param string $superAdminEmail
     */
    public function __construct(RouterInterface $router, SessionInterface $session, TranslatorInterface $translator, int $ttl, string $superAdminEmail)
    {
        $this->router = $router;
        $this->session = $session;
        $this->translator = $translator;
        $this->ttl = $ttl;
        $this->superAdminEmail = $superAdminEmail;
    }

    /**
     * @param FormEvent $event
     */
    public function onPasswordResettingSuccess(FormEvent $event): void
    {
        $url = $this->router->generate('admin_core_user_edit', ['id' => $event->getForm()->getData()->getId()]);
        $event->setResponse(new RedirectResponse($url));
    }

    /**
     * @param GetResponseUserEvent $event
     */
    public function onSendEmailCompleted(GetResponseUserEvent $event): void
    {
        $locale = $event->getRequest()->getLocale();
        $url = $this->router->generate('fos_user_security_login', ['_locale' => $locale]);
        $this->session->getFlashBag()->add('warning', $this->translator->trans('core.fos_user.reset_request', [], null, $locale));
        $event->setResponse(new RedirectResponse($url));
    }

    /**
     * @param GetResponseUserEvent $event
     */
    public function onSendEmailInitialize(GetResponseUserEvent $event): void
    {
        $user = $event->getUser();
        if (!$user) {
            $locale = $event->getRequest()->getLocale();
            $url = $this->router->generate('fos_user_resetting_request', ['_locale' => $locale]);
            $this->session->getFlashBag()->add(
                'error',
                $this->translator->trans('core.fos_user.not_found', [], null, $locale)
            );
            $event->setResponse(new RedirectResponse($url));
            return;
        }
        if ($user->isPasswordRequestNonExpired($this->ttl)) {
            $locale = $event->getRequest()->getLocale();
            $url = $this->router->generate('fos_user_security_login', ['_locale' => $locale]);
            $this->session->getFlashBag()->add(
                'error',
                $this->translator->trans('core.fos_user.reset_request_blocked', ['%email%' => $this->superAdminEmail], null, $locale)
            );
            $event->setResponse(new RedirectResponse($url));
        }
    }
}