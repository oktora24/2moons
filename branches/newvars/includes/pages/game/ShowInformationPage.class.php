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


class ShowInformationPage extends AbstractPage
{
	public static $requireModule = MODULE_INFORMATION;
	
	protected $disableEcoSystem = true;

	function __construct() 
	{
		parent::__construct();
	}
		
	static function getNextJumpWaitTime($lastTime)
	{
		global $uniConfig;
		
		return $lastTime + $uniConfig['planetJumpWaitTime'] * 60;
	}

	public function sendFleet()
	{
		global $PLANET, $USER, $LNG;

		$NextJumpTime = self::getNextJumpWaitTime($PLANET['last_jump_time']);
		
		if (TIMESTAMP < $NextJumpTime) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_already_used'].' '.pretty_time($NextJumpTime - TIMESTAMP), 'error' => true));
		}
		
		$TargetPlanet = HTTP::_GP('jmpto', $PLANET['id']);
		$TargetGate   = $GLOBALS['DATABASE']->getFirstRow("SELECT id, last_jump_time FROM ".PLANETS." WHERE id = ".$TargetPlanet." AND id_owner = ".$USER['id']." AND sprungtor > 0;");

		if (!isset($TargetGate) || $TargetPlanet == $PLANET['id']) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_doesnt_have_one'], 'error' => true));
		}
		
		$NextJumpTime   = self::getNextJumpWaitTime($TargetGate['last_jump_time']);
				
		if (TIMESTAMP < $NextJumpTime) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_not_ready_target'].' '.pretty_time($NextJumpTime - TIMESTAMP), 'error' => true));
		}
		
		$ShipArray		= array();
		$SubQueryOri	= "";
		$SubQueryDes	= "";
		$Ships			= request_outofinf('ship', array());
		
		foreach($reslist['fleet'] as $Ship)
		{
			if(!isset($Ships[$Ship]) || $Ship == 212)
				continue;
				
			$ShipArray[$Ship]	= max(0, min($Ships[$Ship], $PLANET[$GLOBALS['VARS']['ELEMENT'][$Ship]['name']]));
					
			if(empty($ShipArray[$Ship]))
				continue;
				
			$SubQueryOri 		.= $GLOBALS['VARS']['ELEMENT'][$Ship]['name']." = ".$GLOBALS['VARS']['ELEMENT'][$Ship]['name']." - ".$ShipArray[$Ship].", ";
			$SubQueryDes 		.= $GLOBALS['VARS']['ELEMENT'][$Ship]['name']." = ".$GLOBALS['VARS']['ELEMENT'][$Ship]['name']." + ".$ShipArray[$Ship].", ";
			$PLANET[$GLOBALS['VARS']['ELEMENT'][$Ship]['name']] -= $ShipArray[$Ship];
		}

		if (empty($SubQueryOri)) {
			$this->sendJSON(array('message' => $LNG['in_jump_gate_error_data'], 'error' => true));
		}
		
		$JumpTime	= TIMESTAMP;

		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryOri;
		$SQL .= "last_jump_time = ".$JumpTime." ";
		$SQL .= "WHERE ";
		$SQL .= "id = ". $PLANET['id'].";";
		$SQL .= "UPDATE ".PLANETS." SET ";
		$SQL .= $SubQueryDes;
		$SQL .= "last_jump_time = ".$JumpTime." ";
		$SQL .= "WHERE ";
		$SQL .= "id = ".$TargetPlanet.";";
		$GLOBALS['DATABASE']->multi_query($SQL);

		$PLANET['last_jump_time'] 	= $JumpTime;
		$NextJumpTime	= self::getNextJumpWaitTime($PLANET['last_jump_time']);
		$this->sendJSON(array('message' => sprintf($LNG['in_jump_gate_done'], pretty_time($NextJumpTime - TIMESTAMP)), 'error' => false));
	}

	private function getAvalibleFleets()
	{
		global $PLANET;

        $fleetList  = array();

		foreach($reslist['fleet'] as $elementID)
		{
			if ($PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] <= 0 || FleetUtil::GetFleetMaxSpeed($elementID, $USER) == 0)
			{
				continue;
			}
			
			$fleetList[$elementID]	= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		}
				
		return $fleetList;
	}

	public function destroyMissiles()
	{
		global$PLANET;
		
		$Missle												= HTTP::_GP('missile', array());
		$PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']]	-= max(0, min($Missle[502], $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']]));
		$PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']]	-= max(0, min($Missle[503], $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']]));
		
		$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$GLOBALS['VARS']['ELEMENT'][502]['name']." = ".$PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']].", ".$GLOBALS['VARS']['ELEMENT'][503]['name']." = ".$PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']]." WHERE id = ".$PLANET['id'].";");
		
		$this->sendJSON(array($PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']], $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']]));
	}

	private function getTargetGates()
	{
		global $USER, $PLANET;
								
		$Order = $USER['planet_sort_order'] == 1 ? "DESC" : "ASC" ;
		$Sort  = $USER['planet_sort'];

        switch($Sort) {
            case 1:
                $OrderBy	= "galaxy, system, planet, planet_type ". $Order;
                break;
            case 2:
                $OrderBy	= "name ". $Order;
                break;
            default:
                $OrderBy	= "id ". $Order;
                break;
        }
				
				
        $moonResult	= $GLOBALS['DATABASE']->query("SELECT id, name, galaxy, system, planet, last_jump_time, ".$GLOBALS['VARS']['ELEMENT'][43]['name']." FROM ".PLANETS." WHERE id != ".$PLANET['id']." AND id_owner = ". $USER['id'] ." AND planet_type = '3' AND ".$GLOBALS['VARS']['ELEMENT'][43]['name']." > 0 ORDER BY ".$OrderBy.";");
        $moonList	= array();

        while($moonRow = $GLOBALS['DATABASE']->fetchArray($moonResult)) {
			$NextJumpTime				= self::getNextJumpWaitTime($moonRow['last_jump_time']);
			$moonList[$moonRow['id']]	= '['.$moonRow['galaxy'].':'.$moonRow['system'].':'.$moonRow['planet'].'] '.$moonRow['name'].(TIMESTAMP < $NextJumpTime ? ' ('.pretty_time($NextJumpTime - TIMESTAMP).')':'');
		}
		
		$GLOBALS['DATABASE']->free_result($moonResult);

		return $moonList;
	}

	public function show()
	{
		global $USER, $PLANET, $LNG, $uniConfig;

		$elementID 	= HTTP::_GP('id', 0);
		
		$this->setWindow('popup');
		$this->initTemplate();
		
		$productionTable	= array();
		$FleetInfo			= array();
		$MissileList		= array();

		$CurrentLevel		= 0;
		
		$ressIDs			= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_ENERGY]);
		
		if(elementHasFlag($elementID, ELEMENT_PRODUCTION) && elementHasFlag($elementID, ELEMENT_BUILD))
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $PLANET['temp_max'];
			$CurrentLevel		= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
			$BuildEnergy		= $USER[$GLOBALS['VARS']['ELEMENT'][113]['name']];
			$BuildLevel     	= max($CurrentLevel, 0);
			$BuildStartLvl   	= max($CurrentLevel - 2, 0);
						
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				foreach($ressIDs as $ID) 
				{
					if(!isset($GLOBALS['VARS']['ELEMENT'][$elementID]['production'][$ID]))
						continue;
						
					$Production	= eval(ResourceUpdate::getProd($GLOBALS['VARS']['ELEMENT'][$elementID]['production'][$ID]));
					
					if($ID != 911) {
						$Production	*= $uniConfig['ecoSpeed'];
					}
					
					$productionTable['production'][$BuildLevel][$ID]	= $Production;
				}
			}
			
			if(!empty($productionTable['production']))
			{
				$productionTable['usedResource']	= array_keys($productionTable['production'][$BuildStartLvl]);
			}
		}
		elseif(elementHasFlag($elementID, ELEMENT_STORAGE))
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $PLANET['temp_max'];
			$CurrentLevel		= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
			$BuildEnergy		= $USER[$GLOBALS['VARS']['ELEMENT'][113]['name']];
			$BuildLevel     	= max($CurrentLevel, 0);
			$BuildStartLvl   	= max($CurrentLevel - 2, 0);
						
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++)
			{
				foreach($ressIDs as $ID) 
				{
					if(!isset($GLOBALS['VARS']['ELEMENT'][$elementID]['storage'][$ID]))
						continue;
						
					$productionTable['storage'][$BuildLevel][$ID]	= round(eval(ResourceUpdate::getProd($GLOBALS['VARS']['ELEMENT'][$elementID]['storage'][$ID]))) * $uniConfig['storageFactor'];
				}
			}
			
			if(!empty($productionTable['storage']))
			{
				$productionTable['usedResource']	= array_keys($productionTable['storage'][$BuildStartLvl]);
			}
		}
		elseif(elementHasFlag($elementID, ELEMENT_FLEET))
		{
			$FleetInfo	= array(
				'attack'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['attack'],
				'shield'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['shield'],
				'structure'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['structure'],
				'capacity'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['capacity'],
				'speed1'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['speed'],
				'speed2'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['speed2'],
				'consumption1'	=> $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['consumption'],
				'consumption2'	=> $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['consumption2'],
				'rapidfire'		=> array(
					'from'	=> array(),
					'to'	=> array(),
				),
			);
				
			$fleetIDs	= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_FLEET], $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE]);
			
			foreach($fleetIDs as $fleetID)
			{
				if (!empty($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['rapidfire'][$fleetID]))
				{
					$FleetInfo['rapidfire']['to'][$fleetID] = $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['rapidfire'][$fleetID];
				}
				
				if (!empty($GLOBALS['VARS']['ELEMENT'][$fleetID]['combat']['rapidfire'][$elementID]))
				{
					$FleetInfo['rapidfire']['from'][$fleetID] = $GLOBALS['VARS']['ELEMENT'][$fleetID]['combat']['rapidfire'][$elementID];
				}
			}
		}
		elseif (elementHasFlag($elementID, ELEMENT_DEFENSIVE))
		{
			$FleetInfo	= array(
				'structure'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['structure'],
				'attack'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['attack'],
				'shield'		=> $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['shield'],
				'rapidfire'		=> array(
					'from'	=> array(),
					'to'	=> array(),
				),
			);
				
			$fleetIDs	= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_FLEET], $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE]);
			
			foreach($fleetIDs as $fleetID)
			{
				if (!empty($GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['rapidfire'][$fleetID]))
				{
					$FleetInfo['rapidfire']['to'][$fleetID] = $GLOBALS['VARS']['ELEMENT'][$elementID]['combat']['rapidfire'][$fleetID];
				}
				
				if (!empty($GLOBALS['VARS']['ELEMENT'][$fleetID]['combat']['rapidfire'][$elementID]))
				{
					$FleetInfo['rapidfire']['from'][$fleetID] = $GLOBALS['VARS']['ELEMENT'][$fleetID]['combat']['rapidfire'][$elementID];
				}
			}
		}
		elseif($elementID == 43 && $PLANET[$GLOBALS['VARS']['ELEMENT'][43]['name']] > 0)
		{
			$this->loadscript('gate.js');
			$nextTime	= self::getNextJumpWaitTime($PLANET['last_jump_time']);
			$this->assign(array(
				'nextTime'	=> DateUtil::formatDate($LNG['php_tdformat'], $nextTime, $USER['timezone']),
				'restTime'	=> max(0, $nextTime - TIMESTAMP),
				'startLink'	=> BuildPlanetAdressLink($PLANET),
				'gateList' 	=> $this->getTargetGates(),
				'fleetList'	=> $this->getAvalibleFleets(),
			));
		}
		elseif($elementID == 44 && $PLANET[$GLOBALS['VARS']['ELEMENT'][44]['name']] > 0)
		{								
			$MissileList	= array(
				502	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']],
				503	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']]
			);
		}

		$this->assign(array(		
			'elementID'			=> $elementID,
			'productionTable'	=> $productionTable,
			'CurrentLevel'		=> $CurrentLevel,
			'MissileList'		=> $MissileList,
			'Bonus'				=> BuildFunctions::getAvalibleBonus($elementID),
			'FleetInfo'			=> $FleetInfo,
		));
		
		$this->render('page.infomation.default.tpl');
	}
}