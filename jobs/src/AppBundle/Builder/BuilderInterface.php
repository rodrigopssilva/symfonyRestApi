<?php

namespace AppBundle\Builder;

use AppBundle\Entity\EntityInterface;

/**
 * Interface BuilderInterface
 *
 * @category Builder
 * @package  AppBundle\Builder
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
interface BuilderInterface
{
    /**
     * This method must be implemented in order to the class work
     *
     * @param array $params data to create a new object
     *
     * @return EntityInterface
     */
    public static function build(array $params): EntityInterface;
}
