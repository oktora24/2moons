<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


class ShowRecordsPage extends AbstractPage
{
    public static $requireModule = MODULE_RECORDS;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $USER, $PLANET, $LNG, $CONF, $UNI;

		$recordResult	= $GLOBALS['DATABASE']->query("SELECT elementID, level, userID, username FROM ".USERS." INNER JOIN ".RECORDS." ON userID = id WHERE universe = ".$UNI.";");
		
		$defenseList	= array_fill_keys($GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE], array());
		$fleetList		= array_fill_keys($GLOBALS['VARS']['LIST'][ELEMENT_FLEET], array());
		$researchList	= array_fill_keys($GLOBALS['VARS']['LIST'][ELEMENT_TECH], array());
		$buildList		= array_fill_keys($GLOBALS['VARS']['LIST'][ELEMENT_BUILD], array());
		
		while($recordRow = $GLOBALS['DATABASE']->fetchArray($recordResult)) {
			if (in_array($recordRow['elementID'], $reslist['defense'])) {
				$defenseList[$recordRow['elementID']][]		= $recordRow;
			} elseif (in_array($recordRow['elementID'], $reslist['fleet'])) {
				$fleetList[$recordRow['elementID']][]		= $recordRow;
			} elseif (in_array($recordRow['elementID'], $reslist['tech'])) {
				$researchList[$recordRow['elementID']][]	= $recordRow;
			} elseif (in_array($recordRow['elementID'], $reslist['build'])) {
				$buildList[$recordRow['elementID']][]		= $recordRow;
			}
		}
		
		$this->assign(array(	
			'defenseList'	=> $defenseList,
			'fleetList'		=> $fleetList,
			'researchList'	=> $researchList,
			'buildList'		=> $buildList,
			'update'		=> DateUtil::formatDate($LNG['php_tdformat'], $CONF['stat_last_update'], $USER['timezone']),
		));
		
		$this->render('page.records.default.tpl');
	}
}