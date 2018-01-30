<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 11.01.18
 * Time: 22:48
 */

namespace CoreBundle\Repository;


use CoreBundle\Document\Feature;
use CoreBundle\Entity\Site;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class FeatureRepository
 * @package CoreBundle\Repository
 */
abstract class FeatureRepository extends DocumentRepository
{
    /**
     * @param ParameterBag $filters
     * @return Feature|null
     */
    public function getFilteredFeature(ParameterBag $filters): ?Feature
    {
        /** @var \Doctrine\MongoDB\Query\Builder $qb */
        $qb = $this->createQueryBuilder();
        if ($slug = $filters->get('slug')) {
            $qb->field('slug')->equals($slug);
        }
        if ($affiliation = $filters->get('affiliation')) {
            if ($affiliation instanceof Site) {
                $qb->field('siteId')->equals((string)$affiliation->getId());
            } else {
                $qb->field('siteGroupId')->equals((string)$affiliation->getId());
            }
        }
        /** @var Feature|null $result */
        $result = $qb->getQuery()->getSingleResult();
        return $result;
    }
}
