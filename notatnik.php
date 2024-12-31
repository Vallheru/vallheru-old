<?php
/***************************************************************************
 *                               notatnik.php
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

$title = "Notatnik";
require_once("header.php");
print "Tutaj mo¿esz zapisywaæ sobie ró¿ne przydatne informacje.<br><br>";
$lsel = mysql_query("select * from notatnik where gracz=$stat[id] order by id desc limit 25");
while ($log = mysql_fetch_array($lsel)) {
	print "Czas:$log[czas]<br>$log[tekst]<br> (<a href=notatnik.php?akcja=skasuj&nid=$log[id]>Skasuj wpis</a>)<br>";
}
print "<br><br><a href=notatnik.php?akcja=dodaj>(Dodaj wpis)</a>";
if (!isset($_GET['akcja'])) {
     $_GET['akcja'] = '';
}
if ($_GET['akcja'] == 'skasuj') {
	if (!ereg("^[1-9][0-9]*$", $_GET['nid'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$did = mysql_fetch_array(mysql_query("select * from notatnik where id=$_GET[nid]"));
	if (empty($did)) {
		print "Nie ma takiego wpisu!";
		require_once("footer.php");
		exit;
	}
	if ($stat['id'] != $did['gracz']) {
		print "Nie twój wpis!";
		require_once("footer.php");
		exit;
	}
	print "<br>Skasowa³e¶ wpis. (<a href=notatnik.php>od¶wie¿</a>)";
	mysql_query("delete from notatnik where gracz=$stat[id] and id=$_GET[nid]");
}
if ($_GET['akcja'] == 'dodaj') {
	print "<table>";
	print "<form method=post action=notatnik.php?akcja=dodaj&step=send>";
	print "<tr><td valign=top>Notatka:</td><td><textarea name=body rows=5 cols=19></textarea></td></tr>";
	print "<tr><td colspan=2 align=center><input type=submit value=Zapisz></td></tr>";
	print "</form></table>";
	if (!isset($_GET['step'])) {
	   $_GET['step'] = '';
	}
	if ($_GET['step'] == 'send') {
		if (empty ($_POST['body'])) {
			print "Wype³nij pole.";
			require_once("footer.php");
			exit;
		}
		$_POST['body'] = strip_tags($_POST['body']);
		$czas = date("y-m-d H:i:s");
		mysql_query("insert into notatnik (gracz, tekst, czas) values($stat[id],'$_POST[body]', '$czas')") or die("Nie mogê wstawiæ wpisu.");
		print "Notatka dodana. (<a href=notatnik.php>od¶wie¿</a>)";
	}
}
require_once("footer.php");
?>
