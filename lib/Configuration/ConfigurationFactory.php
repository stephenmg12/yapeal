<?php
/**
 * Contains ConfigurationFactory class.
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
 * Class ConfigurationFactory
 *
 * @package Yapeal\Configuration
 */
class ConfigurationFactory implements ConfigFactoryInterface,
    LoggerAwareInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->setLogger($logger);
    }
    /**
     * @param string          $type
     * @param LoggerInterface $logger
     *
     * @return ConfigHandlerInterface
     */
    public function getHandler($type, LoggerInterface $logger = null)
    {
        if (is_null($logger)) {
            $logger = $this->logger;
        }
        if ($this->isUnknownType($type)) {
            $mess = 'Received unknown type ' . $type;
            $this->logger->log(LogLevel::WARNING, $mess);
            return new NullHandler($logger);
        }
        if (!$this->haveHandler($type)) {
            $this->setDefaultHandler($type, $logger);
        }
        return $this->handlers[$type];
    }
    /**
     * @param string $type
     *
     * @return bool
     */
    public function haveHandler($type)
    {
        if (!is_string($type)) {
            $mess = '$type MUST be a string but received '
                . gettype($type);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        return array_key_exists($type, $this->handlers);
    }
    /**
     * @param string                 $type
     * @param ConfigHandlerInterface $handler
     *
     * @return self
     */
    public function setHandler($type, ConfigHandlerInterface $handler)
    {
        if ($this->isUnknownType($type)) {
            $mess = 'Received unknown type ' . $type;
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $this->handlers[$type] = $handler;
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
     * @var array
     */
    private $handlers = array();
    /**
     * @var array Hold a list of known configuration file types.
     */
    private $knownTypes = array(
        ConfigFactoryInterface::INI,
        ConfigFactoryInterface::JSON,
        ConfigFactoryInterface::PHP,
        ConfigFactoryInterface::URL,
        ConfigFactoryInterface::XML
    );
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @param string $type
     *
     * @return bool
     */
    private function isUnknownType($type)
    {
        if (!is_string($type)) {
            $mess = '$type MUST be string but received ' . gettype($type);
            $this->logger->log(LogLevel::WARNING, $mess);
            return true;
        }
        return !in_array($type, $this->knownTypes);
    }
    /**
     * @param string          $type
     * @param LoggerInterface $logger
     *
     * @return self
     */
    private function setDefaultHandler($type, LoggerInterface $logger = null)
    {
        if (is_null($logger)) {
            $logger = $this->logger;
        }
        switch ($type) {
            case ConfigFactoryInterface::INI:
                $this->setHandler($type, new IniHandler($logger));
                break;
            case ConfigFactoryInterface::JSON:
                $this->setHandler($type, new JsonHandler($logger));
                break;
            default:
                $this->setHandler($type, new NullHandler($logger));
                break;
        }
        return $this;
    }
}
