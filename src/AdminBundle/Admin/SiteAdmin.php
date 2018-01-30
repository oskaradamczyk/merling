<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\Feature;
use CoreBundle\Entity\Site;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * SonataAdmin class for Site model.
 *
 * @author oadamczyk
 */
class SiteAdmin extends SiteAffiliationAdmin
{
    /**
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('admin.main')
            ->with('admin.base_options')
            ->add('host')
            ->add('baseUrl')
            ->add('secure')
            ->add('siteGroup', 'sonata_type_model', [
                'required' => false,
                'property' => 'name'
            ])
            ->end()
            ->end()
            ->tab('admin.site.appearance')
            ->add('themeColor', 'sonata_type_color')
            ->add('secondaryColor', 'sonata_type_color');
    }

    /**
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('host')
            ->add('siteGroup');
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
            ->add('getAbsoluteUrl', 'url', [
                'attributes' => ['target' => '_blank']
            ])
            ->add('siteGroup');
        parent::configureListFields($listMapper);
        $listMapper->reorder(['name', 'host']);
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
            ->add('secure')
            ->add('getAbsoluteUrl', 'url', [
                'attributes' => ['target' => '_blank']
            ])
            ->add('siteGroup');
        parent::configureShowFields($showMapper);
        $showMapper->reorder(['name', 'host']);
    }
}
