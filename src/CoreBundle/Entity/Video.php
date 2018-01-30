<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use CoreBundle\Util\VideoAllowedMimeTypeEnum;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Video
 * @package CoreBundle\Document
 * @MongoDB\Document
 * @Vich\Uploadable
 */
class Video extends Media
{
    const MEDIA_TYPE = 'video';
    const ALLOWED_MIME_TYPES_ENUM = VideoAllowedMimeTypeEnum::class;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="videos", fileNameProperty="name")
     * @Assert\File(
     *     maxSize = "250M"
     * )
     */
    protected $file;

    /**
     * @var Image
     * @MongoDB\ReferenceOne(targetDocument="Image", cascade={"persist"}, orphanRemoval=true, inversedBy="video")
     * @Assert\Valid
     */
    protected $poster;

    /**
     * @return Image|null
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param Image|null $poster
     * @return Video
     */
    public function setPoster($poster): Video
    {
        $this->poster = $poster;
        return $this;
    }
}

