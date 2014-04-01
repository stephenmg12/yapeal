<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetList
 *
 * @ORM\Table(name="char_AssetList")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class AssetList extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $flag = 0;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $itemID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $lft;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $locationID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $lvl;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $quantity = 1;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $rawQuantity;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $rgt;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $singleton = false;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $typeID;
}
