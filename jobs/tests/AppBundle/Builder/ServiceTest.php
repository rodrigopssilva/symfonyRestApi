<?php

namespace Tests\AppBundle\Builder;

use AppBundle\Builder\Service;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Service as ServiceEntity;

class ServiceTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @covers \AppBundle\Builder\Service::build
     */
    public function testBuildCreateEntityWithValues()
    {
        $id = '1234';
        $name = 'Clean my house';
        $parameters = [
            'id' => $id,
            'name' => $name
        ];

        $actual = Service::build($parameters);

        $this->assertInstanceOf(
            ServiceEntity::class,
            $actual,
            'The method build should return a Service entity'
        );
        $this->assertEquals($id, $actual->getId());
        $this->assertEquals($name, $actual->getName());
    }

    /**
     * @covers \AppBundle\Builder\Service::build
     */
    public function testBuildCreateEntityWithNullValues()
    {
        $parameters = [];

        $actual = Service::build($parameters);

        $this->assertInstanceOf(
            ServiceEntity::class,
            $actual,
            'The method build should return a Service entity'
        );
        $this->assertNull($actual->getId());
        $this->assertNull($actual->getName());
    }
}
