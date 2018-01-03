<?php

namespace App\Entity\Component\Nav\Menu;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Component\Nav\Nav;
use App\Entity\Component\Nav\NavItemInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class Menu extends Nav
{
    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="nav")
     * @ORM\OrderBy({"sortOrder" = "ASC"})
     * @Groups({"layout", "page"})
     */
    protected $items;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Component\ComponentGroup", mappedBy="parent")
     * @Groups({"page"})
     * @var Collection
     */
    protected $childGroups;

    public function __construct()
    {
        parent::__construct();
        $this->childGroups = new ArrayCollection();
    }

    public function createNavItem(): NavItemInterface
    {
        return new MenuItem();
    }

    /**
     * @return Collection
     */
    public function getChildGroups(): Collection
    {
        return $this->childGroups;
    }
}
