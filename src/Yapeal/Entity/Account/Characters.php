<?php
namespace Yapeal\Entity\Account;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Yapeal\Entity;

/**
 * Characters
 *
 * @ORM\Table(name="account_Characters")
 * @ORM\Entity
 */
class Characters extends Entity\AbstractCharacter
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(
     *     targetEntity="APIKeyInfo",
     *     mappedBy="characters",
     *     cascade={"persist"}
     * )
     */
    private $keys;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->keys = new ArrayCollection();
    }
}
