<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailBodies
 *
 * @ORM\Table(name="char_MailBodies")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class MailBodies extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $messageID;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;
}
