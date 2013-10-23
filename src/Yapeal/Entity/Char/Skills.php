<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skills
 *
 * @ORM\Table(name="char_Skills")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class Skills extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $typeID;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $level;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $skillpoints;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $published;
}
