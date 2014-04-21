#!/usr/bin/env php
<?php
/**
 * Used to check installation meets basic requirements.
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
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2008-2014, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
use Yapeal\Command\LegacyUtil;

// Insure minimum version of PHP we need to run.
$version = '5.3.3';
if (version_compare(PHP_VERSION, $version, '<')) {
    $mess =
        'Need minimum of PHP ' . $version . ' to use this software!' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// IDE only seems to like this form for path since need for this loader is going
// away ASAP not worrying about it.
require_once __DIR__ . '/YapealAutoLoad.php';
YapealAutoLoad::activateAutoLoad();
// Include Composer's auto-loader for all the classes that are being moved.
/*
 * Find auto loader from one of
 * vendor/bin/
 * OR ./
 * OR bin/
 * OR lib/Yapeal/
 * OR vendor/yapeal/yapeal/bin/
 */
(@include_once dirname(__DIR__) . '/autoload.php')
|| (@include_once __DIR__ . '/vendor/autoload.php')
|| (@include_once dirname(__DIR__) . '/vendor/autoload.php')
|| (@include_once dirname(dirname(__DIR__)) . '/vendor/autoload.php')
|| (@include_once dirname(dirname(dirname(__DIR__))) . '/autoload.php')
|| die('Could not find required auto class loader. Aborting ...');
$legacyUtil = new LegacyUtil();
$shortOpts = array('c:');
$longOpts = array('config:');
// Parser command line options first in case user just wanted to see help.
$options = $legacyUtil->parseCommandLineOptions($shortOpts, $longOpts);
if (isset($options['help'])) {
    $legacyUtil->usage(__FILE__, $shortOpts, $longOpts);
    exit(0);
};
if (isset($options['version'])) {
    $legacyUtil->showVersion(__FILE__);
    exit(0);
};
// Check for some required extensions
$required =
    array('curl', 'date', 'hash', 'mysqli', 'SimpleXML', 'SPL', 'xmlreader');
$exts = get_loaded_extensions();
$missing = array_diff($required, $exts);
if (count($missing) > 0) {
    $mess = 'The required PHP extensions: ';
    $mess .= implode(', ', $missing) . ' are missing!' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// Check on cURL version and features.
$cv = curl_version();
if (version_compare($cv['version'], '7.15.0', '<')) {
    $mess = 'Need minimum of cURL 7.15.0 to use this software!' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
if (($cv['features'] & CURL_VERSION_SSL) != CURL_VERSION_SSL) {
    $mess = 'cURL was built without SSL please check it.';
    fwrite(STDERR, $mess);
    exit(2);
};
// Check for minimum MySQL client.
if (mysqli_get_client_version() < 50000) {
    $mess = 'MySQL client version is older than 5.0.' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// Must have getopt() to get command line parameters.
if (!function_exists('getopt')) {
    $mess = 'getopt() not available can not perform checks!' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// Check the custom settings file if it can be found else check the default.
if (!empty($options['config'])) {
    $iniVars = $legacyUtil->getSettingsFromIniFile($options['config']);
} else {
    $iniVars = $legacyUtil->getSettingsFromIniFile();
};
if (empty($iniVars)) {
    $mess = 'Had one or more problems accessing configuration file.';
    $mess .= ' See any other error messages above for more help.' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// Check for required sections.
$required = array('Cache', 'Database', 'Logging');
$mess = '';
foreach ($required as $section) {
    if (!isset($iniVars[$section])) {
        $mess .= 'Required section [' . $section;
        $mess .= '] is missing.' . PHP_EOL;
    }
}
if (!empty($mess)) {
    fwrite(STDERR, $mess);
    exit(2);
};
// Check if log directory is writable.
$dir = dirname(__DIR__) . '/log/';
if (!is_writable($dir)) {
    $mess = $dir . ' is not writable.' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// Check for required Logging section settings.
$required = array('log_config', 'trace_enabled');
$mess = '';
foreach ($required as $setting) {
    if (!isset($iniVars['Logging'][$setting])) {
        $mess .= 'Missing required setting ' . $setting;
        $mess .= ' in section [Logging].' . PHP_EOL;
    }
}
if (!empty($mess)) {
    fwrite(STDERR, $mess);
    exit(2);
};
// Check if cache directory is writable.
$dir =
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
if (!is_writable($dir)) {
    $mess = $dir . ' is not writable.' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
// Check for required Cache section settings.
$required = array('cache_length', 'cache_output');
$mess = '';
foreach ($required as $setting) {
    if (!isset($iniVars['Cache'][$setting])) {
        $mess .= 'Missing required setting ' . $setting;
        $mess .= ' in section [Cache].' . PHP_EOL;
    }
}
if (!empty($mess)) {
    fwrite(STDERR, $mess);
    exit(2);
};
// Check if required cache directories exist and are writable.
if ($iniVars['Cache']['cache_output'] == 'file'
    || $iniVars['Cache']['cache_output'] == 'both'
) {
    $required =
        array('account', 'ADOdb', 'char', 'corp', 'eve', 'map', 'server');
    foreach ($required as $section) {
        if (!is_dir($dir . $section)) {
            $mess = 'Missing required directory ' . $dir . $section
                . PHP_EOL;
            fwrite(STDERR, $mess);
            exit(2);
        };
        if (!is_writable($dir . $section)) {
            $mess = $dir . $section . ' is not writable.' . PHP_EOL;
            fwrite(STDERR, $mess);
            exit(2);
        };
    }
}
// Check for required Database section settings.
$required = array(
    'database',
    'driver',
    'host',
    'suffix',
    'table_prefix',
    'username',
    'password'
);
$mess = '';
foreach ($required as $setting) {
    if (!isset($iniVars['Database'][$setting])) {
        $mess .= 'Missing required setting ' . $setting;
        $mess .= ' in section [Database].' . PHP_EOL;
    };
}
if (!empty($mess)) {
    fwrite(STDERR, $mess);
    exit(2);
};
// Check for the required non-section general settings.
if (!isset($iniVars['application_agent'])) {
    $mess = 'Configuration file is outdated and "application_agent" is not set.'
        . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
}
if (!isset($iniVars['registered_mode'])) {
    $mess = 'Configuration file is outdated and "registered_mode" is not set.'
        . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
$required = array('ignored', 'optional', 'required');
if (!in_array($iniVars['registered_mode'], $required)) {
    $mess = 'Unknown value ' . $iniVars['registered_mode'];
    $mess .= ' for "registered_mode" in configuration file.' . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
$mess = 'All tests passed!!!' . PHP_EOL;
fwrite(STDOUT, $mess);
exit(0);
