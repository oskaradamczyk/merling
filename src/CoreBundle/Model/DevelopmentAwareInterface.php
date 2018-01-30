<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 16.12.17
 * Time: 20:21
 */

namespace CoreBundle\Model;


/**
 * Interface DevelopmentAwareInterface
 * @package CoreBundle\Model
 */
interface DevelopmentAwareInterface
{
    /**
     * @return null|string
     */
    public function getCustomCss(): ?string;

    /**
     * @param null|string $customCss
     * @return mixed
     */
    public function setCustomCss(?string $customCss);

    /**
     * @return null|string
     */
    public function getCustomJs(): ?string;

    /**
     * @param null|string $customJs
     * @return mixed
     */
    public function setCustomJs(?string $customJs);
}