<?php 
/***************************************************************************
 *                               online.php
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

$title = "Graczy w grze"; require_once("header.php"); ?>

<?php
$ctime = time();
$osel = mysql_query("select lpv, id, user, rank from players");
while ($online = mysql_fetch_array($osel)) {
	$span = ($ctime - $online['lpv']);
	if ($span <= 180) {
                if ($online['rank'] == 'Admin') {
			print "<img src=\"images/admin.gif\" ALT=\"Admin!\"><A href=\"view.php?view=".$online['id']."\">".$online['user']."</a> (".$online['id'].")<br>";
		} else {
			print "<A href=\"view.php?view=".$online['id']."\">".$online['user']."</a> (".$online['id'].")<br>";
		}
	}
}
?>

<?php require_once("footer.php"); ?>
