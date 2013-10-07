<?php

namespace Yapeal\Entity\Registered;

use Doctrine\ORM\Mapping as ORM;

/**
 * Key
 *
 * @ORM\Table(name="registered_Key")
 * @ORM\Entity(repositoryClass="KeyRepository")
 */
class Key
{
    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;
    /**
     * @var integer
     * @ORM\Column(name="keyID", type="bigint", nullable=false)
     * @ORM\Id
     */
    private $keyID;
    /**
     * @var integer
     * @ORM\Column(name="activeAPIMask", type="bigint", nullable=true)
     */
    private $activeAPIMask;
    /**
     * @var string
     * @ORM\Column(name="proxy", type="string", length=255, nullable=true)
     */
    private $proxy;
    /**
     * @var string
     * @ORM\Column(name="vCode", type="string", length=64, nullable=false)
     */
    private $vCode;
    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }
    /**
     * @param int $activeAPIMask
     */
    public function setActiveAPIMask($activeAPIMask)
    {
        $this->activeAPIMask = $activeAPIMask;
    }
    /**
     * @return int
     */
    public function getActiveAPIMask()
    {
        return $this->activeAPIMask;
    }
    /**
     * @param int $keyID
     */
    public function setKeyID($keyID)
    {
        $this->keyID = $keyID;
    }
    /**
     * @return int
     */
    public function getKeyID()
    {
        return $this->keyID;
    }
    /**
     * @param string $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }
    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }
    /**
     * @param string $vCode
     */
    public function setVCode($vCode)
    {
        $this->vCode = $vCode;
    }
    /**
     * @return string
     */
    public function getVCode()
    {
        return $this->vCode;
    }
}
