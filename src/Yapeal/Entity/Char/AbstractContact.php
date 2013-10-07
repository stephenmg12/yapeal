<?php
namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractContact
 *
 * @ORM\MappedSuperClass
 */
abstract class AbstractContact extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    protected $contactID;
    /**
     * @var string
     * @ORM\Column(type="string", length=24)
     */
    protected $contactName;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    protected $standing;
}
