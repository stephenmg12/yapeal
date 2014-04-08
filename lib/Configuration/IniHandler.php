<?php
/**
 * Contains IniHandler class.
 *
 * PHP version 5.3
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal which can be used to access the Eve Online
 * API data and place it into a database.
 * Copyright (C) 2014 Michael Cummings
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
 * @copyright 2014 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @author    Michael Cummings <mgcummings@yahoo.com>
 */
namespace Yapeal\Configuration;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

/**
 * Class IniHandler
 *
 * @package Yapeal\Configuration
 */
class IniHandler implements ConfigHandlerInterface, LoggerAwareInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->setLogger($logger);
    }
    /**
     * Get the processed configuration as a key => value list.
     *
     * @throws \LogicException
     * @return string[string]
     */
    public function getProcessedConfigurationAsStringArray()
    {
        if (is_null($this->config)) {
            $mess = 'MUST call processConfiguration() first';
            throw new \LogicException($mess);
        }
        return $this->config;
    }
    /**
     * Process the configuration 'file'.
     *
     * @param string $config
     *
     * @return self
     */
    public function processConfiguration($config)
    {
        $data = parse_ini_file($config, true);
        if (false === $data) {
            $mess = 'No data found';
            $this->logger->log(LogLevel::DEBUG, $mess);
            $data = array();
        }
        $this->config['yapeal'] = $data;
        return $this;
    }
    /**
     * @param LoggerInterface $logger
     *
     * @return null|void
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = (is_null($logger)) ? new NullLogger() : $logger;
    }
    /**
     * @var string[]
     */
    private $config;
    /**
     * @var LoggerInterface
     */
    private $logger;
}