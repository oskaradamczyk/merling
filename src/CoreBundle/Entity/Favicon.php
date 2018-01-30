<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 25.12.17
 * Time: 15:03
 */

namespace CoreBundle\Document;

use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Model\OnePerSiteInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoreBundle\Validator\Constraints as CoreAssert;

/**
 * Class Favicon
 * @package CoreBundle\Document
 * @MongoDB\Document
 * @Vich\Uploadable
 * @CoreAssert\OnePerSite
 */
class Favicon extends Image implements OnePerSiteInterface
{
    const MEDIA_TYPE = 'favicon';

    /**
     * @var Site|null
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\Site", inversedBy="favicon", identifier="siteId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null) or (this.getSiteGroup() == null and this.getSite() != null)",
     *      message="core.one_per_site.create.site_and_site_group_xor"
     * )
     */
    protected $site;

    /**
     * @var File|null
     * @Assert\Image(
     *     maxWidth = 32,
     *     maxHeight = 32
     * )
     */
    protected $file;

    /**
     * @var string|null
     * @MongoDB\Field("string")
     */
    protected $siteId;

    /**
     * @var SiteGroup|null
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\SiteGroup", inversedBy="logo", identifier="siteGroupId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null) or (this.getSiteGroup() == null and this.getSite() != null)",
     *      message="core.one_per_site.create.site_and_site_group_xor"
     * )
     */
    protected $siteGroup;

    /**
     * @var string|null
     * @MongoDB\Field("string")
     */
    protected $siteGroupId;

    /**
     * @return Site|null
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param Site|null $site
     * @return Favicon
     */
    public function setSite(?Site $site): self
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param null|string $siteId
     * @return Favicon
     */
    public function setSiteId($siteId): self
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * @return SiteGroup|null
     */
    public function getSiteGroup(): ?SiteGroup
    {
        return $this->siteGroup;
    }

    /**
     * @param SiteGroup|null $siteGroup
     * @return Favicon
     */
    public function setSiteGroup(?SiteGroup $siteGroup): self
    {
        $this->siteGroup = $siteGroup;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSiteGroupId(): ?string
    {
        return $this->siteGroupId;
    }

    /**
     * @param null|string $siteGroupId
     * @return Favicon
     */
    public function setSiteGroupId(?string $siteGroupId): self
    {
        $this->siteGroupId = $siteGroupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->mediaType;
    }
}
