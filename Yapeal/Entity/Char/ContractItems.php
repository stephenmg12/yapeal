<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContractItems
 *
 * @ORM\Table(name="char_ContractItems")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class ContractItems
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $contractID;
    /**
     * Used to make foreign key work as part of composite primary key.
     *
     * @var integer
     * @ORM\JoinColumn(name="contractID", referencedColumnName="contractID", nullable=false, onDelete="restrict")
     * @ORM\ManyToOne(targetEntity="Contracts")
     */
    private $dummyContract;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $recordID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $typeID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $quantity;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $rawQuantity = 0;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $singleton;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $included;
}
