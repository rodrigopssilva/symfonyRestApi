<?php

namespace AppBundle\Builder;

use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\Service as EntityService;

/**
 * Class Service
 *
 * @category Builder
 * @package  AppBundle\Builder
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class Service implements BuilderInterface
{
    /**
     * Builds a new Service based on $parameters array
     *
     * @param array $parameters data to create a new Service
     *
     * @return EntityInterface
     */
    public static function build(array $parameters): EntityInterface
    {
        $attributes = [];
        $attributes['id'] = $parameters['id'] ?? null;
        $attributes['name'] = $parameters['name'] ?? null;

        return new EntityService($attributes['id'], $attributes['name']);
    }
}
