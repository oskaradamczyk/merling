<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface declaration for managers
 *
 * @author oadamczyk
 */
interface AbstractManagerInterface
{

    /**
     * 
     * @return ObjectManager
     */
    public function getObjectManager(): ObjectManager;

    /**
     * 
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository;

    /**
     * 
     * @param string|null $requestType
     * @return Request
     */
    public function getRequest(string $requestType = null): Request;
}
