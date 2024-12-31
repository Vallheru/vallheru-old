<?php 
/***************************************************************************
 *                               memberlist.php
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

$title = "Lista mieszkañców"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}

	if (empty($_POST['szukany'])) {
		$msel = mysql_query("select id from players");
	} else {
		$_POST['szukany'] = strip_tags($_POST['szukany']);
		$_POST['szukany'] = str_replace("*","%", $_POST['szukany']);
		$msel = mysql_query("select id from players where user like '$_POST[szukany]'");
	}
	$graczy = mysql_num_rows($msel);
	if ($graczy == 0) {
		print "Nie ma gracza o imieniu $_POST[szukany]";
	}
	if ($_GET['limit'] < $graczy) {
		print "<table>";
		print "<tr><td width=50><a href=memberlist.php?lista=id&limit=0><b><u>ID</u></b></a></td><td width=100><a href=memberlist.php?lista=user&limit=0><b><u>Imiê</u></b></a></td><td width=100><a href=memberlist.php?lista=rank&limit=0><b><u>Ranga</u></b></a></td><td width=50><a href=memberlist.php?lista=rasa&limit=0><b><u>Rasa</b></u></a></td><td width=50><a href=memberlist.php?lista=level&limit=0><b><u>Poziom</u></b></a></td></tr>";
		if (empty($_POST['szukany'])) {
			$lista1 = mysql_query("select id, user, rank, rasa, level from players order by $_GET[lista] asc limit $_GET[limit],30");
		} else {
			$lista1 = mysql_query("select id, user, rank, rasa, level from players where user like '$_POST[szukany]' order by $_GET[lista] asc limit $_GET[limit],30");
		}
		while ($mem = mysql_fetch_array($lista1)) {
			if ($mem['rank'] == 'Admin') {
				$ranga = 'W³adca';
			} elseif ($mem['rank'] == 'Staff') {
				$ranga = 'Ksi±¿ê';
			} elseif ($mem['rank'] == 'Member') {
				$ranga = 'Mieszkaniec';
			} else {
				$ranga = $mem['rank'];
			}
			print "<tr><td>$mem[id]</td><td><A href=view.php?view=$mem[id]>$mem[user]</a></td><td>$ranga</td><td>$mem[rasa]</td><td>$mem[level]</td></tr>";
		}
		print "</table>";
		if ($_GET['limit'] >= 30) {
			$lim = $_GET['limit'] - 30;
			print "<a href=memberlist.php?limit=$lim&lista=$lista>Poprzednich 30 graczy</a> ";
		}
		$_GET['limit'] = $_GET['limit'] + 30;
		if ($graczy > 30 && $_GET['limit'] < $graczy) {
			print "<a href=memberlist.php?limit=$_GET[limit]&lista=$_GET[lista]>Nastêpnych 30 graczy</a>";
		}
	}
	print "<br>";
	print "<form method=post action=memberlist.php?limit=0&lista=user>";
	print "Szukaj gracza po ksywce. Je¿eli nie znasz jego dok³adnej ksywki, u¿yj znaku * zamiast liter.<br>";
	print "Gracz: <input type=text name=szukany><br>";
	print "<input type=submit value=Szukaj>";
	print "</form>";

require_once("footer.php");
?>
