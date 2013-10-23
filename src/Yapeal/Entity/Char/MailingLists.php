<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailingLists
 *
 * @ORM\Table(name="char_MailingLists")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class MailingLists extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $listID;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $displayName;
}
