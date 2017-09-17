<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Util;

/**
 * Abstract Enum for types and const holding.
 *
 * @author oadamczyk
 */
abstract class Enum
{

    /**
     * 
     * @return array
     */
    public static function getConstants(): array
    {
        $reflection = new \ReflectionClass(static::class);
        return $reflection->getConstants();
    }

    public static function getConstant(string $name)
    {
        $reflection = new \ReflectionClass(static::class);
        return $reflection->getConstant($name);
    }

}
