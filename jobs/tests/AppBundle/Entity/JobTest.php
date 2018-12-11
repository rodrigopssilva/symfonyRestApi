<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Job;
use PHPUnit\Framework\TestCase;

class JobTest extends TestCase
{
    /**
     * Object that will be tested
     *
     * @var Job
     */
    private $object;

    protected function setUp()
    {
        parent::setUp();
        $this->service_id = 1;
        $this->zipcode_id = '12345';
        $this->title = 'Job title';
        $this->description = 'Job description';
        $this->date_to_be_done = new \DateTime();
        $this->id = '123';
        $this->created_at = new \DateTime();

        $this->object = new Job(
            $this->service_id,
            $this->zipcode_id,
            $this->title,
            $this->description,
            $this->date_to_be_done,
            $this->id,
            $this->created_at
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::__construct
     */
    public function testConstruct()
    {
        $this->assertAttributeEquals(
            $this->service_id,
            'service_id',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->zipcode_id,
            'zipcode_id',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->title,
            'title',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->description,
            'description',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->date_to_be_done,
            'date_to_be_done',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->id,
            'id',
            $this->object
        );

        $this->assertAttributeEquals(
            $this->created_at,
            'created_at',
            $this->object
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getId
     */
    public function testGetId()
    {
        $actual = $this->object->getId();

        $this->assertEquals(
            $this->id,
            $actual,
            'Method getId returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getServiceId
     */
    public function testGetServiceId()
    {
        $actual = $this->object->getServiceId();

        $this->assertEquals(
            $this->service_id,
            $actual,
            'Method getServiceId returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getZipcodeId
     */
    public function testGetZipcodeId()
    {
        $actual = $this->object->getZipcodeId();

        $this->assertEquals(
            $this->zipcode_id,
            $actual,
            'Method getZipcodeId returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getTitle
     */
    public function testGetTitle()
    {
        $actual = $this->object->getTitle();

        $this->assertEquals(
            $this->title,
            $actual,
            'Method getTitle returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getDescription
     */
    public function testGetDescription()
    {
        $actual = $this->object->getDescription();

        $this->assertEquals(
            $this->description,
            $actual,
            'Method getDescription returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getDateToBeDone
     */
    public function testGetDateToBeDone()
    {
        $actual = $this->object->getDateToBeDone();

        $this->assertEquals(
            $this->date_to_be_done,
            $actual,
            'Method getDateToBeDone returned a invalid value'
        );
    }

    /**
     * @covers \AppBundle\Entity\Job::getCreatedAt
     */
    public function testGetCreatedAt()
    {
        $actual = $this->object->getCreatedAt();

        $this->assertEquals(
            $this->created_at,
            $actual,
            'Method getCreatedAt returned a invalid value'
        );
    }

}