<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Customer
 * @package CoreBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="customer")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class Customer extends BaseUser
{
    use TimestampableEntity,
        BlameableEntity;

    /**
     * 
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\Column(type="string")
     * @Assert\Regex("/([A-Z]+)/")
     * @Assert\Length(min=8)
     */
    protected $plainPassword;

    /**
     *
     * @var string
     * @Assert\Expression(
     *      "this.getPlainPassword() == this.getPasswordConfirmation()",
     *      message="admin.client.create.password_confirmation_invalid")
     * )
     */
    protected $passwordConfirmation;

    /**
     * 
     * @return null|string
     */
    public function getPasswordConfirmation()
    {
        return $this->passwordConfirmation;
    }

    /**
     * 
     * @param string $passwordConfirmation
     * @return \self
     */
    public function setPasswordConfirmation(string $passwordConfirmation): self
    {
        $this->passwordConfirmation = $passwordConfirmation;
        return $this;
    }
}
