<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.09.17
 * Time: 06:24
 */

namespace FrontendBundle\Listener\EventListener;

use CoreBundle\Entity\Config;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class AlreadyVisitedEventListener
 * @package CoreBundle\Listener\EventListener
 */
class AlreadyVisitedEventListener
{
    /** @var SessionInterface */
    private $session;

    /**
     * AlreadyVisitedEventListener constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if ($this->session->get('frontend_pre_already_visited') && !$this->session->get('frontend_already_visited')) {
            $this->session->set('frontend_already_visited', true);
        } elseif (!$this->session->get('frontend_pre_already_visited')) {
            $this->session->set('frontend_pre_already_visited', true);
        }
    }
}
