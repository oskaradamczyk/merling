<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 23:04
 */

namespace CoreBundle\Manager;


use CoreBundle\Model\AbstractModelInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Interface AbstractModelManagerInterface
 * @package CoreBundle\Manager
 */
interface AbstractModelManagerInterface
{
    /**
     * @param AbstractModelInterface $model
     */
    public function save(AbstractModelInterface $model): void;

    /**
     * @param Collection $models
     */
    public function saveMany(Collection $models): void;

    /**
     * @param AbstractModelInterface $model
     */
    public function remove(AbstractModelInterface $model): void;

    /**
     * @param Collection $models
     */
    public function removeMany(Collection $models): void;

    /**
     * @return ObjectRepository
     */
    public function getModelRepository(): ObjectRepository;
}