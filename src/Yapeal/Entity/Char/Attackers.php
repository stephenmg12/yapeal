<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attackers
 *
 * @ORM\Table(name="char_Attackers")
 * @ORM\Entity
 */
class Attackers
{
    /**
     * @var integer
     * @ORM\JoinColumn(name="killID", referencedColumnName="killID", nullable=false, onDelete="restrict")
     * @ORM\ManyToOne(targetEntity="KillLog", inversedBy="attackers")
     * @ORM\Id
     */
    private $killID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $characterID = 0;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $allianceID = 0;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $allianceName;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $characterName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $corporationID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $corporationName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $damageDone;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $factionID = 0;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $factionName;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $finalBlow;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $securityStatus;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $shipTypeID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $weaponTypeID;
}
