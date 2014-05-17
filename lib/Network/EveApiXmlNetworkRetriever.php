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

use string;
use Yapeal\Xml\EveApiAwareInterface;
use Yapeal\Xml\EveApiRetrieverInterface;
use Guzzle\Http\Client;e
use Guzzle\Http\Exception\RequestException;
use Yapeal\Xml\EveApiXmlDataInterface;
use \Yapeal\Xml\EveApiXmlData;

/**
 * Class EveApiXmlNetworkRetriever
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
     * @var
     */
    protected $EveApiXmlData;
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     *
     */
    public function _construct( )
    {

    }
    /**
     * @param string $userAgent
     */
    public function setUserAgent(string $userAgent) {
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
        // TODO: Implement retrieveEveApi() method.
    }
    public function httpClient($plugin)
    {
        $this->client = new Client(['base_url' => $baseUrl]);
        if(isset($plugin))
            $this->client->addSubscriber($plugin);
        $this->client->setUserAgent($this->userAgent);
    }
    /**
     * @return mixed
     */
    private function connect()
    {
        $EveApiSectionName = $this->EveApiXmlData->getEveApiSectionName();
        $EveApiName = $this->EveApiXmlData->getEveApiName();
        $apiArguments = $this->EveApiXmlData->getApiArguments();

        $request = $this->client->post('/'.$EveApiSectionName.'/'.$EveApiName.'.xml', '', $apiArguments);
        return $response = $request->send();
    }
}
