<?php

namespace App\Entity\Component\Nav\Menu;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Component\Nav\NavItem;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class MenuItem extends NavItem
{
    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="items")
     * @var Menu
     */
    protected $nav;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Groups({"page"})
     * @var bool
     */
    private $menuLabel = false;

    /**
     * @return bool
     */
    public function isMenuLabel(): bool
    {
        return $this->menuLabel;
    }

    /**
     * @param bool $menuLabel
     */
    public function setMenuLabel(bool $menuLabel): void
    {
        $this->menuLabel = $menuLabel;
    }
}
