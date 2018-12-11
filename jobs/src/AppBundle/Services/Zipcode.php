<?php

namespace AppBundle\Services;

use AppBundle\Repository\ZipcodeRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Zipcode
 *
 * @category Services
 * @package  AppBundle\Services
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class Zipcode extends AbstractService
{
    /**
     * Service constructor.
     *
     * @param ZipcodeRepository      $repository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ZipcodeRepository $repository,
        EntityManagerInterface $entityManager
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }
}
