<?php

namespace AppBundle\Builder;

use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\Zipcode as ZipcodeEntity;

/**
 * Class Zipcode
 *
 * @category Builder
 * @package  AppBundle\Builder
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class Zipcode implements BuilderInterface
{

    /**
     * Builds a new Zipcode based on $parameters array
     *
     * @param array $parameters data to create a new Zipcode
     *
     * @return EntityInterface
     */
    public static function build(array $parameters): EntityInterface
    {
        $attributes = [];
        $attributes['id'] = $parameters['id'] ?? null;
        $attributes['city'] = $parameters['city'] ?? null;

        return new ZipcodeEntity($attributes['id'], $attributes['city']);
    }
}
