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
	print "W <b>Po³udniowej dzielnicy</b> znajduje siê najwiêkszy rynek na Vallheru oraz Stajnia, sk±d mo¿esz wyruszyæ w inne strony ¶wiata Vallheru. Aby dowiedzieæ siê czego¶ wiêcej o danej lokacji, kliknij na jej nazwê.<ul>
	<li><a href=helppoludniowa.php?help=rynek>Rynek</a>
	<li><a href=helppoludniowa.php?help=stajnia>Stajnia</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'rynek') {
	print "Na <b>Rynku</b> mo¿esz sprzedawaæ mithril oraz przedmioty innym graczom. Ty tutaj ustalasz cenê oraz ilo¶æ dostêpnego towaru. S± tutaj dwa rynki:<br>1. <b>Rynek z mithrilem</b>. Jest to jedyne miejsce w grze, gdzie mo¿esz sprzedaæ posiadany mithril (w <i>Sklepie z mithrilem</i> mo¿esz jedynie kupowaæ mithril. S± dostêpne trzy opcje: <b>Oferty</b> tutaj mo¿esz zobaczyæ wszystkie oferty innych graczy dotycz±ce sprzeda¿y mithrilu. Podana jest ilo¶æ, cena za ow± ilo¶æ w sztukach z³ota, ID (numer, nie nazwa) sprzedaj±cego oraz opcja Kupiæ - je¿eli na ni± klikniesz, wtedy kupisz dan± ilo¶æ mithrilu. Druga opcja na tym rynku to <b>Dodaj ofertê</b> - tutaj mo¿esz dodaæ ofertê sprzeda¿y jakiej¶ ilo¶ci mithrilu. Musisz tylko w polu <b>mithril</b> wpisaæ ilo¶æ sprzedawanego mithriu, natomiast w polu <b>Cena za jeden mithril</b> wpisujesz cenê za sztukê mithrilu (nie wpisuj ile chcesz ³±cznie za ca³o¶æ - gra sama to wyliczy). Potem zostaje ju¿ tylko wcisn±æ przycisk <i>Dodaj</i> i twoja oferta pojawia siê na rynku. W tym momencie, ilo¶æ mithrilu jak± zadeklarowa³e¶ do sprzeda¿y jest odejmowana od twojego konta i przelewana na rynek. Je¿eli kto¶ zaakceptuje twoj± ofertê, zostaniesz o tym powiadmiony w <i>Dzienniku</i>. Opcja trzecia na rynku to <b>Skasuj ofertê</b> - klikaj±c tutaj usuwasz wszystkie swoje oferty sprzeda¿y, a ca³y mithril, jaki wystawi³e¶ na sprzeda¿ wraca z powrotem na twoje konto.<br>2. <b>Rynek z przedmiotami</b> - ta opcja bêdzie dostêpna wkrótce.";
} elseif ($_GET['help'] == 'stajnia') {
	print "Ta opcja bêdzie dostêpna dopiero w du¿o pó¼niejszym terminie. Dziêki niej, bêdzie mo¿na podró¿owaæ po ca³ym Vallheru.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helppoludniowa.php>Powrót</a>)";
}

require_once("footer.php");
?>
