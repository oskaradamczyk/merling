<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 22.01.18
 * Time: 01:20
 */

namespace CoreBundle\Model;


interface NameableModelInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string ;

    /**
     * @param null|string $name
     * @return NameableModelInterface
     */
    public function setName(?string $name): NameableModelInterface;
}
