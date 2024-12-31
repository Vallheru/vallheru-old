<?php 
/***************************************************************************
 *                               sedzia.php
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

$title = "Panel Sêdziego";
require_once("header.php");
if ($gracz['rank'] != 'Sêdzia') {
	print "Nie jeste¶ Sêdzi±.";
	require_once("footer.php");
	exit;
}

print "<form method=post action=sedzia.php?step=add>
	Dodaj ID <input type=text name=aid> jako
	<select name=rank>
	<option value=Member>U¿ytkownik</option>
	<option value=Prawnik>Prawnik</option>
	<option value=£awnik>£awnik</option>
	</select>. <input type=submit value=Dodaj>
	</form>";
	if ($_GET['step'] == 'add') {
		$ranga=mysql_fetch_array(mysql_query("select rank from players where id=$_POST[aid]"));
		if ($ranga == 'Member' || $ranga == '£awnik' || $ranga == 'Sêdzia' || $ranga == 'Prawnik') {
			mysql_query("update players set rank=$_POST[rank] where id=$_POST[aid]");
			print "Doda³e¶ ID $_POST[aid] jako $_POST[rank]";
		}
	}
require_once("footer.php");
?>
