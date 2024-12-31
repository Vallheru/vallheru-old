<?php 
/***************************************************************************
 *                               pshop.php
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

$title = "Sklep z mithrilem"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
$prices = mysql_query("select * from market");
$pa = mysql_fetch_array($prices);
$plat_price = $pa['platcost'];
if ($_GET['action'] != 'buy') {
	print "Witaj szukasz mithrilu? Jak tak to dobrze trafi³e¶ mo¿esz tu kupiæ dowoln±
ilo¶æ mithrilu. Jednak ceny tego kruszcu nie s± stabilne nie zdziw siê, gdy
jutro bêdziesz musia³ zap³aciæ dwa razy wiêcej. Obecna cena to $plat_price sztuk z³ota za sztukê mithrilu. Ile chcesz kupiæ?";
	print "<form method=post action=pshop.php?action=buy>";
	print "Chcê kupiæ <input type=text name=plat> sztuk mithrilu. <input type=submit value=Kup>";
	print "</form>";
} else {
	$_POST['plat'] = str_replace("--","", $_POST['plat']);
	$cost = ($_POST['plat'] * $plat_price);
	if ($cost > $gracz['credits'] || $_POST['plat'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['plat'])) {
		print "Nie staæ ciê! (<a href=pshop.php>wróæ</a>)";
	} else {
		mysql_query("update players set credits=credits-$cost where id=$stat[id]");
		mysql_query("update players set platinum=platinum+$_POST[plat] where id=$stat[id]");
		print "Kupi³e¶ <b>$_POST[plat]</b> sztuk mithrilu za <b>$cost</b> sztuk z³ota.";
	}
}
?>

<?php require_once("footer.php"); ?>
