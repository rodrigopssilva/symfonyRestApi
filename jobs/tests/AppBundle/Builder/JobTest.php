<?php

namespace Tests\AppBundle\Builder;

use AppBundle\Builder\Job;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Job as JobEntity;

class JobTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @covers \AppBundle\Builder\Job::build
     */
    public function testBuildCreateEntityWithValues()
    {
        $serviceId = '1234';
        $zipcodeId = 'Clean my house';
        $title = 'Job title';
        $description = 'Job description';
        $dateToBeDone = '2018-11-11T00:00:00+00:00';
        $id = '123456';
        $parameters = [
            'serviceId' => $serviceId,
            'zipcodeId' => $zipcodeId,
            'title' => $title,
            'description' => $description,
            'dateToBeDone' => $dateToBeDone,
            'id' => $id
        ];

        $actual = Job::build($parameters);

        $this->assertInstanceOf(
            JobEntity::class,
            $actual,
            'The method build should return a Job entity'
        );
        $this->assertEquals($serviceId, $actual->getServiceId());
        $this->assertEquals($zipcodeId, $actual->getZipcodeId());
    }

    /**
     * @covers \AppBundle\Builder\Job::build
     */
    public function testBuildCreateEntityWithNullValues()
    {
        $parameters = [];

        $actual = Job::build($parameters);

        $this->assertInstanceOf(
            JobEntity::class,
            $actual,
            'The method build should return a Job entity'
        );
        $this->assertNull($actual->getServiceId());
        $this->assertNull($actual->getZipcodeId());
    }
}
