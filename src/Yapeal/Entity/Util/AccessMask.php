<?php
namespace Yapeal\Entity\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessMask
 *
 * @ORM\Table(name="util_AccessMask")
 * @ORM\Entity
 */
class AccessMask
{
    /**
     * @var string
     * @ORM\Column(name="section", type="string", length=8, nullable=false)
     * @ORM\Id
     */
    private $section;
    /**
     * @var string
     * @ORM\Column(name="api", type="string", length=32, nullable=false)
     * @ORM\Id
     */
    private $api;
    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    /**
     * @var integer
     * @ORM\Column(name="mask", type="bigint", nullable=false)
     */
    private $mask;
    /**
     * @var integer
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;
    /**
     * Constants used with status.
     */
    const NOT_WORKING = 1;
    const XSD_ONLY = 2;
    const WIP = 4;
    const TESTING = 8;
    const COMPLETE = 16;
}
