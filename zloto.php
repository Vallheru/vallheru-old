<?php 
/***************************************************************************
 *                               zloto.php
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

$title = "Bogactwa";
require_once("header.php");
$gr13 = mysql_fetch_array(mysql_query("select bronz, zelazo, wegiel, adam, meteo, krysztal from kopalnie where gracz=$stat[id]"));
$gr1 = mysql_fetch_array(mysql_query("select nutari, illani, illanias from herbs where gracz=$stat[id]"));
print "Tutaj jest lista posiadanych przez ciebie pieni�dzy oraz r�nych minera��w<br>";
print "Sztuki z�ota przy sobie: $gracz[credits]<br>";
print "Sztuki z�ota w banku: $gracz[bank]<br>";
print "Sztuki mithrilu: $gracz[platinum]<br>";
$ref = mysql_num_rows(mysql_query("select id from players where refs=$stat[id]"));
print "Vallary: $ref<br>";
if (!empty($gr13)) {
	print "Bry�y br�zu: $gr13[bronz]<br>";
	print "Bry�y �elaza: $gr13[zelazo]<br>";
	print "Bry�y w�gla: $gr13[wegiel]<br>";
	print "Bry�y adamantium: $gr13[adam]<br>";
	print "Kawa�ki meteor�w: $gr13[meteo]<br>";
	print "Kryszta��w: $gr13[krysztal]<br>";
} else {
	print "Bry�y br�zu: 0<br>";
	print "Bry�y �elaza: 0<br>";
	print "Bry�y w�gla: 0<br>";
	print "Bry�y adamantium: 0<br>";
	print "Kawa�ki meteor�w: 0<br>";
	print "Kryszta��w: 0<br>";
}
if (!empty($gr1)) {
	print "Illani: $gr1[illani]<br>";
	print "Illanias: $gr1[illanias]<br>";
	print "Nutari: $gr1[nutari]<br>";
} else {
	print "Illani: 0<br>";
	print "Illanias: 0<br>";
	print "Nutari: 0<br>";
}
require_once("footer.php");
?>
