<?php 
/***************************************************************************
 *                               updates.php
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

$title = "Wie¶ci"; require_once("header.php"); ?>

<?php
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if ($_GET['view'] !='all') {
	$upd = mysql_fetch_array(mysql_query("select * from updates order by id desc limit 1"));
	print "<b>$upd[title]</b> napisany przez <b>$upd[starter]</b>...<br><br>\"$upd[updates]\".";
	print "<br><br>(<a href=updates.php?view=all>ostatnie 10 wie¶ci</a>)";
} else {
	$usel = mysql_query("select * from updates order by id desc limit 10");
	while ($upd = mysql_fetch_array($usel)) {
		print "<b>$upd[title]</b> napisana przez <b>$upd[starter]</b>... \"$upd[updates]\"<br><br>";
	}
}

require_once("footer.php");
?>
