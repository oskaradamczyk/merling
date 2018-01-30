<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 03.10.17
 * Time: 01:01
 */

namespace AdminBundle\Listener\EventListener;

use CoreBundle\Entity\Config;
use CoreBundle\Entity\User;
use CoreBundle\Util\ActionTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Event\ConfigureMenuEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilderEventListener
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var  EntityManagerInterface */
    protected $em;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $config = $this->em->getRepository(Config::class)->findOneBy(['user' => $user]);
        if ($this->authorizationChecker->isGranted(ActionTypeEnum::EDIT_TYPE, $config)) {
            $menu->addChild('admin.menu.label.config', [
                'label' => 'admin.menu.label.config',
                'route' => 'admin_core_config_edit',
                'routeParameters' => ['id' => $config->getId()]
            ])->setExtras([
                'icon' => '<i class="fa fa-cogs"></i>',
                'on_top' => true
            ]);
        }
    }
}