<?php 
/***************************************************************************
 *                               rest.php
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

$title = "Odpoczynek"; 
require_once("header.php");
$gr8 = mysql_fetch_array(mysql_query("select inteli from players where id=$stat[id]"));
if (!$akcja) {
	print "<b><u>Odpoczynek</b></u><br>";
	$koszt = ceil(($gr8[inteli]-$gracz[pm]) / 10);
	print "Tutaj mo¿esz odpocz±æ regeneruj±c swoje <b>punkty magii</b>. Ca³kowite odzyskanie <b>punktów magii</b> bêdzie ciebie kosztowaæ $koszt energii. Je¿eli nie masz tyle energii mo¿esz równie¿ odzyskaæ czê¶ciowo <b>punkty magii</b><br>";
	print "<form method=post action=rest.php?akcja=all>
Chcê odzyskaæ <input type=text size=3 name=pm> punktów magii. <input type=submit value=Odpoczywaj>
</form>";
	print "<a href=stats.php>Powrót do statystyk</a>";
}
if ($akcja == all) {
	if (!ereg("^[1-9][0-9]*$", $_POST[pm])) {
		print "Zapomnij o tym";
		require_once("footer.php");
		exit;
	}
	$energia = ceil($_POST[pm] / 10);
	if ($gracz[energy] < $energia) {
		print "Nie masz tyle energii!";
		require_once("footer.php");
		exit;
	}
	if ($gracz[pm] == $gr8[inteli]) {
		print "Nie musisz odpoczywaæ";
		require_once("footer.php");
		exit;
	}
	$zpm = ($_POST[pm] + $gracz[pm]);
	if ($zpm > $gr8[inteli]) {
		print "Nie mo¿esz odzyskaæ wiêcej Punktów Magii ni¿ masz maksymalnie!";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set pm=$zpm where id=$stat[id]");
	mysql_query("update players set energy=energy-$energia where id=$stat[id]");
	print "Opocz±³e¶ sobie przez jaki¶ czas i odzyska³e¶ $gpm punkty magii w zamian za $energia energii. <a href=stats.php>Powrót do statystyk</a>";
}
require_once("footer.php");
?>
