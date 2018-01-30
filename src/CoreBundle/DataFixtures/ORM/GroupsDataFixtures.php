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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CoreBundle\Entity\Group;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Loading groups before running system from DoctrineFixtures.
 *
 * @author oadamczyk
 */
class GroupsDataFixtures implements FixtureInterface, ContainerAwareInterface, DependentFixtureInterface
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
        /** @var TranslatorInterface $translator */
        $translator = $this->container->get('translator');
        foreach (RoleEnum::getConstants() as $key => $role) {
            /** @var Group */
            $group = new Group($translator->trans($role), [$role]);
            if ($role === RoleEnum::SUPER_ADMIN) {
                /** @var User $user */
                $user = $manager
                    ->getRepository(User::class)
                    ->findOneBy(['username' => $this->container->getParameter('env(SUPER_ADMIN_USERNAME)')]);
                $user
                    ->addGroup($group);
                $manager->persist($user);
            }
            $manager->persist($group);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SuperAdminDataFixtures::class
        );
    }

}
