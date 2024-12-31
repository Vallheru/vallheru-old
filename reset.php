<?php
/***************************************************************************
 *                               reset.php
 *                            -------------------
 *   copyright            : (C) 2004 Unlimited Creators based on Gamers-Fusion ver 2.5
 *   email                : webmaster@uc.h4c.pl
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/ 

require_once("config.php");
if ($_GET['step'] == 'reset') {
	mysql_query("update players set age=age+1");
	mysql_query("update players set energy=energy+max_energy");
	mysql_query("update players set hp=max_hp");
	mysql_query("update outposts set turns=turns+5");
	mysql_query("update outposts set tokens=tokens+100");
	$plat_price = rand(100, 300);
	mysql_query("update market set platcost='$plat_price'");
	mysql_query("update kopalnie set ops=ops+5");
	mysql_query("update players set trains=trains+15 where corepass='Y'");
	mysql_query("update players set pm=inteli");
	mysql_query("update tribes set atak='N'");
	exit;
}
if ($_GET['step'] == 'revive') {
	mysql_query("update players set hp=max_hp");
	mysql_query("update players set energy=energy+max_energy");
	mysql_query("update outposts set turns=turns+5");
	mysql_query("update outposts set tokens=tokens+100");
	mysql_query("update kopalnie set ops=ops+5");
	mysql_query("update players set pm=inteli");
	mysql_query("update tribes set atak='N'");
	exit;
}
?>
