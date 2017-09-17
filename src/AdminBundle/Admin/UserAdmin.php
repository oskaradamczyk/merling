<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * SonataAdmin class for User model.
 *
 * @author oadamczyk
 */
class UserAdmin extends CustomAbstractAdmin
{

    /**
     *
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('username')
                ->add('plainPassword', 'password', [
                    'help' => 'admin.user.create.password_help'
                ])
                ->add('passwordConfirmation', 'password')
                ->add('email');
    }

    /**
     * 
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('username')
                ->add('createdAt')
                ->add('createdBy');
    }

    /**
     * 
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('username');
        parent::configureListFields($listMapper);
        $listMapper->remove('name');
    }

    /**
     * 
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
                ->add('username')
                ->add('email')
                ->add('groups');
        parent::configureShowFields($showMapper);
    }

    /**
     * 
     * @return UserManagerInterface
     */
    public function getUserManager(): UserManagerInterface
    {
        return $this->userManager;
    }

    /**
     * 
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

}
