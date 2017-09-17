<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use CoreBundle\Document\Traits\SeoFriendlyDocument;
use CoreBundle\Document\Category;

/**
 * Product model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @MongoDB\Document(collection="product")
 */
class Product extends AbstractDocumentModel
{

    use SeoFriendlyDocument;

    /**
     *
     * @var Category
     * @MongoDB\ReferenceOne(targetDocument="Category", mappedBy="products")
     */
    protected $category;

    /**
     *
     * @var Site
     * @Gedmo\ReferenceOne(type="entity", class="Site", mappedBy="products")
     * @Assert\Expression(
     *      "!this.getSiteGroup() and !$this.getSite()",
     *      message="admin.product.create.no_site"
     * )
     */
    protected $site;

    /**
     *
     * @var SiteGroup
     * @Gedmo\ReferenceOne(type="entity", class="SiteGroup", mappedBy="products")
     * @Assert\Expression(
     *      "!this.getSiteGroup() and !$this.getSite()",
     *      message="admin.product.create.no_site_group"
     * )
     */
    protected $siteGroup;

    /**
     *
     * @var float
     * @MongoDB\Field(type="float")
     * @Assert\Type("float")
     */
    protected $price;

    /**
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $unit;

    /**
     *
     * @var bool
     * @MongoDB\Field(type="boolean")
     * @Assert\Type("boolean")
     */
    protected $available;

    /**
     *
     * @var \DateTime
     * @MongoDB\Field(type="date")
     * @Assert\DateTime()
     */
    protected $availableFrom;

    public function __construct()
    {
        parent::__construct();
        $this->products = new ArrayCollection();
        $this->childCategories = new ArrayCollection();
    }

    /**
     * 
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
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
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * 
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * 
     * @return bool|null
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * 
     * @return \DateTime|null
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * 
     * @param Category $category
     * @return \self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
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

    /**
     * 
     * @param float $price
     * @return \self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * 
     * @param string $unit
     * @return \self
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * 
     * @param bool $available
     * @return \self
     */
    public function setAvailable(bool $available): self
    {
        $this->available = $available;
        return $this;
    }

    /**
     * 
     * @param \DateTime $availableFrom
     * @return \self
     */
    public function setAvailableFrom(\DateTime $availableFrom): self
    {
        $this->availableFrom = $availableFrom;
        return $this;
    }

}
