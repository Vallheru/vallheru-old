<?php 
/***************************************************************************
 *                               helpwojenne.php
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
	print "Wojenne Pola to miejsce, gdzie znajdziesz lokacje zwi�zane z walk�. Kliknij na nazw� miejsca aby otrzyma� wi�cej wiadomo�ci na jego temat.<ul>
	<li><a href=helpwojenne.php?help=arena>Arena Walk</a>
	<li><a href=helpwojenne.php?help=zbrojmistrz>Zbrojmistrz</a>
	<li><a href=helpwojenne.php?help=platnerz>P�atnerz</a>
	<li><a href=helpwojenne.php?help=straznica>Stra�nica</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'arena') {
	print "Arena Walk, to miejsce, w kt�rym mo�esz walczy� z innymi graczami oraz �wiczy� swoje umiej�tno�ci na potworach. Dost�pne s� tutaj 3 opcje. <b>Sortuj wed�ug poziomu</b> - mo�esz wybra�, z kt�rego poziomu graczy chcesz widzie�. <b>Poka� wszystkich �ywych graczy</b> - tutaj poka�e ci wszystkich �ywych graczy, b�d�cych na tym samym poziomie co ty. Po klikni�ciu, obie opcje wygl�daj� tak samo - pojawia si� tabelka z numerem (ID), imieniem, rang�, klanem gracza oraz dost�pnymi opcjami (w tym wypadku atakuj). Je�eli wybierzesz opcj� <b>atakuj</b> atomatycznie zaczniesz walk� z innym graczem i albo j� wygrasz, albo przegrasz (wi�cej na temat walki znajdziesz w rozdziale <i><a href=help.php?help=battle>Walka</a></i>). Pami�taj - maksymalna r�nica poziom�w miedzy tob� a graczem kt�rego chcesz zaatakowa� nie mo�e przekracza� dw�ch poziom�w. Aby zaatakowa� jakiego� gracza, nie musi on by� obecny akurat w grze, za to musi by� �ywy. Trzecia opcja <b>Trenuj z potworami</b> jest opcj� treningow�. Walcz�c z potworami mo�esz zdobywa� <b>Punkty Do�wiadczenia</b> oraz <b>Z�oto</b>. Je�eli przegrasz walk� z potworem, nie tracisz �ycia, ani z�ota. Tak wi�c jest to najbezpieczniejszy spos�b na zdobywanie do�wiadczenia. Tabela jaka pojawia si� tutaj jest bardzo podobna do tej z poprzednich opcji, ale tutaj znajduje si� spis wszelkich dost�pnych potwor�w (je�eli chcesz, to na 1 poziomie mo�esz zaatakowa� potwora na 5 poziomie).";
} elseif ($_GET['help'] == 'zbrojmistrz') {
	print "U Zbrojmistrza mo�esz kupi� wszelkie dost�pne zbroje jakie s� w grze. Wszystkie wy�wietlone s� w tabeli, podana jest ich nazwa, efekt (ile daje obrony), cena, wymagany poziom (poziom jaki musisz posiada�, aby� m�g� u�ywa� danej zbroi) oraz opcje (czyli zakup danej zbroi). Aby zakupi� jak�kolwiek zbroj�, musisz mie� odpowiedni� ilo�� sztuk z�ota przy sobie (pieni�dze b�d�ce w banku nie s� uwzgl�dniane).";
} elseif ($_GET['help'] == 'platnerz') {
	print "U P�atnerza mo�esz kupi� wszelkie dost�pne uzbrojenie jakie jest w grze. Ca�e uzbrojenie wy�wietlone jest w tabeli, podana jest ich nazwa, efekt (ile dodaje do obra�e�), cena, wymagany poziom (poziom jaki musisz posiada�, aby� m�g� u�ywa� danej broni) oraz opcje (czyli zakup danej broni). Aby zakupi� jakiekolwiek uzbrojenie, musisz mie� odpowiedni� ilo�� sztuk z�ota przy sobie (pieni�dze b�d�ce w banku nie s� uwzgl�dniane).";
} elseif ($_GET['help'] == 'straznica') {
	print "Stra�nica to mini gra strategiczna. Aby w ni� zagra�, musisz wykupi� bilet za 500 sztuk z�ota. Kiedy to zrobisz, b�dziesz mia� dost�p do specjalnego menu. Opcja <b>Moja Stra�nica</b> zawiera og�lne informacje na temat twojej stra�nicy, posiadanych kopalni oraz �o�nierzy i fortyfikacji. W opcji <b>Kopalnie</b> mo�esz wydobywa� minera�y, kupowa� nowe kopalnie, itp. W opcji <b>Sklep w Stra�nicy</b> mo�esz kupowa� �o�nierzy, fortyfikacje oraz powi�ksza� swoj� stra�nic�. Opcja <b>Atakuj Stra�nic�</b> pozwala ci zaatakowa� stra�nic� innego gracza. Dok�adny opis gry znajduje si� w opcji <b>Instrukcja Stra�nicy</b>";
} 

if ($_GET['help']) {
	print "<br><br>(<a href=helpwojenne.php>Powr�t</a>)";
}

require_once("footer.php");
?>
