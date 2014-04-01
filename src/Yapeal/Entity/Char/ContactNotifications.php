<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactNotifications
 *
 * @ORM\Table(name="char_ContactNotifications")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class ContactNotifications extends AbstractCharacterOwner
{
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $messageData;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $notificationID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $senderID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $senderName;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $sentDate;
}
