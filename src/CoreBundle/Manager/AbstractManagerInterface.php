<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 22:59
 */

namespace CoreBundle\Manager;

use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use Doctrine\Common\Collections\Collection;

interface AbstractManagerInterface
{
    /**
     * @param AbstractObjectInterface $model
     * @return Collection
     */
    public function validate(AbstractObjectInterface $model): Collection;

    /**
     * @return AbstractServiceInterface
     */
    public function getService(): AbstractServiceInterface;
}