<?php require_once("head.php");
/***************************************************************************
 *                               register.php
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

if (!$_GET['action']) {
	print "Zarejestruj siê w grze. To nic nie kosztuje. Po rejestracji na twoje konto email zostanie wys³any specjalny link aktywacyjny. <b>Uwaga!</b> Je¿eli korzystasz z konta na Wirtualnej Polsce lub Tlenie - sprawd¼ czy nie masz ustawionego filtru anty-spamowego. Poniewa¿ mail jest wysy³any programowo nie rêcznie, jest traktowany jako spam i mo¿e nigdy nie doj¶æ do ciebie!<br>";
	$nump = mysql_num_rows(mysql_query("select * from players"));
	print "Mamy obecnie <b>$nump</b> zarejestrowanych graczy.";
	print "<form method=post action=register.php?action=register>
	<table>
	<tr><td>Pseudonim:</td><td><input type=text name=user></td></tr>
	<tr><td>Email:</td><td><input type=text name=email></td></tr>
	<tr><td>Potwierd¼ email:</td><td><input type=text name=vemail></td></tr>
	<tr><td>Has³o:</td><td><input type=text name=pass></td></tr>";
	print "<tr><td>ID Polecaj±cego:</td><td><input type=text name=ref readonly value=".$_GET['ref']."> <i>Je¿eli nie jeste¶ czyim¶ poleconym, to pole jest puste.</i></td></tr>";
	print "<tr><td colspan=2 align=center><input type=submit value=Zarejestruj></td></tr>
</form>";
}
if ($_GET['action'] == 'register') {
	if (!$_POST['user'] || !$_POST['email'] || !$_POST['vemail'] || !$_POST['pass'] ) {
		print "Musisz wype³niæ wszystkie pola.";
		require_once("foot.php");
		exit;
	}
	$dupe1 = mysql_num_rows(mysql_query("select * from players where user='".$_POST['user']."'"));
	if ($dupe1 > 0) {
		print "Kto¶ ju¿ wybra³ taki pseudonim.";
		require_once("foot.php");
		exit;
	}
	$dupe2 = mysql_num_rows(mysql_query("select * from players where email='".$_POST['email']."'"));
	if ($dupe2 > 0) {
		print "Kto¶ ju¿ posiada taki adres mailowy.";
		require_once("foot.php");
		exit;
	}
	if ($_POST['email'] != $_POST['vemail']) {
		print "Z³y adres email.";
		require_once("foot.php");
		exit;
	}
	if (!$ref) {
		$ref = 0;
	}
	$ref = intval($ref); 
	$user = strip_tags($user);
	$email = strip_tags($email);
	$pass = strip_tags($pass);
	$aktw = rand(1,10000000);
	$data = date("y-m-d");
	$ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	$message = "Witaj w $gamename. Twój link aktywacyjny to:  http://www.uc.h4c.pl/vallheru/aktywacja.php?kod=$aktw  ¯yczê mi³ej zabawy w $gamename. Thindil";
	mysql_query("insert into aktywacja (user, email, pass, refs, aktyw, data, ip) values('".$_POST['user']."','".$_POST['email']."',MD5('".$_POST['pass']."'),".$ref.",".$aktw.",'".$data."','".$ip."')") or die("Nie mogê zarejestrowaæ.");
	mail($_POST['email'], $gamename, $message,
     "From: rejestracja@vallheru.etak.pl\r\n"
    ."Reply-To: rejestracja@vallheru.etak.pl\r\n"
    ."X-Mailer: PHP/" . phpversion()) or die("nie mogê wys³aæ maila");
	print "Jeste¶ ju¿ zarejestrowany. Sprawd¼ swoj± skrzynkê pocztow±.";
}

require_once("foot.php");
?>
