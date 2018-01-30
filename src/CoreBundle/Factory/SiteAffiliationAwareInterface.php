<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.01.18
 * Time: 21:03
 */

namespace CoreBundle\Factory;


use Symfony\Component\HttpFoundation\RequestStack;

interface SiteAffiliationAwareInterface
{
    /**
     * @param RequestStack $requestStack
     * @return mixed
     */
    public function setRequestStack(RequestStack $requestStack);

    /**
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack;
}
