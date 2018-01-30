<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use CoreBundle\Util\Enum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoreBundle\Validator\Constraints as CoreAssert;

//TODO Audio and Doc subclasses for DiscriminatorMap

/**
 * Class Media
 * @package CoreBundle\Document
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn()
 * @MongoDB\DiscriminatorMap({
 *     "1"="Image",
 *     "2"="Video",
 *     "3"="Logo",
 *     "4"="Favicon",
 *     "6"="Other"
 * })
 * @Vich\Uploadable
 */
abstract class Media extends DocumentAbstractModel
{
    /**
     * @var File
     * @Assert\NotBlank
     * @CoreAssert\ProperMimeType
     */
    protected $file;

    /**
     * @var Gallery|null
     * @MongoDB\ReferenceOne(targetDocument="Gallery")
     */
    protected $gallery;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $fileUrl;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $mediaType;

    /**
     * Media constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $reflection = new \ReflectionClass(static::class);
        $this->mediaType = $reflection->getConstant('MEDIA_TYPE');
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @return string|null
     */
    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    /**
     * @param string|null $type
     * @return Media
     */
    public function setMediaType(?string $type): self
    {
        $this->mediaType = $type;
        return $this;
    }

    /**
     * @param SplFileInfo|File|null $file
     * @return Media
     */
    public function setFile($file): self
    {
        if ($file) {
            $this->file = $file;
            $this->updatedAt = new \DateTime('now', new \DateTimeZone('europe/warsaw'));
        }
        return $this;
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
     * @return Gallery|null
     */
    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    /**
     * @param Gallery|null $gallery
     * @return Media
     */
    public function setGallery(?Gallery $gallery): self
    {
        $this->gallery = $gallery;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedMimeTypes(): array
    {
        $reflection = new \ReflectionClass(static::class);
        /** @var Enum $enum */
        $enum = $reflection->getConstant('ALLOWED_MIME_TYPES_ENUM');
        return $enum::getConstants();
    }
}
