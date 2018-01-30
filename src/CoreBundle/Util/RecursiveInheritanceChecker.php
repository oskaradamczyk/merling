<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 26.12.17
 * Time: 20:32
 */

namespace CoreBundle\Util;


use Symfony\Component\Finder\Finder;

class RecursiveInheritanceChecker
{
    const appRoot = __DIR__ . "/../../../";

    /**
     * @param \ReflectionClass $reflection
     * @param string[] ...$interfaces
     * @return bool
     */
    public static function recursiveIsImplementing(\ReflectionClass $reflection, string ...$interfaces)
    {
        if(func_num_args() < 2){
            throw new \InvalidArgumentException('Pass one or more classes to check inheritance.');
        }
        $interfacesReflection = $reflection->getInterfaceNames();
        foreach ($interfaces as $interface) {
            if (in_array($interface, $interfacesReflection)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param \ReflectionClass $reflection
     * @param string[] ...$traits
     * @return bool
     */
    public static function recursiveIsUsing(\ReflectionClass $reflection, string ...$traits)
    {
        if(func_num_args() < 2){
            throw new \InvalidArgumentException('Pass one or more classes to check inheritance.');
        }
        $traitsReflection = $reflection->getTraitNames();
        $isUsing = false;
        foreach ($traits as $trait) {
            if (in_array($trait, $traitsReflection)) {
                $isUsing = true;
                break;
            }
        }
        if ($isUsing || !$reflection->getParentClass()) {
            return $isUsing;
        }
        return self::recursiveIsUsing($reflection->getParentClass(), ...$traits);
    }

    /**
     * @param \ReflectionClass $reflection
     * @param string[] ...$classes
     * @return bool
     */
    public static function recursiveIsExtending(\ReflectionClass $reflection, string ...$classes)
    {
        if(func_num_args() < 2){
            throw new \InvalidArgumentException('Pass one or more classes to check inheritance.');
        }
        $isExtending = false;
        foreach ($classes as $class) {
            if ($class === $reflection->getName()) {
                $isExtending = true;
                break;
            }
        }
        if ($isExtending || !$reflection->getParentClass()) {
            return $isExtending;
        }
        return self::recursiveIsExtending($reflection->getParentClass(), ...$classes);
    }
}
