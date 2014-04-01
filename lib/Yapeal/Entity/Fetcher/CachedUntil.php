<?php
/**
 * Contains CachedUntil class
 *
 * PHP version 5.3
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know as Yapeal which will be used to refer to it
 * in the rest of this license.
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @author    Michael Cummings <mgcummings@yahoo.com>
 * @copyright 2013 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link      http://code.google.com/p/yapeal/
 * @link      http://www.eveonline.com/
 */
namespace Yapeal\Entity\Fetcher;

use Doctrine\ORM\Mapping as ORM;

/**
 * CachedUntil
 *
 * @ORM\Table(name="fetcher_CachedUntil", indexes={@ORM\Index(name="until_idx", columns={"cachedUntil"})})
 * @ORM\Entity(repositoryClass="CachedUntilRepository")
 * @package Yapeal\Entity\Fetcher
 */
class CachedUntil
{
    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     * @ORM\Id
     */
    private $apiName;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $cachedUntil;
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $ownerID;
    /**
     * @var string
     * @ORM\Column(type="string", length=8)
     */
    private $sectionName;
}
