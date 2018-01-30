<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.01.18
 * Time: 00:14
 */

namespace AdminBundle\Admin;


use CoreBundle\Document\Feature;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Model\SiteAffiliationInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

abstract class SiteAffiliationAdmin extends CustomAbstractAdmin
{
    //TODO change Site and SiteGroup entities inheritance in joined tables with discriminator
    /**
     * @param SiteAffiliationInterface|Site|SiteGroup $object
     */
    public function preRemove($object)
    {
        /** @var DocumentManager $dm */
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine.odm.mongodb.document_manager');
        if ($object->getLogo()) {
            $dm->remove($object->getLogo());
        }
        if ($object->getFavicon()) {
            $dm->remove($object->getFavicon());
        }
        if ($object->getFavicon()) {
            $dm->remove($object->getFavicon());
        }
        /** @var Feature $feature */
        foreach ($object->getFeatures() as $feature) {
            $feature->setSite(null);
            $dm->persist($feature);
        }
        $dm->flush();
    }
}