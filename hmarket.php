<?php 
/***************************************************************************
 *                               hmarket.php
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

$title = "Rynek zió³"; require_once("header.php"); ?>
<?
$gr = mysql_fetch_array(mysql_query("select illanias, illani, nutari from herbs where gracz=$stat[id]"));
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!$_GET['view'] && !isset($_GET['wyc'])) {
	print "Tutaj jest rynek z zio³ami. Masz parê opcji.<br>";
	print "<ul>";
	print "<li><a href=hmarket.php?view=market&lista=id&limit=0>Zobacz oferty</a>";
	print "<li><a href=hmarket.php?view=szukaj>Szukaj ofert</a></li>";
	print "<li><a href=hmarket.php?view=add>Dodaj ofertê</a>";
	print "<li><a href=hmarket.php?view=del>Skasuj wszystkie swoje oferty</a>";
	print "</ul>";
}
	if ($_GET['view'] == 'szukaj') {
		print "Szukaj ofert na rynku lub <a href=hmarket.php>wróæ</a>. Je¿eli nie znasz dok³adnej nazwy zio³a, u¿yj znaku * zamiast liter.<br><br>";
		print "<table><form method=post action=hmarket.php?view=market&limit=0&lista=nazwa>";
		print "Zio³o: <input type=text name=szukany>";
		print "<tr><td colspan=2 align=center><input type=submit value=Szukaj></td></tr>";
		print "</form></table>";
	}
	if ($_GET['view'] == 'market') {
		print "Zobacz ceny zió³ lub <a href=hmarket.php>wróæ</a>.<br><br>";
		if (empty($_POST['szukany'])) {
			$msel = mysql_query("select id from hmarket");
		} else {
			$_POST['szukany'] = strip_tags($_POST['szukany']);
			$_POST['szukany'] = str_replace("*","%", $_POST['szukany']);
			$msel = mysql_query("select id from hmarket where nazwa like '$_POST[szukany]'");
		}
		$oferty = mysql_num_rows($msel);
		if ($oferty == 0) {
			print "Nie ma ofert na rynku";
		}
		if ($_GET['limit'] < $oferty) {
			print "<table>";
			print "<tr><td width=100><a href=hmarket.php?view=market&lista=nazwa&limit=0><b><u>Zio³o</u></b></td><td width=100><a href=hmarket.php?view=market&lista=ilosc&limit=0><b><u>Ilo¶æ</u></b></td><td width=100><a href=hmarket.php?view=market&lista=cost&limit=0><b><u>Koszt</u></b></td><td width=100><a href=hmarket.php?view=market&lista=seller&limit=0><b><u>Sprzedaj±cy</u></b></td><td width=100><b><u>Opcje</td></tr></tr>";
			if (empty($_POST['szukany'])) {
				$psel = mysql_query("select * from hmarket order by $_GET[lista] desc limit $_GET[limit],30");
			} else {
				$psel = mysql_query("select * from hmarket where nazwa like '$_POST[szukany]' order by $_GET[lista] desc limit $_GET[limit],30");
			}
			while ($pm = mysql_fetch_array($psel)) {
				print "<tr><td>$pm[nazwa]</td><td>$pm[ilosc]</td><td>$pm[cost]</td><td><a href=view.php?view=$pm[seller]>$pm[seller]</a></td>";
				if ($stat['id'] == $pm['seller']) {
					print "<td>- <a href=hmarket.php?wyc=$pm[id]>Wycofaj</a></td></tr>";
				} else {
					print "<td>- <a href=hmarket.php?buy=$pm[id]>Kup</a></td></tr>";
				}
			}
			print "</table>";
			if ($_GET['limit'] >= 30) {
				$lim = $_GET['limit'] - 30;
				print "<a href=hmarket.php?view=market&limit=$lim&lista=$_GET[lista]>Poprzednie 30 ofert</a> ";
			}
			$_GET['limit'] = $_GET['limit'] + 30;
			if ($oferty > 30 && $_GET['limit'] < $oferty) {
				print " <a href=hmarket.php?view=market&limit=$_GET[limit]&lista=$_GET[lista]>Nastêpnych 30 ofert</a>";
			}

		}
	}
	if ($_GET['view'] == 'add') {
		print "Dodaj ofertê na rynku lub <a href=hmarket.php>wróæ</a>.<br><br>";
		print "<table><form method=post action=hmarket.php?view=add&step=add>";
		print "<tr><td>Zio³o:</td><td><select name=mineral>";
		print "<option value=Illani>Illani</option>";
		print "<option value=Illanias>Illanias</option>";
		print "<option value=Nutari>Nutari</option>";
		print "<tr><td>Ilo¶æ zió³:</td><td><input type=text name=ilosc></td></tr>";
		print "<tr><td>Cena:</td><td><input type=text name=cost></td></tr>";
		print "<tr><td colspan=2 align=center><input type=submit value=Dodaj></td></tr>";
		print "</form></table>";
		if ($_GET['step'] == 'add') {
			$_POST['cost'] = str_replace("--","", $_POST['cost']);
			if (empty ($_POST['cost'])) {
				print "Musisz wype³niæ wszystkie pola.";
				require_once("footer.php");
				exit;
			}
			$_POST['cost'] = strip_tags($_POST['cost']);
			if ($_POST['mineral'] == 'Illani') {
				if ($_POST['ilosc'] > $gr['illani']) {
					print "Nie masz takiej ilo¶ci $_POST[mineral].";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'Illanias') {
				if ($_POST['ilosc'] > $gr['illanias']) {
					print "Nie masz takiej ilo¶ci $_POST[mineral].";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'Nutari') {
				if ($_POST['ilosc'] > $gr['nutari']) {
					print "Nie masz takiej ilo¶ci $_POST[mineral].";
					require_once("footer.php");
					exit;
				}
			} else {
				print "Zapomnij o tym!";
				require_once("footer.php");
				exit;
			}
			if ($_POST['ilosc'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
				print "Zapomnij o tym.";
				require_once("footer.php");
				exit;
			}
			if ($_POST['cost'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['cost'])) {
				print "Nie ma za darmo.";
				require_once("footer.php");
				exit;
			}
			mysql_query("update herbs set $_POST[mineral]=$_POST[mineral]-$_POST[ilosc] where gracz=$stat[id]");
			mysql_query("insert into hmarket (seller, ilosc, cost, nazwa) values($stat[id],$_POST[ilosc],$_POST[cost],'$_POST[mineral]')") or die("Nie mogê dodaæ.");
			print "Doda³e¶ <b>$_POST[ilosc]</b> $_POST[mineral] na rynku za <b>$_POST[cost]</b>  sztuk z³ota.";
		}
	}
	if ($_GET['view'] == 'del') {
	$dsel = mysql_query("select * from hmarket where seller=$stat[id]");
	while ($del = mysql_fetch_array($dsel)) {
		mysql_query("update herbs set $del[nazwa]=$del[nazwa]+$del[ilosc] where gracz=$stat[id]");
		mysql_query("delete from hmarket where id=$del[id]");
	}
	print "Usun±³e¶ wszystkie swoje oferty i twoje zio³a wróci³y do ciebie. (<A href=hmarket.php>wróæ</a>)";
	}
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
	$buy = mysql_fetch_array(mysql_query("select * from hmarket where id=$_GET[buy]")) ;
	if (empty ($buy['id'])) {
		print "Nie ma ofert. (<a href=hmarket.php?view=market>wróæ</a>)";
		require_once("footer.php");
		exit;
	}
	if ($buy['cost'] > $gracz['credits']) {
			print "Nie staæ ciê. (<a href=hmarket.php?view=market>wróæ</a>)";
			require_once("footer.php");
			exit;
	}
	if ($buy['seller'] == $stat['id']) {
			print "Nie mo¿esz kupiæ swoich zió³!. (<a href=hmarket.php?view=market>wróæ</a>)";
			require_once("footer.php");
			exit;
	}
	mysql_query("update players set bank=bank+$buy[cost] where id=$buy[seller]");
	mysql_query("update players set credits=credits-$buy[cost] where id=$stat[id]");
	if (empty($gr)) {
		mysql_query("insert into herbs (gracz, $buy[nazwa]) values ($stat[id],$buy[ilosc])");
	} else {
		mysql_query("update herbs set $buy[nazwa]=$buy[nazwa]+$buy[ilosc] where gracz=$stat[id]");
	}
	mysql_query("delete from hmarket where id=$buy[id]");
	$czas = date("y-m-d H:i:s");
	mysql_query("insert into log (owner, log, czas) values($buy[seller],'<b>$gracz[user]</b> zaakceptowa³ twoj± ofertê za $buy[ilosc] $buy[nazwa]. Dosta³e¶ <b>$buy[cost]</b> sztuk z³ota do banku.','$czas')") or die("Nie mogê dodaæ do dziennika.");
	print "Kupi³e¶ <b>$buy[ilosc]</b> $buy[nazwa] za <b>$buy[cost]</b> sztuk z³ota.";
}
if (isset($_GET['wyc'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
		print "Zapomnij o tym.";
		require_once("footer.php");
		exit;
	}
	$dwyc = mysql_fetch_array(mysql_query("select * from hmarket where id=$_GET[wyc]"));
	if ($dwyc['seller'] != $stat['id']) {
		print "Nie mo¿esz wycofaæ cudzych ofert!";
		require_once("footer.php");
		exit;
	}
	mysql_query("update herbs set $dwyc[nazwa]=$dwyc[nazwa]+$dwyc[ilosc] where gracz=$dwyc[seller]");
	mysql_query("delete from hmarket where id=$_GET[wyc]");
	print "Usun±³e¶ swoj± ofertê i twoje zio³a wróci³y do ciebie. (<A href=hmarket.php>wróæ</a>)";
}
?>
<?php require_once("footer.php"); ?>
