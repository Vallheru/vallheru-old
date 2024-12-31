<?php 
/***************************************************************************
 *                               helppoludniowa.php
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
	print "W <b>Po�udniowej dzielnicy</b> znajduje si� najwi�kszy rynek na Vallheru oraz Stajnia, sk�d mo�esz wyruszy� w inne strony �wiata Vallheru. Aby dowiedzie� si� czego� wi�cej o danej lokacji, kliknij na jej nazw�.<ul>
	<li><a href=helppoludniowa.php?help=rynek>Rynek</a>
	<li><a href=helppoludniowa.php?help=stajnia>Stajnia</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'rynek') {
	print "Na <b>Rynku</b> mo�esz sprzedawa� mithril oraz przedmioty innym graczom. Ty tutaj ustalasz cen� oraz ilo�� dost�pnego towaru. S� tutaj dwa rynki:<br>1. <b>Rynek z mithrilem</b>. Jest to jedyne miejsce w grze, gdzie mo�esz sprzeda� posiadany mithril (w <i>Sklepie z mithrilem</i> mo�esz jedynie kupowa� mithril. S� dost�pne trzy opcje: <b>Oferty</b> tutaj mo�esz zobaczy� wszystkie oferty innych graczy dotycz�ce sprzeda�y mithrilu. Podana jest ilo��, cena za ow� ilo�� w sztukach z�ota, ID (numer, nie nazwa) sprzedaj�cego oraz opcja Kupi� - je�eli na ni� klikniesz, wtedy kupisz dan� ilo�� mithrilu. Druga opcja na tym rynku to <b>Dodaj ofert�</b> - tutaj mo�esz doda� ofert� sprzeda�y jakiej� ilo�ci mithrilu. Musisz tylko w polu <b>mithril</b> wpisa� ilo�� sprzedawanego mithriu, natomiast w polu <b>Cena za jeden mithril</b> wpisujesz cen� za sztuk� mithrilu (nie wpisuj ile chcesz ��cznie za ca�o�� - gra sama to wyliczy). Potem zostaje ju� tylko wcisn�� przycisk <i>Dodaj</i> i twoja oferta pojawia si� na rynku. W tym momencie, ilo�� mithrilu jak� zadeklarowa�e� do sprzeda�y jest odejmowana od twojego konta i przelewana na rynek. Je�eli kto� zaakceptuje twoj� ofert�, zostaniesz o tym powiadmiony w <i>Dzienniku</i>. Opcja trzecia na rynku to <b>Skasuj ofert�</b> - klikaj�c tutaj usuwasz wszystkie swoje oferty sprzeda�y, a ca�y mithril, jaki wystawi�e� na sprzeda� wraca z powrotem na twoje konto.<br>2. <b>Rynek z przedmiotami</b> - ta opcja b�dzie dost�pna wkr�tce.";
} elseif ($_GET['help'] == 'stajnia') {
	print "Ta opcja b�dzie dost�pna dopiero w du�o p�niejszym terminie. Dzi�ki niej, b�dzie mo�na podr�owa� po ca�ym Vallheru.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helppoludniowa.php>Powr�t</a>)";
}

require_once("footer.php");
?>
