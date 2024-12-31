<?php 
/***************************************************************************
 *                               helppodgrodzie.php
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
	print "Na <b>Podgrodziu</b> znajduj� si� dwie lokacje. Je�eli chcesz si� dowiedzie� czego� wi�cej o nich, po prostu kliknij na nazw� miejsca.<ul>
	<li><a href=helppodgrodzie.php?help=szkola>Szko�a</a>
	<li><a href=helppodgrodzie.php?help=kopalnia>Kopalnia</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'szkola') {
	print "W <b>Szkole</b> mo�esz podnosi� swoje statystyki, czyli si�� oraz zr�czno��. Ka�dy trening podnosi dan� cech� o 0.06 punkta. W zamian za to zu�ywa si� 0.2 punktu energi. Je�eli chcesz trenowa� jak�� cech�, po prostu wybierz odpowiedni� cech�, w polu obok wpisz il� razy chcesz �wiczy� i wci�nij przycisk <i>Trenuj</i>. ";
} elseif ($_GET['help'] == 'kopalnia') {
	print "Aby mie� dost�p do <b>Kopalni</b> musisz najpierw wykupi� specjalny dost�p do niej za 25 sztuk mithrilu. Od tego momentu stajesz si� posiadaczem jednej kopalni oraz dostajesz dost�p do menu. W nim znajdziesz nast�puj�ce opcje:<b>Statystyki</b> - tutaj znajdziesz og�lne informacje na temat posiadanego przez ciebie obszaru kopalni, ilo�ci operacji (ile razy mo�esz wydobywa� minera�y w kopalni) oraz ilo�� posiadanego przez ciebie w�gla oraz �elaza. W opcji <b>Sklep</b> masz mo�liwo�� dokupienia dodatkowego obszaru kopalni, dzi�ki czemu, b�dziesz w stanie wi�cej zbiera� �elaza oraz w�gla. Dokupienie obszaru kosztuje 1000 sztuk z�ota. W opcji <b>Rynek</b> mo�esz sprzedawa� wydobyty w�giel oraz �elazo. Na razie ceny s� sta�e (15 za bry�� w�gla, 10 za bry�� �elaza), ale mo�liwe, �e za jaki� czas, b�d� zmienia� si� codziennie (tak jak ceny mithrilu. Aby sprzeda� jak�� ilo�� kt�rego� z minera��w, wpisz w odpowiednie pole ilo�� oraz kliknij przycisk <i>Sprzedaj</i>. Sprzedane minera�y zostan� usuni�te z twojego konta, w zamian pojawi� si� tam sztuki z�ota. Opcja <b>Kopalnia</b> pozwala ci wydobywa� minera�y z twojej kopalni. To il� razy mo�esz kopa� zale�y od ilo�ci <i>Operacji</i> jakie posiadasz - regeneruj� si� one wraz z restartem gry. Po tym jak sko�czysz wydobywa�, mo�esz sprzeda� to co wydoby�e�.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helppodgrodzie.php>Powr�t</a>)";
}

require_once("footer.php");
?>
