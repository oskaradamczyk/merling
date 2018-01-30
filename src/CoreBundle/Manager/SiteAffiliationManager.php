<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.01.18
 * Time: 21:47
 */

namespace CoreBundle\Manager;


use CoreBundle\Model\SiteAffiliationInterface;
use CoreBundle\Service\AbstractServiceInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SiteAffiliationManager
 * @package CoreBundle\Manager
 */
class SiteAffiliationManager
{
    /** @var SiteGroupManager */
    protected $siteGroupManager;

    /** @var SiteManager */
    protected $siteManager;

    /** @var SiteAffiliationInterface */
    protected $currentAffiliation;

    public function __construct(SiteManager $siteManager, SiteGroupManager $siteGroupManager)
    {
        $this->siteManager = $siteManager;
        $this->siteGroupManager = $siteGroupManager;
    }

    /**
     * @param ParameterBag $criteria
     */
    public function setCurrentAffiliation(ParameterBag $criteria): void
    {
        if (!($affiliation = $this->siteManager->getCurrentAffiliation($criteria))) {
            $affiliation = $this->siteGroupManager->getCurrentAffiliation($criteria);
        }
        $this->currentAffiliation = $affiliation;
    }

    /**
     * @return SiteAffiliationInterface|null
     */
    public function getCurrentAffiliation(): ?SiteAffiliationInterface
    {
        return $this->currentAffiliation;
    }
}
