<?php 
/***************************************************************************
 *                               index.php
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

print "<b>Witam</b></td></tr><td align=justify>Co to jest Vallheru? Jest to tekstowy RPG dla wielu graczy rozgrywany turowo. Mo�esz tutaj walczy� z potworami, innymi graczami, zarz�dza� w�asn� stra�nic� czy te� zarabia� pieni�dze na w�asnej kopalni b�d� wraz z innymi graczami stworzy� w�asny klan. Nie spodziewaj si� tutaj osza�amiaj�cej grafiki - to gra bardziej na wyobra�ni�. Aby w ni� gra� nie trzeba posiada� pot�nego sprz�tu czy te� �ci�ga� z sieci jaki� program�w. Je�eli zainteresowa�o Ci� to, co do tej pory napisa�em, zarejestruj si� w grze i do��cz do nas. Zanim jednak to zrobisz, przeczytaj <a href=zasady.php>Kodeks Vallheru</a>(czyli zasady obowi�zuj�ce w grze - aktualizacja 9.04.2004).<br><br>Thindil <a href=mailto:webmaster@>webmaster@</a> <br>&nbsp;<br><br>

<table cellpadding=0 cellspacing=0 width=700>

<form method=post action=login.php>

<tr><td width=67 width=10>Email:</td><td width=145><input type=text name=email></td>

            <td width=486 align=right>Obecny czas:";
$date = date("H:i:s"); 
print "$date </td>

          </tr>

<tr><td with=10>Has�o:</td><td><input type=password name=pass></td>

<td width=486 align=right>";
$nump = mysql_num_rows(mysql_query("select id from players"));
$psel = mysql_query("select lpv from players");


print "Mamy <b>$nump</b> zarejestrowanych graczy.";

          print"</tr>

<tr><td colspan=2 align=center><input type=submit value=Zaloguj></td>

            <td width=486 align=right>";


				$ctime = time();

				$numo = 0;

				while ($pl = mysql_fetch_array($psel)) {

					$span = ($ctime - $pl['lpv']);

					if ($span <= 180) {

						$numo = ($numo + 1);

					}

				}

				print "<b>$numo</b> graczy w grze.<br>";

				?>



          </td></tr>

</form></td></tr><tr><td colspan=2 align=center>

<?php

print "<br><a href=haslo.php>Zapomnia�em has�a</a>";

require_once("foot.php");

?>
