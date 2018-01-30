<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 28.10.17
 * Time: 04:45
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class OtherAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, ['required' => false])
            ->add('file', VichFileType::class, [
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
        parent::configureRoutes($collection);
        $collection->clearExcept(['create']);
    }
}
