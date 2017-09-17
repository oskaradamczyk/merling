<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

/**
 * SonataAdmin class for MetaKeywod embedded model.
 *
 * @author oadamczyk
 */
class MetaKeywordAdmin extends CustomAbstractAdmin
{

    /**
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name')
        ;
    }

}
