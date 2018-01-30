<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity;

use CoreBundle\Model\AbstractModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EntityAbstractModel
 * @package CoreBundle\Entity
 */
abstract class EntityAbstractModel extends AbstractModel
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Length(min=3)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $createdBy;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $updatedBy;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
}
