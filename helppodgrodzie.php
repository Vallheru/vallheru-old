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
	print "Na <b>Podgrodziu</b> znajduj± siê dwie lokacje. Je¿eli chcesz siê dowiedzieæ czego¶ wiêcej o nich, po prostu kliknij na nazwê miejsca.<ul>
	<li><a href=helppodgrodzie.php?help=szkola>Szko³a</a>
	<li><a href=helppodgrodzie.php?help=kopalnia>Kopalnia</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'szkola') {
	print "W <b>Szkole</b> mo¿esz podnosiæ swoje statystyki, czyli si³ê oraz zrêczno¶æ. Ka¿dy trening podnosi dan± cechê o 0.06 punkta. W zamian za to zu¿ywa siê 0.2 punktu energi. Je¿eli chcesz trenowaæ jak±¶ cechê, po prostu wybierz odpowiedni± cechê, w polu obok wpisz ilê razy chcesz æwiczyæ i wci¶nij przycisk <i>Trenuj</i>. ";
} elseif ($_GET['help'] == 'kopalnia') {
	print "Aby mieæ dostêp do <b>Kopalni</b> musisz najpierw wykupiæ specjalny dostêp do niej za 25 sztuk mithrilu. Od tego momentu stajesz siê posiadaczem jednej kopalni oraz dostajesz dostêp do menu. W nim znajdziesz nastêpuj±ce opcje:<b>Statystyki</b> - tutaj znajdziesz ogólne informacje na temat posiadanego przez ciebie obszaru kopalni, ilo¶ci operacji (ile razy mo¿esz wydobywaæ minera³y w kopalni) oraz ilo¶æ posiadanego przez ciebie wêgla oraz ¿elaza. W opcji <b>Sklep</b> masz mo¿liwo¶æ dokupienia dodatkowego obszaru kopalni, dziêki czemu, bêdziesz w stanie wiêcej zbieraæ ¿elaza oraz wêgla. Dokupienie obszaru kosztuje 1000 sztuk z³ota. W opcji <b>Rynek</b> mo¿esz sprzedawaæ wydobyty wêgiel oraz ¿elazo. Na razie ceny s± sta³e (15 za bry³ê wêgla, 10 za bry³ê ¿elaza), ale mo¿liwe, ¿e za jaki¶ czas, bêd± zmieniaæ siê codziennie (tak jak ceny mithrilu. Aby sprzedaæ jak±¶ ilo¶æ którego¶ z minera³ów, wpisz w odpowiednie pole ilo¶æ oraz kliknij przycisk <i>Sprzedaj</i>. Sprzedane minera³y zostan± usuniête z twojego konta, w zamian pojawi± siê tam sztuki z³ota. Opcja <b>Kopalnia</b> pozwala ci wydobywaæ minera³y z twojej kopalni. To ilê razy mo¿esz kopaæ zale¿y od ilo¶ci <i>Operacji</i> jakie posiadasz - regeneruj± siê one wraz z restartem gry. Po tym jak skoñczysz wydobywaæ, mo¿esz sprzedaæ to co wydoby³e¶.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helppodgrodzie.php>Powrót</a>)";
}

require_once("footer.php");
?>
