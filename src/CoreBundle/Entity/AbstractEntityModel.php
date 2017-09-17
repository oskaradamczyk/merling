<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Base model for entities to reduce code repetitions
 *
 * @author oadamczyk
 */
abstract class AbstractEntityModel
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
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Length(min=3)
     */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $name
     * @return \self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

}
