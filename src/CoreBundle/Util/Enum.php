<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Util;

/**
 * Trait Enum
 * @package CoreBundle\Util
 */
trait Enum
{

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        $reflection = new \ReflectionClass(static::class);
        return $reflection->getConstants();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function getConstant(string $name)
    {
        $reflection = new \ReflectionClass(static::class);
        return $reflection->getConstant($name);
    }

    /**
     * @return array
     */
    public static function getMap(): array
    {
        $reflection = new \ReflectionClass(static::class);
        return array_flip($reflection->getConstants());
    }

}
