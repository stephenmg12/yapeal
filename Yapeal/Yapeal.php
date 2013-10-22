<?php
/**
 * Contains Yapeal class
 *
 * PHP version 5.3
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal which can be used to access the Eve Online
 * API data and place it into a database.
 * Copyright (C) 2013  Michael Cummings
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General
 * Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * You should be able to find a copy of this license in the LICENSE.md file. A copy of the GNU GPL should also be
 * available in the GNU-GPL.md file.
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
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
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
class Yapeal implements LoggerAwareInterface
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
     * @var LoggerInterface
     */
    private $logger;
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
        NET\NetworkInterface $fetcher = null,
        LoggerInterface $logger = null
    ) {
        $tz = date_default_timezone_get();
        if ($tz !== 'UTC') {
            $mess = "Yapeal requires that PHP's timezone be set to UTC";
            throw new \RuntimeException($mess);
        }
        $this->setLogger($logger);
        $this->setConfiguration($config);
        $this->setDatabase($db);
        $this->setNetwork($fetcher);
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
     * @param CFG\ConfigurationInterface|null $config
     *
     * @return self
     */
    public function setConfiguration(CFG\ConfigurationInterface $config = null)
    {
        if (is_null($config)) {
            $config = new CFG\Configuration($this->logger);
        }
        $this->configuration = $config;
        return $this;
    }
    /**
     * @param DB\DatabaseInterface|null $database
     *
     * @return self
     */
    public function setDatabase(DB\DatabaseInterface $database = null)
    {
        $this->database = $database;
        return $this;
    }
    /**
     * @param LoggerInterface|null $logger
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
     * @param NET\NetworkInterface|null $network
     *
     * @return self
     */
    public function setNetwork(NET\NetworkInterface $network = null)
    {
        $this->network = $network;
        return $this;
    }
}
