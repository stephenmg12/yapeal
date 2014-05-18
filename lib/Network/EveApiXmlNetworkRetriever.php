<?php
/**
 * Contains EveApiXmlNetworkRetriever class.
 *
 * PHP version 5.3
 *
 * LICENSE:
 * This file is part of yapeal
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
namespace Yapeal\Network;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Yapeal\Xml\EveApiRetrieverInterface;
use Yapeal\Xml\EveApiXmlDataInterface;

/**
 * Class EveApiXmlNetworkRetriever
 *
 * @author Stephen Gulick <stephenmg12@gmail.com>
 */
class EveApiXmlNetworkRetriever implements EveApiRetrieverInterface
{
    /**
     * @var string
     */
    protected $baseUrl = 'https://api.eveonline.com/';
    /**
     * @var string
     */
    protected $userAgent = 'Yapeal/1.2 (+https://github.com/Dragonrun1/yapeal/wiki)';
    /**
     * @var EveApiXmlDataInterface
     */
    protected $EveApiXmlData;
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     *
     */
    public function _construct()
    {
    }
    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }
    /**
     * @param EveApiXmlDataInterface $data
     *
     * @return EveApiXmlDataInterface
     */
    public function retrieveEveApi(EveApiXmlDataInterface $data)
    {
        $this->EveApiXmlData = $data;
        if (empty($this->client)) {
            $this->httpClient();
        }
        $this->connect();
        // TODO: Implement retrieveEveApi() method.
    }
    /**
     * @param $plugin
     */
    public function httpClient($plugin = null)
    {
        $this->client = new Client(array('base_url' => $this->baseUrl));
        if (isset($plugin)) {
            $this->client->addSubscriber($plugin);
        }
        $this->client->setUserAgent($this->userAgent);
    }
    /**
     * @return mixed
     */
    private function connect()
    {
        $EveApiSectionName = $this->EveApiXmlData->getEveApiSectionName();
        $EveApiName = $this->EveApiXmlData->getEveApiName();
        $apiArguments = $this->EveApiXmlData->getEveApiArguments();
        $request = $this->client->post('/' . $EveApiSectionName . '/' . $EveApiName. '.xml','', $apiArguments);
        return $response = $request->send();
    }
}
