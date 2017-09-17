<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * User model mapped on DB by FOSUser.
 *
 * @author oadamczyk
 * 
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser
{

    use TimestampableEntity,
        BlameableEntity;

    /**
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * 
     * @Assert\Regex("/([A-Z]+)/")
     * @Assert\Length(min=8)
     */
    protected $plainPassword;

    /**
     *
     * @var string
     * @Assert\Expression(
     *      "this.getPlainPassword() == this.getPasswordConfirmation()",
     *      message="admin.user.create.password_confirmation_invalid")
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
