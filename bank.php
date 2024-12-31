<?php 
/***************************************************************************
 *                               bank.php
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

$title = "Bank";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
?>
Witaj w banku. Mo�esz przechowa� tutaj sztuki z�ota, aby nie ukrad� ci ich kto� inny.
Mo�esz r�wnie� darowa� nieco pieni�dzy innemu u�ytkownikowi


<form method=post action=bank.php?action=withdraw>
<?php
print "Chc� <input type=submit value=wycofa�> <input type=text value=$gracz[bank] name=with> sztuk z�ota.";
?>
</form>

<form method=post action=bank.php?action=deposit>
<?php
print "Chc� <input type=submit value=zdeponowa�> <input type=text value=$gracz[credits] name=dep> sztuk z�ota.";
?>
</form>

<form method=post action=bank.php?action=dotacja>
<?php
print "Chc� <input type=submit value=da�> graczowi ID (numer) <input type=tekst name=id> <input type=text value=$gracz[bank] name=with> sztuk z�ota.";
?>

<?php
if ($_GET['action'] == 'withdraw') {
	$_POST['with'] = str_replace("--","", $_POST['with']);
	if ($_POST['with'] > $gracz['bank'] || !ereg("^[1-9][0-9]*$", $_POST['with'])) {
		print "Nie mo�esz wycofa� a� tyle.";
		require_once("footer.php");
		exit;
	}

	mysql_query("update players set credits=credits+$_POST[with] where id=$stat[id]");
	mysql_query("update players set bank=bank-$_POST[with] where id=$stat[id]");
	print "<br>Wycofa�e� $_POST[with] sztuk z�ota.";
}

if ($_GET['action'] == 'deposit') {
	$_POST['dep'] = str_replace("--","", $_POST['dep']);
	if ($_POST['dep'] > $gracz['credits'] || $_POST['dep'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['dep'])) {
		print "Nie mo�esz zdeponowa� a� tyle.";
		require_once("footer.php");
		exit;
	}

	mysql_query("update players set credits=credits-$_POST[dep] where id=$stat[id]");
	mysql_query("update players set bank=bank+$_POST[dep] where id=$stat[id]");
	print "<br>Zdeponowa�e� $_POST[dep] sztuk z�ota.";
}

if ($_GET['action'] == 'dotacja') {
	$_POST['with'] = str_replace("--","", $_POST['with']);
	if (!ereg("^[1-9][0-9]*$", $_POST['id'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	if ($_POST['with'] > $gracz['bank'] || $_POST['with'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['with'])) {
		print "Nie mo�esz da� a� tyle.";
		require_once("footer.php");
		exit;
	}
	if ($id == $stat['id']) {
		print "Nie mo�esz dotowa� siebie!";
		require_once("footer.php");
		exit;
	}
	$dotowany = mysql_fetch_array(mysql_query("select id from players where id=$_POST[id]"));
	if ($dotowany['id']) {
		mysql_query("update players set credits=credits+$_POST[with] where id=$_POST[id]");
		mysql_query("update players set bank=bank-$_POST[with] where id=$stat[id]");
		print "<br>Da�e� $_POST[with] sztuk z�ota graczowi ID $_POST[id].";
	}  else {
		print "Nie ma takiego gracza!";
		require_once("footer.php");
		exit;
		}
}
?>

<?php require_once("footer.php"); ?>
