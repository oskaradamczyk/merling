<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 23.11.17
 * Time: 02:49
 */

namespace CoreBundle\Factory;


use CoreBundle\Manager\AbstractManagerInterface;
use CoreBundle\Manager\CmsManager;
use CoreBundle\Model\AbstractModelInterface;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use CoreBundle\Service\CmsService;

class CmsFactory extends AbstractFactory
{
    /**
     * @param string $modelClass
     * @return AbstractManagerInterface
     */
    public function createManager(string $modelClass): AbstractManagerInterface
    {
        return new CmsManager(
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
        return new CmsService($this->logger, $this->translator);
    }
}