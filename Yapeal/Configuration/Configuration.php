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
     * @var string
     */
    private $libraryBase;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $vendorParent;
    /**
     * @param string|string[]|null     $files                       Configuration files to look for
     *                                                              if null use defaults.
     * @param \Psr\Log\LoggerInterface $logger
     * @param string                   $libraryBase
     *
     * @return \Yapeal\Configuration\Configuration
     */
    public function __construct(
        $files = null,
        LoggerInterface $logger = null,
        $libraryBase = __DIR__
    ) {
        $this->setLibraryBase($libraryBase);
        $this->setLogger($logger);
        $this->setConfigFiles($files);
    }
    /**
     * Add one or more names of configuration files to be looked for and used.
     *
     * @param string|string[] $files
     *
     * @return self
     * @uses Configuration::getCleanPath() Configuration::getCleanPath()
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
                $mess =
                    '$files must contain strings only it can not have a(n) ';
                $mess .= gettype($file);
                $this->logger->log(LogLevel::WARNING, $mess);
                continue;
            }
            $path = $this->getCleanPath(dirname($file));
            if (false === $path) {
                continue;
            }
            $file = $path . DIRECTORY_SEPARATOR . basename($file);
            if (file_exists($file) && is_file($file) && is_readable($file)) {
                $this->configFiles[] = $file;
            }
        }
        $this->configFiles = array_merge(array_unique($this->configFiles));
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
            $ds = DIRECTORY_SEPARATOR;
            $files = array(
                $this->libraryBase
                . "${ds}Configuration$ds}yapeal-template.json",
                $this->libraryBase . "${ds}config${ds}yapeal.ini",
                $this->libraryBase . "${ds}config${ds}yapeal.json",
                $this->vendorParent . "${ds}config${ds}yapeal.ini",
                $this->vendorParent . "${ds}config${ds}yapeal.json"
            );
        }
        return $this->addConfigFiles($files);
    }
    /**
     * @param mixed  $path
     * @param string $library
     *
     * @return self
     */
    public function setLibraryBase($path = __DIR__, $library = 'Yapeal')
    {
        $library = DIRECTORY_SEPARATOR . $library;
        while (false !== strpos((string)$path, $library)) {
            $path = dirname($path);
        }
        $this->libraryBase = $path . $library;
        $this->setVendorParent($path);
        return $this;
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
     * @param string $path
     * @param string $vendor
     *
     * @return self
     */
    public function setVendorParent($path, $vendor = 'vendor')
    {
        $vendor = DIRECTORY_SEPARATOR . $vendor;
        while (false !== strpos($path, $vendor)) {
            $path = dirname($path);
        }
        $this->vendorParent = $path;
        return $this;
    }
    /**
     * Get a cleaned up full path.
     *
     * The method understands URI style templates but only for '{libraryBase}'
     * or '{vendorParent}' at the beginning of the path.
     *
     * Some examples:
     * <pre>
     * $path = '{libraryBase}/config';
     * $path = '{vendorParent}/config';
     * </pre>
     *
     * The following examples would NOT be allowed:
     * <pre>
     * // {vendorParent} | {libraryBase} NOT both at same time.
     * $path = '{vendorParent}/{libraryBase}/config/dir';
     * // Can NOT use URI template anywhere but at start.
     * $path = 'dir/{libraryBase}/more/dir';
     * // Up directory paths NOT allowed.
     * $path = '../../no-way';
     * // Absolute paths NOT allowed either.
     * $path = '/Yapeal/not-happening';
     * // Unknown URI templates NOT allowed.
     * $path = '{myTemplate}/no-no'
     * </pre>
     *
     * @param string $path
     *
     * @return string|bool
     * @uses \Yapeal\Filesystem\Finder
     * @link http://tools.ietf.org/html/rfc6570 URI Templates
     */
    protected function getCleanPath($path)
    {
        $ds = DIRECTORY_SEPARATOR;
        if (substr($path, 0, 1) == $ds) {
            $mess = '$path can NOT be absolute';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        if (strpos($path, "..$ds") !== false) {
            $mess = '$path can NOT contain up directory reference';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        $search = array("{libraryBase}$ds", "{vendorParent}$ds");
        $replace = array($this->libraryBase . $ds, $this->vendorParent . $ds);
        $path = str_replace($search, $replace, $path, $count);
        if ($count > 1) {
            $mess = '$path can NOT contain more than one URI template';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        if (strpos($path, '{') !== false && strpos($path, '}') !== false) {
            $mess = '$path can NOT contain unknown URI templates';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        return $path;
    }
}
