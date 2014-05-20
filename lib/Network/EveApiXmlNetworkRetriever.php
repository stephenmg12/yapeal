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
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message;
use Guzzle\Http\Message\Response;
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
     * @var
     */
    protected $urlTemplate;
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var array
     */
    private $headers = array(
        'Accept' => 'text/xml,application/xml,application/xhtml+xml;q=0.9,text/html;q=0.8,text/plain;q=0.7,image/png;q=0.6,*/*;q=0.5',
        'Accept-Charset' => 'utf-8;q=0.9,windows-1251;q=0.7,*;q=0.6',
        'Accept-Encoding' => 'gzip',
        'Accept-Language' => 'en-us;q=0.9,en;q=0.8,*;q=0.7',
        'Connection' => 'Keep-Alive',
        'Keep-Alive' => '300'
    );
    /**
     * @var array
     */
    private $options;
    public function __construct()
    {
        //TODO: Implement construct()
    }
    /**
     * @param array $value
     *
     * @return self
     */
    public function setOptions($value)
    {
        $this->options = $value;
        return $this;
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
            $this->getClient();
        }
        /** @var $response response */
        $response = $this->sendRequest(
                         $this->getPost(
                              $this->EveApiXmlData->getEveApiSectionName(),
                                  $this->EveApiXmlData->getEveApiName(),
                                  $this->EveApiXmlData->getEveApiArguments()
                         )
        );
        if ($response->getStatusCode() == '200') {
            $this->EveApiXmlData->setEveApiXml($response->getBody(true));
        }
    }
    /**
     * @return Client|ClientInterface
     */
    protected function getClient()
    {
        /** Check if we already have a client set, else we set one */
        if (isset($this->client)) {
            return $this->client;
        } else {
            $this->client = new Client();
        }
        /** Set user agent on client */
        $this->client->setUserAgent($this->userAgent);
        return $this->client;
    }
    /**
     * @param $request
     *
     * @return response
     */
    private function sendRequest(request $request)
    {
        return $response = $request->send();
    }
    /**
     * @param string $EveApiSectionName
     * @param string $EveApiName
     * @param array  $EveApiArguments
     *
     * @return request
     */
    private function getPost(
        $EveApiSectionName,
        $EveApiName,
        $EveApiArguments = array()
    ) {
        $request = $this->client->post(
                                array(
                                    $this->urlTemplate,
                                    array(
                                        'baseUrl' => $this->baseUrl,
                                        'EveApiSectionName' => $EveApiSectionName,
                                        'EveApiName' => $EveApiName
                                    )
                                ),
                                    $this->headers,
                                    $EveApiArguments,
                                    $this->getOptions()
        );
        return $request;
    }
    /**
     * @return mixed
     */
    public function getOptions()
    {
        if (isset($this->options)) {
            return $this->options;
        } else {
            return $options = array(
                'timeout' => 10,
                'connect_timeout' => 30,
                'verify' =>
                    dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config'
                    . DIRECTORY_SEPARATOR . 'eveonline.crt',
            );
        }
    }
    /**
     * @param string $value
     *
     * @return self
     */
    public function setBaseUrl($value)
    {
        $this->baseUrl = $value;
        return $this;
    }
    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /**
     * @param $plugin
     */
    public function addSubscriber($plugin = null)
    {
        if (isset($plugin)) {
            $this->client->addSubscriber($plugin);
        }
    }
    /**
     * @param Client|ClientInterface $client
     *
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
        return $this;
    }
    /**
     * @param string $urlTemplate
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setUrlTemplate(
        $urlTemplate = 'https://{baseUrl}/{EveApiSectionName}/{EveApiName}.xml.aspx'
    ) {
        if (is_string($urlTemplate)) {
            $this->urlTemplate = $urlTemplate;
            return $this;
        } else {
            throw new \InvalidArgumentException;
        }
    }
}
