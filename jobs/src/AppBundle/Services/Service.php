<?php

namespace AppBundle\Services;

use AppBundle\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Service
 *
 * @category Services
 * @package  AppBundle\Services
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class Service extends AbstractService
{
    /**
     * Service constructor.
     *
     * @param ServiceRepository      $repository    instance of the repository
     * @param EntityManagerInterface $entityManager instance of the entity manager
     */
    public function __construct(
        ServiceRepository $repository,
        EntityManagerInterface $entityManager
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }
}
