<?php
/***************************************************************************
 *                               gory.php
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

 $title = "Góry Kazad-nar";
require_once("header.php");

if($stat['miejsce'] != 'Góry') {
	echo("Nie znajdujesz siê w górach");
	require_once("footer.php");
	die();
}


if ($gracz['hp'] > 0) {
	print"Witaj w Górach Kazad-nar, co chcesz robiæ?<br><br>";
	print "<table>";
	print "<br><tr><td width=100 valign=top>";
	print "<a href=kopalnia.php>Id¼ do kopalni</a><br>";
	print "<a href=explore.php>Zwiedzaj góry</a><br>";
	print "<a href=travel.php>Stajnia</a><br>";
	print "<br></td></tr>";
	print "</table>";
} else {
	mysql_query("update players set miejsce='Altara' where id=$stat[id]");
	print "Poniewa¿ jeste¶ martwy, twa dusza pod±¿a z powrotem do szpitala w Altarze. Kliknij <a href=hospital.php>tutaj</a>.";
}
require_once("footer.php"); ?>
