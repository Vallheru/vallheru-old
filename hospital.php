<?php
/***************************************************************************
 *                               hospital.php
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

$title = "Szpital";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
$mytribe = mysql_fetch_array(mysql_query("select hospass from tribes where id=$gracz[tribe]"));
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if (!$_GET['action']) {
	if ($gracz['hp'] == $gracz['max_hp']) {
		print "Nie marnuj mojego czasu!";
		require_once("footer.php");
		exit;
	}
	if ($gracz['tribe'] > 0) {
		if ($mytribe['hospass'] == "Y" && $gracz['hp'] > 0) {
			print "Czy mo¿esz mnie <a href=hospital.php?action=heal>uzdrowiæ</a>?";
			print "<br>Jasne, twój klan obs³ugujê za darmo";
			require_once("footer.php");
			exit;
		}
	}
	if ($gracz['hp'] > 0) {
		$crneed = ($gracz['max_hp'] - $gracz['hp']);
		if ($crneed > $gracz['credits']) {
			print "Nie mo¿esz byæ wyleczony. Potrzebujesz <b>$crneed</b> sztuk z³ota.";
			require_once("footer.php");
			exit;
		}
		print "Czy mo¿esz mnie <a href=hospital.php?action=heal>uzdrowiæ</a>?";
		print "<br>Jasne, bêdzie ciê to kosztowa³o <b>$crneed</b> sztuk z³ota.";
	}
	if ($gracz['hp'] <= 0) {
		$crneed = ($gracz['max_hp'] * $gracz['level']);
		if ($crneed > $gracz['credits']) {
			print "Nie mo¿esz zostaæ wskrzeszony. Potrzebujesz <b>$crneed</b> sztuk z³ota.";
			require_once("footer.php");
			exit;
		}
		print "Czy chcesz aby twa dusza wróci³a do cia³a?<br>Bêdzie kosztowa³o to <b>$crneed</b> sztuk z³ota.<br><a href=hospital.php?action=ressurect>Tak</a>";
	}
}
if ($_GET['action'] == 'heal') {
	if ($mytribe['hospass'] == "Y") {
		mysql_query("update players set hp=max_hp where id=$stat[id]");
		print "<br>Jeste¶ kompletnie wyleczony.";
		require_once("footer.php");
		exit;
	}
	$crneed = ($gracz['max_hp'] - $gracz['hp']);
	if ($crneed > $gracz['credits']) {
		print "Nie mo¿esz byæ wyleczony. Potrzebujesz $crneed sztuk z³ota";
		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "Musisz byæ wskrzeszony nie uleczony";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set hp=max_hp where id=$stat[id]");
	mysql_query("update players set credits=credits-$crneed where id=$stat[id]");
	print "<br>Jeste¶ kompletnie wyleczony.";
}
if ($_GET['action'] == 'ressurect') {
	$pdpr1 = ceil($gracz['exp'] / 100);
	$pdpr = ($pdpr1 * 2);
	$pd = ($gracz['exp'] - $pdpr);
	$crneed = ($gracz['max_hp'] * $gracz['level']);
	if ($crneed > $gracz['credits']) {
		print "Nie mo¿esz byæ wskrzeszony.";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set exp=$pd where id=$stat[id]");
	mysql_query("update players set hp=max_hp where id=$stat[id]");
	mysql_query("update players set credits=credits-$crneed where id=$stat[id]");
	print "<br>Zosta³e¶ wskrzeszony ale staci³e¶ $pdpr Punktów Do¶wiadczenia.";
}
require_once("footer.php");
?>
