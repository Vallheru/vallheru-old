<?php 
/***************************************************************************
 *                               travel.php
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

$title="Stajnie";
require_once("header.php");
if (!isset($_GET['akcja'])) {
     $_GET['akcja'] = '';
}
if (!$_GET['akcja'] && $stat['miejsce'] == 'Altara') {
	print "Witaj w Stajniach. St�d mo�esz wyruszy� do innych miejsc �wiata Vallheru.<br>";
	print "<ul>";
	print "<li><a href=travel.php?akcja=gory>G�ry Kazad-nar (koszt 1000 sztuk z�ota)</a></li>";
	print "</ul>";
}
if (!$_GET['akcja'] && $stat['miejsce'] != 'Altara') {
	print "Witaj w Stajniach. T�dy mo�esz wr�ci� do stolicy Vallheru, Altary.<br>";
	print "- <a href=travel.php?akcja=powrot>Wr�� do Altary (koszt 1000 sztuk z�ota)</a>";
}
if ($_GET['akcja'] == 'gory') {
	if ($gracz['credits'] < 1000) {
		print "Nie masz tyle pieni�dzy!";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set miejsce='G�ry' where id=$stat[id]");
	mysql_query("update players set credits=credits-1000 where id=$stat[id]");
	print "Dotar�e� do G�r Kazad-nar. Wejd� <a href=gory.php>tutaj</a> aby zobaczy� co ciebie czeka.";
}
if ($_GET['akcja'] == 'powrot') {
	if ($gracz['credits'] < 1000) {
		print "Nie masz tyle pieni�dzy!";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set miejsce='Altara' where id=$stat[id]");
	mysql_query("update players set credits=credits-1000 where id=$stat[id]");
	print "Dotar�e� do Altary. Wejd� <a href=city.php>tutaj</a> aby zobaczy� co ciebie czeka.";
}
require_once("footer.php"); ?>
