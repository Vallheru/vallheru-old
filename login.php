<?php
/***************************************************************************
 *                               login.php
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

require_once("head.php");
if (!$_POST['email'] || !$_POST['pass']) {
	print "Proszê wype³niæ wszystkie pola.";
	print "<table>";
	require_once("foot.php");
	exit;
}
$logres = mysql_num_rows(mysql_query("select logins, email, pass from players where email='".$_POST['email']."' and pass=MD5('".$_POST['pass']."')"));
if ($logres <= 0) {
	print "B³±d przy logowaniu. Je¿eli nie jeste¶ zarejestrowany, zarejestruj siê. W przeciwnym wypadku, sprawd¼ pisowniê i spróbuj jeszcze raz.";
	require_once("foot.php");
	exit;
} else {
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['pass'] = $_POST['pass'];
	mysql_query("update players set logins=logins+1 where email='".$_POST['email']."'");
	print "&nbsp;<br>Witaj ponownie. Proszê sprawd¼ wie¶ci <a href=updates.php>tutaj</a> aby kontynuowaæ...";
print "<table>";
}
require_once("foot.php");
?>
