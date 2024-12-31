<META HTTP-EQUIV=Refresh CONTENT="15;url=chatmsgs.php">
<link rel=stylesheet href=style.css>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-2>

<?php
/***************************************************************************
 *                               chatmsgs.php
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



mysql_connect("localhost", "użytkownik", "hasło");
mysql_select_db("nazwa_bazy");
$csel = mysql_query("select * from chat order by id desc limit 15");
while ($chat = mysql_fetch_array($csel)) {
	print "<b>$chat[user]</b>: $chat[chat]<br>";
}
$psel = mysql_query("select rank, id, lpv, user from players where page='Chat'");
$ctime = time();
$on = 0;
$numon = 0;
while ($pl = mysql_fetch_array($psel)) {
	$span = ($ctime - $pl['lpv']);
	if ($span <= 180) {
		if ($pl['rank'] == 'Admin') {
			$on = "[<A href=view.php?view=$pl[id] target=_parent>$pl[user]</a> ($pl[id])] ";
		} else {
			$on = "[<A href=view.php?view=$pl[id] target=_parent>$pl[user]</a> ($pl[id])] ";
		}	
		$numon = ($numon + 1);
	}
}
print "<font class=normal><center><br><br><br>$on<br>";
$numchat = mysql_num_rows(mysql_query("select id from chat"));
print "Jest <b>$numchat</b> wypowiedzi. | <b>$numon</b> graczy na czacie.<br>";

?>
