<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 29.09.17
 * Time: 16:46
 */

namespace CoreBundle\Util;

/**
 * Allowed mime types enum for images
 */
class ImageAllowedMimeTypeEnum
{
    use Enum;

    const JPG_MIME_TYPE     = 'image/jpg';
    const JPEG_MIME_TYPE    = 'image/jpeg';
    const PNG_MIME_TYPE     = 'image/png';
    const GIF_MIME_TYPE     = 'image/gif';
}
