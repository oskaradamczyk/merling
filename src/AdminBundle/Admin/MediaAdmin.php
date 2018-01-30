<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\Favicon;
use CoreBundle\Document\Image;
use CoreBundle\Document\Logo;
use CoreBundle\Document\Media;
use CoreBundle\Document\Video;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Model\OnePerSiteInterface;
use CoreBundle\Util\RecursiveInheritanceChecker;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 * Description of Image
 *
 * @author oadamczyk
 */
class MediaAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ModelManager $dm */
        $mm = $this->getModelManager();
        /** @var Image $poster */
        $posterPlaceholder = $mm->findOneBy(Image::class, ['name' => 'video-poster-placeholder.png']);
        $object = $this->getSubject();
        if (RecursiveInheritanceChecker::recursiveIsExtending(new \ReflectionClass($object), Image::class)) {
            $formMapper
                ->add('title', null, ['required' => false])
                ->add('alt', null, ['required' => false]);
        }
        $formMapper->add(
            'file', VichFileType::class, [
                'required' => false,
                'allow_delete' => false,
            ]
        );
        if ($object instanceof OnePerSiteInterface) {
            $formMapper
                ->add('site', 'entity', [
                    'class' => Site::class,
                    'required' => false,
                ])
                ->add('siteGroup', 'entity', [
                    'class' => SiteGroup::class,
                    'required' => false,
                ]);
        }
        if (RecursiveInheritanceChecker::recursiveIsExtending(new \ReflectionClass($object), Video::class)) {
            $formMapper->add('poster', 'sonata_type_model', ['required' => false, 'empty_data' => $posterPlaceholder]);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $object = $this->getSubject();
        parent::configureShowFields($showMapper);
        if (RecursiveInheritanceChecker::recursiveIsExtending(new \ReflectionClass($object), Image::class)) {
            $showMapper
                ->add('title')
                ->add('alt');
        }
        $showMapper->add('fileUrl', 'url');
        if ($object instanceof Video) {
            $showMapper
                ->add('poster')
                ->add('poster.title')
                ->add('poster.fileUrl', 'url')
                ->add('poster.alt');
        }
    }

    /**
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('mediaType');
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper->remove('name');
    }

    /**
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('mediaType')
            ->add('fileUrl', 'url')
            ->add('preview', 'virtual', [
                'template' => 'AdminBundle:CRUD/MediaAdmin:list_image.html.twig',
                'virtual_field' => true
            ]);
        parent::configureListFields($listMapper);
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('edit')
            ->remove('batch');
    }

    public function preRemove($object)
    {
        /** @var ModelManager $dm */
        $mm = $this->getModelManager();
        /** @var Media $media */
        $media = $object;
        $gallery = $media->getGallery();
        if ($gallery) {
            $remover = 'remove' . str_replace('CoreBundle\\Document\\', '', get_class($media));
            $gallery->$remover($media);
            $mm->update($gallery);
        }
        if ($media instanceof Image) {
            /** @var Video $video */
            foreach ($media->getVideos() as $video) {
                $video->setPoster(null);
                $mm->update($video);
            }
        }
    }
}
