<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Category
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="page")
 */
class Page extends Cms
{
    /**
     * @var null
     */
    protected $category = null;
}
