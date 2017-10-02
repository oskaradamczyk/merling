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
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Document\Gallery;

/**
 * SonataAdmin class for CmsPage model.
 *
 * @author oadamczyk
 */
class CmsPageAdmin extends CustomAbstractAdmin
{

    /**
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->tab('admin.main')
                ->add('slug')
                ->add('site', 'entity', [
                    'class' => Site::class,
                    'required' => false,
                ])
                ->add('siteGroup', 'entity', [
                    'class' => SiteGroup::class,
                    'required' => false,
                ])
                ->add('content', CKEditorType::class, ['required' => false])
                ->add('galleries', 'sonata_type_collection', [
                    'required' => false,
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position'
                ])
                ->end()
                ->end();
        parent::configureFormFields($formMapper);
    }

    /**
     * 
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('site', 'sonata_type_model')
                ->add('siteGroup', 'sonata_type_model');
        parent::configureListFields($listMapper);
        $listMapper
                ->reorder(['name']);
    }

    /**
     * 
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
                ->add('id')
                ->add('name')
                ->add('site')
                ->add('siteGroup');
    }

}
