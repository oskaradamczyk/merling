<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity;

use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Site;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Setting
 * @package CoreBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="setting")
 * @UniqueEntity(fields={"host", "baseUrl"})
 */
class Setting extends EntityAbstractModel
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
