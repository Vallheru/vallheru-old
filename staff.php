<?php 
/***************************************************************************
 *                               staff.php
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

$title = "Panel Administracyjny"; require_once("header.php"); ?>

<?php
if ($gracz['rank'] != 'Staff') {
	print "Nie jeste¶ Ksiêciem.";
	require_once("footer.php");
	exit;
}
?>

Witaj w panelu administracyjnym. Co chcesz zrobiæ?
<ul>
	<li><A href=addnews.php>Dodaæ Plotkê</a>
	<li><a href=staff.php?view=takeaway>Zabraæ sztuki z³ota</a>
	<li><a href=staff.php?view=clearc>Wyczy¶ciæ Czat</a>
	<li><a href=staff.php?view=czat>Zablokuj/odblokuj wiadomo¶ci od gracza na czacie</a>
</ul>

<?php
if ($_GET['view'] == 'clearc') {
	mysql_query("delete from chat");
	print "Wyczy¶ci³e¶ czat.";
}

if ($_GET['view'] == 'takeaway') {
	print "<form method=post action=staff.php?view=takeaway&step=takenaway> ID: <input type=text name=id> <br>ilo¶æ: <input type=text name=taken>  <input type=submit value=Zabierz></form>";
if ($_GET['step'] == 'takenaway') {
	$taken = str_replace("--","", $_POST['taken']);
	if ($_POST['taken'] < 0 ) {
	print "nie mo¿esz tak zrobiæ";
	require_once("footer.php");
	exit;
	}
	mysql_query("update players set credits=credits-$_POST[taken] where id=$_POST[id]");
	print "$_POST[taken] sztuk z³ota zosta³o zabranych $_POST[id]";
	require_once("footer.php");
	exit;
}
}
if ($_GET['view'] == 'czat') {
	$cz = mysql_query("select * from chat_config");
	print "Lista zablokowanych<br>";
	while ($czatb = mysql_fetch_array($cz)){
		print "ID: $czatb[gracz]";
	}
	print "<form method=post action=staff.php?view=czat&step=czat>";
	print "<select name=czat><option value=blok>Zablokuj</option><option value=odblok>Odblokuj</option></select> ID <input type=text name=czat_id size=5>. <input type=submit value=Zrób>";
	print "</form>";
	if ($_GET['step'] == 'czat') {
		if ($_POST['czat'] == 'blok') {
			mysql_query("insert into chat_config (gracz) values($_POST[czat_id])");
			print "Zablokowa³e¶ wysy³anie wiadomo¶ci na czacie przez gracza $_POST[czat_id]";
		}
		if ($_POST['czat'] == 'odblok') {
			mysql_query("delete from chat_config where gracz=$_POST[czat_id]");
			print "Odblokowa³e¶ wysy³anie wiadomo¶ci na czacie przez gracza $_POST[czat_id]";
		}
	}
}
?>

<?php require_once("footer.php"); ?>
