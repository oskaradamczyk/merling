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
use Doctrine\ODM\MongoDB\Mapping\Annotations\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use CoreBundle\Document\CmsPage;
use CoreBundle\Document\Image;

/**
 * Gallery model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @MongoDB\Document(collection="gallery")
 * @HasLifecycleCallbacks()
 */
class Gallery extends AbstractDocumentModel
{

    /**
     *
     * @var CmsPage
     * @MongoDB\ReferenceOne(targetDocument="CmsPage", inversedBy="cmsPage")
     */
    protected $cmsPage;

    /**
     *
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Image", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $images;

    /**
     * 
     * @var int
     * @MongoDB\Field(type="integer")
     */
    protected $pagePosition = 0;

    public function __construct()
    {
        parent::__construct();
        $this->images = new ArrayCollection();
    }

    /**
     * 
     * @return int
     */
    public function getPagePosition(): int
    {
        return $this->pagePosition;
    }

    /**
     * 
     * @param int $pagePosition
     * @return \self
     */
    public function setPagePosition(int $pagePosition): self
    {
        $this->pagePosition = $pagePosition;
        return $this;
    }

    /**
     * 
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * 
     * @param Collection $images
     * @return \self
     */
    public function setImages(Collection $images): self
    {
        $this->images = $images;
        return $this;
    }

    /**
     * 
     * @param Image|null $image
     */
    public function addImage($image): self
    {
        $this->images->add($image);
        return $this;
    }

    /**
     * 
     * @param Image|null $image
     */
    public function removeImage($image): self
    {
        $this->images->removeElement($image);
        return $this;
    }

    /**
     * 
     * @return CmsPage|null
     */
    public function getCmsPage()
    {
        return $this->cmsPage;
    }

    /**
     * 
     * @param CmsPage $cmsPage
     * @return \self
     */
    public function setCmsPage(CmsPage $cmsPage): self
    {
        $this->cmsPage = $cmsPage;
        return $this;
    }

}
