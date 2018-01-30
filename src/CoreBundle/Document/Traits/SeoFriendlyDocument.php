<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document\Traits;


use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use CoreBundle\Document\MetaKeyword;

/**
 * Trait SeoFriendlyDocument
 * @package CoreBundle\Document\Traits
 */
trait SeoFriendlyDocument
{
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $metaKeywords;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $metaDescription;

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @param string|null $title
     * @return \self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string|null $keywords
     * @return \self
     */
    public function setMetaKeywords(?string $keywords): self
    {
        $this->metaKeywords = $keywords;
        return $this;
    }

    /**
     * @param string|null $description
     * @return \self
     */
    public function setMetaDescription(?string $description): self
    {
        $this->metaDescription = $description;
        return $this;
    }


}
