<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationTexts
 *
 * @ORM\Table(name="char_NotificationTexts")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class NotificationTexts extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $notificationID;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;
}
