<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 11.11.17
 * Time: 20:19
 */

namespace CoreBundle\Util;


class UniqueHashGenerator
{
    /**
     * @param int $min
     * @param int $max
     * @return string
     */
    public static function generateRandomSha1Hash(int $min = 200000, int $max = 250000)
    {
        return sha1(random_bytes(random_int($min, $max)));
    }

    /**
     * @param string $string
     * @param int $min
     * @param int $max
     * @return string
     */
    public static function generateRandomBase64Hash(string $string = '', int $min = 200000, int $max = 250000)
    {
        return base64_encode($string . random_bytes(random_int($min, $max)));
    }
}