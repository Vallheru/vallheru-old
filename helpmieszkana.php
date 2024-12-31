<?php 
/***************************************************************************
 *                               helpmieszkana.php
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

$title = "Pomoc"; require_once("header.php"); ?>

<?php
if (!isset($_GET['help'])) {
        $_GET['help'] = '';
}
if (!$_GET['help']) {
	print "W <b>Dzielnicy mieszkalnej</b> znajdziesz r�ne interesuj�ce informacje na temat os�b graj�cych w Valleru. Je�eli chcesz si� dowiedzie� wi�cej o jakiej� lokacji, kliknij na jej nazwie.<ul>
	<li><a href=helpmieszkana.php?help=spis>Spis mieszka�c�w</a>
	<li><a href=helpmieszkana.php?help=posagi>Pos�gi</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'spis') {
	print "W <b>Spisie mieszka�c�w</b> znajdziesz list� wszystkich os�b graj�cych w Vallheru. Podane s� tutaj numer gracza, imi�, ranga (admin, staff, member) oraz poziom. Je�eli chcesz si� dowiedzie� czego� wi�cej o jakim� graczu, kliknij na jego imi�. Pojawi� si� wtedy dodatkowe informacje: ranga, ostatnio widziany - gdzie ostatnio przebywa�, wiek (wiek postaci w dniach), poziom, status (�ywy/martwy), klan do kt�rego nale�y, maksymalne P� (maksymalne zdrowie), wyniki (bitwy z innymi graczami - pierwsza liczba to wygrane, druga przegrane), ostatnio zabi� (ostatnio zabity gracz przez t� osob�, ostatnio zabity przez (kto go ostatnio zabi�), poleceni (ile os�b zapisa�o si� do gry z jego linku polecaj�cego. Wi�cej o poeconych w opisie <i>Poleceni</i>), Profil (dodatkowe informacje na temat gracza). Na dole znajduje si� opcja <b>Atak</b> - klikaj�c na ni� przyst�pujesz do ataku na danego gracza.";
} elseif ($_GET['help'] == 'posagi') {
	print "W dziale <b>Pos�gi</b> mo�esz zobaczy� list� najlepszych w jakiej� dziedzinie graczy. S� tutaj najlepsi w: poziomie, kowalstwie, najwi�kszej ilo�ci sztuk z�ota (przy sobie lub w banku), najwi�kszej ilo�ci mithrilu, najwi�kszej ilo�ci maksymalnej energii, liczbie zwyci�stw, liczbie pora�ek, sile oraz zr�czno�ci. Obok imienia podana jest warto��. W ka�dej tabeli znajduje si� 5 najlepszych graczy w danej dziedzinie.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpmieszkana.php>Powr�t</a>)";
}

require_once("footer.php");
?>
