<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use CoreBundle\Model\MenuAwareInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use CoreBundle\Document\Traits\SeoFriendlyDocument;

/**
 * Class Category
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="category")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({
 *     "0"="CmsCategory",
 *     "1"="ProductCategory"
 * })
 */
abstract class Category extends DocumentAbstractModel implements MenuAwareInterface
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
     */
    protected $features;

    /**
     * @var Category
     * @MongoDB\ReferenceOne(targetDocument="Category")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null and this.getParentCategory() == null) or (this.getSiteGroup() == null and this.getSite() != null and this.getParentCategory() == null) or (this.getSiteGroup() == null and this.getSite() == null and this.getParentCategory() != null)",
     *      message="core.menu_aware.create.site_and_category_and_site_group_xor"
     * )
     */
    protected $parentCategory;

    /**
     * @var Category
     * @MongoDB\ReferenceMany(targetDocument="Category")
     */
    protected $childCategories;

    /**
     * @var Site
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\Site", inversedBy="categories", identifier="siteId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null and this.getParentCategory() == null) or (this.getSiteGroup() == null and this.getSite() != null and this.getParentCategory() == null) or (this.getSiteGroup() == null and this.getSite() == null and this.getParentCategory() != null)",
     *      message="core.menu_aware.create.site_and_category_and_site_group_xor"
     * )
     */
    protected $site;

    /**
     * @var string
     * @MongoDB\Field("string")
     */
    protected $siteId;

    /**
     * @var SiteGroup
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\SiteGroup", inversedBy="categories", identifier="siteGroupId")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null and this.getParentCategory() == null) or (this.getSiteGroup() == null and this.getSite() != null and this.getParentCategory() == null) or (this.getSiteGroup() == null and this.getSite() == null and this.getParentCategory() != null)",
     *      message="core.menu_aware.create.site_and_category_and_site_group_xor"
     * )
     */
    protected $siteGroup;

    /**
     * @var string
     * @MongoDB\Field("string")
     */
    protected $siteGroupId;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->features = new ArrayCollection();
        $this->childCategories = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return Category
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return null|Category
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @return null|ArrayCollection
     */
    public function getChildCategories()
    {
        return $this->childCategories;
    }

    /**
     * @param Category|null $parentCategory
     * @return Category
     */
    public function setParentCategory(?Category $parentCategory): self
    {
        $this->parentCategory = $parentCategory;
        return $this;
    }

    /**
     * @param Collection|null $childCategories
     * @return Category
     */
    public function setChildCategories(?Collection $childCategories): self
    {
        if (!$childCategories) {
            $childCategories = new ArrayCollection();
        }
        $this->childCategories = $childCategories;
        return $this;
    }

    /**
     * @param Category|null $childCategory
     * @return Category
     */
    public function addChildCategory(?Category $childCategory): self
    {
        $this->childCategories->add($childCategory);
        return $this;
    }

    /**
     * @param Category|null $childCategory
     * @return Category
     */
    public function removeChildCategory(?Category $childCategory): self
    {
        if ($this->childCategories->contains($childCategory)) {
            $this->childCategories->removeElement($childCategory);
        }
        return $this;
    }

    /**
     * @return Site|null
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @return SiteGroup|null
     */
    public function getSiteGroup()
    {
        return $this->siteGroup;
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
     * @return Collection
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    /**
     * @param Collection|null $features
     * @return Category
     */
    public function setFeatures(?Collection $features): self
    {
        if (!$features) {
            $features = new ArrayCollection();
        }
        $this->features = $features;
        return $this;
    }

    /**
     * @param MenuAwareInterface|null $features
     * @return Category
     */
    public function addFeature(?MenuAwareInterface $features): self
    {
        $this->features->add($features);
        return $this;
    }

    /**
     * @param MenuAwareInterface|null $page
     * @return Category
     */
    public function removeFeature(?MenuAwareInterface $page): self
    {
        if ($this->features->contains($page)) {
            $this->features->removeElement($page);
        }
        return $this;
    }

}
