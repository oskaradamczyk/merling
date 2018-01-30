<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity\Traits;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SeoFriendlyEntity trait for SEO friendly content.
 *
 * @author oadamczyk
 */
trait SeoFriendlyEntity
{
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
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
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string|null $title
     * @return \self
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string|null $keywords
     * @return self
     */
    public function setMetaKeywords($keywords): self
    {
        $this->metaKeywords = $keywords;
        return $this;
    }

    /**
     * @param string $description
     * @return \self
     */
    public function setMetaDescription(string $description): self
    {
        $this->metaDescription = $description;
        return $this;
    }
}
