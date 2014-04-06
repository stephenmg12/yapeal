<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;

/**
 * MarketOrders
 *
 * @ORM\Table(name="char_MarketOrders")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class MarketOrders extends AbstractCharacterOwner
{
    /**
     * Constructor
     */
    public function __construct()
    {
        bcscale(2);
    }
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $accountKey;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $bid;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $charID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $duration;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $escrow;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $issued;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $minVolume;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $orderID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $orderState;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $price;
    /**
     * @var integer
     * @ORM\Column(name="range", type="smallint")
     */
    private $range;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $stationID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $typeID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $volEntered;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $volRemaining;
}
