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
 * Class Logo
 * @package CoreBundle\Document
 * @MongoDB\Document
 * @Vich\Uploadable
 * @CoreAssert\OnePerSite
 */
class Logo extends Image implements OnePerSiteInterface
{
    const MEDIA_TYPE = 'logo';

    /**
     * @var Site|null
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\Site", inversedBy="logo", identifier="siteId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null) or (this.getSiteGroup() == null and this.getSite() != null)",
     *      message="core.one_per_site.create.site_and_site_group_xor"
     * )
     */
    protected $site;

    /**
     * @var File|null
     * @Assert\Image(
     *     minWidth = 150,
     *     maxWidth = 250,
     *     minHeight = 150,
     *     maxHeight = 250
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
     * @return Logo
     */
    public function setSite(?Site $site): self
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSiteId(): ?string
    {
        return $this->siteId;
    }

    /**
     * @param null|string $siteId
     * @return Logo
     */
    public function setSiteId(?string $siteId): self
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
     * @return Logo
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
     * @return Logo
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