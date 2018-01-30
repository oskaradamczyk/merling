<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Listener\EntityListener;

use CoreBundle\Document\Cms;
use CoreBundle\Document\Favicon;
use CoreBundle\Document\Feature;
use CoreBundle\Document\Logo;
use CoreBundle\Document\Page;
use CoreBundle\Entity\Site;
use CoreBundle\Util\RecursiveInheritanceChecker;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SiteEntityListener
 * @package CoreBundle\Listener\EntityListener
 */
class SiteEntityListener
{
    const SSL_SCHEMA = 'https://';
    const NO_SSL_SCHEMA = 'http://';

    /** @var RequestStack */
    private $requestStack;

    /** @var DocumentManager */
    private $dm;

    /** @var string */
    private $environment;

    /** @var string */
    private $projectDir;

    /**
     * SiteEntityListener constructor.
     * @param RequestStack $requestStack
     * @param ContainerInterface $container
     * @param string $environment
     * @param string $projectDir
     */
    public function __construct(RequestStack $requestStack, ContainerInterface $container, string $environment, string $projectDir)
    {
        $this->dm = $container->get('doctrine.odm.mongodb.document_manager');
        $this->requestStack = $requestStack;
        $this->environment = $environment;
        $this->projectDir = $projectDir;
    }

    public function postLoad(Site $site, LifecycleEventArgs $event)
    {
        $this->setUrlForSite($site);
        $this->setImagesForSite($site);
        $this->setFeaturesForSite($site);
    }

    private function setUrlForSite(Site $site)
    {
        $schema = self::NO_SSL_SCHEMA;
        if ($site->isSecure()) {
            $schema = self::SSL_SCHEMA;
        }
        $env = '';
        if ($this->environment === 'dev') {
            $env = DIRECTORY_SEPARATOR . 'app_dev.php';
        }
        $site->setAbsoluteUrl(
            $schema .
            $site->getHost() .
            $env .
            DIRECTORY_SEPARATOR .
            $site->getBaseUrl() .
            $this->requestStack->getCurrentRequest()->getLocale()
        );
    }

    /**
     * @param Site $site
     */
    private function setImagesForSite(Site $site)
    {
        /** @var Logo $logo */
        $logo = $this->dm->getRepository(Logo::class)->findOneBy(['siteId' => (string)$site->getId()]);
        $site->setLogo($logo);
        /** @var Favicon $favicon */
        $favicon = $this->dm->getRepository(Favicon::class)->findOneBy(['siteId' => (string)$site->getId()]);
        $site->setFavicon($favicon);
    }

    /**
     * @param Site $site
     */
    private function setFeaturesForSite(Site $site)
    {
        $featuresCollection = new ArrayCollection();
        $documentClasses = array_filter($this->dm->getConfiguration()->getMetadataDriverImpl()->getAllClassNames(), function ($m) {
            return RecursiveInheritanceChecker::recursiveIsExtending(new \ReflectionClass($m), Feature::class) && $m !== Feature::class;
        });
        foreach ($documentClasses as $className) {
            foreach ($this->dm->getRepository($className)->findBy(['siteId' => (string)$site->getId()]) as $feature) {
                $featuresCollection->add($feature);
            }
        }
        $site->setFeatures($featuresCollection);
    }
}
