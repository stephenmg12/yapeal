#!/usr/bin/php -Cq
<?php
/**
 * Used to check installation meets basic requirements.
 *
 * PHP version 5
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know
 * as Yapeal which will be used to refer to it in the rest of this license.
 *
 *  Yapeal is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Yapeal is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with Yapeal. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2008-2011, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @package    Yapeal
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
/**
 * @internal Allow viewing of the source code in web browser.
 */
if (isset($_REQUEST['viewSource'])) {
  highlight_file(__FILE__);
  exit();
};
/**
 * @internal Only let this code be ran in CLI.
 */
if (PHP_SAPI != 'cli') {
  header('HTTP/1.0 403 Forbidden', TRUE, 403);
  $mess = basename(__FILE__) . ' only works with CLI version of PHP but tried';
  $mess = ' to run it using ' . PHP_SAPI . ' instead';
  die($mess);
};
/**
 * @internal Only let this code be ran directly.
 */
$included = get_included_files();
if (count($included) > 1 || $included[0] != __FILE__) {
  $mess = basename(__FILE__) . ' must be called directly and can not be included';
  fwrite(STDERR, $mess . PHP_EOL);
  fwrite(STDOUT, 'error' . PHP_EOL);
  exit(1);
};
/**
 * Define short name for directory separator which always uses unix '/'.
 * @ignore
 */
define('DS', '/');
// Used to over come path issues caused by how script is ran on server.
$baseDir = str_replace('\\', DS, realpath(dirname(__FILE__) . DS. '..')) . DS;
// Pull in Yapeal revision constants.
require_once $baseDir . 'revision.php';
// Get path constants so they can be used.
require_once $baseDir . 'inc' . DS . 'common_paths.php';
require_once YAPEAL_INC . 'parseCommandLineOptions.php';
require_once YAPEAL_INC . 'getSettingsFromIniFile.php';
require_once YAPEAL_INC . 'usage.php';
// Must have getopt() to get command line parameters.
if (!function_exists('getopt')) {
  $mess = 'getopt() not available can not perform checks!' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
$shortOpts = array('c:');
$longOpts = array('config:');
// Parser command line options first in case user just wanted to see help.
$options = parseCommandLineOptions($shortOpts, $longOpts);
$exit = FALSE;
if (isset($options['help'])) {
  $file = basename(__FILE__);
  usage($file, $shortOpts, $longOpts);
  $exit = TRUE;
};
if (isset($options['version'])) {
  $mess = basename(__FILE__);
  if (YAPEAL_VERSION != 'svnversion') {
    $mess .= ' ' . YAPEAL_VERSION . ' (' . YAPEAL_STABILITY . ') ';
    $mess .= YAPEAL_DATE . PHP_EOL . PHP_EOL;
  } else {
    $rev = str_replace(array('$', 'Rev:'), '', '$Rev$');
    $date = str_replace(array('$', 'Date:'), '', '$Date$');
    $mess .= $rev . '(svn)' . $date . PHP_EOL . PHP_EOL;
  };
  $mess .= 'Copyright (c) 2008-2011, Michael Cummings.' . PHP_EOL;
  $mess .= 'License LGPLv3+: GNU LGPL version 3 or later';
  $mess .= ' <http://www.gnu.org/copyleft/lesser.html>.' . PHP_EOL;
  $mess .= 'See COPYING and COPYING-LESSER for more details.' . PHP_EOL;
  $mess .= 'This program comes with ABSOLUTELY NO WARRANTY.' . PHP_EOL . PHP_EOL;
  fwrite(STDOUT, $mess);
  $exit = TRUE;
};
if ($exit == TRUE) {
  exit(0);
};
// Insure minimum version of PHP we need to run.
if (version_compare(PHP_VERSION, '5.2.4', '<')) {
  $mess = 'Need minimum of PHP 5.2.4 to use this software!' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
// Check for some required extensions
$required = array('curl', 'date', 'hash', 'mysqli', 'SimpleXML', 'SPL', 'xmlreader');
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
// Check the custom settings file if it can be found else check the default.
if (!empty($options['config'])) {
  $iniVars = getSettingsFromIniFile($options['config']);
} else {
  $iniVars = getSettingsFromIniFile();
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
  }; // if isset ...
};// foreach $required ...
if (!empty($mess)) {
  fwrite(STDERR, $mess);
  exit(2);
};
// Check if log directory is writable.
if (!is_writable(YAPEAL_LOG)) {
  $mess = YAPEAL_LOG . ' is not writeable.' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
// Check for required Logging section settings.
$required = array('error_log', 'log_level', 'notice_log', 'strict_log',
  'warning_log');
$mess = '';
foreach ($required as $setting) {
  if (!isset($iniVars['Logging'][$setting])) {
    $mess .= 'Missing required setting ' . $setting;
    $mess .= ' in section [Logging].' . PHP_EOL;
  };// if isset $iniVars...
};// foreach $required ...
if (!empty($mess)) {
  fwrite(STDERR, $mess);
  exit(2);
};
// Check if cache directory is writable.
if (!is_writable(YAPEAL_CACHE)) {
  $mess = YAPEAL_CACHE . ' is not writeable.' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
// Check for required Cache section setting.
if (!isset($iniVars['Cache']['cache_output'])) {
  $mess = 'Missing required setting "cache_output"';
  $mess .= ' in section [Cache].' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
// Check if required cache directories exist and are writeable.
if ($iniVars['Cache']['cache_output'] == 'file' ||
  $iniVars['Cache']['cache_output'] == 'both') {
  $required = array('account', 'ADOdb', 'char', 'corp', 'eve', 'map', 'server');
  foreach ($required as $section) {
    if (!is_dir(YAPEAL_CACHE . $section)) {
      $mess = 'Missing required directory ' . YAPEAL_CACHE . $section . PHP_EOL;
      fwrite(STDERR, $mess);
      exit(2);
    };
    if (!is_writable(YAPEAL_CACHE . $section)) {
      $mess = YAPEAL_CACHE . $section . ' is not writeable.' . PHP_EOL;
      fwrite(STDERR, $mess);
      exit(2);
    };
  };// foreach $required ...
};// if $iniVars['Cache']['cache_output'] == 'file' || ...
// Check for required Database section settings.
$required = array('database', 'driver', 'host', 'suffix', 'table_prefix',
  'username', 'password');
$mess = '';
foreach ($required as $setting) {
  if (!isset($iniVars['Database'][$setting])) {
    $mess .= 'Missing required setting ' . $setting;
    $mess .= ' in section [Database].' . PHP_EOL;
  };
};// foreach $required ...
if (!empty($mess)) {
  fwrite(STDERR, $mess);
  exit(2);
};
// Check for the required non-section general settings.
if (!isset($iniVars['application_agent'])) {
  $mess = 'Configuration file is outdated and "application_agent" is not set.' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};// if isset $iniVars['application_agent'] ...
if (!isset($iniVars['registered_mode'])) {
  $mess = 'Configuration file is outdated and "registered_mode" is not set.' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
$required = array('ignored','optional','required');
if (!in_array($iniVars['registered_mode'], $required)) {
  $mess = 'Unknown value ' . $iniVars['registered_mode'];
  $mess .=  ' for "registered_mode" in configuration file.' . PHP_EOL;
  fwrite(STDERR, $mess);
  exit(2);
};
$mess = 'All tests passed!!!' . PHP_EOL;
fwrite(STDOUT, $mess);
exit(0);
?>
