<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 30.11.17
 * Time: 01:09
 */

namespace AdminBundle\Admin;


use CoreBundle\Document\Category;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * SonataAdmin class for Category model.
 *
 * @author oadamczyk
 */
class CategoryAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('slug')
            ->add('site', 'entity', [
                'class' => Site::class,
                'required' => false,
            ])
            ->add('siteGroup', 'entity', [
                'class' => SiteGroup::class,
                'required' => false,
            ])
            ->end()
            ->end();
        parent::configureFormFields($formMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('site', 'sonata_type_model')
            ->add('siteGroup', 'sonata_type_model')
            ->add('parentCategory', 'sonata_type_model');
        parent::configureListFields($listMapper);
        $listMapper
            ->reorder(['name']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
        $showMapper
            ->add('site')
            ->add('siteGroup');
    }


    /**
     * @param Category $object
     */
    public function prePersist($object)
    {
        /** @var Category $category */
        $category = $object->getParentCategory();
        if ($category) {
            $category->addChildCategory($object);
        }
    }

    /**
     * @param Category $object
     */
    public function preUpdate($object)
    {
        /** @var DocumentManager $dm */
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine.odm.mongodb.document_manager');
        if (isset($dm->getUnitOfWork()->getOriginalDocumentData($object)['parentCategory'])) {
            /** @var Category $oldCategory */
            if (($oldCategory = $dm->getUnitOfWork()->getOriginalDocumentData($object)['parentCategory']) !== $object->getParentCategory()) {
                $oldCategory->removeChildCategory($object);
            }
        }
        /** @var Category $category */
        $category = $object->getParentCategory();
        if ($category) {
            $category->addChildCategory($object);
        }
    }

    /**
     * @param Category $object
     */
    public function preRemove($object)
    {
        if ($category = $object->getParentCategory()) {
            $category->removeChildCategory($object);
            /** @var DocumentManager $dm */
            $dm = $this->getConfigurationPool()->getContainer()->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($category);
            $dm->flush();
        }
    }
}