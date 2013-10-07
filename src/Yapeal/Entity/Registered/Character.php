<?php

namespace Yapeal\Entity\Registered;

use Doctrine\ORM\Mapping as ORM;

/**
 * Character
 *
 * @ORM\Table(name="registered_Character")
 * @ORM\Entity
 */
class Character
{
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $active;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $characterID;
    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $activeAPIMask;
    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $characterName;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proxy;
}
