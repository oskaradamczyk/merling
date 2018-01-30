<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.11.17
 * Time: 23:41
 */

namespace Tests\CoreBundle\TestCase;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ContainerAwareTestCase extends WebTestCase
{
    /** @var ContainerInterface */
    protected $container;

    protected function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }
}