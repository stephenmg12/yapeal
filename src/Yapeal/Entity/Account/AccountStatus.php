<?php

namespace Yapeal\Entity\Account;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountStatus
 *
 * @ORM\Table(name="account_AccountStatus")
 * @ORM\Entity
 */
class AccountStatus
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $keyID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createDate;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $logonCount;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $logonMinutes;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $paidUntil;
}
