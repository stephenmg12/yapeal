<?php

namespace Yapeal\Entity\Registered;

use Doctrine\ORM\Mapping as ORM;

/**
 * Corporation
 *
 * @ORM\Table(name="registered_Corporation")
 * @ORM\Entity
 */
class Corporation
{
    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @return int
     */
    public function getActiveAPIMask()
    {
        return $this->activeAPIMask;
    }
    /**
     * @return int
     */
    public function getCorporationID()
    {
        return $this->corporationID;
    }
    /**
     * @return string
     */
    public function getCorporationName()
    {
        return $this->corporationName;
    }
    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }
    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }
    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    /**
     * @param int $activeAPIMask
     */
    public function setActiveAPIMask($activeAPIMask)
    {
        $this->activeAPIMask = $activeAPIMask;
    }
    /**
     * @param int $corporationID
     */
    public function setCorporationID($corporationID)
    {
        $this->corporationID = $corporationID;
    }
    /**
     * @param string $corporationName
     */
    public function setCorporationName($corporationName)
    {
        $this->corporationName = $corporationName;
    }
    /**
     * @param string $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }
    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;
    /**
     * @var integer
     * @ORM\Column(name="activeAPIMask", type="bigint", nullable=true)
     */
    private $activeAPIMask;
    /**
     * @var integer
     * @ORM\Column(name="corporationID", type="bigint", nullable=false)
     * @ORM\Id
     */
    private $corporationID;
    /**
     * @var string
     * @ORM\Column(name="corporationName", type="string", length=150, nullable=true)
     */
    private $corporationName;
    /**
     * @var string
     * @ORM\Column(name="proxy", type="string", length=255, nullable=true)
     */
    private $proxy;
}
