<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /**
     * Object that will be tested
     *
     * @var Service
     */
    private $object;

    /**
     * Stores the id of the service
     *
     * @var string
     */
    private $expectedId;

    /**
     * Stores the name of the service
     *
     * @var string
     */
    private $expectedName;

    protected function setUp()
    {
        parent::setUp();
        $this->expectedId = 1;
        $this->expectedName = 'Fix the bathroom sink';
        $this->object = new Service(
            $this->expectedId,
            $this->expectedName
        );
    }

    /**
     * @covers \AppBundle\Entity\Service::__construct
     */
    public function testConstruct()
    {
        $this->assertAttributeEquals(
            $this->expectedId,
            'id',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->expectedName,
            'name',
            $this->object
        );
    }

    /**
     * @covers \AppBundle\Entity\Service::getId
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
     * @covers \AppBundle\Entity\Service::getName
     */
    public function testGetName()
    {
        $actual = $this->object->getName();

        $this->assertEquals(
            $this->expectedName,
            $actual,
            'Method getName returned a invalid value'
        );
    }
}