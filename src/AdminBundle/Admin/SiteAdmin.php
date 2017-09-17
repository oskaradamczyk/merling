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

/**
 * SonataAdmin class for Site model.
 *
 * @author oadamczyk
 */
class SiteAdmin extends CustomAbstractAdmin
{

    /**
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
                ->tab('admin.main')
                ->add('host')
                ->add('baseUrl')
                ->add('secure')
                ->add('siteGroup', 'sonata_type_model', [
                    'property' => 'name',
                    'required' => false
                ])
                ->end()
                ->end();
        parent::configureFormFields($formMapper);
    }

    /**
     * 
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('host');
    }

    /**
     * 
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('host')
                ->add('baseUrl')
                ->add('secure')
                ->add('_action', null, [
                    'actions' => [
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ]
        ]);
    }

    /**
     * 
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
                ->add('host')
                ->add('baseUrl')
                ->add('secure');
    }

}
