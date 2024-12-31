<?php 
/***************************************************************************
 *                               weapons.php
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

$title = "Zbrojmistrz"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['buy'])) {
     $_GET['buy'] = '';
}
if (!$_GET['buy']) {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='weapon'"));
	print "$opis[opis]<br><br>
	<table>
	<tr><td width=100><b><u>Nazwa</td><td width=100><b><u>Efekt</td><td width=50><b><u>Szyb</u></b></td><td width=50><b><u>Wt.</td><td width=50><b><u>Cena</td><td><b><u>Wymagany poziom</td><td><b><u>Opcje</td></tr>";

	$wsel = mysql_query("select * from equipment where type='W' and status='S' and owner=0 order by cost asc");
	while ($wep = mysql_fetch_array($wsel)) {
		print "<tr><td>$wep[name]</td><td>+$wep[power] Atak</td><td>+$wep[szyb]%</td><td>$wep[wt]</td><td>$wep[cost]</td><td>$wep[minlev]</td><td>- <A href=weapons.php?buy=$wep[id]>Kup</a></td></tr>";
	}
	print "</table>";
}

if ($_GET['buy']) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$arm = mysql_fetch_array(mysql_query("select * from equipment where id=$_GET[buy]"));
	if (empty ($arm['id'])) {
		print "Nie zbroje. Wróæ do <a href=weapons.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($arm['status'] != 'S') {
		print "Tutaj tego nie sprzedasz. Wróc do <a href=weapons.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($arm['minlev'] > $gracz['level']) {
	print "Masz za niski poziom aby u¿ywaæ tej broni! Wróæ do <a href=weapons.php>sklepu</a>.";
	require_once("footer.php");
	exit;
	}
	if ($arm['cost'] > $gracz['credits']) {
		print "Nie staæ ciê! Wróæ do <a href=weapons.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	$newcost = ceil($arm['cost'] * .75);
	mysql_query("insert into equipment (owner, name, power, cost, wt, szyb, minlev,maxwt) values($stat[id],'$arm[name]',$arm[power],$newcost,$arm[wt],$arm[szyb],$arm[minlev],$arm[wt])") or die("Nie mogê dodaæ broni.");
	print "Zap³aci³e¶ <b>$arm[cost]</b> sztuk z³ota, ale teraz masz nowy <b>$arm[name]  z +$arm[power]</b> do Si³y .";
	mysql_query("update players set credits=credits-$arm[cost] where id=$stat[id]");
}
?>

<?php require_once("footer.php"); ?>
