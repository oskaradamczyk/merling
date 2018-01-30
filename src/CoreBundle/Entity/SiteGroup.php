<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Entity;

use CoreBundle\Document\Favicon;
use CoreBundle\Document\Logo;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\Setting;
use CoreBundle\Document\Product;
use CoreBundle\Document\Category;
use CoreBundle\Entity\Traits\SeoFriendlyEntity;
use CoreBundle\Model\SiteAffiliationInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SiteGroup
 * @package CoreBundle\Entity
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\SiteGroupRepository")
 * @ORM\Table(name="site_group")
 */
class SiteGroup extends EntityAbstractModel implements SiteAffiliationInterface
{
    use SeoFriendlyEntity;

    /**
     * @var Site
     * @ORM\OneToMany(targetEntity="Site", mappedBy="siteGroup", cascade={"persist", "remove"})
     */
    protected $sites;

    /**
     * @var Collection
     * @Gedmo\ReferenceMany(type="odm", class="CoreBundle\Document\Feature", mappedBy="siteGroup")
     */
    protected $features;

    /**
     * @var Collection
     * @Gedmo\ReferenceMany(type="document", class="CoreBundle\Document\Category", mappedBy="siteGroup")
     */
    protected $categories;

    /**
     * @var ArrayCollection
     * @Gedmo\ReferenceMany(type="document", class="CoreBundle\Document\Product", mappedBy="siteGroup")
     */
    protected $products;

    /**
     * @var Setting
     * @ORM\OneToOne(targetEntity="Setting", mappedBy="siteGroup", cascade={"persist", "remove"})
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
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $secondaryColor = '#000000';

    /**
     * SiteGroup constructor.
     */
    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

    /**
     * @return Setting|null
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @param Setting $setting
     * @return \self
     */
    public function setSetting(Setting $setting): self
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param Collection|null $features
     * @return \self
     */
    public function setFeatures($features): self
    {
        $this->features = $features;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Collection|null $categories
     * @return SiteGroup
     */
    public function setCategories($categories): SiteGroup
    {
        if (!$categories) {
            $categories = new ArrayCollection();
        }
        $this->categories = $categories;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     *
     * @param ArrayCollection $sites
     * @return \self
     */
    public function setSites(ArrayCollection $sites): self
    {
        $this->sites = $sites;
        return $this;
    }

    /**
     *
     * @param Site $site
     * @return \self
     */
    public function addSite(Site $site): self
    {
        $this->sites->add($site);
        return $this;
    }

    /**
     *
     * @return ArrayCollection|null
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     *
     * @param ArrayCollection $products
     * @return $this
     */
    public function setProducts(ArrayCollection $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     *
     * @param Category $category
     * @return \self
     */
    public function addCategory(Category $category): self
    {
        $this->categories->add($category);
        return $this;
    }

    /**
     *
     * @param Product $product
     * @return \self
     */
    public function addProduct(Product $product): self
    {
        $this->products->add($product);
        return $this;
    }

    /**
     * @return Favicon|null
     */
    public function getFavicon(): ?Favicon
    {
        return $this->favicon;
    }

    /**
     * @param Favicon|null $favicon
     * @return SiteGroup|null
     */
    public function setFavicon(?Favicon $favicon): ?SiteGroup
    {
        $this->favicon = $favicon;
        return $this;
    }

    /**
     * @return Logo|null
     */
    public function getLogo(): ?Logo
    {
        return $this->logo;
    }

    /**
     * @param Logo|null $logo
     * @return SiteGroup|null
     */
    public function setLogo(?Logo $logo): ?SiteGroup
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
     * @return SiteGroup
     */
    public function setThemeColor(?string $themeColor): SiteGroup
    {
        $this->themeColor = $themeColor;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSecondaryColor(): ?string
    {
        return $this->secondaryColor;
    }

    /**
     * @param null|string $secondaryColor
     * @return SiteGroup
     */
    public function setSecondaryColor(?string $secondaryColor): SiteGroup
    {
        $this->secondaryColor = $secondaryColor;
        return $this;
    }
}
