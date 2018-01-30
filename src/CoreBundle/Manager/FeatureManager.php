<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 11.01.18
 * Time: 22:12
 */

namespace CoreBundle\Manager;


use CoreBundle\Document\Feature;
use CoreBundle\Repository\FeatureRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class FeatureManager
 * @package CoreBundle\Manager
 */
abstract class FeatureManager extends AbstractModelManager
{
    /**
     * @param ParameterBag $criteria
     * @return Feature|null
     */
    public function getFeatureForAffiliation(ParameterBag $criteria): ?Feature
    {
        /** @var FeatureRepository $featureRepository */
        $featureRepository = $this->getModelRepository();
        return $featureRepository->getFilteredFeature($criteria);
    }
}