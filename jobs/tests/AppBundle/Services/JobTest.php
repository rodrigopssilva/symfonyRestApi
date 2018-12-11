<?php

namespace Tests\AppBundle\Services;

use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\Job as JobEntity;
use AppBundle\Entity\Service as ServiceEntity;
use AppBundle\Entity\Zipcode as ZipcodeEntity;
use AppBundle\Repository\JobRepository;
use AppBundle\Services\Job;
use AppBundle\Services\Service;
use AppBundle\Services\Zipcode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Tests\Functional\WebTestCase;
use DateTime;
use Tests\AppBundle\Helper\TestHelper;

/**
 * @group unit
 */
class JobTest extends AbstractServicesTest
{
    /**
     * @var JobRepository
     */
    private $repository;

    /**
     * @var Service
     */
    private $service;

    /**
     * @var Zipcode
     */
    private $zipcode;

    /**
     * @var JobEntity
     */
    private $defaultEntity;

    /**
     * @var JobEntity
     */
    private $persistedEntity;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(JobRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findAll', 'find'])
            ->getMock();

        $this->service = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $this->zipcode = $this->getMockBuilder(Zipcode::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $this->defaultEntity = new JobEntity(
            802031,
            '01621',
            'Job to be done',
            'description',
            new DateTime('2018-11-11')
        );
        $this->persistedEntity = new JobEntity(
            802031,
            '01621',
            'Job to be done',
            'description',
            new DateTime('2018-11-11'),
            'a1c59e8f-ca88-11e8-94bd-0242ac130005'
        );
    }

    /**
     * @covers \AppBundle\Services\Job::__construct
     */
    public function testConstruct()
    {
        $jobService = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );

        $this->assertInstanceOf(
            Job::class,
            $jobService
        );
    }

    /**
     * @covers \AppBundle\Services\Job::findAll
     */
    public function testFindAllWithZipcode()
    {
        $expected = ['hello' => 'world'];
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->setMethods(['findBy', 'getRepository'])
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Job::JOB_ENTITY_CLASS)
            ->will($this->returnSelf());

        $entityManager->expects($this->once())
            ->method('findBy')
            ->with(['zipcode_id' => '12345'])
            ->willReturn([$expected]);

        $testedObject = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $entityManager
        );

        $params = ['zipcode' => '12345'];
        $actual = $testedObject->findAll($params);

        $this->assertEquals([$expected], $actual, 'findAll returned a wrong value');
    }

    /**
     * @covers \AppBundle\Services\Job::findAll
     */
    public function testFindAllWithService()
    {
        $expected = ['hello' => 'world'];
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->setMethods(['findBy', 'getRepository'])
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Job::JOB_ENTITY_CLASS)
            ->will($this->returnSelf());

        $entityManager->expects($this->once())
            ->method('findBy')
            ->with(['service_id' => 123])
            ->willReturn([$expected]);

        $testedObject = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $entityManager
        );

        $params = ['service' => 123];
        $actual = $testedObject->findAll($params);

        $this->assertEquals([$expected], $actual, 'findAll returned a wrong value');
    }

    /**
     * @covers \AppBundle\Services\Job::create
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage zipcode_id: This value should have exactly 5 characters
     */
    public function testCreateJobWithInvalidDataThrowsBadRequestHttpException()
    {
        $this->service
            ->expects($this->never())
            ->method('find');
        $this->zipcode
            ->expects($this->never())
            ->method('find');
        $this->entityManager
            ->expects($this->never())
            ->method('persist');
        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );
        $job->create(new JobEntity(
            802031,
            '123',
            'Job',
            'description',
            new DateTime('2018-11-11')
        ));
    }

    /**
     * @covers \AppBundle\Services\Job::create
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage Service '802031' was not found
     */
    public function testCreateJobWithServiceNotFoundThrowsBadRequestHttpException()
    {
        $this->service
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(null))
            ->with(802031);
        $this->zipcode
            ->expects($this->never())
            ->method('find');
        $this->entityManager
            ->expects($this->never())
            ->method('persist');
        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );
        $job->create(new JobEntity(
            802031,
            '12345',
            'Job to be done',
            'description',
            new DateTime('2018-11-11')
        ));
    }

    /**
     * @covers \AppBundle\Services\Job::create
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage Zipcode '12345' was not found
     */
    public function testCreateJobWithZipcodeNotFoundThrowsBadRequestHttpException()
    {
        $this->service
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new ServiceEntity()))
            ->with(802031);
        $this->zipcode
            ->method('find')
            ->will($this->returnValue(null))
            ->with('12345');
        $this->entityManager
            ->expects($this->never())
            ->method('persist');
        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );
        $job->create(new JobEntity(
            802031,
            '12345',
            'Job to be done',
            'description',
            new DateTime('2018-11-11')
        ));
    }

    /**
     * @covers \AppBundle\Services\Job::create
     */
    public function testCreateJobWithValidJobReturnsPersistedJob()
    {
        $this->service
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new ServiceEntity()))
            ->with(802031);
        $this->zipcode
            ->method('find')
            ->will($this->returnValue(new ZipcodeEntity()))
            ->with('01621');
        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->defaultEntity);
        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );
        $job->create($this->defaultEntity);
    }

    /**
     * @covers \AppBundle\Services\Job::update
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage The resource 'a1c59e8f-ca88-11e8-94bd-0242ac130005
     */
    public function testUpdateJobWithNotFoundThrowsBadRequestHttpException()
    {
        $this->repository
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(null))
            ->with('a1c59e8f-ca88-11e8-94bd-0242ac130005');
        $this->service
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new ServiceEntity()))
            ->with(802031);
        $this->zipcode
            ->method('find')
            ->will($this->returnValue(new ZipcodeEntity()))
            ->with('01621');
        $this->entityManager
            ->expects($this->never())
            ->method('merge');
        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );
        $job->update($this->persistedEntity);
    }

    /**
     * @covers \AppBundle\Services\Job::update
     */
    public function testUpdateJobValidReturnsPersistedJob()
    {
        $this->repository
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue($this->persistedEntity))
            ->with('a1c59e8f-ca88-11e8-94bd-0242ac130005');
        $this->service
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new ServiceEntity()))
            ->with(802031);
        $this->zipcode
            ->method('find')
            ->will($this->returnValue(new ZipcodeEntity()))
            ->with('01621');
        $this->entityManager
            ->expects($this->once())
            ->method('merge')
            ->with($this->persistedEntity);
        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );
        $job->update($this->persistedEntity);
    }

    /**
     * @covers \AppBundle\Services\Job::save
     */
    public function testSaveWhenGetIdIsNotNull()
    {
        $this->entityManager
            ->expects($this->once())
            ->method('merge')
            ->with($this->persistedEntity);
        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );

        $actual = TestHelper::invokeMethod($job, 'save', [$this->persistedEntity]);
        $this->assertInstanceOf(EntityInterface::class, $actual);
    }

    /**
     * @covers \AppBundle\Services\Job::save
     */
    public function testSaveWhenGetIdIsNull()
    {

        $this->persistedEntity = $this->getMockBuilder(JobEntity::class)
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();

        $this->persistedEntity
            ->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );

        $actual = TestHelper::invokeMethod($job, 'save', [$this->persistedEntity]);
        $this->assertInstanceOf(EntityInterface::class, $actual);
    }

    /**
     * @covers \AppBundle\Services\Job::validateForeignKeys
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage Service '123' was not found
     */
    public function testValidateForeignKeysReturnsServiceWasNotFound()
    {
        $this->persistedEntity = $this->getMockBuilder(JobEntity::class)
            ->disableOriginalConstructor()
            ->setMethods(['getServiceId', 'getZipcodeId'])
            ->getMock();

        $this->persistedEntity
            ->expects($this->exactly(2))
            ->method('getServiceId')
            ->willReturn(123);

        $this->service
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );

        TestHelper::invokeMethod($job, 'validateForeignKeys', [$this->persistedEntity]);
    }

    /**
     * @covers \AppBundle\Services\Job::validateForeignKeys
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage Zipcode '12345' was not found
     */
    public function testValidateForeignKeysReturnsZipcodeWasNotFound()
    {
        $this->persistedEntity = $this->getMockBuilder(JobEntity::class)
            ->disableOriginalConstructor()
            ->setMethods(['getServiceId', 'getZipcodeId'])
            ->getMock();

        $this->persistedEntity
            ->expects($this->once())
            ->method('getServiceId')
            ->willReturn(123);

        $this->service
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->persistedEntity);

        $this->persistedEntity
            ->expects($this->exactly(2))
            ->method('getZipcodeId')
            ->willReturn('12345');


        $this->zipcode
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );

        TestHelper::invokeMethod($job, 'validateForeignKeys', [$this->persistedEntity]);
    }

    /**
     * @covers \AppBundle\Services\Job::validateForeignKeys
     */
    public function testValidateForeignKeysWithSuccess()
    {
        $this->persistedEntity = $this->getMockBuilder(JobEntity::class)
            ->disableOriginalConstructor()
            ->setMethods(['getServiceId', 'getZipcodeId'])
            ->getMock();

        $this->persistedEntity
            ->expects($this->once())
            ->method('getServiceId')
            ->willReturn(123);

        $this->service
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->persistedEntity);

        $this->persistedEntity
            ->expects($this->once())
            ->method('getZipcodeId')
            ->willReturn('12345');


        $this->zipcode
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->defaultEntity);

        $job = new Job(
            $this->repository,
            $this->service,
            $this->zipcode,
            $this->entityManager
        );

        TestHelper::invokeMethod($job, 'validateForeignKeys', [$this->persistedEntity]);
    }

}
