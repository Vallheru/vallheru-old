<?php
/***************************************************************************
 *                               referrals.php
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

$title = "Centrum Poleconych";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
$ref = mysql_num_rows(mysql_query("select id from players where refs=$stat[id]"));
print "Witaj w centrum poleconych. Za ka¿dym razem, kiedy kto¶ zapisze siê przez ten link  (<i>http://vallheru.etak.pl/register.php?ref=$stat[id]</i>) oraz bêdzie gra³ w Valheru, zdobywasz jednego Vallara. Potem mo¿esz za te punkty kupiæ specjalne przedmioty (dostêpne wkrótce). Tak wiêc, na razie masz <b>$ref</b> Vallar(ów).";
require_once("footer.php");
?>
