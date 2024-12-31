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
	print "Zachodnia strona to najstarsza dzielnica miasta. Znajdziesz tutaj tylko dwie lokacje. Kliknij na nazwê miejsca aby otrzymaæ wiêcej wiadomo¶ci na jego temat.<ul>
	<li><a href=helpzachodni.php?help=labirynt>Labirynt</a>
	<li><a href=helpzachodni.php?help=mithril>Sklep z mithrilem</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'labirynt') {
	print "Labirynt to miejsce, gdzie znale¼æ mo¿esz ró¿ne ciekawe rzeczy. Po prostu klikaj±c, zwiedzasz go. Ka¿da wizyta w labiryncie zabiera nieco energii. Przedmioty pojawiaj± siê losowo. Mo¿esz znale¼æ tutaj z³oto, mithril czy te¿ ¼róde³ko regeneruj±ce energiê.";
} elseif ($_GET['help'] == 'mithril') {
	print "W Sklepie z mithrilem, mo¿esz kupiæ mithril, przydatny np przy zakupie kopalni. Jednak nie sprzedasz go tutaj. Cena mithrilu nie jest sta³a i zmienia siê co dziennie. Aby kupiæ jak±kolwiek ilo¶æ mithrilu, musisz posiadaæ sztuki z³ota przy sobie, te, które s± w banku nie s± brane pod uwagê podczas zakupów. Aby zakupiæ mithril, po prostu wpisz ilo¶æ jak± chcesz kupiæ i potwierd¼.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpzachodni.php>Powrót</a>)";
}

require_once("footer.php");
?>
