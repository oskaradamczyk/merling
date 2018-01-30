<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 28.10.17
 * Time: 04:45
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\Image;
use CoreBundle\Document\Video;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Sonata\DoctrineMongoDBAdminBundle\Model\ModelManager;

class VideoAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ModelManager $dm */
        $mm = $this->getModelManager();
        /** @var Image $poster */
        $poster = $mm->findOneBy(Image::class, ['name' => 'video-poster-placeholder.png']);
        $formMapper
            ->add('file', VichFileType::class, [
                    'required' => false,
                    'allow_delete' => false,
                ]
            )
            ->add('poster', 'sonata_type_model', ['required' => true]);
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->clearExcept(['create']);
    }

    public function prePersist($object)
    {
        /** @var Video $video */
        $video = $object;
        if (!$video->getPoster()) {
            /** @var ModelManager $dm */
            $mm = $this->getModelManager();
            /** @var Image $poster */
            $poster = $mm->findOneBy(Image::class, ['name' => 'video-poster-placeholder.png']);
            $video->setPoster($poster);
        }
    }
}
