<?php

namespace App\Entity\Component;

use App\Entity\Component\Nav\Navbar\Navbar;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
class Hero extends Component
{
    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Component\Nav\Navbar\Navbar")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"page"})
     * @var null|Navbar
     */
    private $nav;

    /**
     * @ORM\Column(type="string")
     * @Groups({"page"})
     * @var null|string
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @Groups({"page"})
     * @var null|string
     */
    private $subtitle;

    /**
     * @return Navbar|null
     */
    public function getNav(): ?Navbar
    {
        return $this->nav;
    }

    /**
     * @param Navbar|null $nav
     */
    public function setNav(?Navbar $nav): void
    {
        $this->nav = $nav;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param null|string $subtitle
     */
    public function setSubtitle(?string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }
}
