<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 28.10.17
 * Time: 04:45
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\Image;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineMongoDBAdminBundle\Model\ModelManager;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, ['required' => false])
            ->add('url', UrlType::class, ['required' => false])
            ->add('alt', null, ['required' => false])
            ->add('file', VichImageType::class, [
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
