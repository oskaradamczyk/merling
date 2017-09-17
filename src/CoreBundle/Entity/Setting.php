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
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;

/**
 * Settings model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @ORM\Entity
 * @ORM\Table(name="setting")
 * @UniqueEntity(fields={"host", "baseUrl"})
 */
class Setting extends AbstractEntityModel
{

    use BlameableEntity,
        TimestampableEntity;

    /**
     *
     * @var SiteGroup
     * @ORM\OneToOne(targetEntity="SiteGroup", inversedBy="setting")
     * @Assert\Expression(
     *      "!this.getSiteGroup() and !$this.getSite()",
     *      message="admin.setting.create.no_site_group"
     * )
     */
    protected $siteGroup;

    /**
     *
     * @var Site
     * @ORM\OneToOne(targetEntity="Site", inversedBy="setting")
     * @Assert\Expression(
     *      "!this.getSiteGroup() and !$this.getSite()",
     *      message="admin.setting.create.no_site"
     * )
     */
    protected $site;

}
