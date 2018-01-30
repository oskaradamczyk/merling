<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 22.01.18
 * Time: 01:20
 */

namespace CoreBundle\Model;

/**
 * Interface IdentityModelInterface
 * @package CoreBundle\Model
 */
interface IdentityModelInterface
{
    /**
     * @return string|int
     */
    public function getId();

    /**
     * @param string|int $id
     * @return IdentityModelInterface
     */
    public function setId($id): IdentityModelInterface;
}
