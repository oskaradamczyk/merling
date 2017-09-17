<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Admin;

use Symfony\Component\Validator\Constraints\Valid;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use CoreBundle\Document\CmsPage;
use CoreBundle\Document\Gallery;
use CoreBundle\Document\Image;
use AdminBundle\Util\PagePositionEnum;

/**
 * SonataAdmin class for Gallery model.
 *
 * @author oadamczyk
 */
class GalleryAdmin extends CustomAbstractAdmin
{

    /**
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name')
                ->add('pagePosition', 'choice', [
                    'choices' => PagePositionEnum::getConstants()
                ])
                ->add('cmsPage')
                ->add('images', 'sonata_type_collection', [
                    'by_reference' => false,
                    'required' => false,
                    'mapped' => true
                        ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position'
        ]);
    }

    /**
     * 
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('name')
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
                ->add('site')
                ->add('siteGroup');
    }

    public function prePersist($object)
    {
        /** @var Gallery $gallery */
        $gallery = $object;
        /** @var Image $image */
        foreach ($gallery->getImages() as $image) {
            $image->setUpdatedAt(new \DateTime());
        }
    }

    public function preUpdate($object)
    {
        /** @var Gallery $gallery */
        $gallery = $object;
        /** @var Image $image */
        foreach ($gallery->getImages() as $image) {
            $image->setUpdatedAt(new \DateTime());
        }
    }

}
