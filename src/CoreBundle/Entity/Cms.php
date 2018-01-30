<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Cms
 * @package CoreBundle\Document
 * @MongoDB\Document(collection="cms", repositoryClass="CoreBundle\Repository\CmsRepository")
 */
class Cms extends Feature
{
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $content;

    /**
     * @var CmsCategory
     * @MongoDB\ReferenceOne(targetDocument="CmsCategory")
     * @Assert\Expression(
     *      "(this.getSiteGroup() != null and this.getSite() == null and this.getCategory() == null) or (this.getSiteGroup() == null and this.getSite() != null and this.getCategory() == null) or (this.getSiteGroup() == null and this.getSite() == null and this.getCategory() != null)",
     *      message="core.feature.create.site_and_category_and_site_group_xor"
     * )
     */
    protected $category;

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return \self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
