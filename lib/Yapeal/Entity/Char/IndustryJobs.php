<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndustryJobs
 *
 * @ORM\Table(name="char_IndustryJobs")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class IndustryJobs extends AbstractCharacterOwner
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $activityID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $assemblyLineID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $beginProductionTime;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $charMaterialMultiplier;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $charTimeMultiplier;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $completed;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $completedStatus = 0;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $completedSuccessfully = 0;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $containerID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $containerLocationID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $containerTypeID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $endProductionTime;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $installTime;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedInSolarSystemID;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $installedItemCopy;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $installedItemFlag;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemLicensedProductionRunsRemaining;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemLocationID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemMaterialLevel;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemProductivityLevel;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemQuantity;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installedItemTypeID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $installerID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $jobID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $licensedProductionRuns;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $materialMultiplier;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $outputFlag;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $outputLocationID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $outputTypeID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $pauseProductionTime = '0001-01-01 00:00:00';
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $runs;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $timeMultiplier;
}
