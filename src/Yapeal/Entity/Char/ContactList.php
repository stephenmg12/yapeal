<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactList
 *
 * @ORM\Table(name="char_ContactList")
 * @ORM\Entity
 */
class ContactList extends AbstractContact
{
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $inWatchlist;
}
