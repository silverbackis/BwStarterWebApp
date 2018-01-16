<?php

namespace App\DataFixtures\Nav;

use App\DataFixtures\AbstractFixture;
use App\DataFixtures\CustomEntityInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Silverback\ApiComponentBundle\Entity\Component\Nav\Navbar\Navbar;
use Silverback\ApiComponentBundle\Entity\Page;

/**
 * Class AbstractNav
 * @package App\DataFixtures\Nav
 * @author Daniel West <daniel@silverback.is>
 * @property Navbar $entity
 */
abstract class AbstractNav extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
        if ($this instanceof CustomEntityInterface) {
            $this->entity = $this->getEntity();
        } else {
            $this->entity = new Navbar();
        }
    }

    /**
     * @param string $navLabel
     * @param int|null $order
     * @param Page|null $page
     * @param string|null $fragment
     * @return mixed
     */
    protected function addNavItem(string $navLabel, int $order = null, Page $page = null, string $fragment = null)
    {
        if (null === $order) {
            // auto ordering
            $lastItem = $this->entity->getItems()->last();
            if (!$lastItem) {
                $order = 0;
            } else {
                $order = $lastItem->getSortOrder() + 1;
            }
        }
        $navItem = $this->entity->createNavItem();
        $navItem->setLabel($navLabel);
        $navItem->setSortOrder($order);
        $navItem->setRoute($page->getRoutes()->first());
        $navItem->setFragment($fragment);
        $this->entity->addItem($navItem);
        $this->manager->persist($navItem);
        return $navItem;
    }
}