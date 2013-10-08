#!/usr/bin/php -Cq
<?php
/**
 * Command line interface caller for using Yapeal class.
 *
 * This script expects to be ran from a command line or from a crontab job.
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
 * @since      2013-09-29 06:57:00
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
if (false === strpos(___DIR__, 'vendor/')) {
    require_once dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';
}
$yapeal = new Yapeal();
$yapeal->configure()->run();
