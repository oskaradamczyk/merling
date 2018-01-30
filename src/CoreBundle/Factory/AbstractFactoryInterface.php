<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 22:56
 */

namespace CoreBundle\Factory;

use CoreBundle\Manager\AbstractManagerInterface;
use CoreBundle\Model\AbstractModelInterface;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;

interface AbstractFactoryInterface
{
    /**
     * @param string $modelClass
     * @return AbstractManagerInterface
     */
    public function createManager(string $modelClass): AbstractManagerInterface;

    /**
     * @return AbstractServiceInterface
     */
    public function createService(): AbstractServiceInterface;
}