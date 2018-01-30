<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use CoreBundle\Entity\Site;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

//TODO whole model

/**
 * Class MetaKeyword
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="meta_keyword")
 */
class MetaKeyword extends DocumentAbstractModel
{
    /**
     * @var Cms
     * @MongoDB\ReferenceOne(targetDocument="Cms")
     */
    protected $Cms;

    /**
     *
     * @var Site
     * @Gedmo\ReferenceOne(type="orm", class="CoreBundle\Entity\Site", inversedBy="metaKeywords", identifier="siteId")
     * )
     */
    protected $site;

    /**
     *
     * @MongoDB\Field("string")
     */
    protected $siteId;

}
