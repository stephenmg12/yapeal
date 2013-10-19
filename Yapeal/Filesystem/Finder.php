<?php
/**
 * Contains Finder static class
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
namespace Yapeal\Filesystem;

/**
 * Static only path finding class.
 *
 * @package Yapeal\Filesystem
 */
class Finder
{
    final private function __construct()
    {
        throw new \LogicException('Static only class');
    }
    public static function getLibraryBasePath()
    {
        return dirname(__DIR__);
    }
    public static function getPathOfVendorParent($file = __FILE__)
    {
        $path = dirname($file);
        while (self::hasVendorParent($path)) {
            $path = dirname($path);
        }
        return $path;
    }
    public static function hasVendorParent($dir = __FILE__)
    {
        $dir = dirname($dir);
        return (false !== strpos($dir, '/vendor')) ? true : false;
    }
    final private function __clone()
    {
        throw new \LogicException('Static only class');
    }
    final private function __invoke()
    {
        throw new \LogicException('Static only class');
    }
    final private function __wakeup()
    {
        throw new \LogicException('Static only class');
    }
}
