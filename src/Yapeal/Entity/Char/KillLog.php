<?php

namespace Yapeal\Entity\Char;

use Doctrine\Common\Collections;
use Doctrine\ORM\Mapping as ORM;

/**
 * KillLog
 *
 * @ORM\Table(name="char_KillLog")
 * @ORM\Entity
 */
class KillLog extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $killID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $killTime;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $moonID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $solarSystemID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
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
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private $characterName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $corporationID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $corporationName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $damageTaken;
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
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $shipTypeID;
    /**
     * @var Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Attackers", mappedBy="killID")
     */
    private $attackers;
    /**
     * @var Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Items", mappedBy="killID")
     */
    private $items;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attackers = new Collections\ArrayCollection();
    }
}
