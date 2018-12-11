<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\JobController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\Job as JobService;
use AppBundle\Builder\Job as JobBuilder;

/**
 * @group functional
 */
class JobControllerTest extends AbstractControllerTest
{
    /**
     * @var array
     */
    private $defaultJob;

    public function setUp()
    {
        parent::setUp();
        $this->loadServiceFixtures();
        $this->loadZipcodeFixtures();
        $this->loadJobFixtures();
        $this->defaultJob = [
            'serviceId' => 804040,
            'zipcodeId' => '10115',
            'title' => 'title',
            'description' => 'decription',
            'dateToBeDone' => '2018-11-11'
        ];
    }

    /**
     * @covers \AppBundle\Controller\JobController::__construct
     */
    public function testConstruct()
    {
        $controller = new JobController();

        $this->assertInstanceOf(
            JobController::class,
            $controller
        );
        $this->assertAttributeEquals(
            JobService::class,
            'serviceName',
            $controller
        );
        $this->assertAttributeEquals(
            JobBuilder::class,
            'builder',
            $controller
        );
    }

    /**
     * @covers \AppBundle\Controller\JobController::getAllFilteringAction
     */
    public function testGetAllFiltering()
    {
        $expected = json_decode(file_get_contents('tests/Fixtures/jobs.json'), true);
        $expected[0]['id'] = $this->getFirstJobId();

        $this->client->request('GET', '/job');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(json_encode($expected), $this->client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\JobController::getAllAction
     * @covers \AppBundle\Controller\AbstractController::getAllAction
     */
    public function testGetAllJobs()
    {
        $expected = json_decode(file_get_contents('tests/Fixtures/jobs.json'), true);
        $expected[0]['id'] = $this->getFirstJobId();
        $expected[0]['created_at'] = (new \DateTime('2018-11-11T00:00:00+00:00'))
            ->format(\DateTimeInterface::ATOM);

        $this->client->request('GET', '/job');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(json_encode($expected), $this->client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\JobController::getAction
     * @covers \AppBundle\Controller\AbstractController::getAction
     */
    public function testGetOneJobFound()
    {
        $expected = [
            'id' => $this->getFirstJobId(),
            'service_id' => 804040,
            'zipcode_id' => "10115",
            'title' => 'title',
            'description' => 'decription',
            'date_to_be_done' => '2018-11-11T00:00:00+00:00',
            'created_at' => (new \DateTime('2018-11-11T00:00:00+00:00'))
                ->format(\DateTimeInterface::ATOM)
        ];

        $this->client->request('GET', '/job/' . $expected['id']);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(json_encode($expected), $this->client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\JobController::getAction
     * @covers \AppBundle\Controller\AbstractController::getAction
     */
    public function testGetOneJobNotFound()
    {
        $this->client->request('GET', '/job/1');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\JobController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostInvalidJobReturnsBadRequest()
    {
        $this->defaultJob['title'] = '';

        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\JobController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostJobWithServiceNotFoundReturnsBadRequest()
    {
        $this->defaultJob['serviceId'] = 12345;

        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\JobController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostJobWithZipcodeNotFoundReturnsBadRequest()
    {
        $this->defaultJob['zipcodeId'] = '12345';

        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\JobController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostValidJobNewJobIsCreated()
    {
        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\JobController::putAction
     */
    public function testPutWithNotFoundJobReturnsNotFound()
    {
        $this->client->request(
            'PUT',
            '/job/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\JobController::putAction
     */
    public function testPutWithValidJobReturnsNotFound()
    {
        $this->client->request(
            'PUT',
            '/job/' . $this->getFirstJobId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Returns the id generated to the first job.
     *
     * @return String
     */
    private function getFirstJobId()
    {
        $this->client->request('GET', '/job');
        $allJobs = json_decode($this->client->getResponse()->getContent(), true);
        $id = $allJobs[0]['id'];

        return $id;
    }
}
