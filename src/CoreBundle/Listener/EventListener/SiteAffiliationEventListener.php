<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.09.17
 * Time: 05:34
 */

namespace CoreBundle\Listener\EventListener;


use CoreBundle\Manager\SiteAffiliationManager;
use CoreBundle\Manager\SiteGroupManager;
use CoreBundle\Manager\SiteManager;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Templating\PhpEngine;

/**
 * Class SiteAffiliationEventListener
 * @package CoreBundle\Listener\EventListener
 */
class SiteAffiliationEventListener implements EventSubscriberInterface
{
    /** @var SiteAffiliationManager */
    private $affiliationManager;

    /** @var TwigEngine */
    private $templating;

    /** @var string */
    private $environment;

    /**
     * SiteAffiliationEventListener constructor.
     * @param SiteAffiliationManager $affiliationManager
     * @param TwigEngine $templating
     * @param string $environment
     */
    public function __construct(SiteAffiliationManager $affiliationManager, TwigEngine $templating, string $environment)
    {
        $this->affiliationManager = $affiliationManager;
        $this->environment = $environment;
        $this->templating = $templating;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (strpos($request->getUri(), 'admin') === false) {
            $host = $request->getHost();
            $baseUrl = $request->getBaseUrl();
            if ($this->environment === 'dev') {
                $baseUrl = str_replace('/app_dev.php', '', $baseUrl);
            }
            $this->affiliationManager->setCurrentAffiliation(new ParameterBag([
                'host' => $host,
                'base_url' => $baseUrl,
                'site_group' => null
            ]));
            if (!$this->affiliationManager->getCurrentAffiliation()) {
                $event->setResponse(new Response($this->templating->render('CoreBundle:Exception:error404.html.twig')));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => [['onKernelRequest', 16]],
        );
    }
}
