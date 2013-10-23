<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locations
 *
 * @ORM\Table(name="char_Locations")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class Locations extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $itemID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $itemName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $x;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $y;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $z;
}
