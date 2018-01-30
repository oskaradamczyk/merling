<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\Image;
use CoreBundle\Document\Media;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Validator\Constraints\Valid;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use CoreBundle\Document\Cms;
use CoreBundle\Document\Gallery;
use CoreBundle\Util\FeaturePositionEnum;

/**
 * SonataAdmin class for Gallery model.
 *
 * @author oadamczyk
 */
class GalleryAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('pagePosition', 'choice', ['choices' => FeaturePositionEnum::getConstants()])
            ->add('images', 'sonata_type_collection', [
                'by_reference' => false,
                'required' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position'
            ])
            ->add('others', 'sonata_type_collection', [
                'by_reference' => false,
                'required' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position'
            ])
            ->add('videos', 'sonata_type_collection', [
                'by_reference' => false,
                'required' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position'
            ]);
    }

    /**
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
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('site')
            ->add('siteGroup');
    }

    /**
     * @param Gallery $object
     */
    public function prePersist($object)
    {
        /** @var Media $media */
        foreach ($object->getMedias() as $media) {
            $media->setGallery($object);
        }
    }

    /**
     * @param Gallery $object
     */
    public function preUpdate($object)
    {
        /** @var Media $media */
        foreach ($object->getMedias() as $media) {
            $media->setGallery($object);
        }
    }

    /**
     * @param Gallery $object
     */
    public function preRemove($object)
    {
        $feature = $object->getFeature();
        $feature->getGalleries()->removeElement($object);
        /** @var DocumentManager $dm */
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $dm->persist($feature);
        $dm->flush();
    }
}
