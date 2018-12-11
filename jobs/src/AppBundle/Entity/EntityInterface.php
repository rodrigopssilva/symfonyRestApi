<?php

namespace AppBundle\Entity;

/**
 * Interface EntityInterface
 *
 * @category Builder
 * @package  AppBundle\Entity
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
interface EntityInterface
{
    /**
     * This method will return the identifier code of the object
     *
     * @return mixed
     */
    public function getId();
}