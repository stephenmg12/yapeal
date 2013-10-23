<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items
 *
 * @ORM\Table(name="char_Items")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class Items
{
    /**
     * @var integer
     * @ORM\JoinColumn(name="killID", referencedColumnName="killID", nullable=false, onDelete="restrict")
     * @ORM\ManyToOne(targetEntity="KillLog", inversedBy="items")
     * @ORM\Id
     */
    private $killID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $lft;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $flag;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $lvl;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $rgt;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $qtyDropped;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $qtyDestroyed;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $singleton;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $typeID;
}
