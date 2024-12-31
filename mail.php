<?php 
/***************************************************************************
 *                               mail.php
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

$title = "Poczta"; require_once("header.php"); ?>

<?php
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['read'])) {
     $_GET['read'] = '';
}
if (!isset($_GET['zapisz'])) {
     $_GET['zapisz'] = '';
}
if (!isset($_GET['kasuj'])) {
     $_GET['kasuj'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!$_GET['view'] && !$_GET['read'] && !$_GET['zapisz'] && !$_GET['kasuj']) {
	print "Co chcesz zrobiæ?<br><br>
	- <a href=mail.php?view=inbox>Skrzynka</a><br>
	- <a href=mail.php?view=zapis>Zapisane</a><br>
	- <a href=mail.php?view=write>Napisz</a>";
}

if ($_GET['view'] == 'inbox') {
	print "<table>";
	print "<tr><td width=75><b><u>Od</td><td width=75><b><u>ID</td><td width=100><b><u>Temat</td><td width=50><b><u>Opcje</td></tr>";
	$msel = mysql_query("select * from mail where owner=$stat[id] and zapis='N' order by id desc");
	while ($mail = mysql_fetch_array($msel)) {
		print "<tr><td>$mail[sender]</td><td>$mail[senderid]</td><td>$mail[subject]</td><td>- <a href=mail.php?read=$mail[id]>Czytaj</a></td></tr>";
	}
	print "</table>";
	print "<br>[<a href=mail.php?view=zapis>Zapisane</a>][<a href=mail.php?view=inbox&step=clear>Wyczy¶æ Skrzynkê</a>][<a href=mail.php?view=write>Napisz</a>]";

	if ($_GET['step'] == 'clear') {
		print "<br>Listy usuniête. (<a href=mail.php?view=inbox>od¶wie¿</a>)";
		mysql_query("delete from mail where owner=$stat[id] and zapis='N'");
	}
}
if ($_GET['view'] == 'zapis') {
	print "<table>";
	print "<tr><td width=75><b><u>Od</td><td width=75><b><u>ID</td><td width=100><b><u>Temat</td><td width=50><b><u>Opcje</td></tr>";
	$msel = mysql_query("select * from mail where owner=$stat[id] and zapis='Y' order by id desc");
	while ($mail = mysql_fetch_array($msel)) {
		print "<tr><td>$mail[sender]</td><td>$mail[senderid]</td><td>$mail[subject]</td><td>- <a href=mail.php?read=$mail[id]>Czytaj</a></td></tr>";
	}
	print "</table>";
	print "<br>[<a href=mail.php?view=inbox>Skrzynka</a>][<a href=mail.php?view=zapis&step=clear>Wykasuj zapisane listy</a>][<a href=mail.php?view=write>Napisz</a>]";

	if ($_GET['step'] == 'clear') {
		print "<br>Listy usuniête. (<a href=mail.php?view=zapis>od¶wie¿</a>)";
		mysql_query("delete from mail where owner=$stat[id] nad zapis='Y'");
	}
}

if ($_GET['view'] == 'write') {
        if (!$to) {
           $to = '';
        }
        if (!$re) {
           $re = '';
        }
	print "[<a href=mail.php?view=inbox>Skrzynka</a>]<br><br>";
	print "<table>";
	print "<form method=post action=mail.php?view=write&step=send>";
	print "<tr><td>Do (ID Numer):</td><td><input type=text name=to value=".$to."></td></tr>";
	print "<tr><td>Temat:</td><td><input type=text name=subject size=55 value=".$re."></td></tr>";
	print "<tr><td valign=top>Tre¶æ:</td><td><textarea name=body rows=13 cols=55></textarea></td></tr>";
	print "<tr><td></td><td align=center><input type=submit value=Wy¶lij></td></tr>";
	print "</form></table>";

	if ($_GET['step'] == 'send') {
		if (empty ($to) || empty ($body)) {
			print "Wype³nij wszystkie pola.";
			require_once("footer.php");
			exit;
		}
		if (empty ($subject)) {
			$subject = "Brak";
		}
		$rec = mysql_fetch_array(mysql_query("select * from players where id=$to"));
		if (empty ($rec[id])) {
			print "Nie ma takiego gracza.";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $to)) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$subject = strip_tags($subject);
		$body = strip_tags($body);
		mysql_query("insert into mail (sender,senderid,owner,subject,body) values('$gracz[user]','$stat[id]',$to,'$subject','$body')") or die("Nie mogê wys³aæ listu.");
		$czas = date("y-m-d H:i:s");
		mysql_query("insert into log (owner, log, czas) values($to, '<b>$gracz[user]</b> wys³a³ ci wiadomo¶æ.','$czas')") or die("Nie mogê dodaæ do dziennika.");
		print "Wys³a³e¶ wiadomo¶æ do $rec[user].";
	}
}

if ($_GET['read']) {
	if (!ereg("^[1-9][0-9]*$", $read)) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$mail = mysql_fetch_array(mysql_query("select * from mail where id=$read"));
	if (empty ($mail[id])) {
		print "Nie ta wiadomo¶æ.";
		require_once("footer.php");
		exit;
	}
	if ($mail[owner] != $stat[id]) {
		print "To nie twój list.";
		require_once("footer.php");
		exit;
	}
	mysql_query("update mail set unread='T' where id=$mail[id]");
	print "<b>$mail[sender]</b> napisa³(a)... \"$mail[body]\".<br><br>[<a href=mail.php?view=inbox>Skrzynka</a>][<a href=mail.php?zapisz=$mail[id]>Zapisz</a>][<a href=mail.php?kasuj=$mail[id]>Skasuj</a>][<a href=mail.php?view=write>Napisz</a>][<a href=mail.php?view=write&to=$mail[senderid]&re=Odp:$mail[subject]>Odpisz</a>]";
}
if ($_GET['zapisz']) {
	if (!ereg("^[1-9][0-9]*$", $zapisz)) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$mail = mysql_fetch_array(mysql_query("select id, owner from mail where id=$zapisz"));
	if (empty ($mail[id])) {
		print "Nie ta wiadomo¶æ.";
		require_once("footer.php");
		exit;
	}
	if ($mail[owner] != $stat[id]) {
		print "To nie twój list.";
		require_once("footer.php");
		exit;
	}
	mysql_query("update mail set zapis='Y' where id=$zapisz");
	print "<br>Zapisano list. (<a href=mail.php>Wróæ</a>)";
}
if ($_GET['kasuj']) {
	if (!ereg("^[1-9][0-9]*$", $kasuj)) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$mail = mysql_fetch_array(mysql_query("select id, owner from mail where id=$kasuj"));
	if (empty ($mail[id])) {
		print "Nie ta wiadomo¶æ.";
		require_once("footer.php");
		exit;
	}
	if ($mail[owner] != $stat[id]) {
		print "To nie twój list.";
		require_once("footer.php");
		exit;
	}
	mysql_query("delete from mail where id=$kasuj");
	print "<br>Usuniêto list. (<a href=mail.php>Wróæ</a>)";
}
?>

<?php require_once("footer.php"); ?>
