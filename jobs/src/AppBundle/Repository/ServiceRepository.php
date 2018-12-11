<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ServiceRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class ServiceRepository extends ServiceEntityRepository
{
    /**
     * ServiceRepository constructor.
     *
     * @param RegistryInterface $registry
     *
     * @codeCoverageIgnore
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Service::class);
    }
}
