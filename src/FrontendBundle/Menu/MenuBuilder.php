<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 23.11.17
 * Time: 02:13
 */

namespace FrontendBundle\Menu;

use FrontendBundle\Strategy\MenuStrategyInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;

class MenuBuilder
{
    /** @var FactoryInterface */
    protected $factory;

    /** @var MenuStrategyInterface */
    protected $strategy;

    /**
     * MenuBuilder constructor.
     * @param MenuStrategyInterface $strategy
     * @param FactoryInterface $factory
     */
    public function __construct(MenuStrategyInterface $strategy, FactoryInterface $factory)
    {
        $this->strategy = $strategy;
        $this->factory = $factory;
    }

    public function createMenu(array $options)
    {
        /** @var MenuItem $menu */
        $menu = $this->factory->createItem($this->strategy->getAlias());
        $this->strategy->decorateMenu($menu);
        return $menu;
    }
}