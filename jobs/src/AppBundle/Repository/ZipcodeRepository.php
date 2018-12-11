<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Zipcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ZipcodeRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class ZipcodeRepository extends ServiceEntityRepository
{
    /**
     * ZipcodeRepository constructor.
     *
     * @param RegistryInterface $registry
     *
     * @codeCoverageIgnore
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Zipcode::class);
    }
}
