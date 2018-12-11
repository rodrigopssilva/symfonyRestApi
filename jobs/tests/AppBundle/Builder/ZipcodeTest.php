<?php

namespace Tests\AppBundle\Builder;

use AppBundle\Builder\Zipcode;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Zipcode as ZipcodeEntity;

class ZipcodeTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @covers \AppBundle\Builder\Zipcode::build
     */
    public function testBuildCreateEntityWithValues()
    {
        $id = '123';
        $city = 'Hamburg';
        $parameters = [
            'id' => $id,
            'city' => $city
        ];

        $actual = Zipcode::build($parameters);

        $this->assertInstanceOf(
            ZipcodeEntity::class,
            $actual,
            'The method build should return a Zipcode entity'
        );
        $this->assertEquals($id, $actual->getId());
        $this->assertEquals($city, $actual->getCity());
    }

    /**
     * @covers \AppBundle\Builder\Zipcode::build
     */
    public function testBuildCreateEntityWithNullValues()
    {
        $parameters = [];

        $actual = Zipcode::build($parameters);

        $this->assertInstanceOf(
            ZipcodeEntity::class,
            $actual,
            'The method build should return a Zipcode entity'
        );
        $this->assertNull($actual->getId());
        $this->assertNull($actual->getCity());
    }
}
