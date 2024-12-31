<?php
/***************************************************************************
 *                               chat.php
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

$title = "Karczma"; require_once("header.php"); mysql_query("update players set page='Chat' where id=$stat[id]");
?>

<table width=100%>
<form method=post action=chat.php?action=chat>
<tr><td colspan=2 align=center>
[<a href=chat.php>od¶wie¿</a>] <input type=text name=msg size=55> <input type=submit value=Wy¶lij>
</form>

<?php
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if ($_GET['action'] == 'chat') {
	if ($_POST['msg']) {
		if ($gracz['rank'] == 'Admin') {
			$starter = "<font color=0066cc>$gracz[user]</font>";
		} else {
			$starter = "$gracz[user]";
		}
		$test = mysql_query("select * from chat_config");
		while ($czat = mysql_fetch_array($test)) {
			if ($stat[id] == $czat[gracz]) {
				print "Nie mo¿esz pisaæ wiadomo¶ci na czacie";
				require_once("footer.php");
				exit;
			}
		}
		mysql_query("insert into chat (user, chat) values('$starter', '".strip_tags($_POST['msg'])."')");
	}
}
?>

</td></tr>
<tr><td width=400 valign=top>
<u><b>Karczma</u></b><br><br>

<iframe src=chatmsgs.php width="105%" height=306 id=ifr name=ifr frameborder=0></iframe>

</td><td width=100 valign=top>
&nbsp;</td></tr>
<tr><td colspan=2 align=center>

<?php
$numchat = mysql_num_rows(mysql_query("select id from chat"));
print "Jest <b>$numchat</b> wypowiedzi.";
?>

</td></tr>
</table>

<?php require_once("footer.php"); ?>
