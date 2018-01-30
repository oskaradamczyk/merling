<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.11.17
 * Time: 23:13
 */

namespace Tests\CoreBundle\Manager;

use CoreBundle\Manager\AbstractManager;
use CoreBundle\Model\Mail;
use CoreBundle\Service\AbstractService;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\CoreBundle\TestCase\ContainerAwareTestCase;

class AbstractManagerTest extends ContainerAwareTestCase
{
    /**
     * @dataProvider validateDataProvider
     *
     * @param ParameterBag $data
     */
    public function testValidate(ParameterBag $data)
    {
        $serviceStub = $this->getMockForAbstractClass(
            AbstractService::class,
            [$this->container->get('logger'), $this->container->get('translator')]
        );
        $stub = $this->getMockForAbstractClass(
            AbstractManager::class,
            [$this->container->get('validator'), $serviceStub, get_class($data->get('object'))]
        );
        $this->assertEquals($data->get('expected_errors_count'), $stub->validate($data->get('object'))->count());
    }

    public function validateDataProvider()
    {
        for ($i = 0; $i < 5; $i++) {
            $mail = new Mail();
            $mail
                ->setContent($i > 3 ? null : 'Test content')
                ->setSubject($i > 2 ? null : 'Test subject')
                ->setReceiver($i > 1 ? null : 'test_email@test.com')
                ->setFrom($i > 0 ? null : 'test_email_from@test.com');
            yield $i . '_errors' => [
                'data' => new ParameterBag([
                    'object' => $mail,
                    'expected_errors_count' => $i
                ])
            ];
        }
    }
}