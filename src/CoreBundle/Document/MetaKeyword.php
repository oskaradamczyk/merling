<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MetaKeyword embedded model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @MongoDB\Document(collection="meta_keyword")
 */
class MetaKeyword extends AbstractDocumentModel
{

    /**
     * @var CmsPage
     * @MongoDB\ReferenceOne(targetDocument="CmsPage")
     */
    protected $cmsPage;

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
