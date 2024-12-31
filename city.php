<?php 
/***************************************************************************
 *                               city.php
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

$title = "Altara"; require_once("header.php"); ?>

<?php 
if($stat['miejsce'] != 'Altara') {
	echo("Nie znajdujesz siê w mie¶cie");
	require_once("footer.php");
	die();
}
?>

Witaj w stolicy Vallheru, Altarze.<br><br>

<table>
<br><tr><td width=100 valign=top>
	<b><u>Wojenne Pola</b></u><br>	
	<a href=battle.php>Arena Walk</a><br>	
	<a href=armor.php>P³atnerz</a><br>	
	<a href=weapons.php>Zbrojmistrz</a><br>
	<a href=outposts.php>Stra¿nica</a><br>
<br></td><td width=100 valign=top>
	<b><u>Spo³eczno¶æ</b></u><br>	
	<a href=news.php>Plotki</a><br>
	<a href=forums.php?view=topics>Forum</a><br>	
	<a href=chat.php>Karczma</a><br>	
	<a href=mail.php>Poczta</a><br>
	<A href=tribes.php>Klany</a><br>
<br></td><td width=100 valign=top>
	<b><u>Podgrodzie</b></u><br>	
	<a href=train.php>Szko³a</a><br>
	<a href=mines.php>Kopalnie</a><br>
	<a href=core.php>Polana Chowañców</a><br>
<br></td></tr>
<tr><td valign=top>
	<b><u>Zachodnia strona</u></b><br>
	<a href=grid.php>Labirynt</a><br>	
	<a href=pshop.php>Sklep z mithrilem</a><br>
	<a href=wieza.php>Magiczna Wie¿a</a><br>
	<a href=temple.php>¦wi±tynia</a><br>
	<a href=msklep.php>Alchemik</a><br>
<br></td><td valign=top>
	<b><u>Dzielnica mieszkalna</u></b><br>	
	<a href=memberlist.php?limit=0&lista=id>Spis mieszkañców</a><br>
	<a href=monuments.php>Pos±gi</a><br>
<br></td><td valign=top>
	<b><u>Zamek</u></b><br>
	<a href=updates.php>Wie¶ci</a><br>
	<a href=tower.php>Zegar miejski</a><br>
	<a href=referrals.php>Poleceni</a><br>
<br></td></tr>
<tr><td width=100 valign=top>
	<b><u>Praca</u></b><br>
	<a href=landfill.php>Oczyszczanie miasta</a><br>
	<a href=kowal.php>Ku¼nia</a><br>
	<a href=alchemik.php>Pracownia alchemiczna</a><br>
<br></td><td valign=top>
	<b><u>Dzielnica po³udniowa</u></b><br>
	<a href=market.php>Rynek</a><br>
	<a href=travel.php>Stajnia</a><br>
<br></td></tr>
</table>

<?php require_once("footer.php"); ?>
