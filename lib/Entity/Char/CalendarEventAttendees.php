<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalendarEventAttendees
 *
 * @ORM\Table(name="char_CalendarEventAttendees")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class CalendarEventAttendees extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $characterID;
    /**
     * @var string
     * @ORM\Column(type="string", length=24)
     */
    private $characterName;
    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $response = 'Undecided';
}
