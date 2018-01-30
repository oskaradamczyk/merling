<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 13.12.17
 * Time: 03:10
 */

namespace FrontendBundle\Strategy;


use CoreBundle\Document\Cms;
use CoreBundle\Document\CmsCategory;
use CoreBundle\Manager\CategoryManager;
use CoreBundle\Manager\CmsManager;
use CoreBundle\Model\MenuAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\Menu\MenuItem;

final class CmsMenuStrategy extends AbstractMenuStrategy
{
    const MENU_ALIAS = 'cms';

    public function decorateMenu(MenuItem $menu): void
    {
        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->categoryFactory->createManager(CmsCategory::class);
        $this->setMenuChildren(new ArrayCollection($categoryManager->getModelRepository()->findBy(['parentCategory' => null])), $menu);
        /** @var CmsManager $cmsManager */
        $cmsManager = $this->featureFactory->createManager(Cms::class);
        /** @var  $Cms */
        $this->setMenuOrphans(new ArrayCollection($cmsManager->getModelRepository()->findBy(['category' => null])), $menu);
    }

    public function setMenuOrphans(Collection $orphans, MenuItem $menu): void
    {
        /** @var MenuAwareInterface $orphan */
        foreach ($orphans as $orphan) {
            $menu
                ->addChild($orphan->getName(), [
                    'route' => $this->alias . '_view',
                    'routeParameters' => [
                        'slug' => $orphan->getSlug()
                    ]
                ])
                ->setLinkAttribute('class', 'col-xs-2 main-item padding0');
        }
    }

    public function setMenuChildren(Collection $categories, MenuItem $menu): void
    {
        /** @var CmsCategory $category */
        foreach ($categories as $category) {
            if (!$parentCategory = $category->getParentCategory()) {
                $item = $menu
                    ->addChild($category->getName(), [
                        'route' => $this->alias . '_category_view',
                        'routeParameters' => [
                            'slug' => $category->getSlug()
                        ]
                    ])
                    ->setLinkAttribute('class', 'col-xs-2 main-item padding0');
            }
            if ($parentCategory) {
                $item = $menu
                    ->getChild($parentCategory->getName())
                    ->addChild($category->getName(), [
                        'route' => $this->alias . '_category_view',
                        'routeParameters' => [
                            'slug' => $category->getSlug()
                        ]
                    ])
                    ->setLinkAttribute('class', 'col-xs-2');
            }
            if (!($children = $category->getFeatures())->isEmpty()) {
                /** @var MenuAwareInterface $child */
                foreach ($children as $child) {
                    if (isset($item)) {
                        $item->addChild($child->getName(), [
                            'route' => $this->alias . '_page_view',
                            'routeParameters' => [
                                'slug' => $child->getSlug()
                            ]
                        ])
                            ->setLinkAttribute('class', 'col-xs-2');
                    }
                }
            }
            if ($childCategories = $category->getChildCategories()) {
                $this->setMenuChildren($childCategories, $menu);
            }
        }
    }
}