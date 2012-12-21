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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowActivePage()
{
	global $LNG, $USER;
	$id = HTTP::_GP('id', 0);
	if($_GET['action'] == 'delete' && !empty($id))
		$GLOBALS['DATABASE']->query("DELETE FROM ".USERS_VALID." WHERE `id` = '".$id."' AND `universe` = '".$_SESSION['adminuni']."';");

	$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".USERS_VALID." WHERE `universe` = '".$_SESSION['adminuni']."' ORDER BY id ASC");

	$Users	= array();
	while ($User = $GLOBALS['DATABASE']->fetchArray($query)) {
		$Users[]	= array(
			'id'		=> $User['id'],
			'name'		=> $User['username'],
			'date'		=> DateUtil::formatDate($LNG['php_tdformat'], $User['date'], $USER['timezone']),
			'email'		=> $User['email'],
			'ip'		=> $User['ip'],
			'password'	=> $User['password'],
			'cle'		=> $User['cle'],
		);
	}

	$template	= new Template();

	$template->assign(array(	
		'Users'				=> $Users,
		'uni'				=> $_SESSION['adminuni'],
	));
	
	$template->show('ActivePage.tpl');
}