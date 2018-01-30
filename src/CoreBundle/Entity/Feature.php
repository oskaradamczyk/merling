<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 10.12.17
 * Time: 04:39
 */

namespace CoreBundle\Document;

use CoreBundle\Document\Traits\SeoFriendlyDocument;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Model\DevelopmentAwareInterface;
use CoreBundle\Model\MenuAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

//TODO import custom css and js file instead/in addition to raw code

/**
 * Class Feature
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="feature")
 * @MongoDB\InheritanceType("COLLECTION_PER_CLASS")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({
 *     "1"="Page",
 *     "2"="Cms"
 * })
 */
abstract class Feature extends DocumentAbstractModel implements MenuAwareInterface, DevelopmentAwareInterface
{
    use SeoFriendlyDocument;

    /**
     * @var string
     * @MongoDB\Field("string")
     * @Assert\NotBlank
     */
    protected $slug;

    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Gallery", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $galleries;

    /**
     * @var SiteGroup|null
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\SiteGroup", inversedBy="features", identifier="siteGroupId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null and this.getCategory() == null) or (this.getSiteGroup() == null and this.getSite() != null and this.getCategory() == null) or (this.getSiteGroup() == null and this.getSite() == null and this.getCategory() != null)",
     *      message="core.menu_aware.create.site_and_category_and_site_group_xor"
     * )
     */
    protected $siteGroup;

    /**
     * @var string|null
     * @MongoDB\Field("string")
     */
    protected $siteGroupId;

    /**
     * @var Site|null
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\Site", inversedBy="features", identifier="siteId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null and this.getCategory() == null) or (this.getSiteGroup() == null and this.getSite() != null and this.getCategory() == null) or (this.getSiteGroup() == null and this.getSite() == null and this.getCategory() != null)",
     *      message="core.menu_aware.create.site_and_category_and_site_group_xor"
     * )
     */
    protected $site;

    /**
     * @var string|null
     * @MongoDB\Field("string")
     */
    protected $siteId;

    /**
     * Inheritance helping field
     * @var Category|null
     */
    protected $category;

    /**
     * @var string|null
     * @MongoDB\Field(type="string")
     */
    protected $customCss;

    /**
     * @var string|null
     * @MongoDB\Field(type="string")
     */
    protected $customJs;

    /**
     * Feature constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->galleries = new ArrayCollection();
    }
    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Feature
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
    /**
     * @return SiteGroup|null
     */
    public function getSiteGroup()
    {
        return $this->siteGroup;
    }

    /**
     * @return Site|null
     */
    public function getSite()
    {
        return $this->site;
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
     * @return Feature
     */
    public function setSiteId(?string $siteId): Feature
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
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
     * @return null|string
     */
    public function getSiteGroupId(): ?string
    {
        return $this->siteGroupId;
    }

    /**
     * @param null|string $siteGroupId
     * @return Feature
     */
    public function setSiteGroupId(?string $siteGroupId): Feature
    {
        $this->siteGroupId = $siteGroupId;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getGalleries()
    {
        return $this->galleries;
    }

    /**
     * @param Collection $galleries
     * @return \self
     */
    public function setGalleries(Collection $galleries): self
    {
        $this->galleries = $galleries;
        return $this;
    }

    /**
     * @param Gallery $gallery
     * @return \self
     */
    public function addGallery(Gallery $gallery): self
    {
        $this->galleries->add($gallery);
        return $this;
    }

    /**
     * @param Gallery $gallery
     * @return \self
     */
    public function removeGallery(Gallery $gallery): self
    {
        if ($this->galleries->contains($gallery)) {
            $this->galleries->removeElement($gallery);
        }
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return Feature
     */
    public function setCategory($category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCustomCss(): ?string
    {
        return $this->customCss;
    }

    /**
     * @param null|string $customCss
     * @return Feature
     */
    public function setCustomCss(?string $customCss): self
    {
        $this->customCss = $customCss;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCustomJs(): ?string
    {
        return $this->customJs;
    }

    /**
     * @param null|string $customJs
     * @return Feature
     */
    public function setCustomJs(?string $customJs): self
    {
        $this->customJs = $customJs;
        return $this;
    }
}
