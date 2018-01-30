<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 28.10.17
 * Time: 04:45
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\Image;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineMongoDBAdminBundle\Model\ModelManager;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LogoAdmin extends MediaAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('site', 'entity', [
                'class' => Site::class,
                'required' => false,
            ])
            ->add('siteGroup', 'entity', [
                'class' => SiteGroup::class,
                'required' => false,
            ]);
        parent::configureFormFields($formMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('site', 'sonata_type_model')
            ->add('siteGroup', 'sonata_type_model');
        parent::configureListFields($listMapper);
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('edit');
    }
}
