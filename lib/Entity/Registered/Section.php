<?php

namespace Yapeal\Entity\Registered;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="registered_Section")
 * @ORM\Entity
 */
class Section
{
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $active;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $activeAPIMask;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $proxy;
    /**
     * @var string
     * @ORM\Column(type="string", length=8)
     * @ORM\Id
     */
    private $sectionName;
}
