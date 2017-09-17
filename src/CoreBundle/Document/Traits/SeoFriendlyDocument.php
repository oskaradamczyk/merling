<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Document\Traits;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use CoreBundle\Document\MetaKeyword;

/**
 * SeoFriendlyDocument trait for SEO friendly content.
 *
 * @author oadamczyk
 */
trait SeoFriendlyDocument
{

    /**
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="MetaKeyword", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $metaKeywords;

    /**
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $metaDescription;

    /**
     * 
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 
     * @return array|null
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * 
     * @return string|null
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * 
     * @param string $title
     * @return \self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 
     * @param Collection $keywords
     * @return \self
     */
    public function setMetaKeywords(Collection $keywords): self
    {
        $this->metaKeywords = $keywords;
        return $this;
    }

    /**
     * 
     * @param string $description
     * @return \self
     */
    public function setMetaDescription(string $description): self
    {
        $this->metaDescription = $description;
        return $this;
    }

    /**
     * 
     * @param MetaKeyword $keyword
     * @return \self
     */
    public function addMetaKeyword(MetaKeyword $keyword): self
    {
        $this->metaKeywords->add($keyword);
        return $this;
    }

}
