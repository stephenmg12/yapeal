<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;

/**
 * WalletTransactions
 *
 * @ORM\Table(name="char_WalletTransactions")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class WalletTransactions extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $transactionID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $accountKey;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $clientID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $clientName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $journalTransactionID;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $price;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $quantity;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $stationID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $stationName;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $transactionDateTime;
    /**
     * @var string
     * @ORM\Column(type="string", length=11)
     */
    private $transactionFor;
    /**
     * @var string
     * @ORM\Column(type="string", length=4)
     */
    private $transactionType;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $typeID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $typeName;
    /**
     * Constructor
     */
    public function __construct()
    {
        bcscale(2);
    }
}
