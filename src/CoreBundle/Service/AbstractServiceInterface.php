<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.11.17
 * Time: 01:03
 */

namespace CoreBundle\Service;


interface AbstractServiceInterface
{
    /**
     * @param string $message
     */
    public function log(string $message): void;

    /**
     * @param string $id
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     * @return string
     */
    public function translate(string $id, array $parameters = [], string $domain = null, string $locale = null): string;
}