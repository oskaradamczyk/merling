<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoreBundle\Entity\Setting;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Traits\SeoFriendlyEntity;

/**
 * Site model mapped on DB.
 *
 * @author oadamczyk
 * 
 * @ORM\Entity
 * @ORM\Table(name="site")
 * @UniqueEntity(fields={"host", "baseUrl"})
 * @Vich\Uploadable
 */
class Site extends AbstractEntityModel
{

    use SeoFriendlyEntity;

    /**
     *
     * @var SiteGroup
     * @ORM\ManyToOne(targetEntity="SiteGroup", inversedBy="sites")
     */
    protected $siteGroup;

    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\Type("boolean")
     */
    protected $secure = false;

    /**
     *
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $host;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $baseUrl;

    /**
     *
     * @var Collection
     * @Gedmo\ReferenceMany(type="odm", class="CoreBundle\Document\CmsPage", mappedBy="site")
     */
    protected $cmsPages;

    /**
     *
     * @var Setting
     * @ORM\OneToOne(targetEntity="Setting", mappedBy="site", cascade={"persist", "remove"})
     */
    protected $setting;

    /**
     * 
     * @var File|null
     * @Vich\UploadableField(mapping="favicon", fileNameProperty="faviconName")
     */
    protected $faviconFile;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $faviconName;

    /**
     * 
     * @var File|null
     * @Vich\UploadableField(mapping="logo", fileNameProperty="logoName")
     */
    protected $logoFile;

    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $logoName;

    public function __construct()
    {
        $this->cmsPages = new ArrayCollection();
        $this->metaKeywords = new ArrayCollection();
    }

    /**
     * 
     * @return ArrayCollectio|null
     */
    public function getCmsPages()
    {
        return $this->cmsPages;
    }

    /**
     * 
     * @param Collection $cmsPages
     * @return \self
     */
    public function setCmsPages(ArrayCollection $cmsPages): self
    {
        $this->cmsPages = $cmsPages;
        return $this;
    }

    /**
     * 
     * @return SiteGroup|null
     */
    public function getSiteGroup()
    {
        return $this->siteGroup;
    }

    /**
     * 
     * @return boolean|null
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * 
     * @return string|null
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * 
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * 
     * @param SiteGroup $group
     * @return $this
     */
    public function setSiteGroup(SiteGroup $group): self
    {
        $this->siteGroup = $group;
        return $this;
    }

    /**
     * 
     * @param bool $secure
     * @return $this
     */
    public function setSecure(bool $secure): self
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * 
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): self
    {
        $this->host = $host;
        return $this;
    }

    /**
     * 
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * 
     * @return Setting
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * 
     * @return File|null
     */
    public function getFaviconFile(): File
    {
        return $this->faviconFile;
    }

    /**
     * 
     * @return string|null
     */
    public function getFaviconName()
    {
        return $this->faviconName;
    }

    /**
     * 
     * @return File|null
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * 
     * @return string|null
     */
    public function getLogoName()
    {
        return $this->logoName;
    }

    /**
     * 
     * @param Setting|null $setting
     * @return \self
     */
    public function setSetting($setting): self
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * 
     * @param File|null $faviconFile
     * @return \self
     */
    public function setFaviconFile($faviconFile): self
    {
        $this->faviconFile = $faviconFile;
        return $this;
    }

    /**
     * 
     * @param string|null $faviconName
     * @return \self
     */
    public function setFaviconName($faviconName): self
    {
        $this->faviconName = $faviconName;
        return $this;
    }

    /**
     * 
     * @param File|null $logoFile
     * @return \self
     */
    public function setLogoFile($logoFile): self
    {
        $this->logoFile = $logoFile;
        return $this;
    }

    /**
     * 
     * @param string|null $logoName
     * @return \self
     */
    public function setLogoName($logoName): self
    {
        $this->logoName = $logoName;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->name ? $this->name : '';
    }

    /**
     * 
     * Virtual method for getting whole URL of site
     * 
     * @return string
     */
    public function getAbsoluteUrl(): string
    {
        $schema = 'http://';
        if ($this->isSecure()) {
            $schema = 'https://';
        }
        return implode('.', [$schema, (string) $this->host, (string) $this->baseUrl]);
    }

}
