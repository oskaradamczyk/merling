<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.01.18
 * Time: 21:32
 */

namespace CoreBundle\Factory;


use CoreBundle\Manager\AbstractManagerInterface;
use CoreBundle\Manager\SiteGroupManager;
use CoreBundle\Manager\SiteManager;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use CoreBundle\Service\SiteGroupService;
use CoreBundle\Service\SiteService;
use Symfony\Component\HttpFoundation\RequestStack;

class SiteGroupFactory extends AbstractFactory implements SiteAffiliationAwareInterface
{
    /** @var RequestStack */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     * @return $this
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        return $this;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    /**
     * @param string $modelClass
     * @return AbstractManagerInterface
     */
    public function createManager(string $modelClass): AbstractManagerInterface
    {
        return new SiteGroupManager(
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
        return new SiteGroupService($this->logger, $this->translator);
    }
}