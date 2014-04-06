<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;

/**
 * Contracts
 *
 * @ORM\Table(name="char_Contracts")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class Contracts extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $acceptorID = 0;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $assigneeID = 0;
    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $availability;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $buyout;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $collateral = 0;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $contractID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateAccepted;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCompleted;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateExpired;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateIssued;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $endStationID;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $forCorp;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $issuerCorpID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $issuerID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $numDays;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $price = 0;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $reward = 0;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $startStationID;
    /**
     * @var string
     * @ORM\Column(type="string", length=25)
     */
    private $status;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;
    /**
     * @var string
     * @ORM\Column(type="string", length=15)
     */
    private $type;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $volume;
}
