<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 22.01.18
 * Time: 01:44
 */

namespace CoreBundle\Model;


/**
 * Interface BlameableModelInterface
 * @package CoreBundle\Model
 */
interface BlameableModelInterface
{
    /**
     * @param string $createdBy
     * @return BlameableModelInterface
     */
    public function setCreatedBy(string $createdBy): BlameableModelInterface;

    /**
     * @return string
     */
    public function getCreatedBy(): string;

    /**
     * @param string $updatedBy
     * @return BlameableModelInterface
     */
    public function setUpdatedBy(string $updatedBy): BlameableModelInterface;

    /**
     * @return string
     */
    public function getUpdatedBy(): string;
}
