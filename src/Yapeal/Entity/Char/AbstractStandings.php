<?php
namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractStandings
 *
 * @ORM\MappedSuperClass
 */
abstract class AbstractStandings extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    protected $fromID;
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $fromName;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $standing;
}
