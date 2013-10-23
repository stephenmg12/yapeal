<?php
namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractCharacterOwner
 *
 * @ORM\MappedSuperClass
 * @package src\Entity\Char
 */
abstract class AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\JoinColumn(name="ownerID", referencedColumnName="characterID", nullable=false, onDelete="restrict")
     * @ORM\ManyToOne(targetEntity="CharacterSheet")
     * @ORM\Id
     */
    protected $ownerID;
}
