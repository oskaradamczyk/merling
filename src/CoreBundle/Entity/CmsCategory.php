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
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use CoreBundle\Document\Traits\SeoFriendlyDocument;

/**
 * Class CmsCategory
 * @package CoreBundle\Document
 * @MongoDB\Document
 */
class CmsCategory extends Category
{
    /**
     * @var Collection
     * @MongoDB\ReferenceMany(targetDocument="Cms", cascade={"persist", "remove"})
     */
    protected $features;
}
