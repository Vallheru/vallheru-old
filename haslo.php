<?php 
/***************************************************************************
 *                               haslo.php
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
if (!$_GET['akcja']) {
	print "Je�eli zapomnia�e� has�a do swojej postaci, wpisz tutaj sw�j adres email. Jednak ze wzgl�du na to, �e has�a w bazie danych s� kodowane, niemo�liwe jest odzyskanie twojego starego has�a. Dlatego dostaniesz nowe has�o. Je�eli twoje konto istnieje, informacja o ha�le zostanie wys�ana pod podany mail. <b>Uwaga!</b> je�eli masz na swoim koncie w��czony filtr anty-spamowy, wy��cz go przed wys�aniem maila, inaczej informacja o ha�le nie dojdzie do ciebie!</tr>
	<form method=post action=haslo.php?akcja=haslo>
	<table>
	<tr><td>Email:</td><td><input type=text name=email></td></tr>
	<tr><td colspan=2 align=center><input type=submit value=Wy�lij></td></tr>
	</form>";
}
if ($_GET['akcja'] == 'haslo') {
	if (!$_POST['email']) {
		print "Podaj mail.";
		require_once("foot.php");
		exit;
	}
	$dupe1 = mysql_num_rows(mysql_query("select id from players where email='$_POST[email]'"));
	if ($dupe1 == 0) {
		print "Nie ma takiego maila w bazie danych.";
		require_once("foot.php");
		exit;
	}
	$new_pass = substr(md5(uniqid(rand(), true)), 3, 9);
	mysql_query("UPDATE players SET pass = MD5('".$new_pass."') where email='".$_POST['email']."'");echo(mysql_error());
	mail("$_POST[email]", "$gamename", "Dosta�e� ten mail, poniewa� chcia�e� zmieni� has�o w $gamename. Twoje nowe has�o do konta to \n".$new_pass."\n Zmie� je jak tylko wejdziesz do gry. �ycz� mi�ej zabawy w $gamename. Thindil",
     "From: webmaster@vallheru.etak.pl\r\n"
    ."Reply-To: webmaster@vallheru.etak.pl\r\n"
    ."X-Mailer: PHP/" . phpversion()) or die("nie mog� wys�a� maila");

	print "Mail z has�em zosta� wys�any na podany adres e-mail";
}
require_once("foot.php");
?>
