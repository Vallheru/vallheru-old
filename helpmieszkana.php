<?php 
/***************************************************************************
 *                               helpmieszkana.php
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
	print "W <b>Dzielnicy mieszkalnej</b> znajdziesz ró¿ne interesuj±ce informacje na temat osób graj±cych w Valleru. Je¿eli chcesz siê dowiedzieæ wiêcej o jakiej¶ lokacji, kliknij na jej nazwie.<ul>
	<li><a href=helpmieszkana.php?help=spis>Spis mieszkañców</a>
	<li><a href=helpmieszkana.php?help=posagi>Pos±gi</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'spis') {
	print "W <b>Spisie mieszkañców</b> znajdziesz listê wszystkich osób graj±cych w Vallheru. Podane s± tutaj numer gracza, imiê, ranga (admin, staff, member) oraz poziom. Je¿eli chcesz siê dowiedzieæ czego¶ wiêcej o jakim¶ graczu, kliknij na jego imiê. Pojawi± siê wtedy dodatkowe informacje: ranga, ostatnio widziany - gdzie ostatnio przebywa³, wiek (wiek postaci w dniach), poziom, status (¿ywy/martwy), klan do którego nale¿y, maksymalne P¯ (maksymalne zdrowie), wyniki (bitwy z innymi graczami - pierwsza liczba to wygrane, druga przegrane), ostatnio zabi³ (ostatnio zabity gracz przez t± osobê, ostatnio zabity przez (kto go ostatnio zabi³), poleceni (ile osób zapisa³o siê do gry z jego linku polecaj±cego. Wiêcej o poeconych w opisie <i>Poleceni</i>), Profil (dodatkowe informacje na temat gracza). Na dole znajduje siê opcja <b>Atak</b> - klikaj±c na ni± przystêpujesz do ataku na danego gracza.";
} elseif ($_GET['help'] == 'posagi') {
	print "W dziale <b>Pos±gi</b> mo¿esz zobaczyæ listê najlepszych w jakiej¶ dziedzinie graczy. S± tutaj najlepsi w: poziomie, kowalstwie, najwiêkszej ilo¶ci sztuk z³ota (przy sobie lub w banku), najwiêkszej ilo¶ci mithrilu, najwiêkszej ilo¶ci maksymalnej energii, liczbie zwyciêstw, liczbie pora¿ek, sile oraz zrêczno¶ci. Obok imienia podana jest warto¶æ. W ka¿dej tabeli znajduje siê 5 najlepszych graczy w danej dziedzinie.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpmieszkana.php>Powrót</a>)";
}

require_once("footer.php");
?>
