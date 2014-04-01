<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailingLists
 *
 * @ORM\Table(name="char_MailingLists")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class MailingLists extends AbstractCharacterOwner
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $displayName;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $listID;
}
