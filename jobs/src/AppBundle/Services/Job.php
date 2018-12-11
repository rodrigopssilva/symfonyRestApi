<?php

namespace AppBundle\Services;

use AppBundle\Entity\EntityInterface;
use AppBundle\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Job as JobEntity;
use \Doctrine\DBAL\DBALException;

/**
 * Class Job
 *
 * @category Services
 * @package  AppBundle\Services
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class Job extends AbstractService
{
    const JOB_ENTITY_CLASS = '\AppBundle\Entity\Job';

    /**
     * Stores the namespace of the Service used
     *
     * @var Service
     */
    private $service;

    /**
     * Stores the namespace of the Zipcode used
     *
     * @var Zipcode
     */
    private $zipcode;

    /**
     * Job constructor.
     *
     * @param JobRepository          $repository
     * @param Service                $service
     * @param Zipcode                $zipcode
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        JobRepository $repository,
        Service $service,
        Zipcode $zipcode,
        EntityManagerInterface $entityManager
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->zipcode = $zipcode;
        $this->entityManager = $entityManager;
    }

    /**
     * Find all occourences of zipcode or service inside of database
     *
     * @param array $params array of parameters to find data
     *
     * @return array
     */
    public function findAll(array $params = []): array
    {
        $search = [];

        if (!empty($params['zipcode'])) {
            $search['zipcode_id'] = $params['zipcode'];
        }

        if (!empty($params['service'])) {
            $search['service_id'] = $params['service'];
        }

        return $this->entityManager
            ->getRepository(self::JOB_ENTITY_CLASS)
            ->findBy($search);
    }

    /**
     * Create a new Job and then stores it in the database
     *
     * @param EntityInterface $entity object that will be persisted
     *
     * @return EntityInterface
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        $this->basicValidation($entity);
        $this->validateForeignKeys($entity);

        return $this->save($entity);
    }

    /**
     * Update a Job and then stores it in the database
     *
     * @param EntityInterface $entity object that will be persisted
     *
     * @throws NotFoundHttpException if Job not found
     *
     * @return JobEntity
     */
    public function update(EntityInterface $entity): JobEntity
    {
        $this->basicValidation($entity);
        $this->validateForeignKeys($entity);

        /* @var JobEntity $persistedEntity */
        $persistedEntity = $this->find($entity->getId());
        if (is_null($persistedEntity)) {
            throw new NotFoundHttpException(
                sprintf(
                    'The resource \'%s\' was not found.',
                    $entity->getId()
                )
            );
        }

        return $this->save($entity);
    }

    /**
     * Validate the foreign keys who will be changed
     *
     * @param JobEntity $entity the object that will be validated
     *
     * @throws BadRequestHttpException if Service not found or Zipcode not found
     *
     * @return void
     */
    private function validateForeignKeys(JobEntity $entity): void
    {
        if (!$this->service->find($entity->getServiceId())) {
            throw new BadRequestHttpException(
                sprintf(
                    'Service \'%s\' was not found',
                    $entity->getServiceId()
                )
            );
        }

        if (!$this->zipcode->find($entity->getZipcodeId())) {
            throw new BadRequestHttpException(
                sprintf(
                    'Zipcode \'%s\' was not found',
                    $entity->getZipcodeId()
                )
            );
        }
    }

    /**
     * Stores a new Job in the database
     *
     * @param EntityInterface $entity data that will be persisted
     *
     * @return EntityInterface
     */
    protected function save(EntityInterface $entity): EntityInterface
    {
        if (is_null($entity->getId())) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->merge($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
