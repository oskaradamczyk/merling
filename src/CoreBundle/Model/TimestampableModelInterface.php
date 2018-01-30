<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 22.01.18
 * Time: 01:33
 */

namespace CoreBundle\Model;


/**
 * Interface TimestampableModelInterface
 * @package CoreBundle\Model
 */
interface TimestampableModelInterface
{
    /**
     * @param \DateTime $createdAt
     * @return TimestampableModelInterface
     */
    public function setCreatedAt(\DateTime $createdAt): TimestampableModelInterface;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $updatedAt
     * @return TimestampableModelInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt): TimestampableModelInterface;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
