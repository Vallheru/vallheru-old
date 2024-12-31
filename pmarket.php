<?php 
/***************************************************************************
 *                               pmarket.php
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

$title = "Rynek minera³ów"; require_once("header.php"); ?>
<?
$gr = mysql_fetch_array(mysql_query("select bronz, zelazo, wegiel, adam, meteo, krysztal from kopalnie where gracz=$stat[id]"));
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!$_GET['view'] && !isset($_GET['wyc'])) {
	print "Tutaj jest rynek z minera³ami. Masz parê opcji.<br>";
	print "<ul>";
	print "<li><a href=pmarket.php?view=market&lista=id&limit=0>Zobacz oferty</a>";
	print "<li><a href=pmarket.php?view=szukaj>Szukaj ofert</a></li>";
	print "<li><a href=pmarket.php?view=add>Dodaj ofertê</a>";
	print "<li><a href=pmarket.php?view=del>Skasuj wszystkie swoje oferty</a>";
	print "</ul>";
}
	if ($_GET['view'] == 'szukaj') {
		print "Szukaj ofert na rynku lub <a href=pmarket.php>wróæ</a>. Je¿eli nie znasz dok³adnej nazwy minera³u, u¿yj znaku * zamiast liter.<br><br>";
		print "<table><form method=post action=pmarket.php?view=market&limit=0&lista=nazwa>";
		print "Minera³: <input type=text name=szukany>";
		print "<tr><td colspan=2 align=center><input type=submit value=Szukaj></td></tr>";
		print "</form></table>";
	}
	if ($_GET['view'] == 'market') {
		print "Zobacz ceny minera³ów lub <a href=pmarket.php>wróæ</a>.<br><br>";
		if (empty($_POST['szukany'])) {
			$msel = mysql_query("select id from pmarket");
		} else {
			$_POST['szukany'] = strip_tags($_POST['szukany']);
			$_POST['szukany'] = str_replace("*","%", $_POST['szukany']);
			$msel = mysql_query("select id from pmarket where nazwa like '$_POST[szukany]'");
		}
		$oferty = mysql_num_rows($msel);
		if ($oferty == 0) {
			print "Nie ma ofert na rynku";
		}
		if ($_GET['limit'] < $oferty) {
			print "<table>";
			print "<tr><td width=100><a href=pmarket.php?view=market&lista=nazwa&limit=0><b><u>Minera³</u></b></td><td width=100><a href=pmarket.php?view=market&lista=ilosc&limit=0><b><u>Ilo¶æ</u></b></td><td width=100><a href=pmarket.php?view=market&lista=cost&limit=0><b><u>Koszt</u></b></td><td width=100><a href=pmarket.php?view=market&lista=seller&limit=0><b><u>Sprzedaj±cy</u></b></td><td width=100><b><u>Opcje</td></tr></tr>";
			if (empty($_POST['szukany'])) {
				$psel = mysql_query("select * from pmarket order by $_GET[lista] desc limit $_GET[limit],30");
			} else {
				$psel = mysql_query("select * from pmarket where nazwa like '$_POST[szukany]' order by $_GET[lista] desc limit $_GET[limit],30");
			}
			while ($pm = mysql_fetch_array($psel)) {
				print "<tr><td>$pm[nazwa]</td><td>$pm[ilosc]</td><td>$pm[cost]</td><td><a href=view.php?view=$pm[seller]>$pm[seller]</a></td>";
				if ($stat['id'] == $pm['seller']) {
					print "<td>- <a href=pmarket.php?wyc=$pm[id]>Wycofaj</a></td></tr>";
				} else {
					print "<td>- <a href=pmarket.php?buy=$pm[id]>Kup</a></td></tr>";
				}
			}
			print "</table>";
			if ($_GET['limit'] >= 30) {
				$lim = $_GET['limit'] - 30;
				print "<a href=pmarket.php?view=market&limit=$lim&lista=$_GET[lista]>Poprzednie 30 ofert</a> ";
			}
			$_GET['limit'] = $_GET['limit'] + 30;
			if ($oferty > 30 && $_GET['limit'] < $oferty) {
				print " <a href=pmarket.php?view=market&limit=$_GET[limit]&lista=$_GET[lista]>Nastêpnych 30 ofert</a>";
			}

		}
	}
	if ($_GET['view'] == 'add') {
		print "Dodaj ofertê na rynku lub <a href=pmarket.php>wróæ</a>.<br><br>";
		print "<table><form method=post action=pmarket.php?view=add&step=add>";
		print "<tr><td>Minera³:</td><td><select name=mineral>";
		print "<option value=mithril>Mithril</option>";
		print "<option value=br±z>Br±z</option>";
		print "<option value=¿elazo>¯elazo</option>";
		print "<option value=wêgiel>Wêgiel</option>";
		print "<option value=adamantyt>Adamantyt</option>";
		print "<option value=meteoryt>Meteor</option>";
		print "<option value=kryszta³>Kryszta³</option></select></td></tr>";
		print "<tr><td>Ilo¶æ minera³u:</td><td><input type=text name=ilosc></td></tr>";
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
			if ($_POST['mineral'] == 'mithril') {
				$nazwa = 'mithrilu';
				if ($_POST['ilosc'] > $gracz['platinum']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'br±z') {
				$min = 'bronz';
				$nazwa = 'br±zu';
				if ($_POST['ilosc'] > $gr['bronz']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == '¿elazo') {
				$min = 'zelazo';
				$nazwa = '¿elaza';
				if ($_POST['ilosc'] > $gr['zelazo']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'wêgiel') {
				$min = 'wegiel';
				$nazwa = 'wêgla';
				if ($_POST['ilosc'] > $gr['wegiel']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'adamantyt') {
				$min = 'adam';
				$nazwa = 'adamantium';
				if ($_POST['ilosc'] > $gr['adam']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'meteoryt') {
				$min = 'meteo';
				$nazwa = 'meteorytu';
				if ($_POST['ilosc'] > $gr['meteo']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} elseif ($_POST['mineral'] == 'kryszta³') {
				$min = 'krysztal';
				$nazwa = 'kryszta³ów';
				if ($_POST['ilosc'] > $gr['krysztal']) {
					print "Nie masz takiej ilo¶ci $nazwa.";
					require_once("footer.php");
					exit;
				}
			} else {
				print "Zapomnij o tym";
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
			if ($_POST['mineral'] == 'mithril') {
				mysql_query("update players set platinum=platinum-$_POST[ilosc] where id=$stat[id]");
			} else {
				mysql_query("update kopalnie set $min=$min-$_POST[ilosc] where gracz=$stat[id]");
			}
			mysql_query("insert into pmarket (seller, ilosc, cost, nazwa) values($stat[id],$_POST[ilosc],$_POST[cost],'$_POST[mineral]')") or die("Nie mogê dodaæ.");
			print "Doda³e¶ <b>$_POST[ilosc]</b> $nazwa na rynku za <b>$_POST[cost]</b>  sztuk z³ota.";
		}
	}
	if ($_GET['view'] == 'del') {
	$dsel = mysql_query("select * from pmarket where seller=$stat[id]");
	while ($del = mysql_fetch_array($dsel)) {
		if ($del['nazwa'] == 'meteoryt') {
			$min = 'meteo';
		}
		if ($del['nazwa'] == 'br±z') {
			$min = 'bronz';
		}
		if ($del['nazwa'] == '¿elazo') {
			$min = 'zelazo';
		}
		if ($del['nazwa'] == 'wêgiel') {
			$min = 'wegiel';
		}
		if ($del['nazwa'] == 'adamantyt') {
			$min = 'adam';
		}
		if ($del['nazwa'] == 'kryszta³') {
			$min = 'krysztal';
		}
		if ($del['nazwa'] == 'mithril') {
			mysql_query("update players set platinum=platinum+$del[ilosc] where id=$stat[id]");
		} else {
			mysql_query("update kopalnie set $min=$min+$del[ilosc] where gracz=$stat[id]");
		}
		mysql_query("delete from pmarket where id=$del[id]");
	}
	print "Usun±³e¶ wszystkie swoje oferty i twoje minera³y wróci³y do ciebie. (<A href=pmarket.php>wróæ</a>)";
	}
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
	$buy = mysql_fetch_array(mysql_query("select * from pmarket where id=$_GET[buy]")) ;
	if (empty ($buy['id'])) {
		print "Nie ma ofert. (<a href=pmarket.php?view=market>wróæ</a>)";
		require_once("footer.php");
		exit;
	}
	if ($buy['cost'] > $gracz['credits']) {
			print "Nie staæ ciê. (<a href=pmarket.php?view=market>wróæ</a>)";
			require_once("footer.php");
			exit;
	}
	if ($buy['seller'] == $stat['id']) {
			print "Nie mo¿esz kupiæ swoich minera³ów!. (<a href=pmarket.php?view=market>wróæ</a>)";
			require_once("footer.php");
			exit;
	}
	if ($buy['nazwa'] == 'meteoryt') {
		$min = 'meteo';
	}
	if ($buy['nazwa'] == 'kryszta³') {
		$min = 'krysztal';
	}
	if ($buy['nazwa'] == 'br±z') {
		$min = 'bronz';
	}
	if ($buy['nazwa'] == '¿elazo') {
		$min = 'zelazo';
	}
	if ($buy['nazwa'] == 'wêgiel') {
		$min = 'wegiel';
	}
	if ($buy['nazwa'] == 'adamantyt') {
		$min = 'adam';
	}
	mysql_query("update players set bank=bank+$buy[cost] where id=$buy[seller]");
	mysql_query("update players set credits=credits-$buy[cost] where id=$stat[id]");
	if ($buy[nazwa] == 'mithril') {
		mysql_query("update players set platinum=platinum+$buy[ilosc] where id=$stat[id]");
	} else {
		if (empty($gr)) {
			mysql_query("insert into kopalnie (gracz, $min) values ($stat[id],$buy[ilosc])");
		} else {
			mysql_query("update kopalnie set $min=$min+$buy[ilosc] where gracz=$stat[id]");
		}
	}
	mysql_query("delete from pmarket where id=$buy[id]");
	$czas = date("y-m-d H:i:s");
	mysql_query("insert into log (owner, log, czas) values($buy[seller],'<b>$gracz[user]</b> zaakceptowa³ twoj± ofertê za $buy[nazwa]. Dosta³e¶ <b>$buy[cost]</b> sztuk z³ota do banku.','$czas')") or die("Nie mogê dodaæ do dziennika.");
	print "Kupi³e¶ <b>$buy[ilosc]</b> $buy[nazwa] za <b>$buy[cost]</b> sztuk z³ota.";
}
if (isset($_GET['wyc'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
		print "Zapomnij o tym.";
		require_once("footer.php");
		exit;
	}
	$dwyc = mysql_fetch_array(mysql_query("select * from pmarket where id=$_GET[wyc]"));
	if ($dwyc['seller'] != $stat['id']) {
		print "Nie mo¿esz wycofaæ cudzej oferty!";
		require_once("footer.php");
		exit;
	}
	if ($dwyc['nazwa'] == 'meteoryt') {
		$min = 'meteo';
	}
	if ($dwyc['nazwa'] == 'br±z') {
		$min = 'bronz';
	}
	if ($dwyc['nazwa'] == '¿elazo') {
		$min = 'zelazo';
	}
	if ($dwyc['nazwa'] == 'wêgiel') {
		$min = 'wegiel';
	}
	if ($dwyc['nazwa'] == 'adamantyt') {
		$min = 'adam';
	}
	if ($dwyc['nazwa'] == 'kryszta³') {
		$min = 'krysztal';
	}
	if ($dwyc['nazwa'] == 'mithril') {
		mysql_query("update players set platinum=platinum+$dwyc[ilosc] where id=$dwyc[seller]");
	} else {
		mysql_query("update kopalnie set $min=$min+$dwyc[ilosc] where gracz=$dwyc[seller]");
	}
	mysql_query("delete from pmarket where id=$_GET[wyc]");
	print "Usun±³e¶ swoj± ofertê i twoje minera³y wróci³y do ciebie. (<A href=pmarket.php>wróæ</a>)";
}
?>
<?php require_once("footer.php"); ?>
