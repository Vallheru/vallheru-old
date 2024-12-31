<?php
/***************************************************************************
 *                               czary.php
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

 $title = "Ksiêga czarów"; require_once("header.php"); ?>

<u>Obecnie u¿ywane czary</u>:<br>

<?php
$czarb = mysql_fetch_array(mysql_query("select * from czary where gracz=$stat[id] and status='E' and typ='B'"));
if (!empty ($czarb['id'])) {
	print "Czar bojowy: $czarb[nazwa] (+$czarb[obr] x Inteligencja obra¿eñ) | <a href=czary.php?deakt=$czarb[id]>Deaktywuj czar</a><br>";
} else {
	print "Czar bojowy: brak<br>";
}
$czaro = mysql_fetch_array(mysql_query("select * from czary where gracz=$stat[id] and status='E' and typ='O'"));
if (!empty ($czaro['id'])) {
	print "Czar obronny: $czaro[nazwa] (+$czaro[obr] x Si³a Woli obrony) | <a href=czary.php?deakt=$czaro[id]>Deaktywuj czar</a><br>";
} else {
	print "Czar obronny: brak<br>";
}
if (isset($_GET['deakt'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['deakt'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$czary1 = mysql_fetch_array(mysql_query("select * from czary where id=$_GET[deakt]"));
	if (empty ($czary1[id])) {
		print "Nie ten czar.";
		require_once("footer.php");
		exit;
	}

	if ($stat[id] != $czary1[gracz]) {
		print "Nie posiadasz tego czaru.";
		require_once("footer.php");
		exit;
	}

	mysql_query("update czary set status='U' where id=$czary1[id] and gracz=$stat[id]");
	print "<a href=czary.php>(Od¶wie¿)</a>";
}
?>

<br><u>Czary w ksiêdze</u>:<br>
<b>-Czary bojowe:</b><br>
<?php
$czar = mysql_query("select * from czary where gracz=$stat[id] and status='U' and typ='B'");
while ($czary = mysql_fetch_array($czar)) {
	print "$czary[nazwa] (+$czary[obr] x Inteligencja obra¿eñ) [ <a href=czary.php?naucz=$czary[id]>U¿ywaj tego czaru</a>]<br>";
}
?>
<br><b>-Czary obronne:</b><br>
<?php
$czaro = mysql_query("select * from czary where gracz=$stat[id] and status='U' and typ='O'");
while ($czaryo = mysql_fetch_array($czaro)) {
	print "$czaryo[nazwa] (+$czaryo[obr] x Si³a Woli obrony) [ <a href=czary.php?naucz=$czaryo[id]>U¿ywaj tego czaru</a>]<br>";
}

if (isset($_GET['naucz'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['naucz'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$czary = mysql_fetch_array(mysql_query("select * from czary where id=$_GET[naucz]"));
	if (empty ($czary[id])) {
		print "Nie ten czar.";
		require_once("footer.php");
		exit;
	}

	if ($stat[id] != $czary[gracz]) {
		print "Nie posiadasz tego czaru.";
		require_once("footer.php");
		exit;
	}

	if ($gracz[level] < $czary[poziom]) {
		print "Nie masz odpowiednio wysokiego poziomu!";
		require_once("footer.php");
		exit;
	}
	mysql_query("update czary set status='U' where gracz=$stat[id] and typ='$czary[typ]' and status='E'");
	mysql_query("update czary set status='E' where id=$czary[id] and gracz=$stat[id]");
	print "U¿ywasz $czary[nazwa]. (<a href=czary.php>od¶wie¿</a>)";
}
require_once("footer.php");
?>
