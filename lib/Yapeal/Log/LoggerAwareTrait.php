<?php
/**
 * Contains LoggerAwareTrait Trait.
 *
 * PHP version 5.4
 *
 * LICENSE:
 * This file is part of master
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
namespace Yapeal\Log;

use Psr\Log as PL;
use Yapeal\DependencyContainerTrait;

/**
 * Trait LoggerAwareTrait
 *
 * @package Yapeal\Log
 */
trait LoggerAwareTrait
{
    use DependencyContainerTrait;
    /**
     * @param string|null $loggerName
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return PL\LoggerInterface
     */
    public function getLogger($loggerName = null)
    {
        if ($this->logger) {
            return $this->logger;
        }
        $loggerName = $loggerName ? : 'yapeal.logger';
        if (!is_string($loggerName)) {
            $mess = '$loggerName must be a string but given ' . gettype(
                    $loggerName
                );
            throw new \InvalidArgumentException($mess);
        }
        $container = $this->getDependencyContainer();
        if (empty($container[$loggerName])) {
            $container[$loggerName] = function () {
                return new PL\NullLogger();
            };
        }
        $logger = $container[$loggerName];
        $interface = '\Psr\Log\LoggerInterface';
        if (!is_subclass_of($logger, $interface, false)) {
            $mess = 'Class found in dependency container is NOT an instance of '
                . $interface;
            throw new \RuntimeException($mess);
        }
        return $logger;
    }
    /**
     * Sets a logger.
     *
     * @param PL\LoggerInterface|null $logger
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function setLogger(PL\LoggerInterface $logger = null)
    {
        $this->logger = $logger ? : $this->getLogger();
    }
    /**
     * @var PL\LoggerInterface
     */
    protected $logger;
}
