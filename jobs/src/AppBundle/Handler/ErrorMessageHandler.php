<?php

namespace AppBundle\Handler;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class ValidationHandler
 *
 * @category Repository
 * @package  AppBundle\Handler
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class ErrorMessageHandler
{

    /**
     * This method throws a BadRequestHttpException to the application
     *
     * @param ConstraintViolationList $errors object with the violation errors
     *
     * @return void
     *
     * @throws BadRequestHttpException when a error is found
     */
    public static function checkErrors(ConstraintViolationList $errors)
    {
        foreach ($errors as $error) {
            throw new BadRequestHttpException(
                $error->getPropertyPath() . ': ' . $error->getMessage()
            );
        }
    }
}
