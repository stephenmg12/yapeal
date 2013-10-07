<?php

namespace Yapeal\Entity\Account;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * APIKeyInfo
 *
 * @ORM\Table(name="account_APIKeyInfo")
 * @ORM\Entity
 */
class APIKeyInfo
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $keyID;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $accessMask;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expires;
    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $type;
    /**
     * @var ArrayCollection
     * @ORM\JoinTable(
     *     name="account_KeyBridge",
     *     joinColumns={
     *         @ORM\JoinColumn(
     *             name="keyID",
     *             referencedColumnName="keyID"
     *         )
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(
     *             name="characterID",
     *             referencedColumnName="characterID"
     *         )
     *     }
     * )
     * @ORM\ManyToMany(
     *     targetEntity="Characters",
     *     inversedBy="keys",
     *     cascade={"persist"}
     * )
     * @-ORM\OrderBy("characterName"="ASC")
     */
    private $characters;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }
}
