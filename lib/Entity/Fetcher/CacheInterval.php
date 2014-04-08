<?php
/**
 * Contains CachedInterval class
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
 * CachedInterval
 *
 * @ORM\Table(name="fetcher_CacheInterval")
 * @ORM\Entity
 * @package Yapeal\Entity\Fetcher
 */
class CacheInterval
{
    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     * @ORM\Id
     */
    private $api;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $interval;
    /**
     * @var string
     * @ORM\Column(type="string", length=8)
     * @ORM\Id
     */
    private $section;
}