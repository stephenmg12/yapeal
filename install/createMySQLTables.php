#!/usr/bin/php -Cq
<?php
/**
 * Contains code used to add or update tables in database.
 *
 * PHP version 5
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal which can be used to access the Eve Online
 * API data and place it into a database.
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2008-2014, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @package    Yapeal
 * @subpackage Install
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
/**
 * @internal Allow viewing of the source code in web browser.
 */
if (isset($_REQUEST['viewSource'])) {
    highlight_file(__FILE__);
    exit();
}
/**
 * @internal Only let this code be ran in CLI.
 */
if (PHP_SAPI != 'cli') {
    header('HTTP/1.0 403 Forbidden', true, 403);
    $mess = basename(__FILE__) . ' only works with CLI version of PHP but tried'
        . ' to run it using ' . PHP_SAPI . ' instead.' . PHP_EOL;
    die($mess);
}
/**
 * @internal Only let this code be ran directly.
 */
$included = get_included_files();
if (count($included) > 1 || $included[0] != __FILE__) {
    $mess = basename(__FILE__)
        . ' must be called directly and can not be included.' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(1);
}
/**
 * Define short name for directory separator which always uses unix '/'.
 *
 * @ignore
 */
define('DS', '/');
// Check if the base path for Yapeal has been set in the environment.
$dir = @getenv('YAPEAL_BASE');
if ($dir === false) {
    // Used to overcome path issues caused by how script is ran.
    $dir = str_replace('\\', DS, realpath(dirname(__FILE__) . DS . '..')) . DS;
}
// Get path constants so they can be used.
require_once $dir . 'inc' . DS . 'common_paths.php';
require_once YAPEAL_BASE . 'revision.php';
require_once YAPEAL_INC . 'parseCommandLineOptions.php';
require_once YAPEAL_INC . 'getSettingsFromIniFile.php';
require_once YAPEAL_INC . 'usage.php';
require_once YAPEAL_INC . 'showVersion.php';
require_once YAPEAL_EXT . 'ADOdb' . DS . 'adodb.inc.php';
require_once YAPEAL_EXT . 'ADOdb' . DS . 'adodb-xmlschema03.inc.php';
$shortOpts = array('c:', 'd:', 'p:', 's:', 't:', 'u:');
$longOpts = array(
    'config:',
    'database:',
    'driver:',
    'password:',
    'server:',
    'suffix:',
    'table-prefix:',
    'username:',
    'xml:'
);
$options = parseCommandLineOptions($shortOpts, $longOpts);
if (isset($options['help'])) {
    usage(__FILE__, $shortOpts, $longOpts);
    exit(0);
}
if (isset($options['version'])) {
    showVersion(__FILE__);
    exit(0);
}
if (!empty($options['config'])) {
    $section = getSettingsFromIniFile($options['config'], 'Database');
    unset($options['config']);
} else {
    $section = getSettingsFromIniFile(null, 'Database');
}
if (isset($options['xml'])) {
    $sections = explode(' ', $options['xml']);
    unset($options['xml']);
} else {
    $sections =
        array('util', 'account', 'char', 'corp', 'eve', 'map', 'server');
}
// Merge the configuration file settings with ones from command line.
// Settings from command line will override any from file.
$options = array_merge($section, $options);
$required = array('database', 'host', 'password', 'username');
$mess = '';
foreach ($required as $setting) {
    if (empty($options[$setting])) {
        $mess .= 'Missing required setting ' . $setting . PHP_EOL;
    }
}
if (!empty($mess)) {
    fwrite(STDERR, $mess);
    exit(2);
}
$file = $dir . DS . 'install' . DS . 'sql' . DS . 'DatabaseCreate.sql';
if (!is_file($file)) {
    $mess = 'Could not find SQL file ' . $file . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
}
$sqlStatements = file_get_contents($file);
if (false === $sqlStatements) {
    $mess = 'Could not get contents of SQL file ' . $file;
    fwrite(STDERR, $mess);
    exit(2);
}
// Replace {database} with database option.
$sqlStatements =
    str_replace('{database}', $options['database'], $sqlStatements);
// Replace {table_prefix} with table_prefix option.
$sqlStatements =
    str_replace('{table_prefix}', $options['table_prefix'], $sqlStatements);
// Trim off blank last line.
$sqlStatements = rtrim($sqlStatements);
// Split up SQL into statements.
$sqlStatements = explode(';', $sqlStatements);
$mysqli = new mysqli(
    $options['host'], $options['username'], $options['password'], ''
);
if (mysqli_connect_error()) {
    $mess = 'Could NOT connect to MySQL. MySQL error was ('
        . mysqli_connect_errno() . ') ' . mysqli_connect_error();
    fwrite(STDERR, $mess);
    exit(2);
}
foreach ($sqlStatements as $line => $sql) {
    $sql = rtrim($sql, ';');
    if (strlen($sql) < 3) {
        continue;
    }
    if ($mysqli->query($sql) === false) {
        $mess = 'The following SQL statement failed on statement: ' . $line
            . PHP_EOL
            . $sql . PHP_EOL
            . '(' . $mysqli->errno . ') ' . $mysqli->error . PHP_EOL;
        fwrite(STDERR, $mess);
        $mysqli->close();
        exit(2);
    }
}
$mysqli->close();
$mess =
    'All database tables have been installed or updated as needed.' . PHP_EOL;
fwrite(STDOUT, $mess);
exit(0);
