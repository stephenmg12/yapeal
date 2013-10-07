<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;

/**
 * ContractBids
 *
 * @ORM\Table(name="char_ContractBids")
 * @ORM\Entity
 */
class ContractBids
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $contractID;
    /**
     * Used to make foreign key work as part of composite primary key.
     *
     * @var integer
     * @ORM\JoinColumn(name="contractID", referencedColumnName="contractID", nullable=false, onDelete="restrict")
     * @ORM\ManyToOne(targetEntity="Contracts")
     */
    private $dummyContract;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $bidID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $bidderID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateBid;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $amount;
    /**
     * Constructor
     */
    public function __construct()
    {
        bcscale(2);
    }
}
