<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 10.12.17
 * Time: 00:37
 */

namespace FrontendBundle\Strategy;


use Doctrine\Common\Collections\Collection;
use Knp\Menu\MenuItem;

interface MenuStrategyInterface
{
    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @param MenuItem $menu
     */
    public function decorateMenu(MenuItem $menu): void;

    /**
     * @param Collection $orphans
     * @param MenuItem $menu
     */
    public function setMenuOrphans(Collection $orphans, MenuItem $menu): void;

    /**
     * @param Collection $categories
     * @param MenuItem $menu
     */
    public function setMenuChildren(Collection $categories, MenuItem $menu): void;
}