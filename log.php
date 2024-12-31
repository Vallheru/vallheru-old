<?php
/***************************************************************************
 *                               log.php
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

$title = "Dziennik"; 
require_once("header.php"); 
print "Tu jest spis wydarzeñ zwi±zanych z twoj± postaci±.<br><br>";
mysql_query("update log set unread='T' where unread='F' and owner=$stat[id]");
$lsel = mysql_query("select * from log where owner=$stat[id] order by id desc limit 25");
while ($log = mysql_fetch_array($lsel)) {
	print "<b>Wydarzenie:<br></b>Data:$log[czas]<br>$log[log]<br><br>";
}
print "<a href=log.php?akcja=wyczysc>(Wyczy¶æ dziennik)</a>";
if (!isset($_GET['akcja'])) {
        $_GET['akcja'] = '';
}
if ($_GET['akcja'] == 'wyczysc') {
		print "<br>Dziennik wyczyszczony. (<a href=log.php>od¶wie¿</a>)";
		mysql_query("delete from log where owner=$stat[id]");
}
require_once("footer.php");
?>
