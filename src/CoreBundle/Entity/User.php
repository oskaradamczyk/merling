<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity;

use CoreBundle\Model\AbstractModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 * @package CoreBundle\Entity
 * @ORM\Entity
 * @ORM\EntityListeners({"CoreBundle\Listener\EntityListener\UserEntityListener"})
 * @ORM\Table(name="`user`")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser implements AbstractModelInterface
{
    use TimestampableEntity,
        BlameableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Group")
     * @ORM\JoinTable(name="user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "admin.fos_user.create.groups"
     * )
     */
    protected $groups;

    /**
     * @var Config
     * @ORM\OneToOne(targetEntity="Config", mappedBy="user")
     */
    protected $config;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/([A-Z]+)/",
     *     message="core.fos_user.create.password_format"
     * )
     * @Assert\Length(
     *     min=8,
     *     minMessage="core.fos_user.create.password_length"
     * )
     * @Assert\NotBlank(groups={"Create"})
     */
    protected $plainPassword;

    /**
     * @return Config|null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config|null $config
     * @return User
     */
    public function setConfig($config): self
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param null|string $name
     * @return User
     */
    public function setName(?string $name): self
    {
        $this->username = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->username ? $this->username : '';
    }
}
