<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\User;
use CoreBundle\Util\RoleEnum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Loading default config for Super Admin before running system from DoctrineFixtures.
 *
 * @author oadamczyk
 */
class SuperAdminDataFixtures implements FixtureInterface, ContainerAwareInterface
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /** @var UserManager $userManager */
        $userManager = $this->container->get('fos_user.user_manager');

        /** @var User $user */
        $user = $userManager->createUser();
        $user->setUsername($this->container->getParameter('env(SUPER_ADMIN_USERNAME)'));
        $user->setEmail($this->container->getParameter('env(SUPER_ADMIN_EMAIL)'));
        $user->setPlainPassword($this->container->getParameter('env(SUPER_ADMIN_PASSWORD)'));
        $user->setEnabled(true);
        $manager->persist($user);
        $manager->flush();
    }
}
