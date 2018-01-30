<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 27.12.17
 * Time: 13:18
 */

namespace CoreBundle\Factory;


use CoreBundle\Manager\AbstractManagerInterface;
use CoreBundle\Manager\ImageManager;
use CoreBundle\Model\AbstractModelInterface;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use CoreBundle\Service\ImageService;

class ImageFactory extends AbstractFactory
{
    /**
     * @param string $modelClass
     * @return AbstractManagerInterface
     */
    public function createManager(string $modelClass): AbstractManagerInterface
    {
        return new ImageManager(
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
        return new ImageService($this->logger, $this->translator);
    }
}
