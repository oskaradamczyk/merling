<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use CoreBundle\Document\Gallery;
use CoreBundle\Document\Traits\SeoFriendlyDocument;

/**
 * Class Blog
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="blog")
 */
class Blog extends DocumentAbstractModel
{
    use SeoFriendlyDocument;

    /**
     *
     * @MongoDB\Field("string")
     */
    protected $slug;

    /**
     *
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Gallery", mappedBy="Cms", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     */
    protected $galleries;

    /**
     *
     * @var SiteGroup
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\SiteGroup", inversedBy="Cmss", identifier="siteGroupId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null) or (this.getSiteGroup() == null and this.getSite() != null)",
     *      message="admin.cms_page.create.site_and_site_group_xor"
     * )
     */
    protected $siteGroup;

    /**
     *
     * @MongoDB\Field("string")
     */
    protected $siteGroupId;

    /**
     *
     * @var Site
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\Site", inversedBy="Cmss", identifier="siteId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null) or (this.getSiteGroup() == null and this.getSite() != null)",
     *      message="admin.cms_page.create.site_and_site_group_xor"
     * )
     */
    protected $site;

    /**
     *
     * @MongoDB\Field("string")
     */
    protected $siteId;

    /**
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $content;

    /**
     * Blog constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->galleries = new ArrayCollection();
    }

    /**
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *
     * @param string|null $content
     * @return \self
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     *
     * @return SiteGroup|null
     */
    public function getSiteGroup()
    {
        return $this->siteGroup;
    }

    /**
     *
     * @return Site|null
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     *
     * @param Site|null $site
     * @return \self
     */
    public function setSite($site): self
    {
        $this->site = $site;
        $this->siteId = $site ? $site->getId() : null;
        return $this;
    }

    /**
     *
     * @param SiteGroup|null $group
     * @return \self
     */
    public function setSiteGroup($group): self
    {
        $this->siteGroup = $group;
        $this->siteGroupId = $group ? $group->getId() : null;
        return $this;
    }

    /**
     *
     * @return Collection|null
     */
    public function getGalleries()
    {
        return $this->galleries;
    }

    /**
     *
     * @param Collection $galleries
     * @return \self
     */
    public function setGalleries(Collection $galleries): self
    {
        $this->galleries = $galleries;
        return $this;
    }

    /**
     *
     * @param Gallery $gallery
     * @return \self
     */
    public function addGallery(Gallery $gallery): self
    {
        $this->galleries->add($gallery);
        return $this;
    }

    /**
     *
     * @param Gallery $gallery
     * @return \self
     */
    public function removeGallery(Gallery $gallery): self
    {
        $this->galleries->removeElement($gallery);
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): self
    {
        $this->slug = $slug;
        return $this;
    }
}
