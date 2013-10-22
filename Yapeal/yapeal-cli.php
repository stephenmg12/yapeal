#!/usr/bin/env php
<?php
/**
 * Command line interface caller for using Yapeal class.
 *
 * This script expects to be ran from a command line or from a crontab job.
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
namespace Yapeal;

/**
 * @internal Only let this code be ran in CLI.
 */
if (PHP_SAPI != 'cli') {
    header('HTTP/1.0 403 Forbidden', true, 403);
    $mess =
        basename(__FILE__)
        . ' only works with CLI version of PHP but tried to run it using '
        . PHP_SAPI
        . ' instead.'
        . PHP_EOL;
    die($mess);
};
/**
 * @internal Only let this code be ran directly.
 */
$included = get_included_files();
if (count($included) > 1 || $included[0] != __FILE__) {
    $mess =
        basename(__FILE__)
        . ' must be called directly and can not be included.'
        . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(1);
};
$path = dirname(__DIR__);
while (false !== strpos($path, '/vendor')) {
    $path = dirname($path);
}
require_once $path . '/vendor/autoload.php';
$yapeal = new Yapeal();
$yapeal
    ->configure()
    ->run();
