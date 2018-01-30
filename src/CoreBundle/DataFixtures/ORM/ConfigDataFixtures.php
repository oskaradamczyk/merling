<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\Config;
use CoreBundle\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Loading default config for Super Admin before running system from DoctrineFixtures.
 *
 * @author oadamczyk
 */
class ConfigDataFixtures implements FixtureInterface, ContainerAwareInterface, DependentFixtureInterface
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
        $config = new Config();
        /** @var User $user */
        $user = $manager
            ->getRepository(User::class)
            ->findOneBy(['username' => $this->container->getParameter('env(SUPER_ADMIN_USERNAME)')]);
        $config
            ->setUser($user)
            ->setLocale($this->container->getParameter('default_locale'))
            ->setName($translator->trans('admin.config.default'));
        $manager->persist($config);
        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SuperAdminDataFixtures::class
        );
    }


}
