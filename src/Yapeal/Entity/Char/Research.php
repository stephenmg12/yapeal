<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Research
 *
 * @ORM\Table(name="char_Research")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class Research extends AbstractCharacterOwner
{
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
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $skillTypeID;
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
     * Constructor
     */
    public function __construct()
    {
    }
}
