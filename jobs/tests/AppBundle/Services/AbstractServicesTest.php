<?php

namespace Tests\AppBundle\Services;

use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\Job;
use AppBundle\Entity\Zipcode;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Tests\Functional\WebTestCase;
use AppBundle\Services\AbstractService;
use Symfony\Component\Validator\Validation;
use Tests\AppBundle\Helper\TestHelper;

abstract class AbstractServicesTest extends WebTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function setUp()
    {
        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers AppBundle\Services\AbstractService::save
     */
    public function testSaveWithSuccess()
    {
        $stub = $this->getMockForAbstractClass(AbstractService::class);

        $entityMock = $this->getMockBuilder(Job::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($entityMock);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        TestHelper::setProtectedAttribute($stub, 'entityManager', $this->entityManager);

        $actual = TestHelper::invokeMethod($stub, 'save', [$entityMock]);

        $this->assertInstanceOf(
            EntityInterface::class,
            $actual,
            'Error when savind a new register'
        );
    }

    /**
     * @covers \AppBundle\Services\AbstractService::find
     */
    public function testFindReturnsNull()
    {
        $id = 1234;
        $stub = $this->getMockForAbstractClass(AbstractService::class);

        $repositoryMock = $this->getMockBuilder(JobRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $repositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($id)
            ->willThrowException(new \Exception());

        TestHelper::setProtectedAttribute($stub, 'repository', $repositoryMock);

        $actual = $stub->find($id);

        $this->assertNull($actual);
    }

    /**
     * @covers \AppBundle\Services\AbstractService::basicValidation
     */
    public function testBasicValidationWithSuccess()
    {
        $stub = $this->getMockForAbstractClass(AbstractService::class);

        $entity = new Zipcode(12345, 'Berlin');

        TestHelper::invokeMethod($stub, 'basicValidation', [$entity]);
    }

    /**
     * @covers \AppBundle\Services\AbstractService::basicValidation
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage id: This value should not be blank.
     */
    public function testBasicValidationThrowsBadRequest()
    {
        $stub = $this->getMockForAbstractClass(AbstractService::class);

        $entity = new Zipcode();

        TestHelper::invokeMethod($stub, 'basicValidation', [$entity]);
    }

}
