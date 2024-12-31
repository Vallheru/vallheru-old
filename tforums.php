<?php 
/***************************************************************************
 *                               tforums.php
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

$title = "Forum klanu"; require_once("header.php"); ?>

<?php
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
// The Topic List
if ($_GET['view'] == 'topics') {
	print "<table><tr><td width=150><u><b>Temat</td><td width=100><u><b>Autor</td><td width=50><b><u>Odpowiedzi</td></tr>";

	$tsel = mysql_query("select * from tribe_topics where tribe=$gracz[tribe] order by id asc");
	while ($topic = mysql_fetch_array($tsel)) {
		$replies = mysql_num_rows(mysql_query("select * from tribe_replies where topic_id=$topic[id]"));
		print "<tr><td><a href=tforums.php?topic=$topic[id]>$topic[topic]</a></td><td>$topic[starter]</td><td>$replies</td></tr>";
	}

	print "</table>";
	print "</center><form method=post action=tforums.php?action=addtopic>";
	print "Dodaj temat:<br><input type=text name=title2 value=Temat size=40><br><textarea name=body cols=40 rows=10>Tekst</textarea><br><input type=submit value=\"Dodaj Temat\"></form>";
}

// View Topic
if (isset($_GET['topic'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['topic'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$klan = mysql_fetch_array(mysql_query("select * from tribes where id=$gracz[tribe]"));
	$topicinfo = mysql_fetch_array(mysql_query("select * from tribe_topics where id=$_GET[topic] and tribe=$gracz[tribe]"));
	if (empty ($topicinfo['id'])) {
		print "Nie ma tematu.";
		require_once("footer.php");
		exit;
	}
	print "<center><br><table class=td width=98% cellpadding=0 cellspacing=0><tr><td style=\"border-bottom: solid black 1px;\"><b>$topicinfo[topic]</b> napisany przez $topicinfo[starter] (<a href=tforums.php?view=topics>wróæ</a>) ";
	if ($stat['id'] == $klan['owner']) {
		print " (<a href=tforums.php?kasuj1=$topicinfo[id]>Skasuj</a>)";
	}
	print "</td></tr>";
	print "<tr><td>$topicinfo[body]</td></tr></table><br>";

	$rsel = mysql_query("select * from tribe_replies where topic_id=$topicinfo[id] order by id asc");
	while ($reply = mysql_fetch_array($rsel)) {
		print "<center><table class=td width=98% cellpadding=0 cellspacing=0><tr><td style=\"border-bottom: solid black 1px;\"><b>$reply[starter]</b> powiedzia³... (<a href=tforums.php?view=topics>wróæ</a>) ";
		if ($stat['id'] == $klan['owner']) {
			print "(<a href=tforums.php?kasuj=$reply[id]>Skasuj</a>)";
		}
		print "</td></tr>";
		print "<tr><td>$reply[body]</td></tr></table><br>";
	}

	print "</center><form method=post action=tforums.php?reply=$topicinfo[id]>";
	print "Dodaj Odpowied¼:<br><textarea name=rep cols=40 rows=10>Tekst</textarea><br><input type=submit value=\"Dodaj Odpowied¼\"></form>";
}

// Add Topic
if ($_GET['action'] == 'addtopic') {
	if (empty ($_POST['title2']) || empty ($_POST['body'])) {
		print "Musisz wype³niæ wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	$_POST['title2'] = strip_tags($_POST['title2']);
	$_POST['body'] = strip_tags($_POST['body']);
	mysql_query("insert into tribe_topics (topic, body, starter, tribe) values('$_POST[title2]', '$_POST[body]', '$gracz[user]', '$gracz[tribe]')") or die("Could not add topic.");
	print "Temat dodany. Kliknij <a href=tforums.php?view=topics>tutaj</a> aby wróciæ do listy tematów.";
}

// Add Reply
if (isset($_GET['reply'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['reply'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$test = mysql_fetch_array(mysql_query("select tribe from tribe_topics where id=$_GET[reply] and tribe=$gracz[tribe]"));
	if (!$test) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
$exists = mysql_num_rows(mysql_query("select * from tribe_topics where id=$_GET[reply]"));
	if ($exists <= 0) {
		print "Nie ma tematu.";
		require_once("footer.php");
		exit;
	}
	if (empty ($_POST['rep'])) {
		print "Musisz wype³niæ wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	$_POST['rep'] = strip_tags($_POST['rep']);
mysql_query("insert into tribe_replies (starter, topic_id, body) values('$gracz[user]', $_GET[reply], '$_POST[rep]')") or die("Could not add reply.");
print "Odpowied¼ dodana. Kliknij <a href=tforums.php?topic=$_GET[reply]>tutaj</a>.";
}

//Kasowanie Postu
if (isset($_GET['kasuj'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['kasuj'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$test = mysql_fetch_array(mysql_query("select topic_id from tribe_replies where id=$_GET[kasuj]"));
	if ($test) {
		$test2 = mysql_fetch_array(mysql_query("select id from tribe_topics where id=$test[topic_id] and tribe=$gracz[tribe]"));
		if (!$test2) {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		} else {
			mysql_query("delete from tribe_replies where id=$_GET[kasuj]");
			print "Post wykasowany <a href=tforums.php?view=topics>wroæ</a>";
		}
	}
}

// Kasowanie Tematu
if (isset($_GET['kasuj1'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['kasuj1'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$test = mysql_fetch_array(mysql_query("select id from tribe_topics where id=$_GET[kasuj1] and tribe=$gracz[tribe]"));
	if (!$test) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	} else {
		mysql_query("delete from tribe_replies where topic_id=$_GET[kasuj1]");
		mysql_query("delete from tribe_topics where id=$_GET[kasuj1]");
		print "Temat wykasowany <a href=tforums.php?view=topics>wroæ</a>";
	}
}

require_once("footer.php");
?>
