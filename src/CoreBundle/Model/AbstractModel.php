<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.01.18
 * Time: 03:04
 */

namespace CoreBundle\Model;


use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class AbstractModel
 * @package CoreBundle\Model
 */
class AbstractModel implements AbstractModelInterface
{
    /**
     * @var string|int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     * @Gedmo\Blameable(on="create")
     */
    protected $createdBy;

    /**
     * @var string
     * @Gedmo\Blameable(on="update")
     */
    protected $updatedBy;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|int $id
     * @return IdentityModelInterface
     */
    public function setId($id): IdentityModelInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return NameableModelInterface
     */
    public function setName(?string $name): NameableModelInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param \DateTime $createdAt
     * @return TimestampableModelInterface
     */
    public function setCreatedAt(\DateTime $createdAt): TimestampableModelInterface
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return TimestampableModelInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): TimestampableModelInterface
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param string $createdBy
     * @return BlameableModelInterface
     */
    public function setCreatedBy(string $createdBy): BlameableModelInterface
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @param string $updatedBy
     * @return BlameableModelInterface
     */
    public function setUpdatedBy(string $updatedBy): BlameableModelInterface
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedBy(): string
    {
        return $this->updatedBy;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if ($this->id) {
            return empty($this->name) ? $this->id : $this->name;
        }
        return static::class;
    }
}
