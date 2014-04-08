<?php
/**
 * Contains NetworkInterface
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
 * @since      0.1.0-alpha Initial alpha release done to get feedback.
 */
/**
 * Default namespace for network related stuff.
 */
namespace Yapeal\Network;

/**
 * Contains src's main network interface.
 */
interface NetworkInterface
{
    const DEFAULT_SERVER_BASE_URL = 'https://api.eveonline.com';
    const DEFAULT_SERVER_URI_TEMPLATE = '/{section}/{api}.xml.aspx';
    const SINGULARITY_SERVER_BASE_URL = 'https://api.testeveonline.com';
    const TRANQUILITY_SERVER_BASE_URL = 'https://api.eveonline.com';
}