<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Document\Image;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Translation\Translator;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Loading placeholders before running system from DoctrineFixtures.
 *
 * @author oadamczyk
 */
class PlaceholdersDataFixtures implements FixtureInterface, ContainerAwareInterface
{
    const VIDEO_POSTER_NAME = 'video-poster-placeholder.png';

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /** @var Translator $translator */
        $translator = $this->container->get('translator');
        $defaultLocale = $this->container->getParameter('default_locale');
        $posterPlaceholder = new Image();
        $posterPlaceholder
            ->setAlt($translator->trans('core.video.poster_placeholder.alt', [], null, $defaultLocale))
            ->setTitle($translator->trans('core.video.poster_placeholder.title', [], null, $defaultLocale));

        $finder = Finder::create();
        $finder
            ->files()
            ->name(self::VIDEO_POSTER_NAME)
            ->in(
                $this->container->getParameter('kernel.project_dir') .
                DIRECTORY_SEPARATOR .
                'web' .
                DIRECTORY_SEPARATOR .
                $this->container->getParameter('admin.path.uri_prefix.images')
            );
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $posterPlaceholder
                ->setCreatedBy('oadamczyk')
                ->setUpdatedBy('oadamczyk')
                ->setFile($file)
                ->setName($file->getFilename());
        }
        /** @var DocumentManager $dm */
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $dm->persist($posterPlaceholder);
        $dm->flush();
    }
}
