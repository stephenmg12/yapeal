<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity\Types;

/**
 * AccountBalance
 *
 * @ORM\Table(name="char_AccountBalance")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class AccountBalance extends AbstractCharacterOwner
{
    /**
     * Constructor
     */
    public function __construct()
    {
        bcscale(2);
    }
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $accountID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     * @ORM\Id
     */
    private $accountKey;
    /**
     * @var string
     * @ORM\Column(type="ISK")
     */
    private $balance;
}