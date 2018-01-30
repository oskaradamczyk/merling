<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 23:10
 */

namespace CoreBundle\Model;


/**
 * Interface AbstractObjectInterface
 * @package CoreBundle\Model
 */
interface AbstractObjectInterface
{
    /**
     * @return string
     */
    public function __toString(): string;
}