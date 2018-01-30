<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use CoreBundle\Entity\Site;
use CoreBundle\Util\ImageAllowedMimeTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoreBundle\Validator\Constraints as CoreAssert;

/**
 * Class Image
 * @package CoreBundle\Document
 * @MongoDB\Document
 * @Vich\Uploadable
 */
class Image extends Media
{
    const MEDIA_TYPE = 'image';
    const ALLOWED_MIME_TYPES_ENUM = ImageAllowedMimeTypeEnum::class;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="images", fileNameProperty="name")
     * @Assert\File(
     *     maxSize = "16M"
     * )
     */
    protected $file;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $alt;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $url;

    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    protected $resize = false;

    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Video", cascade={"persist"}, orphanRemoval=true, mappedBy="poster")
     * @Assert\Valid
     */
    protected $videos;

    /**
     * @return string|null
     */
    public function getAlt()
    {
        return $this->alt;
    }

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function getResize(): bool
    {
        return $this->resize;
    }

    /**
     * @param string $alt
     * @return \self
     */
    public function setAlt($alt): self
    {
        $this->alt = $alt;
        return $this;
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
     * @param string|null $url
     * @return \self
     */
    public function setUrl($url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param bool $resize
     * @return \self
     */
    public function setResize(bool $resize): self
    {
        $this->resize = $resize;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param Collection|null $videos
     * @return \self
     */
    public function setVideos($videos): self
    {
        if (!$videos) {
            $videos = new ArrayCollection();
        }
        $this->videos = $videos;
        return $this;
    }

    /**
     * @param Video|null $video
     * @return Image
     */
    public function addVideo($video): self
    {
        $this->videos->add($video);
        return $this;
    }

    /**
     * @param Video|null $video
     * @return Image
     */
    public function removeVideo($video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
        }
        return $this;
    }
}
