<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;

/**
 * WalletJournal
 *
 * @ORM\Table(name="char_WalletJournal")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class WalletJournal extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $refID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $accountKey;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $amount;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $argID1;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $argName1;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $balance;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $ownerID1;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $ownerID2;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ownerName1;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ownerName2;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $reason;
    /**
     * @var integer
     * @ORM\Column(name="refTypeID", type="integer")
     */
    private $refTypeID;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $taxAmount;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $taxReceiverID;
    /**
     * Constructor
     */
    public function __construct()
    {
        bcscale(2);
    }
}
