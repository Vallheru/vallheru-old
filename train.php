<?php 
/***************************************************************************
 *                               train.php
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

$title = "Szkolenie"; require_once("header.php"); ?>
<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if ($gracz['hp'] == 0) {
	print "Nie mo�esz szkoli� si�, poniewa� jeste� martwy!";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
$gr11 = mysql_fetch_array(mysql_query("select rasa, klasa from players where id=$stat[id]"));
print "Witaj w szkole. Tutaj mo�esz �wiczy� swoj� si�� i zr�czno��. Koszt podniesiena zale�y od twojej rasy: ";
if ($gr11['rasa'] == 'Cz�owiek') {
	print "0,3 energii za 0,06 Si�y, Zr�czno�ci, Szybko�ci i Wytrzyma�o�ci ";
}
if ($gr11['rasa'] == 'Elf') {
	print "0,4 energii za 0,06 Si�y lub Wytrzyma�o�ci, 0,2 energii za 0,06 Zr�czno�ci lub Szybko�ci";
}
if ($gr11['rasa'] == 'Krasnolud') {
	print "0,2 energii za 0,06 Si�y lub Wytrzyma�o�ci, 0,4 energii za 0,06 Zr�czno�ci lub Szybko�ci";
}
if ($gr11['klasa'] == 'Wojownik') {
	print " oraz 0,4 energii za 0,06 Si�y Woli lub Inteligencji.";
}
if ($gr11['klasa'] == 'Mag') {
	print " oraz 0,2 energii za 0,06 Si�y Woli lub Inteligencji.";
}
if ($gr11['klasa'] == 'Obywatel') {
	print " oraz 0,3 energii za 0,06 Si�y Woli lub Inteligencji.";
}
$cost = ($gracz['level'] * 10);
print " Opr�cz tego ka�dy trening kosztuje $cost sztuk z�ota.";
?>
<form method=post action=train.php?action=train>
Chc� trenowa� moj� <select name=train><option value=strength>Si��</option><option value=agility>Zr�czno��</option><option value=inteli>Inteligencj�</option><option value=szyb>Szybko��</option><option value=wytrz>Wytrzyma�o��</option><option value=wisdom>Si�� Woli</option></select> <input type=text size=3 value=0 name=rep> razy. <input type=submit value=Trenuj>
</form>

<?php
if ($_GET['action'] == 'train') {
	$_POST["rep"] = str_replace("--","", $_POST["rep"]);
	if (!ereg("^[1-9][0-9]*$", $_POST["rep"])) {
		print "Zapomnij o tym";
		require_once("footer.php");
		exit;
	}
	if ($_POST["train"] != 'strength' && $_POST['train'] != 'agility' && $_POST['train'] != 'inteli' && $_POST['train'] != 'szyb' && $_POST['train'] != 'wytrz' && $_POST['train'] != 'wisdom') {
		print "Zapomnij o tym";
		require_once("footer.php");
		exit;
	}
	$cost = (($gracz['level'] * 10) * $_POST["rep"]);
	if ($gracz['credits'] < $cost) {
		print "Nie mo�esz tyle �wiczy�, poniewa� nie sta� ciebie na to!";
		require_once("footer.php");
		exit;
	}
	if ($gr11['rasa'] == 'Cz�owiek') {
		$repeat = ($_POST["rep"] * .3);
	}
	if ($gr11['rasa'] == 'Elf' && $_POST["train"] == 'strength') {
		$repeat = ($_POST["rep"] * .4);
	}
	if ($gr11['rasa'] == 'Elf' && $_POST["train"] == 'wytrz') {
		$repeat = ($_POST["rep"] * .4);
	}
	if ($gr11['rasa'] == 'Elf' && $_POST["train"] == 'agility') {
		$repeat = ($_POST["rep"] * .2);
	}
	if ($gr11['rasa'] == 'Elf' && $_POST["train"] == 'szyb') {
		$repeat = ($_POST["rep"] * .2);
	}
	if ($gr11['rasa'] == 'Krasnolud' && $_POST["train"] == 'strength') {
		$repeat = ($_POST["rep"] * .2);
	}
	if ($gr11['rasa'] == 'Krasnolud' && $_POST["train"] == 'wytrz') {
		$repeat = ($_POST["rep"] * .2);
	}
	if ($gr11['rasa'] == 'Krasnolud' && $_POST["train"] == 'agility') {
		$repeat = ($_POST["rep"] * .4);
	}
	if ($gr11['rasa'] == 'Krasnolud' && $_POST["train"] == 'szyb') {
		$repeat = ($_POST["rep"] * .4);
	}
	if ($gr11['rasa'] == '') {
		print "Nie masz wybranej rasy!";
		require_once("footer.php");
		exit();
	}
	if ($gr11['klasa'] == 'Wojownik' && $_POST["train"]) {
                if ($_POST['train'] == 'inteli' || $_POST['train'] == 'wisdom') {
                	$repeat = ($_POST["rep"] * .4);
                }
	}
	if ($gr11['klasa'] == 'Mag' && $_POST["train"]) {
                if ($_POST['train'] == 'inteli' || $_POST['train'] == 'wisdom') {
                	$repeat = ($_POST["rep"] * .2);
                }
	}
	if ($gr11['klasa'] == 'Obywatel' && $_POST["train"]) {
                if ($_POST['train'] == 'inteli' || $_POST['train'] == 'wisdom') {
                	$repeat = ($_POST["rep"] * .3);
                }
	}
	if ($gr11['klasa'] == '') {
		print "Nie masz wybranej klasy!";
		require_once("footer.php");
		exit();
	}
	$gain = ($_POST["rep"] * .060);
	if ($repeat > $gracz['energy'] || $_POST["rep"] < 1) {
		print "Nie masz wystarczaj�cej ilo�ci energii.";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set energy=energy-$repeat where id=$stat[id]");
	mysql_query("update players set $_POST[train]=$_POST[train]+$gain where id=$stat[id]");
	mysql_query("update players set credits=credits-$cost where id=$stat[id]");
	if ($_POST['train'] == 'strength') {
		$cecha = 'Si�y';
	}
	if ($_POST['train'] == 'agility') {
		$cecha = 'Zr�czno�ci';
	}
	if ($_POST['train'] == 'inteli') {
		$cecha = "Inteligencji";
	}
	if ($_POST['train'] == 'szyb') {
		$cecha = "Szybko�ci";
	}
	if ($_POST['train'] == 'wytrz') {
		$cecha = "Wytrzyma�o�ci";
	}
	if ($_POST['train'] == 'wisdom') {
	        $cecha = "Si�y Woli";
	}
	print "Zyskujesz <b>$gain $cecha</b>. Zap�aci�e�(a�) za to $cost sztuk z�ota.";
}
?>

<?php require_once("footer.php"); ?>
