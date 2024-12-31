<?php 
/***************************************************************************
 *                               wieza.php
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

$title = "Magiczna wie¿a"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['buy'])) {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='wieza'"));
	print "$opis[opis]<br><br>
	<table>
	<tr><td width=100><b><u>Nazwa</td><td width=100><b><u>Obra¿enia</td><td width=50><b><u>Cena</td><td><b><u>Wymagany poziom</td><td><b><u>Opcje</td></tr>";

	$czar = mysql_query("select * from czary where gracz=0 and status='S' order by cena asc");
	while ($czary = mysql_fetch_array($czar)) {
		print "<tr><td>$czary[nazwa]</td>";
		if ($czary[typ] == 'B') {
			print "<td>+$czary[obr] x Int obra¿eñ</td>";
		}
		if ($czary[typ] == 'O') {
			print "<td>+$czary[obr] x SW obrony</td>";
		}
		print "<td>$czary[cena]</td><td>$czary[poziom]</td><td>- <A href=wieza.php?buy=$czary[id]>Kup</a></td></tr>";
	}
	print "</table>";
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$czary = mysql_fetch_array(mysql_query("select * from czary where id=$_GET[buy]"));
	if (empty ($czary['id'])) {
		print "Nie ten czar. Wróæ do <a href=wieza.php>wie¿y</a>.";
		require_once("footer.php");
		exit;
	}
	if ($czary['poziom'] > $gracz['level']) {
	print "Twój poziom jest za niski dla tej rzeczy! Wróæ do <a href=wieza.php>wie¿y</a>.";
	require_once("footer.php");
	exit;
	}
	if ($czary['cena'] > $gracz['credits']) {
		print "Nie staæ ciê! Wróæ do <a href=wieza.php>wie¿y</a>.";
		require_once("footer.php");
		exit;
	}
	mysql_query("insert into czary (gracz, nazwa, cena, poziom, typ, obr, status) values($stat[id],'$czary[nazwa]',$czary[cena],$czary[poziom],'$czary[typ]',$czary[obr],'U')") or die("Nie mogê dodaæ czaru.");
	print "Zap³aci³e¶ <b>$czary[cena]</b> sztuk z³ota, i kupi³e¶ za to nowy czar <b>$czary[nazwa]</b>.";
	mysql_query("update players set credits=credits-$czary[cena] where id=$stat[id]");
}
?>

<?php require_once("footer.php"); ?>
