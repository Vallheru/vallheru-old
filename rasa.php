<?php 
/***************************************************************************
 *                               rasa.php
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

$title = "Wybierz ras�"; require_once("header.php"); ?>

<?php
$gracz = mysql_fetch_array(mysql_query("select rasa from players where id=$stat[id]"));
if (!isset($_GET['rasa'])) {
     $_GET['rasa'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!$_GET['rasa'] && $gracz['rasa'] == '') {
	print "Tutaj mo�esz wybra� ras� swojej postaci. Ka�da rasa ma swoje plusy i minusy (ich opis znajdziesz po klikni�ciu w link). Zastan�w si� dobrze, poniewa� po�niej nie b�dziesz ju� m�g� zmieni� swojej rasy.<br><br>

	- <a href=rasa.php?rasa=czlowiek>Cz�owiek</a><br>
	- <a href=rasa.php?rasa=elf>Elf</a><br>
	- <a href=rasa.php?rasa=krasnolud>Krasnolud</a><br><br>";
}
if ($_GET['rasa'] == 'czlowiek' && $gracz['rasa'] == '') {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='rasa1'"));
	print "$opis[opis]";
	print "<form method=post action=rasa.php?rasa=czlowiek&step=wybierz>";
	print "<input type=submit value=Wybierz><br>";
	print "(<a href=rasa.php>Wr��</a>)";
	if ($_GET['step'] == 'wybierz' && $gracz['rasa'] == '') {
		mysql_query("update players set rasa='Cz�owiek' where id=$stat[id]");
		print "<br>Wybra�e� ras� ludzk�. Kliknij <a href=stats.php>tutaj</a> aby wr�ci�.";
	}
}
if ($_GET['rasa'] == 'elf' && $gracz['rasa'] == '') {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='rasa3'"));
	print "$opis[opis]";
	print "<form method=post action=rasa.php?rasa=elf&step=wybierz>";
	print "<input type=submit value=Wybierz><br>";
	print "(<a href=rasa.php>Wr��</a>)";
	if ($_GET['step'] == 'wybierz' && $gracz['rasa'] == '') {
		mysql_query("update players set rasa='Elf' where id=$stat[id]");
		print "<br>Wybra�e� ras� Elf�w. Kliknij <a href=stats.php>tutaj</a> aby wr�ci�.";
	}
}
if ($_GET['rasa'] == 'krasnolud' && $gracz['rasa'] == '') {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='rasa2'"));
	print "$opis[opis]";
	print "<form method=post action=rasa.php?rasa=krasnolud&step=wybierz>";
	print "<input type=submit value=Wybierz><br>";
	print "(<a href=rasa.php>Wr��</a>)";
	if ($_GET['step'] == 'wybierz' && $gracz['rasa'] == '') {
		mysql_query("update players set rasa='Krasnolud' where id=$stat[id]");
		print "<br>Wybra�e� ras� Krasnolud�w. Kliknij <a href=stats.php>tutaj</a> aby wr�ci�.";
	}
}
?>

<?php require_once("footer.php"); ?>
