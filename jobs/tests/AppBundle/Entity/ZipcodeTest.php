<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Zipcode;
use PHPUnit\Framework\TestCase;

class ZipcodeTest extends TestCase
{
    /**
     * Object that will be tested
     *
     * @var Zipcode
     */
    private $object;

    /**
     * Stores the id of the city
     *
     * @var string
     */
    private $expectedId;

    /**
     * Stores the name of the city
     *
     * @var string
     */
    private $expectedCity;

    protected function setUp()
    {
        parent::setUp();
        $this->expectedId = 1;
        $this->expectedCity = 'Berlin';
        $this->object = new Zipcode(
            $this->expectedId,
            $this->expectedCity
        );
    }

    /**
     * @covers \AppBundle\Entity\Zipcode::__construct
     */
    public function testConstruct()
    {
        $this->assertAttributeEquals(
            $this->expectedId,
            'id',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->expectedCity,
            'city',
            $this->object
        );
    }

    /**
     * @covers \AppBundle\Entity\Zipcode::getId
     */
    public function testGetId()
    {
        $actual = $this->object->getId();

        $this->assertEquals(
            $this->expectedId,
            $actual,
            'Method getId returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Zipcode::getCity
     */
    public function testGetCity()
    {
        $actual = $this->object->getCity();

        $this->assertEquals(
            $this->expectedCity,
            $actual,
            'Method getCity returned a invalid value'
        );
    }
}