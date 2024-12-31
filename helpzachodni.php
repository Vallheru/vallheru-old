<?php 
/***************************************************************************
 *                               helpzachodni.php
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
	print "Zachodnia strona to najstarsza dzielnica miasta. Znajdziesz tutaj tylko dwie lokacje. Kliknij na nazw� miejsca aby otrzyma� wi�cej wiadomo�ci na jego temat.<ul>
	<li><a href=helpzachodni.php?help=labirynt>Labirynt</a>
	<li><a href=helpzachodni.php?help=mithril>Sklep z mithrilem</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'labirynt') {
	print "Labirynt to miejsce, gdzie znale�� mo�esz r�ne ciekawe rzeczy. Po prostu klikaj�c, zwiedzasz go. Ka�da wizyta w labiryncie zabiera nieco energii. Przedmioty pojawiaj� si� losowo. Mo�esz znale�� tutaj z�oto, mithril czy te� �r�de�ko regeneruj�ce energi�.";
} elseif ($_GET['help'] == 'mithril') {
	print "W Sklepie z mithrilem, mo�esz kupi� mithril, przydatny np przy zakupie kopalni. Jednak nie sprzedasz go tutaj. Cena mithrilu nie jest sta�a i zmienia si� co dziennie. Aby kupi� jak�kolwiek ilo�� mithrilu, musisz posiada� sztuki z�ota przy sobie, te, kt�re s� w banku nie s� brane pod uwag� podczas zakup�w. Aby zakupi� mithril, po prostu wpisz ilo�� jak� chcesz kupi� i potwierd�.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpzachodni.php>Powr�t</a>)";
}

require_once("footer.php");
?>
