<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 16.12.17
 * Time: 20:52
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\CmsCategory;
use CoreBundle\Document\Feature;
use CoreBundle\Document\Gallery;
use CoreBundle\Document\Media;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

abstract class FeatureAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('admin.main')
            ->with('admin.base_options')
            ->add('slug')
            ->add('site', 'entity', [
                'class' => Site::class,
                'required' => false,
            ])
            ->add('siteGroup', 'entity', [
                'class' => SiteGroup::class,
                'required' => false,
            ])
            ->add('category', 'sonata_type_model', [
                'property' => 'name',
                'model_manager' => $this->modelManager,
                'required' => false,
                'template' => 'AdminBundle:Form/Type:sonata_type_model_autocomplete.html.twig'
            ])
            ->add('content', CKEditorType::class, ['required' => false])
            ->add('galleries', 'sonata_type_collection', [
                'required' => false,
                'by_reference' => false,
                'mapped' => true
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position'
            ])
            ->end()
            ->with('admin.style')
            ->add('customCss', TextareaType::class, [
                'attr' => ['class' => 'code-mirror-aware code-mirror-aware-css'],
                'required' => false
            ])
            ->add('customJs', TextareaType::class, [
                'attr' => ['class' => 'code-mirror-aware code-mirror-aware-js'],
                'required' => false
            ])
            ->end()
            ->end();
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('site', 'sonata_type_model')
            ->add('siteGroup', 'sonata_type_model')
            ->add('category', 'sonata_type_model');
        parent::configureListFields($listMapper);
        $listMapper
            ->reorder(['name']);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $dm = $this->getModelManager();
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('category', null, [], 'sonata_type_model', ['model_manager' => $dm]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
        $showMapper
            ->add('site')
            ->add('siteGroup')
            ->add('category', 'sonata_type_model')
            ->add('galleries');
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('batch');
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * @param Feature $object
     */
    public function prePersist($object)
    {
        /** @var Gallery $gallery */
        foreach ($object->getGalleries() as $gallery) {
            $gallery->setFeature($object);
            /** @var Media $media */
            foreach ($gallery->getMedias() as $media) {
                $media->setGallery($gallery);
            }
        }
        $this->updateGalleries($object, true);
    }

    /**
     * @param Feature $object
     */
    public function preUpdate($object)
    {
        /** @var Gallery $gallery */
        foreach ($object->getGalleries() as $gallery) {
            $gallery->setFeature($object);
            /** @var Media $media */
            foreach ($gallery->getMedias() as $media) {
                $media->setGallery($gallery);
            }
        }
    }

    /**
     * @param Feature $object
     */
    public function preRemove($object)
    {
        if ($category = $object->getCategory()) {
            $category->removeFeature($object);
            /** @var DocumentManager $dm */
            $dm = $this->getConfigurationPool()->getContainer()->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($category);
            $dm->flush();
        }
        $this->updateGalleries($object);
    }

    /**
     * @param Feature $object
     * @param bool $isPersist
     */
    protected function updateGalleries($object, bool $isPersist = false)
    {
        if ($isPersist) {
            /** @var CmsCategory $category */
            $category = $object->getCategory();
            if ($category) {
                $category->addFeature($object);
            }
            return;
        }
        /** @var DocumentManager $dm */
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine.odm.mongodb.document_manager');
        if (isset($dm->getUnitOfWork()->getOriginalDocumentData($object)['cmsCategory'])) {
            /** @var CmsCategory $oldCategory */
            if (($oldCategory = $dm->getUnitOfWork()->getOriginalDocumentData($object)['cmsCategory']) !== $object->getCategory()) {
                $oldCategory->removeFeature($object);
            }
        }
        /** @var CmsCategory $category */
        $category = $object->getCategory();
        if ($category) {
            $category->addFeature($object);
        }
    }
}