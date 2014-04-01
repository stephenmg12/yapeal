<?php

namespace Yapeal\Entity\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegisteredUploader
 *
 * @ORM\Table(name="util_RegisteredUploader")
 * @ORM\Entity
 */
class RegisteredUploader
{
    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * @return int
     */
    public function getOwnerID()
    {
        return $this->ownerID;
    }
    /**
     * @return int
     */
    public function getUploadDestinationID()
    {
        return $this->uploadDestinationID;
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
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
    /**
     * @param int $ownerID
     */
    public function setOwnerID($ownerID)
    {
        $this->ownerID = $ownerID;
    }
    /**
     * @param int $uploadDestinationID
     */
    public function setUploadDestinationID($uploadDestinationID)
    {
        $this->uploadDestinationID = $uploadDestinationID;
    }
    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;
    /**
     * @var string
     * @ORM\Column(name="key", type="string", length=255, nullable=true)
     */
    private $key;
    /**
     * @var integer
     * @ORM\Column(name="ownerID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ownerID;
    /**
     * @var integer
     * @ORM\Column(name="uploadDestinationID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $uploadDestinationID;
}
