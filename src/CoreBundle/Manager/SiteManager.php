<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.01.18
 * Time: 22:15
 */

namespace CoreBundle\Manager;


use CoreBundle\Model\SiteAffiliationInterface;
use CoreBundle\Repository\SiteRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class SiteManager
 * @package CoreBundle\Manager
 */
class SiteManager extends AbstractModelManager
{
    /**
     * @param ParameterBag|null $criteria
     * @return SiteAffiliationInterface
     */
    public function getCurrentAffiliation(ParameterBag $criteria): ?SiteAffiliationInterface
    {
        /** @var SiteRepository $siteRepository */
        $siteRepository = $this->modelRepository;
        return $siteRepository->getFilteredSite($criteria);
    }
}
