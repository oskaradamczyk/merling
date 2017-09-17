<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Description of Image
 *
 * @author oadamczyk
 */
class ImageAdmin extends CustomAbstractAdmin
{

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('title')
                ->add('url')
                ->add('alt')
                ->add(
                        'file', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                        ]
        );
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'delete']);
    }

}
