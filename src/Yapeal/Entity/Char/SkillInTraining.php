<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkillInTraining
 *
 * @ORM\Table(name="char_SkillInTraining")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class SkillInTraining extends AbstractCharacterOwner
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $currentTQTime;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $offset;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $skillInTraining;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $trainingDestinationSP;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $trainingEndTime;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $trainingStartSP;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $trainingStartTime;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $trainingToLevel;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $trainingTypeID;
    /**
     * Constructor
     */
    public function __construct()
    {
    }
}
