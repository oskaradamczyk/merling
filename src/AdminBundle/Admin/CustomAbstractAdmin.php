<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use CoreBundle\Document\Traits\SeoFriendlyDocument;
use CoreBundle\Entity\Traits\SeoFriendlyEntity;

/**
 * Abstract sonata admin service to avoid code repetition
 *
 * @author oadamczyk
 */
class CustomAbstractAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt',
    ];

    /**
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->tab('admin.main')
                ->add('name')
                ->end()
                ->end();
        if (
                in_array(SeoFriendlyEntity::class, class_uses($this->getSubject())) ||
                in_array(SeoFriendlyDocument::class, class_uses($this->getSubject()))
        ) {
            $formMapper
                    ->tab('admin.seo')
                    ->add('title', null, ['required' => false])
                    ->add('metaKeywords', 'sonata_type_collection', [
                        'by_reference' => false,
                        'required' => false,
                        'mapped' => true
                            ], [
                        'edit' => 'inline',
                        'inline' => 'standard',
                        'sortable' => 'position',
                        'admin_code' => 'admin.meta_keyword'
                    ])
                    ->add('metaDescription', 'textarea', ['required' => false])
                    ->end();
        }
    }

    /**
     * 
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name')
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
                ->add('name')
                ->add('createdAt')
                ->add('createdBy')
                ->add('_action', 'actions', [
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
                ->add('name')
                ->add('createdAt')
                ->add('createdBy');
    }

}
