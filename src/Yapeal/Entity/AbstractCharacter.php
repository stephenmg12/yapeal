<?php
/**
 * Contains AbstractCharacter class
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
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2013, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
/**
 * Namespace used by all Doctrine2 ORM mapping classes.
 *
 * All other entity namespaces and classes should appear below this namespace.
 */
namespace Yapeal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract mapping super class use in Yapeal's entity classes.
 *
 * Many APIs have this common core group of fields. To save repeating the fields
 * in all the entity classes they can extend this class instead.
 *
 * @ORM\MappedSuperClass
 * @version 0.1.0-alpha Initial alpha release done to get feedback.
 */
abstract class AbstractCharacter
{
    /**
     * @var integer Character ID as received from Eve API.
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    protected $characterID;
    /**
     * @var string Character name as received from Eve API.
     * @ORM\Column(type="string", length=24)
     */
    protected $characterName;
    /**
     * @var integer Corporation ID as received from Eve API.
     * @ORM\Column(type="bigint")
     */
    protected $corporationID;
    /**
     * @var string Corporation name as received from Eve API.
     * @ORM\Column(type="string", length=50)
     */
    protected $corporationName;
    /**
     * @return int
     */
    public function getCharacterID()
    {
        return $this->characterID;
    }
    /**
     * @param int $characterID
     *
     * @return self
     */
    public function setCharacterID($characterID)
    {
        $this->characterID = $characterID;
        return $this;
    }
    /**
     * @return string
     */
    public function getCharacterName()
    {
        return $this->characterName;
    }
    /**
     * @param string $characterName
     *
     * @return self
     */
    public function setCharacterName($characterName)
    {
        $this->characterName = $characterName;
        return $this;
    }
    /**
     * @return int
     */
    public function getCorporationID()
    {
        return $this->corporationID;
    }
    /**
     * @param int $corporationID
     *
     * @return self
     */
    public function setCorporationID($corporationID)
    {
        $this->corporationID = $corporationID;
        return $this;
    }
    /**
     * @return string
     */
    public function getCorporationName()
    {
        return $this->corporationName;
    }
    /**
     * @param string $corporationName
     *
     * @return self
     */
    public function setCorporationName($corporationName)
    {
        $this->corporationName = $corporationName;
        return $this;
    }
}
