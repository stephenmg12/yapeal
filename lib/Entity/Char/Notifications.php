<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifications
 *
 * @ORM\Table(name="char_Notifications")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class Notifications extends AbstractCharacterOwner
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
    private $notificationID;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $read;
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
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $typeID;
}
