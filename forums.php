<?php
/***************************************************************************
 *                               forums.php
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

 $title = "Forum"; require_once("header.php"); ?>

<?php
// inicjalizacja zmiennych
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
// Lista kategorii
if ($_GET['view'] == 'categories') {
        print "<table><tr><td><b><u>Kategoria</u></b></td><td><b><u>Tematów</u></b></td></tr>";
	$tsel = mysql_query("select * from categories order by id asc");
	while ($cat = mysql_fetch_array($tsel)) {
		$topics = mysql_num_rows(mysql_query("select * from topics where cat_id=$cat[id]"));
		print "<tr><td><a href=forums.php?topics=$cat[id]><u>$cat[name]<u></a></td><td><a href=forums.php?topics=$cat[id]>$topics</a></td></tr><tr><td><a href=forums.php?topics=$cat[id]><i>$cat[desc]</i></a></td></tr>";
		print "<tr><td colspan=2><hr></td></tr>";
	}
	print "</table>";
}
// The Topic List
if (isset($_GET['topics'])) {
	print "<table><tr><td width=150><u><b>Temat</td><td width=100><u><b>Autor</td><td width=50><b><u>Odpowiedzi</td></tr>";

	$tsel = mysql_query("select * from topics where cat_id=$_GET[topics] order by id asc");
	while ($topic = mysql_fetch_array($tsel)) {
		$replies = mysql_num_rows(mysql_query("select * from replies where topic_id=$topic[id]"));
		print "<tr><td><a href=forums.php?topic=$topic[id]>$topic[topic]</a></td><td>$topic[starter]</td><td>$replies</td></tr>";
	}

	print "</table>";
	print "</center>";
        print "<form method=post action=forums.php?action=addtopic>";
	print "Dodaj temat:<br><input type=text name=title2 value=Temat size=40><br>
        <textarea name=body cols=40 rows=10>Tekst</textarea><br>
        <input type=hidden name=catid value=$_GET[topics]>
        <input type=submit value=\"Dodaj Temat\"></form><br><br>";
       	print "<a href=forums.php?view=categories>Wróæ</a> do listy kategorii.";

}

// View Topic
if (isset($_GET['topic'])) {
	$topicinfo = mysql_fetch_array(mysql_query("select * from topics where id=$_GET[topic]"));
	if (empty ($topicinfo['id'])) {
		print "Nie ten temat.";
		require_once("footer.php");
		exit;
	}
	print "<center><br><table class=td width=98% cellpadding=0 cellspacing=0><tr><td style=\"border-bottom: solid black 1px;\" bgcolor=black><b>$topicinfo[topic]</b> napisany przez $topicinfo[starter] ";
	if ($topicinfo['gracz'] != 0) {
		print "ID $topicinfo[gracz] ";
	}
	print "(<a href=forums.php?topics=$topicinfo[cat_id]>wróæ</a>)";
	if ($gracz['rank'] == 'Admin' || $gracz['rank'] == 'Staff') {
		print " (<a href=forums.php?kasuj1=$topicinfo[id]>Skasuj</a>)";
	}
	print "</td></tr>";
	print "<tr><td>$topicinfo[body]</td></tr></table><br>";

	$rsel = mysql_query("select * from replies where topic_id=$topicinfo[id] order by id asc");
	while ($reply = mysql_fetch_array($rsel)) {
		print "<center><table class=td width=98% cellpadding=0 cellspacing=0><tr><td bgcolor=black style=\"border-bottom: solid black 1px;\"><b>$reply[starter]</b> ";
		if ($topicinfo['gracz'] != 0) {
			print "ID $reply[gracz] ";
		}
		print "napisa³(a)... (<a href=forums.php?topics=$topicinfo[cat_id]>wróæ</a>) ";
		if ($gracz['rank'] == 'Admin' || $gracz['rank'] == 'Staff') {
			print "(<a href=forums.php?kasuj=$reply[id]>Skasuj</a>)";
		}
		print "</td></tr>";
		print "<tr><td>$reply[body]</td></tr></table><br>";
	}
	print "</center><form method=post action=forums.php?reply=$topicinfo[id]>";
	print "Odpowiedz:<br><textarea name=rep cols=40 rows=10>Tekst</textarea><br><input type=submit value=\"Odpowiedz\"></form>";
}

// Add Topic
if ($_GET['action'] == 'addtopic') {
	if (empty ($_POST['title2']) || empty ($_POST['body'])) {
		print "Wype³nij wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	$_POST['title2'] = strip_tags($_POST['title2']);
	$_POST['body'] = strip_tags($_POST['body']);
	mysql_query("insert into topics (topic, body, starter, gracz, cat_id) values('$_POST[title2]', '$_POST[body]', '$gracz[user]',$stat[id],$_POST[catid])") or die("Could not add topic.");
	print "Temat dodany. Kliknij <a href=forums.php?topics=$_POST[catid]>tutaj</a> aby wróciæ do listy tematów w danej kategorii.";
}

// Add Reply
if (isset($_GET['reply'])) {
$exists = mysql_num_rows(mysql_query("select * from topics where id=$_GET[reply]"));
	if ($exists <= 0) {
		print "Nie ten temat.";
		require_once("footer.php");
		exit;
	}
	if (empty ($_POST['rep'])) {
		print "Musisz wype³niæ wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	$_POST['rep'] = strip_tags($_POST['rep']);
mysql_query("insert into replies (starter, topic_id, body, gracz) values('$gracz[user]', $_GET[reply], '$_POST[rep]',$stat[id])") or die("Could not add reply.");
print "Odpowied¼ dodana. Kliknij <a href=forums.php?topic=$_GET[reply]>tutaj</a>.";
}

//Kasowanie Postu
if (isset($_GET['kasuj'])) {
        $tid = mysql_fetch_array(mysql_query("select topic_id from replies where id=$_GET[kasuj]"));
	mysql_query("delete from replies where id=$_GET[kasuj]");
	print "Post wykasowany <a href=forums.php?topic=$tid[topic_id]>wroæ</a>";
}

// Kasowanie Tematu
if (isset($_GET['kasuj1'])) {
        $cid = mysql_fetch_array(mysql_query("select cat_id from topics where id=$_GET[kasuj1]"));
	mysql_query("delete from replies where topic_id=$_GET[kasuj1]");
	mysql_query("delete from topics where id=$_GET[kasuj1]");
	print "Temat wykasowany <a href=forums.php?topics=$cid[cat_id]>wroæ</a>";
}
?>
<?php
require_once("footer.php");
?>
