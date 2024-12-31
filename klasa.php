<?php 
/***************************************************************************
 *                               klasa.php
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

$title = "Wybierz klasê"; require_once("header.php"); ?>

<?php
if (!isset($_GET['klasa'])) {
     $_GET['klasa'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
$gr5 = mysql_fetch_array(mysql_query("select klasa from players where id=$stat[id]"));
if (!$_GET['klasa']) {
	print "Tutaj mo¿esz wybraæ klasê swojej postaci. Ka¿da klasa ma swoje plusy i minusy. Zastanów siê dobrze, poniewa¿ po¼niej nie bêdziesz ju¿ móg³ zmieniæ swojej klasy.<br><br>

	- <a href=klasa.php?klasa=wojownik>Wojownik</a><br>
	- <a href=klasa.php?klasa=mag>Mag</a><br>
	- <a href=klasa.php?klasa=obywatel>Obywatel</a><br><br>";
}
if ($_GET['klasa'] == 'wojownik' && $gr5['klasa'] == '') {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='klasa1'"));
	print "$opis[opis]";
	print "<form method=post action=klasa.php?klasa=wojownik&step=wybierz>";
	print "<input type=submit value=Wybierz><br>";
	print "(<a href=klasa.php>Wróæ</a>)";
	if ($_GET['step'] == 'wybierz' && $gr5['klasa'] == '') {
		mysql_query("update players set klasa='Wojownik' where id=$stat[id]");
		print "<br>Wybra³e¶ kastê wojowników. Kliknij <a href=stats.php>tutaj</a> aby wróciæ.";
	}
}
if ($_GET['klasa'] == 'mag' && $gr5['klasa'] == '') {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='klasa2'"));
	print "$opis[opis]";
	print "<form method=post action=klasa.php?klasa=mag&step=wybierz>";
	print "<input type=submit value=Wybierz><br>";
	print "(<a href=klasa.php>Wróæ</a>)";
	if ($_GET['step'] == 'wybierz' && $gr5['klasa'] == '') {
		mysql_query("update players set klasa='Mag' where id=$stat[id]");
		print "<br>Wybra³e¶ kastê magów. Kliknij <a href=stats.php>tutaj</a> aby wróciæ.";
	}
}
if ($_GET['klasa'] == 'obywatel' && $gr5['klasa'] == '') {
	$opis = mysql_fetch_array(mysql_query("select opis from opisy where nazwa='klasa3'"));
	print "$opis[opis]";
	print "<form method=post action=klasa.php?klasa=obywatel&step=wybierz>";
	print "<input type=submit value=Wybierz><br>";
	print "(<a href=klasa.php>Wróæ</a>)";
	if ($_GET['step'] == 'wybierz' && $gr5['klasa'] == '') {
		mysql_query("update players set klasa='Obywatel' where id=$stat[id]");
		print "<br>Wybra³e¶ kastê obywateli. Kliknij <a href=stats.php>tutaj</a> aby wróciæ.";
	}
}
?>

<?php require_once("footer.php"); ?>
