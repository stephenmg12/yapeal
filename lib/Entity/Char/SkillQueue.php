<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkillQueue
 *
 * @ORM\Table(name="char_SkillQueue")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class SkillQueue extends AbstractCharacterOwner
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $endSP;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $endTime;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $level;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     * @ORM\Id
     */
    private $queuePosition;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $startSP;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $startTime;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $typeID;
}
