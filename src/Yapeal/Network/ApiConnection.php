<?php
/**
 * Contains ApiConnection class
 *
 * PHP version 5.3
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know as Yapeal which will be used to refer to it
 * in the rest of this license.
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2013, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
namespace Yapeal\Network;

use Guzzle\Http\Client;
use Guzzle\Http\Curl\CurlVersion;
use Yapeal\Yapeal;

/**
 * Main network connection class use to connect to the Eve API servers.
 */
class ApiConnection extends Client implements NetworkInterface
{
    public function __construct(
        $baseUrl = NetworkInterface::DEFAULT_SERVER_BASE_URL,
        $config = null
    ) {
        parent::__construct($baseUrl, $config);
    }
    /**
     * Get the default User-Agent string to use with Guzzle
     *
     * @return string
     */
    public function getDefaultUserAgent()
    {
        return
            'src/'
            . Yapeal::getVersion()
            . ' curl/'
            . CurlVersion::getInstance()
                         ->get('version')
            . ' PHP/'
            . PHP_VERSION;
    }
    public function post(
        $uri = NetworkInterface::DEFAULT_SERVER_URI_TEMPLATE,
        $headers = null,
        $postBody = null,
        array $options = array()
    ) {
        return $this->createRequest(
            'POST',
            $uri,
            $headers,
            $postBody,
            $options
        );
    }
}
