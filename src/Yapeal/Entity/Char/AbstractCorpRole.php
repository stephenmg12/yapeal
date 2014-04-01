<?php
namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractCorpRole
 *
 * @ORM\MappedSuperClass
 * @package Yapeal\Entity\Char
 */
abstract class AbstractCorpRole extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    protected $roleID;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $roleName;
}
