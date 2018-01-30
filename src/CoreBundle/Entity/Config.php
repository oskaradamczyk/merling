<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 03.10.17
 * Time: 01:11
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Config
 * @package CoreBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="config")
 * @UniqueEntity(fields={"name", "user"})
 */
class Config extends EntityAbstractModel
{
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Length(min=2)
     */
    protected $locale;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="config", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string|null $locale
     * @return Config
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Config
     */
    public function setUser($user): self
    {
        $this->user = $user;
        return $this;
    }
}
