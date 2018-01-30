<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 29.09.17
 * Time: 16:46
 */

namespace CoreBundle\Util;

/**
 * Allowed mime types enum for other files.
 */
class OtherAllowedMimeTypeEnum
{
    use Enum;

    const MSWORD_MIME_TYPE = "application/msword";
    const OPENOFFICE_MIME_TYPE = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
    const MSEXCEL_MIME_TYPE = "application/vnd.ms-excel";
    const OPENSHEET_MIME_TYPE = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
    const MSPPOINT_MIME_TYPE = "application/vnd.ms-powerpoint";
    const OPENPRESENTATION_MIME_TYPE = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
    const FONTOBJECT_MIME_TYPE = "application/vnd.ms-fontobject";
    const SFNT_MIME_TYPE = "application/font-sfnt";
    const SVG_MIME_TYPE = "image/svg+xml";
    const WOFF_MIME_TYPE = "application/font-woff";
    const XOPENTYPE_MIME_TYPE = "application/x-font-opentype";
    const WOFF2_MIME_TYPE = "application/font-woff2";
    const OPENTYPE_MIME_TYPE = "font/opentype";
    const XTRUETYPE_MIME_TYPE = "application/x-font-truetype";
    const OTF_MIME_TYPE = "font/otf";
    const APPOPENTYPE_MIME_TYPE = "application/opentype";
    const XFONT_MIME_TYPE = "application/x-font";
    const OASISTPL_MIME_TYPE = "application/vnd.oasis.opendocument.formula-template";
    const MSFONTOBJECT_MIME_TYPE = "application/vnd.ms-fontobject";
    const MSOPENTYPE_MIME_TYPE = "application/vnd.ms-opentype";
    const XWOFF_MIME_TYPE = "application/x-font-woff";
}
