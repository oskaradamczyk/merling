<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\Setting;
use CoreBundle\Document\Product;
use CoreBundle\Document\Category;
use CoreBundle\Entity\Traits\SeoFriendlyEntity;

/**
 * SiteGroup model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @ORM\Entity
 * @ORM\Table(name="site_group")
 */
class SiteGroup extends AbstractEntityModel
{

    use SeoFriendlyEntity;

    /**
     *
     * @var Site
     * @ORM\OneToMany(targetEntity="Site", mappedBy="siteGroup", cascade={"persist", "remove"})
     */
    protected $sites;

    /**
     *
     * @var ArrayCollection
     * @Gedmo\ReferenceMany(type="odm", class="CoreBundle\Document\CmsPage", mappedBy="siteGroup")
     */
    protected $cmsPages;

    /**
     *
     * @var ArrayCollection
     * @Gedmo\ReferenceMany(type="document", class="CoreBundle\Document\Category", mappedBy="siteGroup")
     */
    protected $categories;

    /**
     *
     * @var ArrayCollection
     * @Gedmo\ReferenceMany(type="document", class="CoreBundle\Document\Product", mappedBy="siteGroup")
     */
    protected $products;

    /**
     *
     * @var Setting
     * @ORM\OneToOne(targetEntity="Setting", mappedBy="siteGroup", cascade={"persist", "remove"})
     */
    protected $setting;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->cmsPages = new ArrayCollection();
    }

    /**
     * 
     * @return Setting|null
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * 
     * @param Setting $setting
     * @return \self
     */
    public function setSetting(Setting $setting): self
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * 
     * @return ArrayCollection|null
     */
    public function getCmsPages()
    {
        return $this->cmsPages;
    }

    /**
     * 
     * @param ArrayCollection $cmsPages
     * @return \self
     */
    public function setCmsPages(ArrayCollection $cmsPages): self
    {
        $this->cmsPages = $cmsPages;
        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param ArrayCollection $sites
     * @return \self
     */
    public function setSites(ArrayCollection $sites): self
    {
        $this->sites = $sites;
        return $this;
    }

    /**
     * 
     * @param Site $site
     * @return \self
     */
    public function addSite(Site $site): self
    {
        $this->sites->add($site);
        return $this;
    }

    /**
     * 
     * @return ArrayCollection|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * 
     * @return ArrayCollection|null
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * 
     * @param ArrayCollection $categories
     * @return \self
     */
    public function setCategories(ArrayCollection $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * 
     * @param ArrayCollection $products
     * @return $this
     */
    public function setProducts(ArrayCollection $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     * 
     * @param Category $category
     * @return \self
     */
    public function addCategory(Category $category): self
    {
        $this->categories->add($category);
        return $this;
    }

    /**
     * 
     * @param Product $product
     * @return \self
     */
    public function addProduct(Product $product): self
    {
        $this->products->add($product);
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->name ? $this->name : '';
    }

}
