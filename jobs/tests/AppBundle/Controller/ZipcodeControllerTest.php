<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Builder\Zipcode as Zipcodebuilder;
use AppBundle\Services\Zipcode as ZipcodeService;
use AppBundle\Controller\ZipcodeController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ZipcodeControllerTest extends AbstractControllerTest
{
    public function setUp()
    {
        parent::setUp();
        $this->loadZipcodeFixtures();
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::__construct
     */
    public function testConstruct()
    {
        $controller = new ZipcodeController();

        $this->assertInstanceOf(
            ZipcodeController::class,
            $controller
        );
        $this->assertAttributeEquals(
            ZipcodeService::class,
            'serviceName',
            $controller
        );
        $this->assertAttributeEquals(
            Zipcodebuilder::class,
            'builder',
            $controller
        );
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::getAllAction
     * @covers \AppBundle\Controller\AbstractController::getAllAction
     */
    public function testGetAllZipcodes()
    {
        $expected = file_get_contents('tests/Fixtures/zipcodes.json');

        $this->client->request('GET', '/zipcode');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($expected, $this->client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::getAction
     * @covers \AppBundle\Controller\AbstractController::getAction
     */
    public function testGetOneZipcodeFound()
    {
        $expected = '{"id":"01623","city":"Lommatzsch"}';

        $this->client->request('GET', '/zipcode/01623');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($expected, $this->client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::getAction
     * @covers \AppBundle\Controller\AbstractController::getAction
     */
    public function testGetOneZipcodeNotFound()
    {
        $this->client->request('GET', '/zipcode/1');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostZipcodeRepeatedReturnsBadRequest()
    {
        $this->client->request(
            'POST',
            '/zipcode',
            [],
            [],
            ['CONTENT-TYPE' => 'application/json'],
            '{"id": "01623", "city": "Lommatzsch"}'
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostInvalidZipcodeReturnsBadRequest()
    {
        $this->client->request(
            'POST',
            '/zipcode',
            [],
            [],
            ['CONTENT-TYPE' => 'application/json'],
            '{"id": "123", "city": ""}'
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @covers \AppBundle\Controller\ZipcodeController::postAction
     * @covers \AppBundle\Controller\AbstractController::postAction
     */
    public function testPostValidZipcodeReturnsCreated()
    {
        $this->client->request(
            'POST',
            '/zipcode',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"id": "12345", "city": "Valid city"}'
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }
}
