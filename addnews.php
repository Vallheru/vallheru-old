<?php
/***************************************************************************
 *                               addnews.php
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
$title = "Dodaj Plotk�"; require_once("header.php");
if ($gracz['rank'] != "Admin") {
	print "Nie masz prawa przebywa� tutaj.";
	require_once("footer.php");
	exit;
}
?>

<table>
<form method=post action=addnews.php?action=add>
<tr><td>Tytu�:</td><td><input type=text name=addtitle></td></tr>
<tr><td valign=top>Tekst:</td><td><textarea name=addnews rows=5 cols=19></textarea></td></tr>
<tr><td colspan=2 align=center><input type=submit value="Dodaj plotk�"></td></tr>
</form>
</table>

<?php
if ($_GET['action'] == 'add') {
	if (empty ($_POST['addtitle']) || empty ($_POST['addnews'])) {
		print "Wype�nij wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	mysql_query("insert into news (starter, title, news) values('$gracz[user] ($stat[id])','".$_POST['addtitle']."','".$_POST['addnews']."')") or die("Could not add news.");
	print "Plotka dodana.";
}

require_once("footer.php");
?>