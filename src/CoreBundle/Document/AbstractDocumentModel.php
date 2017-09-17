<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;

/**
 * Base model for documents to reduce code repetitions
 *
 * @author oadamczyk
 */
abstract class AbstractDocumentModel
{

    use TimestampableDocument,
        BlameableDocument;

    /**
     * 
     * @var string
     * @MongoDB\Id
     */
    protected $id;

    /**
     * 
     * @var string
     * @MongoDB\Field(type="string")
     * @Assert\Length(min=3)
     */
    protected $name;

    public function __construct()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('europe/warsaw'));
        $this->createdAt = new \DateTime('now', new \DateTimeZone('europe/warsaw'));
    }

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
     * @param string|null $name
     * @return \self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

}
