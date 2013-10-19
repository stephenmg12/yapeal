<?php
/**
 * Contains Configuration Interface
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
namespace Yapeal\Configuration;

/**
 * Class ConfigurationInterface
 *
 * @package Yapeal\Configuration
 */
interface ConfigurationInterface
{
    /**
     * Used to add additional filesystem paths to search for config files in.
     *
     * @param string|string[] $paths
     *
     * @return self
     */
    public function addSearchPaths($paths);
    /**
     * Sets the filesystem paths used when searching for configuration files.
     *
     * @param string|string[] $paths Paths to use if null use defaults.
     *
     * @return self
     */
    public function setSearchPaths($paths = null);
    /**
     * Add one or more names of configuration files to be looked for and used.
     *
     * @param string|string[] $files
     *
     * @return self
     */
    public function addConfigFiles($files);
    /**
     * Set the name or names of configuration files to be looked for and used.
     *
     * @param string|string[] $files Files to use if null use defaults.
     *
     * @return self
     */
    public function setConfigFiles($files = null);
    /**
     *
     */
}
