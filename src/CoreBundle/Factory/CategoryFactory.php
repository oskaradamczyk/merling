<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 23.11.17
 * Time: 02:49
 */

namespace CoreBundle\Factory;


use CoreBundle\Manager\AbstractManagerInterface;
use CoreBundle\Manager\CategoryManager;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use CoreBundle\Service\CategoryService;

class CategoryFactory extends AbstractFactory
{
    /**
     * @param string $modelClass
     * @return AbstractManagerInterface
     */
    public function createManager(string $modelClass): AbstractManagerInterface
    {
        return new CategoryManager(
            $this->validator,
            $this->createService(),
            $this->om,
            $this->eventDispatcher,
            $modelClass
        );
    }

    /**
     * @return AbstractServiceInterface
     */
    public function createService(): AbstractServiceInterface
    {
        return new CategoryService($this->logger, $this->translator);
    }
}
