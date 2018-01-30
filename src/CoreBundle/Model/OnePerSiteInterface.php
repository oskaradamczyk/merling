<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.12.17
 * Time: 22:46
 */

namespace CoreBundle\Model;


use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;

/**
 * Interface OnePerSiteInterface
 * @package CoreBundle\Model
 */
interface OnePerSiteInterface
{

    /**
     * @return Site|null
     */
    public function getSite(): ?Site;

    /**
     * @param Site|null $site
     * @return mixed
     */
    public function setSite(?Site $site);

    /**
     * @return SiteGroup|null
     */
    public function getSiteGroup(): ?SiteGroup;

    /**
     * @param SiteGroup|null $siteGroup
     * @return mixed
     */
    public function setSiteGroup(?SiteGroup $siteGroup);

    /**
     * @return string
     */
    public function getType(): string;
}