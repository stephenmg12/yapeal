<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacWarStats
 *
 * @ORM\Table(name="char_FacWarStats")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class FacWarStats extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $factionID;
    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    private $factionName;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $enlisted;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $currentRank;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $highestRank;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $killsYesterday;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $killsLastWeek;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $killsTotal;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $victoryPointsYesterday;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $victoryPointsLastWeek;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $victoryPointsTotal;
    /**
     * Constructor
     */
    public function __construct()
    {
    }
}
