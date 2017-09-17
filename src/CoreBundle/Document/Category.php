<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use CoreBundle\Document\Traits\SeoFriendlyDocument;

/**
 * Category model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @MongoDB\Document(collection="category")
 */
class Category extends AbstractDocumentModel
{

    use SeoFriendlyDocument;

    /**
     *
     * @var Category
     * @MongoDB\ReferenceOne(targetDocument="Category")
     */
    protected $parentCategory;

    /**
     *
     * @var Category
     * @MongoDB\ReferenceMany(targetDocument="Category", orphanRemoval=true)
     */
    protected $childCategories;

    /**
     *
     * @var
     * @MongoDB\ReferenceMany(targetDocument="Product", mappedBy="category", orphanRemoval=true)
     */
    protected $products;

    /**
     *
     * @var Site
     * @Gedmo\ReferenceOne(type="entity", class="Site", mappedBy="categories")
     * @Assert\Expression(
     *      "!this.getSiteGroup() and !$this.getSite()",
     *      message="admin.category.create.no_site"
     * )
     */
    protected $site;

    /**
     *
     * @var SiteGroup
     * @Gedmo\ReferenceOne(type="entity", class="SiteGroup", mappedBy="categories")
     * @Assert\Expression(
     *      "!this.getSiteGroup() and !$this.getSite()",
     *      message="admin.category.create.no_site_group"
     * )
     */
    protected $siteGroup;

    public function __construct()
    {
        parent::__construct();
        $this->products = new ArrayCollection();
        $this->childCategories = new ArrayCollection();
    }

    /**
     * 
     * @return null|Category
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * 
     * @return null|ArrayCollection
     */
    public function getChildCategories()
    {
        return $this->childCategories;
    }

    /**
     * 
     * @return null|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * 
     * @param Category $parentCategory
     * @return \self
     */
    public function setParentCategory(Category $parentCategory): self
    {
        $this->parentCategory = $parentCategory;
        return $this;
    }

    /**
     * 
     * @param Collection $childCategories
     * @return \self
     */
    public function setChildCategories(Collection $childCategories): self
    {
        $this->childCategories = $childCategories;
        return $this;
    }

    /**
     * 
     * @param Collection $products
     * @return \self
     */
    public function setProducts(Collection $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     * 
     * @param \CoreBundle\Document\Category $childCategory
     * @return \self
     */
    public function addChildCategory(Category $childCategory): self
    {
        $this->childCategories->add($childCategory);
        return $this;
    }

    /**
     * 
     * @param \CoreBundle\Document\Product $product
     * @return \self
     */
    public function addProduct(Product $product): self
    {
        $this->products->add($product);
        return $this;
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
     * @return SiteGroup|null
     */
    public function getSiteGroup()
    {
        return $this->siteGroup;
    }

    /**
     * 
     * @param Site $site
     * @return \self
     */
    public function setSite(Site $site): self
    {
        $this->site = $site;
        return $this;
    }

    /**
     * 
     * @param SiteGroup $siteGroup
     * @return \self
     */
    public function setSiteGroup(SiteGroup $siteGroup): self
    {
        $this->siteGroup = $siteGroup;
        return $this;
    }

}
