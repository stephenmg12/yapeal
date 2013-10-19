<?php
/**
 * Contains APIKeyInfo class
 *
 * PHP version 5.3
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know as Yapeal which will be used to refer to it
 * in the rest of this license.
 *
 * Yapeal is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Yapeal is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with Yapeal. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @author    Michael Cummings <mgcummings@yahoo.com>
 * @copyright 2013 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link      http://code.google.com/p/yapeal/
 * @link      http://www.eveonline.com/
 */
namespace Yapeal\Entity\Account;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * APIKeyInfo
 *
 * @ORM\Table(name="account_APIKeyInfo")
 * @ORM\Entity
 * @package Yapeal\Entity\Account
 */
class APIKeyInfo
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     */
    private $accessMask;
    /**
     * @var ArrayCollection
     * @ORM\JoinTable(
     *             name="account_KeyBridge",
     *             joinColumns={
     * @ORM\JoinColumn(
     *             name="keyID",
     *             referencedColumnName="keyID"
     *         )
     *     },
     *             inverseJoinColumns={
     * @ORM\JoinColumn(
     *             name="characterID",
     *             referencedColumnName="characterID"
     *         )
     *     }
     * )
     * @ORM\ManyToMany(
     *             targetEntity="Characters",
     *             inversedBy="keys",
     *             cascade={"persist"}
     * )
     * @-ORM\OrderBy("characterName"="ASC")
     */
    private $characters;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expires;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $keyID;
    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $type;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }
}
