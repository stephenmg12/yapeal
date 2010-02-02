<?php
/**
 * Contains abstract class for account section.
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
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with Yapeal. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2008-2009, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @package    Yapeal
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eve-online.com/
 */
/**
 * @internal Allow viewing of the source code in web browser.
 */
if (isset($_REQUEST['viewSource'])) {
  highlight_file(__FILE__);
  exit();
};
/**
 * @internal Only let this code be included or required not ran directly.
 */
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
  exit();
};
/**
 * Abstract class for Account APIs.
 *
 * @package Yapeal
 * @subpackage Api_account
 */
abstract class AAccount implements IFetchApiTable, IStoreApiTable {
  /**
   * @var string Apikey for this user.
   */
  protected $apiKey;
  /**
   * @var string Holds proxy info.
   */
  protected $proxy;
  /**
   * @var string Name of Eve server.
   */
  protected $serverName;
  /**
   * @var string DB table prefix.
   */
  protected $tablePrefix;
  /**
   * @var int userID for this user.
   */
  protected $userID;
  /**
   * Constructor
   *
   * @param string $proxy Allows overriding API server for example to use a
   * different proxy on a per char/corp basis. It should contain a url format
   * string made to used in sprintf() to replace %1$s with $api and %2$s with
   * $section as needed to complete the url. For example:
   * 'http://api.eve-online.com/%2$s/%1$s.xml.aspx' for normal Eve API server.
   * @param array $params Holds the required parameters like userID, apiKey,
   * etc as needed.
   *
   * @return object Returns the instance of the class.
   *
   * @throws LengthException for any missing required $params.
   */
  public function __construct($proxy, array $params) {
    $this->tablePrefix = YAPEAL_TABLE_PREFIX . 'account';
    $this->proxy = $proxy;
    $required = array('apiKey' => 'C', 'serverName' => 'C', 'userID' => 'I');
    foreach ($required as $k => $v) {
      if (!isset($params[$k])) {
        $mess = 'Missing required parameter $params["' . $k . '"]';
        $mess .= ' to constructor for ' . $this->api;
        $mess .= ' in ' . basename(__FILE__);
        throw new LengthException($mess, 1);
      };// if !isset $params[$k] ...
      switch ($v) {
        case 'C':
        case 'X':
          if (!is_string($params[$k])) {
            $mess = '$params["' . $k . '"] must be a string for ' . $this->api;
            $mess .= ' in ' . basename(__FILE__);
            throw new LengthException($mess, 2);
          };// if !is_string $params[$k] ...
          break;
        case 'I':
          if (0 != strlen(str_replace(range(0,9),'',$params[$k]))) {
            $mess = '$params["' . $k . '"] must be an integer for ' . $this->api;
            $mess .= ' in ' . basename(__FILE__);
            throw new LengthException($mess, 3);
          };// if 0 == strlen(...
          break;
      };// switch $v ...
    };// foreach $required ...
    $this->apiKey = $params['apiKey'];
    $this->serverName = $params['serverName'];
    $this->userID = $params['userID'];
  }// function __construct
  /**
   * Used to get an item from Eve API.
   *
   * Parent item (object) should call all child(ren)'s apiFetch() as appropriate.
   *
   * @return boolean Returns TRUE if item received.
   */
  function apiFetch() {
    global $tracing;
    $postData = array('userID' => $this->userID, 'apiKey' => $this->apiKey);
    $tableName = $this->tablePrefix . $this->api;
    try {
      // Build base part of cache file name.
      $cacheName = $this->serverName . $tableName . $this->userID . '.xml';
      // Try to get XML from local cache first if we can.
      $mess = 'getCachedXml for ' . $cacheName;
      $mess .= ' in ' . basename(__FILE__);
      $tracing->activeTrace(YAPEAL_TRACE_ACCOUNT, 2) &&
      $tracing->logTrace(YAPEAL_TRACE_ACCOUNT, $mess);
      $xml = YapealApiRequests::getCachedXml($cacheName, YAPEAL_API_ACCOUNT);
      if (empty($xml)) {
        $mess = 'getAPIinfo for ' . $this->api;
        $mess .= ' in ' . basename(__FILE__);
        $tracing->activeTrace(YAPEAL_TRACE_ACCOUNT, 2) &&
        $tracing->logTrace(YAPEAL_TRACE_ACCOUNT, $mess);
        $xml = YapealApiRequests::getAPIinfo($this->api, YAPEAL_API_ACCOUNT,
          $postData, $this->proxy);
        if ($xml instanceof SimpleXMLElement) {
          // Store XML in local cache.
          YapealApiRequests::cacheXml($xml->asXML(), $cacheName, YAPEAL_API_ACCOUNT);
        };// if $xml ...
      };// if empty $xml ...
      if (!empty($xml)) {
        $this->xml = $xml;
        return TRUE;
      } else {
        $mess = 'No XML found for ' . $tableName;
        trigger_error($mess, E_USER_NOTICE);
        return FALSE;
      };
    }
    catch (YapealApiErrorException $e) {
      // Any API errors that need to be handled in some way are handled in this
      // function.
      $this->handleApiError($e);
      return FALSE;
    }
    catch (YapealApiFileException $e) {
      return FALSE;
    }
    catch (ADODB_Exception $e) {
      return FALSE;
    }
  }// function apiFetch
  /**
   * Handles some Eve API error codes in special ways.
   *
   * @param object $e Eve API exception returned.
   *
   * @return bool Returns TRUE if handled the error else FALSE.
   */
  protected function handleApiError($e) {
    global $tracing;
    try {
      switch ($e->getCode()) {
        case 105:// Invalid characterID.
        case 201:// Character does not belong to account.
        case 202:// API key authentication failure.
        case 203:// Authentication failure.
        case 204:// Authentication failure.
        case 205:// Authentication failure (final pass).
        case 210:// Authentication failure.
        case 212:// Authentication failure (final pass).
          $mess = 'Deactivating characterID: ' . $this->characterID;
          $mess .= ' as their Eve API information is incorrect';
          trigger_error($mess, E_USER_WARNING);
          $con = YapealDBConnection::connect(YAPEAL_DSN);
          $sql = 'update `' . YAPEAL_TABLE_PREFIX . 'utilRegisteredCharacter`';
          $sql .= ' set `isActive`=0';
          $sql .= ' where `characterID`=' . $this->characterID;
          $mess = 'Before update utilRegisteredCharacter in ' . basename(__FILE__);
          $tracing->activeTrace(YAPEAL_TRACE_DATABASE, 2) &&
          $tracing->logTrace(YAPEAL_TRACE_DATABASE, $mess);
          $con->Execute($sql);
          break;
        case 200:// Current security level not high enough. (Wrong API key)
          $mess = 'Deactivating Eve API: ' . $this->api;
          $mess .= ' for ' . $this->characterID;
          $mess .= ' as did not give the required full API key';
          trigger_error($mess, E_USER_WARNING);
          $con = YapealDBConnection::connect(YAPEAL_DSN);
          $sql = 'select `activeAPI`';
          $sql .= ' from `' . YAPEAL_TABLE_PREFIX . 'utilRegisteredCharacter`';
          $sql .= ' where `characterID`=' . $this->characterID;
          $mess = 'Before select activeAPI in ' . basename(__FILE__);
          $tracing->activeTrace(YAPEAL_TRACE_DATABASE, 2) &&
          $tracing->logTrace(YAPEAL_TRACE_DATABASE, $mess);
          $result = $con->GetOne($sql);
          // Split the string on spaces and put into the keys.
          $apis = array_flip(explode(' ', $result));
          unset($apis[$this->api]);
          $sql = 'update `' . YAPEAL_TABLE_PREFIX . 'utilRegisteredCharacter`';
          $sql .= ' set `activeAPI`=' . $con->qstr(implode(' ', array_flip($apis)));
          $sql .= ' where `characterID`=' . $this->characterID;
          $mess = 'Before update utilRegisteredCharacter in ' . basename(__FILE__);
          $tracing->activeTrace(YAPEAL_TRACE_DATABASE, 2) &&
          $tracing->logTrace(YAPEAL_TRACE_DATABASE, $mess);
          $con->Execute($sql);
          break;
        case 211:// Login denied by account status.
          // The user's account isn't active deactivate it.
          $mess = 'Deactivating userID: ' . $this->userID;
          $mess .= ' as their Eve account is currently suspended';
          trigger_error($mess, E_USER_WARNING);
          $con = YapealDBConnection::connect(YAPEAL_DSN);
          $sql = 'update `' . YAPEAL_TABLE_PREFIX . 'utilRegisteredUser`';
          $sql .= ' set `isActive`=0';
          $sql .= ' where `userID`=' . $this->userID;
          $mess = 'Before update utilRegisteredUser in ' . basename(__FILE__);
          $tracing->activeTrace(YAPEAL_TRACE_DATABASE, 2) &&
          $tracing->logTrace(YAPEAL_TRACE_DATABASE, $mess);
          $con->Execute($sql);
          break;
        case 901:// Web site database temporarily disabled.
        case 902:// EVE backend database temporarily disabled.
          $cuntil = gmdate('Y-m-d H:i:s', strtotime('6 hours'));
          $data = array( 'tableName' => $this->tablePrefix . $this->api,
            'ownerID' => $this->userID, 'cachedUntil' => $cuntil
          );
          YapealDBConnection::upsert($data,
            YAPEAL_TABLE_PREFIX . 'utilCachedUntil', YAPEAL_DSN);
          break;
        default:
          return FALSE;
          break;
      };// switch $code ...
    }
    catch (ADODB_Exception $e) {
      return FALSE;
    }
    return TRUE;
  }// function handleApiError
}
?>
