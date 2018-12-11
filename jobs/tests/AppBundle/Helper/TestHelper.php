<?php

namespace Tests\AppBundle\Helper;

/**
 * Class TestHelper
 *
 * @category Helper
 * @package Tests\AppBundle\Helper
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class TestHelper
{

    /**
     * This method allows test private or protected methods
     *
     * @param  mixed  $object
     * @param  string $methodName
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public static function invokeMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    /**
     * This method allows to set values to protected or private attributes
     *
     * @param mixed $object
     * @param string $attributeName
     * @param mixed $value
     *
     * @throws \ReflectionException
     */
    public static function setProtectedAttribute($object, $attributeName, $value)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $reflectionProperty = $reflection->getProperty($attributeName);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }
}
