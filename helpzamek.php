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
	print "Zamek to siedziba w³adcy Vallheru, Thindila. Znajdziesz tutaj ró¿nie informacje zwi±zane ze sprawami technicznymi gry. Aby zobaczyæ opis jakiego¶ miejsca po prostu kliknij na jego nazwê.<ul>
	<li><a href=helpzamek.php?help=wiesci>Wie¶ci</a>
	<li><a href=helpzamek.php?help=zegar>Zegar miejski</a>
	<li><a href=helpzamek.php?help=poleceni>Poleceni</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'wiesci') {
	print "Tutaj znajdziesz informacje na temat technicznej strony gry (nowo¶ci w grze, zmiany w plikach i tym podobne sprawy. Aby zobaczyæ ostatnie 10 Wie¶ci kliknij po prostu na <i>Ostatnie 10 wie¶ci</i>";
} elseif ($_GET['help'] == 'zegar') {
	print "Tutaj mo¿esz zobaczyæ obecny czas oraz kiedy bêdzie nastêpny restart gry (czyli odzyskanie energi, uzdrowienie, itd. G³ówny restart o 12 to pocz±tek nowego dnia na Vallheru, wtedy dodatkowo zmieniaj± siê równie¿ ceny mithrilu w <i>Sklepie z mithrilem</i>";
} elseif ($_GET['help'] == 'poleceni') {
	print "Tutaj mo¿esz zobaczyæ specjalny link, dziêki któremu mo¿esz zbieraæ poleconych (czyli osoby, które zapisa³y siê do gry przez twój link). <b>Uwaga!</b> Je¿eli dojdzie do mnie informacja, ¿e kto¶ wysy³a spam, w takim wypadku, bêdê kasowa³ jego konto bez chwili wachania! Oprócz tego mo¿esz tutaj zobaczyæ ilu ju¿ masz poleconych. W przysz³o¶ci za zdobycie odpowiedniej liczby poleconych bêdzie mo¿na dostaæ jakie¶ specjalne przedmioty.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpzamek.php>Powrót</a>)";
}

require_once("footer.php");
?>
