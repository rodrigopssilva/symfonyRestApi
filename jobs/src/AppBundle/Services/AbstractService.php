<?php

namespace AppBundle\Services;

use AppBundle\Entity\EntityInterface;
use AppBundle\Handler\ErrorMessageHandler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractService
 *
 * @category Services
 * @package  AppBundle\Services
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
abstract class AbstractService
{
    /**
     * Stores the Service that will be used
     *
     * @var ServiceEntityRepositoryInterface
     */
    protected $repository;

    /**
     * Stores the Entity that will be used
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Returns all registers without filtering
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Finds a register by a identifier
     *
     * @param mixed $id data identifier
     *
     * @return null|EntityInterface
     */
    public function find($id): ?EntityInterface
    {
        try {
            $entity = $this->repository->find($id);
        } catch (\Exception $exception) {
            $entity = null;
        }

        return $entity;
    }

    /**
     * Inserts a new register in the database
     *
     * @param EntityInterface $entity object to be persisted
     *
     * @throws BadRequestHttpException when the identifier already exists
     *
     * @return EntityInterface
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        $this->basicValidation($entity);

        if ($this->find($entity->getId())) {
            throw new BadRequestHttpException(
                sprintf(
                    'Resource \'%s\' already exists',
                    $entity->getId()
                )
            );
        }

        return $this->save($entity);
    }

    /**
     * Validates the entity passed by parameter.
     *
     * @param EntityInterface $entity Object that will be validated
     *
     * @return void
     */
    protected function basicValidation(EntityInterface $entity) : void
    {
        /* @var RecursiveValidator $validator */
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        /* @var ConstraintViolationList $errors */
        $errors = $validator->validate($entity);
        ErrorMessageHandler::checkErrors($errors);
    }

    /**
     * Flushes the data to the database
     *
     * @param EntityInterface $entity Object to commit
     *
     * @return EntityInterface
     */
    protected function save(EntityInterface $entity): EntityInterface
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
