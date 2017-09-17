<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoreBundle\Document\CmsPage;
use CoreBundle\Document\Gallery;

/**
 * Image model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @MongoDB\Document(collection="image")
 * @Vich\Uploadable
 */
class Image extends AbstractDocumentModel
{

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="images", fileNameProperty="name")
     */
    protected $file;

    /**
     * 
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $alt;

    /**
     * 
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * 
     * @var string
     * @MongoDB\Field(type="string")
     * @Assert\Url()
     */
    protected $url;

    /**
     * 
     * @var string
     * @MongoDB\Field(type="string")
     * @Assert\Url()
     */
    protected $fileUrl;

    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    protected $resize = false;

    /**
     * @var Gallery
     * @MongoDB\ReferenceOne(targetDocument="Gallery", cascade={"all"})
     */
    protected $gallery;

    /**
     * 
     * @return File|null
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getFileUrl()
    {
        return $this->fileUrl;
    }

    public function setFileUrl($fileUrl): self
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getAlt()
    {
        return $this->alt;
    }

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
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 
     * @return bool
     */
    public function getResize(): bool
    {
        return $this->resize;
    }

    /**
     * 
     * @param File|null $file
     * @return \self
     */
    public function setFile($file): self
    {
        if ($file) {
            $this->file = $file;
            $this->updatedAt = new \DateTime('now', new \DateTimeZone('europe/warsaw'));
        }
        return $this;
    }

    /**
     * 
     * @param string $alt
     * @return \self
     */
    public function setAlt($alt): self
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * 
     * @param string|null $title
     * @return \self
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 
     * @param string|null $url
     * @return \self
     */
    public function setUrl($url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 
     * @param bool $resize
     * @return \self
     */
    public function setResize(bool $resize): self
    {
        $this->resize = $resize;
        return $this;
    }

    /**
     * 
     * @return Gallery|null
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * 
     * @param Gallery $gallery
     * @return \self
     */
    public function setGallery(Gallery $gallery): self
    {
        $this->gallery = $gallery;
        return $this;
    }

}
