<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 23.11.17
 * Time: 23:10
 */

namespace Tests\CoreBundle\Service;


use CoreBundle\Service\AbstractService;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\CoreBundle\TestCase\ContainerAwareTestCase;

class AbstractServiceTest extends ContainerAwareTestCase
{

    /**
     * @dataProvider translateDataProvider
     *
     * @param ParameterBag $data
     */
    public function testTranslate(ParameterBag $data)
    {
        $stub = $this->getMockForAbstractClass(
            AbstractService::class,
            [$this->container->get('logger'), $this->container->get('translator')]
        );

        $this->assertEquals($data->get('expected_translation'), $stub->translate($data->get('key')));
    }

    public function translateDataProvider()
    {
        return [
            'valid' => [
                'data' => new ParameterBag([
                    'key' => 'core.test',
                    'expected_translation' => 'Test translation'
                ])
            ],
            'invalid' => [
                'data' => new ParameterBag([
                    'key' => $invalidKey = base64_decode('core.test'),
                    'expected_translation' => $invalidKey
                ])
            ]
        ];
    }
}