<?php
/**
 * Contains corp ContainerLog class.
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
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
namespace Yapeal\Database\Corp;

use Yapeal\Database\AbstractCorp;
use Yapeal\Database\QueryBuilder;

/**
 * Class used to fetch and store corp ContainerLog API.
 */
class ContainerLog extends AbstractCorp
{
    /**
     * Constructor
     *
     * @param array $params Holds the required parameters like keyID, vCode, etc
     *                      used in HTML POST parameters to API servers which varies depending on API
     *                      'section' being requested.
     *
     * @throws \LengthException for any missing required $params.
     */
    public function __construct(array $params)
    {
        $this->section = strtolower(basename(__DIR__));
        $this->api = basename(__CLASS__);
        parent::__construct($params);
    }
    /**
     * Simple <rowset> per API parser for XML.
     *
     * Most common API style is a simple <rowset>. This implementation allows most
     * API classes to be empty except for a constructor which sets $this->api and
     * calls their parent constructor.
     *
     * @return bool Returns TRUE if XML was parsed correctly, FALSE if not.
     */
    protected function parserAPI()
    {
        $tableName = YAPEAL_TABLE_PREFIX . $this->section . $this->api;
        // Get a new query instance.
        $qb = new QueryBuilder($tableName, YAPEAL_DSN);
        // Set any column defaults needed.
        $qb->setDefault('ownerID', $this->ownerID);
        $row = array();
        try {
            while ($this->reader->read()) {
                switch ($this->reader->nodeType) {
                    case \XMLReader::ELEMENT:
                        switch ($this->reader->localName) {
                            case 'row':
                                // Walk through attributes and add them to row.
                                while ($this->reader->moveToNextAttribute()) {
                                    $row[$this->reader->name] =
                                        $this->reader->value;
                                    switch ($this->reader->name) {
                                        case 'newConfiguration':
                                        case 'oldConfiguration':
                                        case 'quantity':
                                        case 'typeID':
                                            // Fix empty values with zero.
                                            if ($this->reader->value == '') {
                                                $row[$this->reader->name] = 0;
                                            }
                                            break;
                                        default: // Nothing to do.
                                    }
                                }
                                $qb->addRow($row);
                                break;
                        }
                        break;
                    case \XMLReader::END_ELEMENT:
                        if ($this->reader->localName == 'result') {
                            // Insert any leftovers.
                            if (count($qb) > 0) {
                                $qb->store();
                            }
                            $qb = null;
                            return true;
                        }
                        break;
                }
            }
        } catch (\ADODB_Exception $e) {
            \Logger::getLogger('yapeal')
                   ->error($e);
            return false;
        }
        $mess =
            'Function ' . __FUNCTION__ . ' did not exit correctly' . PHP_EOL;
        \Logger::getLogger('yapeal')
               ->warn($mess);
        return false;
    }
}
