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
	print "Wojenne Pola to miejsce, gdzie znajdziesz lokacje zwi±zane z walk±. Kliknij na nazwê miejsca aby otrzymaæ wiêcej wiadomo¶ci na jego temat.<ul>
	<li><a href=helpwojenne.php?help=arena>Arena Walk</a>
	<li><a href=helpwojenne.php?help=zbrojmistrz>Zbrojmistrz</a>
	<li><a href=helpwojenne.php?help=platnerz>P³atnerz</a>
	<li><a href=helpwojenne.php?help=straznica>Stra¿nica</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'arena') {
	print "Arena Walk, to miejsce, w którym mo¿esz walczyæ z innymi graczami oraz æwiczyæ swoje umiejêtno¶ci na potworach. Dostêpne s± tutaj 3 opcje. <b>Sortuj wed³ug poziomu</b> - mo¿esz wybraæ, z którego poziomu graczy chcesz widzieæ. <b>Poka¿ wszystkich ¿ywych graczy</b> - tutaj poka¿e ci wszystkich ¿ywych graczy, bêd±cych na tym samym poziomie co ty. Po klikniêciu, obie opcje wygl±daj± tak samo - pojawia siê tabelka z numerem (ID), imieniem, rang±, klanem gracza oraz dostêpnymi opcjami (w tym wypadku atakuj). Je¿eli wybierzesz opcjê <b>atakuj</b> atomatycznie zaczniesz walkê z innym graczem i albo j± wygrasz, albo przegrasz (wiêcej na temat walki znajdziesz w rozdziale <i><a href=help.php?help=battle>Walka</a></i>). Pamiêtaj - maksymalna ró¿nica poziomów miedzy tob± a graczem którego chcesz zaatakowaæ nie mo¿e przekraczaæ dwóch poziomów. Aby zaatakowaæ jakiego¶ gracza, nie musi on byæ obecny akurat w grze, za to musi byæ ¿ywy. Trzecia opcja <b>Trenuj z potworami</b> jest opcj± treningow±. Walcz±c z potworami mo¿esz zdobywaæ <b>Punkty Do¶wiadczenia</b> oraz <b>Z³oto</b>. Je¿eli przegrasz walkê z potworem, nie tracisz ¿ycia, ani z³ota. Tak wiêc jest to najbezpieczniejszy sposób na zdobywanie do¶wiadczenia. Tabela jaka pojawia siê tutaj jest bardzo podobna do tej z poprzednich opcji, ale tutaj znajduje siê spis wszelkich dostêpnych potworów (je¿eli chcesz, to na 1 poziomie mo¿esz zaatakowaæ potwora na 5 poziomie).";
} elseif ($_GET['help'] == 'zbrojmistrz') {
	print "U Zbrojmistrza mo¿esz kupiæ wszelkie dostêpne zbroje jakie s± w grze. Wszystkie wy¶wietlone s± w tabeli, podana jest ich nazwa, efekt (ile daje obrony), cena, wymagany poziom (poziom jaki musisz posiadaæ, aby¶ móg³ u¿ywaæ danej zbroi) oraz opcje (czyli zakup danej zbroi). Aby zakupiæ jak±kolwiek zbrojê, musisz mieæ odpowiedni± ilo¶æ sztuk z³ota przy sobie (pieni±dze bêd±ce w banku nie s± uwzglêdniane).";
} elseif ($_GET['help'] == 'platnerz') {
	print "U P³atnerza mo¿esz kupiæ wszelkie dostêpne uzbrojenie jakie jest w grze. Ca³e uzbrojenie wy¶wietlone jest w tabeli, podana jest ich nazwa, efekt (ile dodaje do obra¿eñ), cena, wymagany poziom (poziom jaki musisz posiadaæ, aby¶ móg³ u¿ywaæ danej broni) oraz opcje (czyli zakup danej broni). Aby zakupiæ jakiekolwiek uzbrojenie, musisz mieæ odpowiedni± ilo¶æ sztuk z³ota przy sobie (pieni±dze bêd±ce w banku nie s± uwzglêdniane).";
} elseif ($_GET['help'] == 'straznica') {
	print "Stra¿nica to mini gra strategiczna. Aby w ni± zagraæ, musisz wykupiæ bilet za 500 sztuk z³ota. Kiedy to zrobisz, bêdziesz mia³ dostêp do specjalnego menu. Opcja <b>Moja Stra¿nica</b> zawiera ogólne informacje na temat twojej stra¿nicy, posiadanych kopalni oraz ¿o³nierzy i fortyfikacji. W opcji <b>Kopalnie</b> mo¿esz wydobywaæ minera³y, kupowaæ nowe kopalnie, itp. W opcji <b>Sklep w Stra¿nicy</b> mo¿esz kupowaæ ¿o³nierzy, fortyfikacje oraz powiêkszaæ swoj± stra¿nicê. Opcja <b>Atakuj Stra¿nicê</b> pozwala ci zaatakowaæ stra¿nicê innego gracza. Dok³adny opis gry znajduje siê w opcji <b>Instrukcja Stra¿nicy</b>";
} 

if ($_GET['help']) {
	print "<br><br>(<a href=helpwojenne.php>Powrót</a>)";
}

require_once("footer.php");
?>
