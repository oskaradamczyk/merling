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
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use CoreBundle\Document\Traits\SeoFriendlyDocument;
use CoreBundle\Document\Category;

//TODO whole model - consider abstract ,,offers" with discriminator on products, services and so on

/**
 * Class Product
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="product")
 */
class Product extends DocumentAbstractModel
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

    /**
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @return bool|null
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @return \DateTime|null
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * @param Category $category
     * @return \self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }


    /**
     * @param float $price
     * @return \self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param string $unit
     * @return \self
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @param bool $available
     * @return \self
     */
    public function setAvailable(bool $available): self
    {
        $this->available = $available;
        return $this;
    }

    /**
     * @param \DateTime $availableFrom
     * @return \self
     */
    public function setAvailableFrom(\DateTime $availableFrom): self
    {
        $this->availableFrom = $availableFrom;
        return $this;
    }

}
