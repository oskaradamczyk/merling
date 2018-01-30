<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.09.17
 * Time: 05:42
 */

namespace CoreBundle\Repository;


use CoreBundle\Entity\Site;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class SiteRepository
 * @package CoreBundle\Repository
 */
class SiteRepository extends EntityRepository
{
    /**
     * @param ParameterBag $filters
     * @return Site|null
     */
    public function getFilteredSite(ParameterBag $filters): ?Site
    {
        $qb = $this->createQueryBuilder('s');
        if ($host = $filters->get('host')) {
            $qb
                ->andWhere('s.host = :host')
                ->setParameter('host', $host);
        }
        if ($baseUrl = $filters->get('base_url')) {
            $qb
                ->andWhere('s.baseUrl = :base_url')
                ->setParameter('base_url', $baseUrl);
        }
        if ($siteGroup = $filters->get('site_group')) {
            $qb
                ->andWhere('s.siteGroup = :site_group')
                ->setParameter('site_group', $siteGroup);
        }
        return $qb->getQuery()->getOneOrNullResult();
    }
}
