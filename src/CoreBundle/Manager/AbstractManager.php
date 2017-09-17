<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract manager with basic dependency injections for child managers.
 *
 * @author oadamczyk
 */
class AbstractManager implements AbstractManagerInterface
{

    const PARENT_REQUEST_TYPE = 'Parent';
    const MASTER_REQUEST_TYPE = 'Master';

    /** @var ObjectManager */
    protected $om;

    /** @var RequestStack */
    protected $requestStack;

    /** @var ObjectRepository */
    protected $repository;

    public function __construct(ObjectManager $om, string $objectClassName, RequestStack $requestStack = null)
    {
        $this->om = $om;
        $this->repository = $om->getRepository($objectClassName);
        if ($requestStack instanceof RequestStack) {
            $this->requestStack = $requestStack;
        }
    }

    public function getObjectManager(): ObjectManager
    {
        return $this->om;
    }

    public function getRepository(): ObjectRepository
    {
        return $this->repository;
    }

    public function getRequest(string $requestType = null): Request
    {
        if (!$requestType) {
            return $this->requestStack->getCurrentRequest();
        }
        if ($requestType === self::MASTER_REQUEST_TYPE) {
            return $this->requestStack->getMasterRequest();
        }
        if ($requestType === self::PARENT_REQUEST_TYPE) {
            return $this->requestStack->getParentRequest();
        }
    }

}
