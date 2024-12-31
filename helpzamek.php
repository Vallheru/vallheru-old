<?php 
/***************************************************************************
 *                               helpzamek.php
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
	print "Zamek to siedziba w�adcy Vallheru, Thindila. Znajdziesz tutaj r�nie informacje zwi�zane ze sprawami technicznymi gry. Aby zobaczy� opis jakiego� miejsca po prostu kliknij na jego nazw�.<ul>
	<li><a href=helpzamek.php?help=wiesci>Wie�ci</a>
	<li><a href=helpzamek.php?help=zegar>Zegar miejski</a>
	<li><a href=helpzamek.php?help=poleceni>Poleceni</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'wiesci') {
	print "Tutaj znajdziesz informacje na temat technicznej strony gry (nowo�ci w grze, zmiany w plikach i tym podobne sprawy. Aby zobaczy� ostatnie 10 Wie�ci kliknij po prostu na <i>Ostatnie 10 wie�ci</i>";
} elseif ($_GET['help'] == 'zegar') {
	print "Tutaj mo�esz zobaczy� obecny czas oraz kiedy b�dzie nast�pny restart gry (czyli odzyskanie energi, uzdrowienie, itd. G��wny restart o 12 to pocz�tek nowego dnia na Vallheru, wtedy dodatkowo zmieniaj� si� r�wnie� ceny mithrilu w <i>Sklepie z mithrilem</i>";
} elseif ($_GET['help'] == 'poleceni') {
	print "Tutaj mo�esz zobaczy� specjalny link, dzi�ki kt�remu mo�esz zbiera� poleconych (czyli osoby, kt�re zapisa�y si� do gry przez tw�j link). <b>Uwaga!</b> Je�eli dojdzie do mnie informacja, �e kto� wysy�a spam, w takim wypadku, b�d� kasowa� jego konto bez chwili wachania! Opr�cz tego mo�esz tutaj zobaczy� ilu ju� masz poleconych. W przysz�o�ci za zdobycie odpowiedniej liczby poleconych b�dzie mo�na dosta� jakie� specjalne przedmioty.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpzamek.php>Powr�t</a>)";
}

require_once("footer.php");
?>
