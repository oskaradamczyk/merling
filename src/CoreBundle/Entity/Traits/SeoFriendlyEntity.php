<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Entity\Traits;

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
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;
    /**
     *
     * @var Collection
     * @Gedmo\ReferenceMany(type="odm", class="CoreBundle\Document\MetaKeyword")
     */
    protected $metaKeywords;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
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
     * @return Collection|null
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
     * @param Collection|null $keywords
     * @return \self
     */
    public function setMetaKeywords($keywords): self
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
     * @param string $keyword
     * @return \self
     */
    public function addMetaKeyword(string $keyword): self
    {
        $this->metaKeywords->add($keyword);
        return $this;
    }

}
