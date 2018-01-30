<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 13.12.17
 * Time: 03:10
 */

namespace FrontendBundle\Strategy;


use CoreBundle\Factory\AbstractFactoryInterface;
use CoreBundle\Factory\CategoryFactory;

abstract class AbstractMenuStrategy implements MenuStrategyInterface
{
    const MENU_ALIAS = 'abstract';

    /** @var CategoryFactory */
    protected $categoryFactory;

    /** @var AbstractFactoryInterface */
    protected $featureFactory;

    /** @var string */
    protected $alias;

    /**
     * AbstractMenuStrategy constructor.
     * @param CategoryFactory $categoryFactory
     * @param AbstractFactoryInterface $featureFactory
     */
    public function __construct(CategoryFactory $categoryFactory, AbstractFactoryInterface $featureFactory)
    {
        $this->categoryFactory = $categoryFactory;
        $this->featureFactory = $featureFactory;
        $reflection = new \ReflectionClass($this);
        $this->alias = $reflection->getConstant('MENU_ALIAS');
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }
}
