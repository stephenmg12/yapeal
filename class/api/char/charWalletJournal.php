<?php
/**
 * Contains WalletJournal class.
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
 * @internal Only let this code be included or required not ran directly.
 */
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
  exit();
};
/**
 * Class used to fetch and store char WalletJournal API.
 *
 * @package Yapeal
 * @subpackage Api_char
 */
class charWalletJournal extends AChar {
  /**
   * @var string Holds the refID from each row in turn to use when walking.
   */
  protected $beforeID;
  /**
   * @var string Holds the date from each row in turn to use when walking.
   */
  protected $date;
  /**
   * @var integer Hold row count used in walking.
   */
  private $rowCount;
  /**
   * Constructor
   *
   * @param array $params Holds the required parameters like userID, apiKey, etc
   * used in HTML POST parameters to API servers which varies depending on API
   * 'section' being requested.
   *
   * @throws LengthException for any missing required $params.
   */
  public function __construct(array $params) {
    // Cut off 'A' and lower case abstract class name to make section name.
    $this->section = strtolower(substr(get_parent_class($this), 1));
    $this->api = str_replace($this->section, '', __CLASS__);
    parent::__construct($params);
  }// function __construct
  /**
   * Used to store XML to MySQL table(s).
   *
   * @return Bool Return TRUE if store was successful.
   */
  public function apiStore() {
    /* This counter is used to insure do ... while can't become infinite loop.
     * Using 1000 means at most last 255794 rows can be retrieved. That works
     * out to over 355 entries per hour over the maximum 30 days allowed by
     * the API servers. If you have a corp or char with more than that please
     * contact me for addition help with Yapeal.
     */
    $counter = 1000;
    $this->date = gmdate('Y-m-d H:i:s', strtotime('1 hour'));
    $this->beforeID = 0;
    // Only try to get a few rows the first time.
    $rowCount = 16;
    // SQL use to find actual number of records for this owner and account.
    $sql = 'select count(1)';
    $sql .= ' from ' . YAPEAL_TABLE_PREFIX . $this->section . $this->api;
    $sql .= ' where `ownerID`=' . $this->ownerID;
    try {
        // Need database connection to do some counting.
        $dbCon = YapealDBConnection::connect(YAPEAL_DSN);
      do {
        // Give each API 60 seconds to finish. This should never happen but is
        // here to catch runaways.
        set_time_limit(60);
        /* Not going to assume here that API servers figure oldest allowed
         * entry based on a saved time from first pull but instead use current
         * time. The few seconds of difference shouldn't cause any missed data
         * and is safer than assuming.
         */
        $oldest = gmdate('Y-m-d H:i:s', strtotime('30 days ago'));
        // Need to add extra stuff to normal parameters to make walking work.
        $apiParams = $this->params;
        // Added the accountKey to params.
        $apiParams['accountKey'] = 1000;
        // This tells API server where to start from when walking.
        $apiParams['fromID'] = $this->beforeID;
        // This tells API server how many rows we want.
        $apiParams['rowCount'] = $rowCount;
        // First get a new cache instance.
        $cache = new YapealApiCache($this->api, $this->section, $this->ownerID, $apiParams);
        // See if there is a valid cached copy of the API XML.
        $result = $cache->getCachedApi();
        // If it's not cached need to try to get it.
        if (FALSE === $result) {
          $proxy = $this->getProxy();
          $con = new YapealNetworkConnection();
          $result = $con->retrieveXml($proxy, $apiParams);
          // FALSE means there was an error and it has already been report so just
          // return to caller.
          if (FALSE === $result) {
            return FALSE;
          };
          // Cache the received XML.
          $cache->cacheXml($result);
          // Check if XML is valid.
          if (FALSE === $cache->isValid()) {
            // No use going any farther if the XML isn't valid.
            return FALSE;
          };
        };// if FALSE === $result ...
        // Create XMLReader.
        $this->xr = new XMLReader();
        // Pass XML to reader.
        $this->xr->XML($result);
        // Calculate how many records there should be if have no dups in XML.
        $expectedCount = $dbCon->GetOne($sql) + $rowCount;
        // Outer structure of XML is processed here.
        while ($this->xr->read()) {
          if ($this->xr->nodeType == XMLReader::ELEMENT &&
            $this->xr->localName == 'result') {
            $result = $this->parserAPI();
          };// if $this->xr->nodeType ...
        };// while $this->xr->read() ...
        $this->xr->close();
        $actual = $dbCon->GetOne($sql) + 0;
        /* There are three normal conditions to end walking. They are:
         * Got less rows than expected because there are no more to get.
         * The oldest row we got is oldest API allows us to get.
         * Some of the rows are duplicates of existing records and there is no
         * reason to waste any time walking back to get more.
         */
        if ($this->rowCount != $rowCount || $this->date < $oldest
          || $actual < $expectedCount) {
          // Have to break while.
          break;
        };
        /* Get less rows at first but keep getting more until we hit maximum.
         * Wastes some time when doing initial walk for new owners but works
         * well after that.
         */
        if ($rowCount < 129) {
          $rowCount *= 2;
        } else {
          $rowCount = 256;
        };
      } while ($counter--);
    }
    catch (YapealApiErrorException $e) {
      // Any API errors that need to be handled in some way are handled in this
      // function.
      $this->handleApiError($e);
      return FALSE;
    }
    catch (ADODB_Exception $e) {
      return FALSE;
    }
    return $result;
  }// function apiStore
  /**
   * Parsers the XML from API.
   *
   * Most common API style is a simple <rowset>. Journals are a little more
   * complex because of need to do walking back for older records.
   *
   * @return bool Returns TRUE if XML was parsered correctly, FALSE if not.
   */
  protected function parserAPI() {
    $tableName = YAPEAL_TABLE_PREFIX . $this->section . $this->api;
    // Get a new query instance.
    $qb = new YapealQueryBuilder($tableName, YAPEAL_DSN);
    // Set any column defaults needed.
    $defaults = array('accountKey' => 1000, 'ownerID' => $this->ownerID);
    $qb->setDefaults($defaults);
    try {
      while ($this->xr->read()) {
        switch ($this->xr->nodeType) {
          case XMLReader::ELEMENT:
            switch ($this->xr->localName) {
              case 'row':
                /* The following assumes the date attribute exists and is not
                 * empty and the same is true for refID. Since XML would be
                 * invalid if ether were true they should never return bad
                 * values.
                 */
                $date = $this->xr->getAttribute('date');
                // If this date is the oldest so far need to save date and refID
                // to use in walking.
                if ($date < $this->date) {
                  $this->date = $date;
                  $this->beforeID = $this->xr->getAttribute('refID');
                };// if $date ...
                // Walk through attributes and add them to row.
                while ($this->xr->moveToNextAttribute()) {
                  $row[$this->xr->name] = $this->xr->value;
                  switch ($this->xr->name) {
                    case 'taxReceiverID':
                    case 'taxAmount':
                      // Fix blank with zero for upsert.
                      if ($this->xr->value === '') {
                        $row[$this->xr->name] = 0;
                      };// if $this->xr->value ...
                      break;
                    default:// Nothing to do here.
                  };// switch $this->xr->name ...
                };// while $this->xr->moveToNextAttribute() ...
                $qb->addRow($row);
                break;
            };// switch $this->xr->localName ...
            break;
          case XMLReader::END_ELEMENT:
            if ($this->xr->localName == 'result') {
              // Save row count and store rows.
              if ($this->rowCount = count($qb) > 0) {
                $qb->store();
              };// if count $rows ...
              $qb = NULL;
              return TRUE;
            };// if $this->xr->localName == 'row' ...
            break;
        };// switch $this->xr->nodeType
      };// while $xr->read() ...
    }
    catch (ADODB_Exception $e) {
      return FALSE;
    }
    $mess = 'Function ' . __FUNCTION__ . ' did not exit correctly' . PHP_EOL;
    trigger_error($mess, E_USER_WARNING);
    return FALSE;
  }// function parserAPI
}
?>