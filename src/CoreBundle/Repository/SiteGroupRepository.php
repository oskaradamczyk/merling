<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.09.17
 * Time: 05:43
 */

namespace CoreBundle\Repository;


use CoreBundle\Entity\SiteGroup;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class SiteGroupRepository
 * @package CoreBundle\Repository
 */
class SiteGroupRepository extends EntityRepository
{
    /**
     * @param ParameterBag $filters
     * @return SiteGroup|null
     */
    public function getSiteGroupFiltered(ParameterBag $filters): ?SiteGroup
    {
        $qb = $this->createQueryBuilder('s')->join('s.sites', 'ss');
        if ($host = $filters->get('host')) {
            $qb
                ->andWhere('ss.host = :host')
                ->setParameter('host', $host);
        }
        if ($baseUrl = $filters->get('base_url')) {
            $qb
                ->join('s.site', 'ss2')
                ->andWhere('ss.baseUrl = :base_url')
                ->setParameter('base_url', $baseUrl);
        }
        if ($site = $filters->get('site')) {
            $qb
                ->andWhere('s.site = :site')
                ->setParameter('site', $site);
        }
        return $qb->getQuery()->getOneOrNullResult();
    }
}
