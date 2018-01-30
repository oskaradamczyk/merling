<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity;


use CoreBundle\Document\Category;
use CoreBundle\Document\Favicon;
use CoreBundle\Document\Image;
use CoreBundle\Document\Logo;
use CoreBundle\Entity\Setting;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Entity\Traits\SeoFriendlyEntity;
use CoreBundle\Model\SiteAffiliationInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Site
 * @package CoreBundle\Entity
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\SiteRepository")
 * @ORM\EntityListeners({"CoreBundle\Listener\EntityListener\SiteEntityListener"})
 * @ORM\Table(name="site")
 * @UniqueEntity(fields={"host", "baseUrl"})
 * @Vich\Uploadable
 */
class Site extends EntityAbstractModel implements SiteAffiliationInterface
{
    use SeoFriendlyEntity;

    /**
     * @var SiteGroup
     * @ORM\ManyToOne(targetEntity="SiteGroup", inversedBy="sites")
     */
    protected $siteGroup;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\Type("boolean")
     */
    protected $secure = false;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $host;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $baseUrl;

    /**
     * @var Collection
     * @Gedmo\ReferenceMany(type="odm", class="CoreBundle\Document\Feature", mappedBy="site")
     */
    protected $features;

    /**
     * @var Collection
     * @Gedmo\ReferenceMany(type="odm", class="CoreBundle\Document\Category", mappedBy="site")
     */
    protected $categories;

    /**
     * @var Setting
     * @ORM\OneToOne(targetEntity="Setting", mappedBy="site", cascade={"persist", "remove"})
     */
    protected $setting;

    /**
     * @var Favicon
     * @Gedmo\ReferenceOne(type="odm", class="CoreBundle\Document\Favicon", mappedBy="site")
     */
    protected $favicon;

    /**
     * @var Logo
     * @Gedmo\ReferenceOne(type="odm", class="CoreBundle\Document\Logo", mappedBy="site")
     */
    protected $logo;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $themeColor = '#000000';

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $secondaryColor = '#000000';

    /**
     * Virtual field for absolute url of site
     */
    protected $absoluteUrl;

    /**
     * Site constructor.
     */
    public function __construct()
    {
        $this->Cmss = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param Collection|null $features
     * @return \self
     */
    public function setFeatures(?Collection $features): self
    {
        if (!$features) {
            $features = new ArrayCollection();
        }
        $this->features = $features;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection|null $categories
     * @return Site
     */
    public function setCategories(?Collection $categories): Site
    {
        if (!$categories) {
            $categories = new ArrayCollection();
        }
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return SiteGroup|null
     */
    public function getSiteGroup(): ?SiteGroup
    {
        return $this->siteGroup;
    }

    /**
     * @return boolean
     */
    public function isSecure(): bool
    {
        return $this->secure;
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    /**
     * @param SiteGroup|null $group
     * @return Site
     */
    public function setSiteGroup(?SiteGroup $group): self
    {
        $this->siteGroup = $group;
        return $this;
    }

    /**
     * @param bool $secure
     * @return Site
     */
    public function setSecure(bool $secure): self
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @param null|string $host
     * @return Site
     */
    public function setHost(?string $host): self
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @param null|string $baseUrl
     * @return Site
     */
    public function setBaseUrl(?string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @return Setting
     */
    public function getSetting(): ?Setting
    {
        return $this->setting;
    }

    /**
     * @return Image|null
     */
    public function getFavicon(): ?Image
    {
        return $this->favicon;
    }

    /**
     * @return Logo|null
     */
    public function getLogo(): ?Logo
    {
        return $this->logo;
    }

    /**
     * @param $setting
     * @return Site
     */
    public function setSetting($setting): self
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * @param Image|null $favicon
     * @return Site
     */
    public function setFavicon(?Image $favicon): self
    {
        $this->favicon = $favicon;
        return $this;
    }

    /**
     * @param Logo|null $logo
     * @return Site
     */
    public function setLogo(?Logo $logo): self
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getThemeColor(): ?string
    {
        return $this->themeColor;
    }

    /**
     * @param null|string $themeColor
     * @return Site
     */
    public function setThemeColor(?string $themeColor): Site
    {
        $this->themeColor = $themeColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryColor(): ?string
    {
        return $this->secondaryColor;
    }

    /**
     * @param null|string $secondaryColor
     * @return Site
     */
    public function setSecondaryColor(?string $secondaryColor): Site
    {
        $this->secondaryColor = $secondaryColor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbsoluteUrl(): ?string
    {
        return $this->absoluteUrl;
    }

    /**
     * @param string|null $absoluteUrl
     * @return Site
     */
    public function setAbsoluteUrl(?string $absoluteUrl)
    {
        $this->absoluteUrl = $absoluteUrl;
        return $this;
    }
}
