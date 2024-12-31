<?php 
/***************************************************************************
 *                               armor.php
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

$title = "P³atnerz"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['buy'])) {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='armor'"));
	print "$opis[opis]<br><br>";
	print "<ul>";
	print "<li><a href=armor.php?dalej=A>Zbroje</a></li>";
	print "<li><a href=armor.php?dalej=H>He³my</a></li>";
	print "<li><a href=armor.php?dalej=N>Nagolenniki</a></li>";
	print "</ul>";
	if (isset($_GET['dalej'])) {
		if ($_GET['dalej'] != 'A' && $_GET['dalej'] != 'H' && $_GET['dalej'] != 'N') {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		print "<table>
		<tr><td width=100><b><u>Nazwa</td><td><b><u>Wt.</td><td width=100><b><u>Efekt</td><td width=50><b><u>Cena</td><td><b><u>Wymagany poziom</td><td><b><u>Ograniczenie zrêczno¶ci</td><td><b><u>Opcje</td></tr>";

		$asel = mysql_query("select * from equipment where type='$_GET[dalej]' and status='S' and owner=0 order by cost asc");
		while ($arm = mysql_fetch_array($asel)) {
			print "<tr><td>$arm[name]</td><td>$arm[wt]</td><td>+$arm[power] Obrona</td><td>$arm[cost]</td><td>$arm[minlev]</td><td>$arm[zr] %<td>- <A href=armor.php?buy=$arm[id]>Kup</a></td></tr>";
		}
		print "</table>";
	}
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		print "Zapomnij o tym";
		require_once("footer.php");
		exit;
	}
	$arm = mysql_fetch_array(mysql_query("select * from equipment where id=$_GET[buy]"));
	if (empty ($arm['id'])) {
		print "Nie ta zbroja. Wróæ do <a href=armor.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($arm['status'] != 'S') {
		print "Tutaj tego nie sprzedasz. Wróæ do <a href=armor.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($arm['minlev'] > $gracz['level']) {
	print "Twój poziom jest za niski dla tej rzeczy! Wróæ do <a href=armor.php>sklepu</a>.";
	require_once("footer.php");
	exit;
	}
	if ($arm['cost'] > $gracz['credits']) {
		print "Nie staæ ciê! Wróæ do <a href=armor.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	$newcost = ceil($arm['cost'] * .75);
	mysql_query("insert into equipment (owner, name, power, type, cost, zr, wt, minlev,maxwt) values($stat[id],'$arm[name]',$arm[power],'$arm[type]',$newcost,$arm[zr],$arm[wt],$arm[minlev],$arm[wt])") or die("Nie mogê dodaæ zbroi.");
	print "Zap³aci³e¶ <b>$arm[cost]</b> sztuk z³ota, i kupi³e¶ za to now± <b>$arm[name] z Obron± +$arm[power]</b>.";
	mysql_query("update players set credits=credits-$arm[cost] where id=$stat[id]");
}
?>

<?php require_once("footer.php"); ?>
