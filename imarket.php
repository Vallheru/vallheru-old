<?php 
/***************************************************************************
 *                               imarket.php
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

$title = "Rynek z przedmiotami"; require_once("header.php"); ?>
<?
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!$_GET['view'] && !isset($_GET['wyc'])) {
	print "Tutaj jest rynek z przedmiotami. Masz parê opcji.<br>";
	print "<ul>";
	print "<li><a href=imarket.php?view=market&limit=0&lista=id>Zobacz oferty</a></li>";
	print "<li><a href=imarket.php?view=szukaj>Szukaj ofert</a></li>";
	print "<li><a href=imarket.php?view=add>Dodaj ofertê</a></li>";
	print "<li><a href=imarket.php?view=del>Skasuj swoje oferty</a></li>";
	print "</ul>";
}
	if ($_GET['view'] == 'szukaj') {
		print "Szukaj ofert na rynku lub <a href=imarket.php>wróæ</a>. Uwaga! Wpisz dok³adn± nazwê przedmiotu jakiego poszukujesz.<br><br>";
		print "<table><form method=post action=imarket.php?view=market&limit=0&lista=name>";
		print "Przedmiot: <input type=text name=szukany>";
		print "<tr><td colspan=2 align=center><input type=submit value=Szukaj></td></tr>";
		print "</form></table>";
	}

	if ($_GET['view'] == 'market') {
		if (empty($_POST['szukany'])) {
			$msel = mysql_query("select id from equipment where status='R'");
		} else {
			$_POST['szukany'] = strip_tags($_POST['szukany']);
			$msel = mysql_query("select id from equipment where status='R' and name='$_POST[szukany]'");
		}
		$przed = mysql_num_rows($msel);
		if ($przed == 0) {
			print "Nie ma ofert na rynku! <a href=imarket.php>Wróæ</a>";
		}
		if ($_GET['limit'] < $przed) {
			print "Zobacz oferty lub <a href=imarket.php>wróæ</a>.<br><br>";
			print "<table>";
			print "<tr><td width=100><a href=imarket.php?view=market&lista=name&limit=0><b><u>Nazwa</u></b></a></td><td width=100><a href=imarket.php?view=market&lista=power&limit=0><b><u>Si³a</u></b></a></td><td width=100><a href=imarket.php?view=market&lista=wt&limit=0><b><u>Wytrzyma³o¶æ</u></b></a></td><td width=100><a href=imarket.php?view=market&lista=cost&limit=0><b><u>Koszt</u></b></a></td><td width=100><a href=imarket.php?view=market&lista=owner&limit=0><b><u>Sprzedaj±cy</u></b></a></td><td width=100><b><u>Opcje</td></tr>";
			if (empty($_POST['szukany'])) {
				$psel = mysql_query("select * from equipment where status='R' order by $_GET[lista] desc limit $_GET[limit],30");
			} else {
				$psel = mysql_query("select * from equipment where status='R' and name='$_POST[szukany]' order by $_GET[lista] desc limit $_GET[limit],30");
			}
			while ($pm = mysql_fetch_array($psel)) {
				print "<tr><td>$pm[name]</td><td align=center>$pm[power]</td><td align=center>$pm[wt]</td><td>$pm[cost]</td><td><a href=view.php?view=$pm[owner]>$pm[owner]</a></td>";
				if ($stat['id'] == $pm['owner']) {
					print "<td>- <a href=imarket.php?wyc=$pm[id]>Wycofaj</a></td></tr>";
				} else {
					print "<td>- <a href=imarket.php?buy=$pm[id]>Kup</a></td></tr>";
				}
			}
			print "</table>";
			if ($_GET['limit'] >= 30) {
				$lim = $_GET['limit'] - 30;
				print "<a href=imarket.php?view=market&limit=$lim&lista=$_GET[lista]>Poprzednie 30 przedmiotów</a> ";
			}
			$_GET['limit'] = $_GET['limit'] + 30;
			if ($przed > 30 && $_GET['limit'] < $przed) {
				print " <a href=imarket.php?view=market&limit=$limit&lista=$_GET[lista]>Nastêpnych 30 przedmiotów</a>";
			}

		}
	}

	if ($_GET['view'] == 'add') {
		print "Dodaj ofertê na rynku lub <a href=imarket.php>wróæ</a>.<br><br>";
		print "<table><form method=post action=imarket.php?view=add&step=add>";
		print "Przedmiot: <select name=przedmiot>";
		$csel = mysql_query("select * from equipment where status='U' and owner=$stat[id]");
		while ($rzecz = mysql_fetch_array($csel)) {
		print "<option value=$rzecz[id]>$rzecz[name]</option>";
		}
		print "<tr><td>Cena za przedmiot:</td><td><input type=text name=cost></td></tr>";
		print "<tr><td colspan=2 align=center><input type=submit value=Dodaj></td></tr>";
		print "</form></table>";
		if ($_GET['step'] == 'add') {
			if (!$cost || !ereg("^[1-9][0-9]*$", $_POST['cost'])) {
				print "Podaj cenê";
				require_once("footer.php");
				exit;
			}
			if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot'])) {
				print "Zapomnij o tym";
				require_once("footer.php");
				exit;
			}
			mysql_query("update equipment set status='R' where id=$_POST[przedmiot]");
			mysql_query("update equipment set cost=$_POST[cost] where id=$_POST[przedmiot]");
			$nazwa = mysql_fetch_array(mysql_query("select * from equipment where id=$_POST[przedmiot]"));
			print "Doda³e¶ <b>$nazwa[name]</b> na rynku za <b>$_POST[cost]</b> sztuk z³ota.";
		}
	}
	if (isset($_GET['wyc'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$dwyc = mysql_fetch_array(mysql_query("select id, owner from equipment where id=$_GET[wyc]"));
		if ($dwyc['owner'] != $stat['id']) {
			print "Nie mo¿esz wycofaæ cudzych ofert!";
			require_once("footer.php");
			exit;
		}
		mysql_query("update equipment set cost=1 where id=$dwyc[id]");
		mysql_query("update equipment set status='U' where id=$dwyc[id]");
		mysql_query("update equipment set cost=1 where id=$dwyc[id]");
		print "Usun±³e¶ swoj± ofertê i twój przedmiot wróci³ do ciebie. (<A href=imarket.php>wróæ</a>)";
	}

	if ($_GET['view'] == 'del') {	$dsel = mysql_query("select * from equipment where owner=$stat[id] and status='R'");
	while ($del = mysql_fetch_array($dsel)) {
		mysql_query("update equipment set cost=1 where owner=$del[owner] and status='R'");
		mysql_query("update equipment set status='U' where owner=$del[owner] and status='R'");
	}
	print "Usun±³e¶ wszystkie swoje oferty i twoje przedmioty wróci³y do ciebie. (<A href=imarket.php>wróæ</a>)";
	}
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$buy = mysql_fetch_array(mysql_query("select * from equipment where id=$_GET[buy]")) ;
	if (empty ($buy['id'])) {
		print "Nie ma ofert. (<a href=imarket.php?view=market>wróæ</a>)";
		require_once("footer.php");
		exit;
	}
	if ($buy['minlev'] > $gracz['level']) {
		print "Twój poziom jest za niski dla tej rzeczy! (<a href=imarket.php?view=market>Wróæ</a>)";
		require_once("footer.php");
		exit;
	}
	if ($buy['cost'] > $gracz['credits']) {
			print "Nie staæ ciê. (<a href=imarket.php?view=market>wróæ</a>)";
			require_once("footer.php");
			exit;
	}
	if ($buy['owner'] == $stat['id']) {
			print "Nie mo¿esz kupiæ w³asnego przedmiotu! (<a href=imarket.php?view=market>wróæ</a>)";
			require_once("footer.php");
			exit;
	}
	$ncost = ceil($buy['cost'] * .5);
	mysql_query("update players set bank=bank+$buy[cost] where id=$buy[owner]");
	mysql_query("update players set credits=credits-$buy[cost] where id=$stat[id]");
	$czas = date("y-m-d H:i:s");
	mysql_query("insert into log (owner, log, czas) values($buy[owner],'<b>$gracz[user]</b> zaakceptowa³ twoj± ofertê za <b>$buy[name]</b>. Dosta³e¶ <b>$buy[cost]</b> sztuk z³ota do banku.','$czas')") or die("Nie mogê dodaæ do dziennika.");
	mysql_query("update equipment set status='U' where id=$buy[id]");
	mysql_query("update equipment set owner=$stat[id] where id=$buy[id]");
	mysql_query("update equipment set cost=1 where id=$buy[id]");
	print "Kupi³e¶ <b>$buy[name]</b> za <b>$buy[cost]</b> sztuk z³ota.";
}

?>
<?php require_once("footer.php"); ?>
