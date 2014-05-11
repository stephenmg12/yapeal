#!/usr/bin/env php
<?php
/**
 * Contains code used to test if user has privileges on a MySQL database.
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
 */
// IDE only seems to like this form for path since need for this loader is going
// away ASAP not worrying about it.
use Yapeal\Command\LegacyUtil;

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
$shortOpts = array('c:', 'd:', 'p:', 's:', 'u:');
$longOpts = array(
    'config:',
    'database:',
    'password:',
    'privileges:',
    'server:',
    'username:'
);
$options = $legacyUtil->parseCommandLineOptions($shortOpts, $longOpts);
$exit = false;
if (isset($options['help'])) {
    $legacyUtil->usage(__FILE__, $shortOpts, $longOpts);
    exit(0);
};
if (isset($options['version'])) {
    $legacyUtil->showVersion(__FILE__);
    exit(0);
};
if (!empty($options['config'])) {
    $section =
        $legacyUtil->getSettingsFromIniFile($options['config'], 'Database');
    unset($options['config']);
} else {
    $section = $legacyUtil->getSettingsFromIniFile(null, 'Database');
};
// Merge the configuration file settings with ones from command line.
// Settings from command line will override any from file.
$options = array_merge($section, $options);
$required = array('database', 'host', 'password', 'username');
$mess = '';
foreach ($required as $setting) {
    if (empty($options[$setting])) {
        $mess .= 'Missing required setting ' . $setting;
        $mess .= ' in section [Database].' . PHP_EOL;
    };
}
if (!empty($mess)) {
    fwrite(STDERR, $mess);
    exit(2);
};
$mysqli =
    @new mysqli($options['host'], $options['username'], $options['password']);
if ($mysqli->connect_error || mysqli_connect_error()) {
    $mess = 'Connection error (' . mysqli_connect_errno() . ') ' .
        mysqli_connect_error() . PHP_EOL;
    fwrite(STDERR, $mess);
    exit(2);
};
if (empty($options['privileges'])) {
    $privs = array(
        'alter',
        'create',
        'delete',
        'drop',
        'index',
        'insert',
        'select',
        'update'
    );
} else {
    $privs = explode(' ', $options['privileges']);
};
$split = array();
// May need to do a little escaping on database name.
$database = str_replace('_', '\\_', $options['database']);
$sql = 'show grants';
$result = $mysqli->query($sql);
if ($result) {
    while ($row = $result->fetch_row()) {
        $dbPos = strpos($row[0], '`' . $database . '`');
        // If not the right table continue.
        if (false !== $dbPos) {
            // Trim grant off the front.
            $split = str_replace('GRANT ', '', $row[0]);
            // Find the end part and strip it off.
            $end = substr($split, strpos($split, ' ON '));
            $split = str_replace($end, '', $split);
            // Delete the spaces.
            $split = str_replace(' ', '', $split);
            // If $split isn't empty there are privs.
            if (!empty($split)) {
                $split = explode(',', strtolower($split));
            }
        } else {
            continue;
        }
    }
    $result->free();
    $mysqli->close();
    $missing = array_diff($privs, $split);
    if (count($missing) > 0
        && false === array_search('allprivileges', $split)
    ) {
        $mess = $options['username'] . ' lacks the needed privileges: ';
        $mess .= implode(', ', $missing) . ' on the ' . $options['database'];
        $mess .= ' database.' . PHP_EOL;
        fwrite(STDERR, $mess);
        exit(2);
    };
};
$mess = $options['username'] . ' has the needed privileges on the ';
$mess .= $options['database'] . ' database.' . PHP_EOL;
fwrite(STDOUT, $mess);
exit(0);
