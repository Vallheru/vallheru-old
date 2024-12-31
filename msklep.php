<?php
/***************************************************************************
 *                               msklep.php
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

 $title = "Alchemik"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
$gr = mysql_fetch_array(mysql_query("select inteli, level from players where id=$stat[id]"));
if (!isset($_GET['buy'])) {
	print "Witaj w sklepie alchemika, mo¿esz tutaj kupiæ ró¿ne przydatne mikstury. Cena mikstur zale¿y od twojego poziomu, twoich statystyk oraz od samej mikstury<br><br>
	<table>
	<tr><td width=100><b><u>Nazwa</u></b></td><td width=100><b><u>Efekt</u></b></td><td width=50><b><u>Cena</td><td><b><u>Opcje</td></tr>";
	$asel = mysql_query("select * from mikstury where gracz=0 and status='S' order by moc asc");
	while ($arm = mysql_fetch_array($asel)) {
		if ($arm['typ'] == 'M') {
			$moc = ($arm['moc'] / 100);
			$cena = (ceil($gr['inteli'] * $gr['level']) * $moc);
		}
		if ($arm['typ'] == 'Z') {
			$cena = $gracz['max_hp'];
		}
		if ($arm['typ'] == 'W') {
			$cena = ($gracz['level'] * $gracz['max_hp']);
		}
		if ($arm['typ'] == 'M') {
			print "<tr><td>$arm[nazwa] (moc:$arm[moc]%)</td><td>$arm[efekt]</td><td>$cena</td><td>- <a href=msklep.php?buy=$arm[id]>Kup</a></td></tr>";
		} else {
			print "<tr><td>$arm[nazwa]</td><td>$arm[efekt]</td><td>$cena</td><td>- <a href=msklep.php?buy=$arm[id]>Kup</a></td></tr>";
		}
	}
	print "</table>";
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$arm = mysql_fetch_array(mysql_query("select * from mikstury where id=$_GET[buy]"));
	if (empty ($arm['id'])) {
		print "Nie ta mikstura. Wróæ do <a href=msklep.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($arm['status'] != 'S') {
		print "Tutaj tego nie sprzedasz. Wróæ do <a href=msklep.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($arm['typ'] == 'M') {
		$moc = ($arm['moc'] / 100);
		$cena = (ceil($gr['inteli'] * $gr['level']) * $moc);
	}
	if ($arm['typ'] == 'Z') {
		$cena = $gracz['max_hp'];
	}
	if ($arm['typ'] == 'W') {
		$cena = ($gracz['level'] * $gracz['max_hp']);
	}
	if ($cena > $gracz['credits']) {
		print "Nie staæ ciê! Wróæ do <a href=msklep.php>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	mysql_query("insert into mikstury (gracz, nazwa, typ, efekt, status, moc) values($stat[id],'$arm[nazwa]','$arm[typ]','$arm[efekt]','K',$arm[moc])") or die("Nie mogê dodaæ mikstury.");
	print "Zap³aci³e¶ <b>$cena</b> sztuk z³ota, i kupi³e¶ za to now± <b>miksturê $arm[nazwa]</b>.";
	mysql_query("update players set credits=credits-$cena where id=$stat[id]");
}
?>

<?php require_once("footer.php"); ?>
