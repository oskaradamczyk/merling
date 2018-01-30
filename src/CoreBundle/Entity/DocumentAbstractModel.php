<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;


use CoreBundle\Model\AbstractModel;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DocumentAbstractModel
 * @package CoreBundle\Document
 */
abstract class DocumentAbstractModel extends AbstractModel
{
    /**
     * @var string
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Assert\Length(min=3)
     */
    protected $name;

    /**
     * @var \DateTime
     * @MongoDB\Field(type="date")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @MongoDB\Field(type="date")
     */
    protected $updatedAt;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $createdBy;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $updatedBy;
}
