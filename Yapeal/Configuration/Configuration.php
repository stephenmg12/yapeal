<?php
/**
 * Contains Configuration class
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

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Yapeal\Filesystem\Finder;

/**
 * Class Configuration
 *
 * @package Yapeal\Configuration
 */
class Configuration implements ConfigurationInterface, LoggerAwareInterface
{
    /**
     * @var string[] Holds a list of existing absolute path config files.
     */
    private $configFiles;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string[]
     */
    private $searchFiles = array();
    /**
     * @var string[]
     */
    private $searchPaths = array();
    /**
     * @param string|string[]|null $searchPaths     Paths to used when looking for
     *                                              config files if null use defaults.
     * @param string|string[]|null $files           Configuration files to look for
     *                                              if null use defaults.
     * @param LoggerInterface      $logger
     *
     * @return \Yapeal\Configuration\Configuration
     */
    public function __construct(
        $searchPaths = null,
        $files = null,
        LoggerInterface $logger = null
    ) {
        $this->setLogger($logger);
        $this->setSearchPaths($searchPaths);
        $this->setConfigFiles($files);
    }
    /**
     * Add one or more names of configuration files to be looked for and used.
     *
     * @param string|string[] $files
     *
     * @return self
     */
    public function addConfigFiles($files)
    {
        if (is_string($files)) {
            $files = (array)$files;
        } elseif (!is_array($files)) {
            $mess = '$files must be a string or an array it can not be a(n) ';
            $mess .= gettype($files);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        foreach ($files as $file) {
            if (!is_string($file)) {
                $mess = '$files must contain strings only it can not have a(n) ';
                $mess .= gettype($file);
                $this->logger->log(LogLevel::WARNING, $mess);
                continue;
            }
            // If plain file name ...
            if (false === strpos($file, '/')) {
                $this->searchFiles[] = $file;
                continue;
            }
            $path = dirname($file);
            $fileName = basename($file);
            $path = $this->getCleanPath($path);
            if (false === $path) {
                continue;
            }
            $file = $path . '/' . $fileName;
            if (file_exists($file) && is_file($file) && is_readable($file)) {
                $this->configFiles[] = $file;
            }
        }
        $this->searchFiles = array_merge(array_unique($this->searchFiles));
        $this->configFiles = array_merge(array_unique($this->configFiles));
        return $this;
    }
    /**
     * Used to add additional filesystem paths to search for config files in.
     *
     * @param string|string[] $paths
     *
     * @return self
     */
    public function addSearchPaths($paths)
    {
        if (is_string($paths)) {
            $paths = (array)$paths;
        } elseif (!is_array($paths)) {
            $mess = '$paths must be a string or an array it can not be a(n) ';
            $mess .= gettype($paths);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        foreach ($paths as $path) {
            if (!is_string($path)) {
                $mess = '$paths must contain strings only it can not have a(n) ';
                $mess .= gettype($path);
                $this->logger->log(LogLevel::WARNING, $mess);
                continue;
            }
            $cleanPath = $this->getCleanPath($path);
            if (false === $cleanPath) {
                continue;
            }
            $this->searchPaths[] = $cleanPath;
        }
        $this->searchPaths = array_merge(array_unique($this->searchPaths));
        return $this;
    }
    /**
     * Set the name or names of configuration files to be looked for and used.
     *
     * @param string|string[]|null $files Configuration files to look for if
     *                                    null use defaults.
     *
     * @return self
     * @throws \InvalidArgumentException Throw exception if $files is incorrect
     * type.
     */
    public function setConfigFiles($files = null)
    {
        $this->configFiles = array();
        if (is_null($files)) {
            $this->searchFiles = array('yapeal.ini', 'yapeal.json');
            return $this;
        } else {
            $this->searchFiles = array();
        }
        return $this->addConfigFiles($files);
    }
    /**
     * @param LoggerInterface $logger
     *
     * @return null|void
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        if (is_null($logger)) {
            $logger = new NullLogger();
        }
        $this->logger = $logger;
    }
    /**
     * Sets the filesystem paths used when searching for configuration files.
     *
     * @param string|string[]|null $paths Paths to used when looking for config
     *                                    files if null use defaults.
     *
     * @return self
     * @throws \InvalidArgumentException Throw exception if $paths is incorrect
     * type.
     */
    public function setSearchPaths($paths = null)
    {
        $this->searchPaths = array();
        if (is_null($paths)) {
            $this->searchPaths =
                array(Finder::getLibraryBasePath() . '/config');
            if (Finder::hasVendorParent()) {
                $this->searchPaths[] =
                    Finder::getPathOfVendorParent() . '/config';
            }
            return $this;
        }
        return $this->addSearchPaths($paths);
    }
    /**
     * Get a cleaned up full path.
     *
     * The method understands URI style templates but only for '{libraryBase}'
     * and '{vendorParent}'
     *
     * @param string $path
     *
     * @return string|bool
     * @uses \Yapeal\Filesystem\Finder
     * @link http://tools.ietf.org/html/rfc6570
     */
    protected function getCleanPath($path)
    {
        $firstChar = substr($path, 0, 1);
        if ($firstChar == '/' || strpos($path, '../') !== false) {
            return false;
        }
        $search = array('{libraryBase}/', '{vendorParent}/');
        $replace = array(Finder::getLibraryBasePath() . '/');
        if (Finder::hasVendorParent()) {
            $replace[] = Finder::getPathOfVendorParent() . '/';
        } else {
            $replace[] = $replace[0];
        }
        $path = str_replace($search, $replace, $path, $count);
        if ($count > 1 || strpos($path, '{') !== false) {
            return false;
        }
        return $path;
    }
}
