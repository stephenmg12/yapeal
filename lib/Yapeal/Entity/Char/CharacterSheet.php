<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;
use Yapeal\Entity;

/**
 * CharacterSheet
 *
 * @ORM\Table(name="char_CharacterSheet")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class CharacterSheet extends Entity\AbstractCharacter
{
    /**
     * Constructor
     */
    public function __construct()
    {
        bcscale(2);
    }
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $DoB;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $allianceID = 0;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $allianceName;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $ancestry;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $balance;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $bloodLine;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $charisma;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $cloneName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $cloneSkillPoints;
    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $gender;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $intelligence;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $memory;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $perception;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $race;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $willpower;
}
