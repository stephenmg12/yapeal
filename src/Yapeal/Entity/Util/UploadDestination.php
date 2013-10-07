<?php

namespace Yapeal\Entity\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * UploadDestination
 *
 * @ORM\Table(name="util_UploadDestination")
 * @ORM\Entity
 */
class UploadDestination
{
    /**
     * @var integer
     * @ORM\Column(name="uploadDestinationID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uploadDestinationID;
    /**
     * @var boolean
     * @ORM\Column(name="isActive", type="boolean", nullable=true)
     */
    private $isActive;
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=25, nullable=true)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param int $uploadDestinationID
     */
    public function setUploadDestinationID($uploadDestinationID)
    {
        $this->uploadDestinationID = $uploadDestinationID;
    }
    /**
     * @return int
     */
    public function getUploadDestinationID()
    {
        return $this->uploadDestinationID;
    }
    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
