<?php
/**
 * Contains Yapeal class
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
/**
 * Main namespace for all of Yapeal. All other namespaces used are under it.
 */
namespace Yapeal;

use Doctrine\DBAL;
use Yapeal\Configuration as CFG;
use Yapeal\Database as DB;
use Yapeal\Filesystem\Finder;
use Yapeal\Network as NET;

/**
 * Class Yapeal is used to get information from Eve-online API and store in to a database.
 *
 * This is the main class that is needed to use Yapeal.
 *
 * The Yapeal class expects that a suitable PSR-0 compatible auto-loader is being used that will look in it's current
 * installed location and make available the other packages from the vendor directory. Composer's default one which you
 * can find in vendor/autoload.php works.
 *
 * @package Yapeal
 */
class Yapeal
{
    private static $version;
    /**
     * @var CFG\ConfigurationInterface Holds main configuration.
     */
    private $configuration;
    /**
     * @var DB\DatabaseInterface Holds main database connection.
     */
    private $database;
    /**
     * @var int Holds the soft limit used to keep Yapeal from overloading servers.
     */
    private $executeSoftLimit;
    /**
     * @var NET\NetworkInterface Holds main network connection.
     */
    private $network;
    /**
     * Holds GMT date-time Yapeal started
     *
     * This is use to have the same time on all APIs that error out and need to be tried again.
     *
     * @var string
     */
    private $savedStartTime;
    /**
     * @param CFG\ConfigurationInterface $config
     * @param DB\DatabaseInterface       $db
     * @param NET\NetworkInterface       $fetcher
     *
     * @throws \RuntimeException
     */
    public function __construct(
        CFG\ConfigurationInterface $config = null,
        DB\DatabaseInterface $db = null,
        NET\NetworkInterface $fetcher = null
    ) {
        $tz = date_default_timezone_get();
        if ($tz !== 'UTC') {
            $mess = "Yapeal requires that PHP's timezone be set to UTC";
            throw new \RuntimeException($mess);
        }
        if (is_null($config)) {
            $config = new CFG\Configuration();
        }
        $this->configuration = $config;
        $this->database = $db;
        $this->network = $fetcher;
    }
    /**
     * Returns the version info string for Yapeal.
     *
     * @return string
     * @throws \RuntimeException Throws \RuntimeException if can not access VERSION file.
     */
    public static function getVersion()
    {
        if (!static::$version) {
            $version = @file_get_contents('VERSION');
            if (false === $version) {
                throw new \RuntimeException('Can not access VERSION file');
            }
            static::$version = trim($version);
        }
        return static::$version;
    }
    public function configure()
    {
        if (isset($this->configuration)) {
            $this->configuration->fetchConfiguration();
        }
        if (empty($this->database)) {
            $db = 'junk'; // TODO database stuff
        }
        return $this;
    }
    public function getDatabaseConnection()
    {
        $config = new DBAL\Configuration();
        $connectionParams = array();
    }
    public function run()
    {
        if (empty($this->database)) {
            $mess =
                'Database connection is needed before Yapeal::run() can be called';
            throw new \LogicException($mess);
        }
        if (empty($this->network)) {
            $mess =
                'Network connection is needed before Yapeal::run() can be called';
            throw new \LogicException($mess);
        }
        $this->executeSoftLimit = strtotime('10 minutes');
        $this->savedStartTime = gmdate('Y-m-d H:i:s', $this->executeSoftLimit);
        print 'Works!' . PHP_EOL;
        return $this;
    }
    /**
     * @param CFG\ConfigurationInterface $value
     *
     * @return self
     */
    public function setConfiguration(CFG\ConfigurationInterface $value)
    {
        $this->configuration = $value;
        return $this;
    }
    /**
     * @param DB\DatabaseInterface $database
     *
     * @return self
     */
    public function setDatabase(DB\DatabaseInterface $database)
    {
        $this->database = $database;
        return $this;
    }
    /**
     * @param NET\NetworkInterface $network
     *
     * @return self
     */
    public function setNetwork(NET\NetworkInterface $network)
    {
        $this->network = $network;
        return $this;
    }
}
