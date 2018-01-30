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
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use CoreBundle\Document\Cms;
use CoreBundle\Document\Image;

/**
 * Class Gallery
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="gallery")
 */
class Gallery extends DocumentAbstractModel
{
    /**
     * @var Feature
     * @MongoDB\ReferenceOne(targetDocument="Feature", orphanRemoval=true)
     */
    protected $feature;

    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Other", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $others;

    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Image", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $images;

    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Video", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    protected $videos;

    /**
     * @var int
     * @MongoDB\Field(type="integer")
     */
    protected $pagePosition = 0;

    /**
     * Gallery constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->others = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getPagePosition(): int
    {
        return $this->pagePosition;
    }

    /**
     * @param int $pagePosition
     * @return \self
     */
    public function setPagePosition(int $pagePosition): self
    {
        $this->pagePosition = $pagePosition;
        return $this;
    }

    public function getMedias()
    {
        $medias = [];
        foreach (get_class_methods($this) as $value) {
            if (preg_match('/(get)(.*)(Medias)/', $value) && $value !== __FUNCTION__) {
                $medias = array_merge($this->$value()->toArray(), $medias);
            }
        }

        return new ArrayCollection($medias);
    }

    /**
     * @return Collection|null
     */
    public function getOthers()
    {
        return $this->others;
    }

    /**
     * @param Collection|null $medias
     * @return Gallery
     */
    public function setOthers($medias): self
    {
        if (!$medias) {
            $medias = new ArrayCollection();
        }
        $this->others = $medias;
        return $this;
    }

    /**
     * @param Other|null $media
     * @return Gallery
     */
    public function addOther(?Other $media): self
    {
        $this->others->add($media);
        return $this;
    }

    /**
     * @param Other|null $media
     * @return Gallery
     */
    public function removeOther(?Other $media): self
    {
        if ($this->others->contains($media)) {
            $this->others->removeElement($media);
        }
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Collection|null $images
     * @return Gallery
     */
    public function setImages(?Collection $images): self
    {
        if (!$images) {
            $images = new ArrayCollection();
        }
        $this->images = $images;
        return $this;
    }

    /**
     * @param Image|null $image
     * @return Gallery
     */
    public function addImage(?Image $image): self
    {
        $this->images->add($image);
        return $this;
    }

    /**
     * @param Image|null $image
     * @return Gallery
     */
    public function removeImage(?Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
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
     * @return Gallery
     */
    public function setVideos(?Collection $videos): self
    {
        if (!$videos) {
            $videos = new ArrayCollection();
        }
        $this->videos = $videos;
        return $this;
    }

    /**
     * @param Video|null $video
     * @return Gallery
     */
    public function addVideo(?Video $video): self
    {
        $this->videos->add($video);
        return $this;
    }

    /**
     * @param Video|null $video
     * @return Gallery
     */
    public function removeVideo(?Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
        }
        return $this;
    }

    /**
     * @return Feature|null
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @param Feature $feature
     * @return Gallery
     */
    public function setFeature(Feature $feature): self
    {
        $this->feature = $feature;
        return $this;
    }
}
