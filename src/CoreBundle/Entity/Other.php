<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoreBundle\Validator\Constraints as CoreAssert;

/**
 * Class Other
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="media")
 * @Vich\Uploadable
 */
class Other extends Media
{
    const MEDIA_TYPE = 'other';

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="others", fileNameProperty="name")
     * @CoreAssert\ProperMimeType
     * @Assert\File(
     *     maxSize = "3M"
     * )
     */
    protected $file;

    /**
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $description;

    /**
     * @param string|null $description
     * @return \self
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }
}

