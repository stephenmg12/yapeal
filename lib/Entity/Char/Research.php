<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Research
 *
 * @ORM\Table(name="char_Research")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class Research extends AbstractCharacterOwner
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
     * @ORM\Id
     */
    private $agentID;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $pointsPerDay;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $remainderPoints;
    /**
     * @var \DateTime
     * @ORM\Column(name="researchStartDate", type="datetime")
     */
    private $researchStartDate;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $skillTypeID;
}
