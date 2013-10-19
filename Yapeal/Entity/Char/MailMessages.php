<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailMessages
 *
 * @ORM\Table(name="char_MailMessages")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class MailMessages extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $messageID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $senderID;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $sentDate;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $toCharacterIDs;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $toCorpOrAllianceID;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $toListID;
    /**
     * Constructor
     */
    public function __construct()
    {
    }
}
