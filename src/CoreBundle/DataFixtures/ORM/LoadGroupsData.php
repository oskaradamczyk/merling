<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CoreBundle\Entity\Group;

/**
 * Loading groups before running system from DoctrineFixtures.
 *
 * @author oadamczyk
 */
class LoadGroupsData implements FixtureInterface, ContainerAwareInterface
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
        foreach (explode('|', $this->container->getParameter('env(ROLES_PIPE_SEPERATED)')) as $role) {
            /** @var Group */
            $group = new Group(ucfirst(str_replace('ADMIN_', '', $role)), $role);
            $manager->persist($group);
        }
        $manager->flush();
    }

}
