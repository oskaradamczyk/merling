<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.01.18
 * Time: 22:16
 */

namespace CoreBundle\Manager;


use CoreBundle\Model\SiteAffiliationInterface;
use CoreBundle\Repository\SiteGroupRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SiteGroupManager
 * @package CoreBundle\Manager
 */
class SiteGroupManager extends AbstractModelManager
{
    /**
     * @param ParameterBag $criteria
     * @return SiteAffiliationInterface|null
     */
    public function getCurrentAffiliation(ParameterBag $criteria): ?SiteAffiliationInterface
    {
        /** @var SiteGroupRepository $siteGroupRepository */
        $siteGroupRepository = $this->modelRepository;
        return $siteGroupRepository->getFilteredSiteGroup($criteria);
    }
}
