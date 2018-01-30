<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.12.17
 * Time: 02:33
 */

namespace CoreBundle\Model;


/**
 * Interface MenuAwareInterface
 * @package CoreBundle\Model
 */
interface MenuAwareInterface
{
    /**
     * @return string|null
     */
    public function getSlug(): ?string;

    /**
     * @param string|null $slug
     * @return \self
     */
    public function setSlug(?string $slug);

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string|null $name
     * @return \self
     */
    public function setName(?string $name);
}