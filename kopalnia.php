<?php 
/***************************************************************************
 *                               kopalnia.php
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

$title = "Kopalnia";
require_once("header.php");
if ($stat['miejsce'] != 'G�ry') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['akcja'])) {
     $_GET['akcja'] = '';
}
$kop = mysql_fetch_array(mysql_query("select adam, krysztal from kopalnie where gracz=$stat[id]"));
$sila = mysql_fetch_array(mysql_query("select strength, klasa from players where id=$stat[id]"));
if (!$_GET['akcja'] && $gracz['hp'] > 0) {
	print "Witaj w kopaniach w g�rach Kazad-nar, czy chcesz wyruszy� na poszukiwanie minera��w?<br><br>";
	print "<a href=kopalnia.php?akcja=kop>Tak</a><br>";
	print "<a href=gory.php>Nie</a><br>";
}
if ($_GET['akcja'] == 'kop') {
	if ($gracz['energy'] < 0.5) {
		print "Nie mo�esz poszukiwa� minera��w poniewa� nie masz energii!";
		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "Nie mo�esz pracowa� w kopalni, poniewa� jeste� martwy!";
		require_once("footer.php");
		exit;
	}
	mysql_query("update players set energy=energy-0.5 where id=$stat[id]");
	$pr = ceil($sila['strength'] / 10);
	if ($sila['klasa'] == 'Obywatel') {
		$premia1 = ceil($gracz['level'] / 10);
		$premia = ($premia1 + $pr);
	} else {
		$premia = $pr;
	}
	$rzut = rand(1,10);
	if ($rzut < 5) {
		print "Uderza�e� przez jaki� czas kilofem w ska��, ale nic nie znalaz�e�.";
	}
	if ($rzut == 5) {
		$ilosc = rand(1,10);
		print "W pewnym momencie zauwa�y�e� w �cianie kilka niewielkich kryszta�k�w koloru czerwonego. Delikatnie ob�upuj�c je ze �ciany zdoby�e� $ilosc kryszta��w kt�re mog� pos�u�y� do wykonania przedmiot�w.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, krysztal) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set krysztal=krysztal+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 6) {
		$ilosc = (rand(1,10) + $premia);
		print "Przez pewien czas pracowa�e� w kopalni, gdy nagle na �cianie twoim oczom ukaza�a si� ma�a niebieska �y�ka minera�u. Zacz��e� intensywniej pracowa� i uda�o ci si� wydoby� $ilosc bry� adamantium.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, adam) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set adam=adam+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 7) {
		$ilosc = (rand(1,50) + $premia);
		print "Pracuj�c w kopalni zauwa�y�e� du�� �y�� adamantium. Od�upuj�c ska�y zyska�e� $ilosc bry� adamantium.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, adam) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set adam=adam+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 8) {
		$ilosc = (rand(1,100) + $premia);
		print "Znalaz�e� �y�� mithrilu! Uda�o ci si� wydoby� $ilosc sztuk mithrilu.";
		mysql_query("update players set platinum=platinum+$ilosc where id=$stat[id]");
	}
	if ($rzut == 9) {
		$ilosc = (rand(1,1000) + $premia);
		print "Pracuj�c przez jaki� czas w kopalni, uda�o ci si� wydoby� kilka diament�w, wartych $ilosc sztuk z�ota.";
		mysql_query("update players set credits=credits+$ilosc where id=$stat[id]");
	}
	if ($rzut == 10) {
		$rzut2 = rand(1,100);
		if ($rzut2 <= 50) {
			print "Nagle poczu�e�, jak ca�e wyrobisko powoli zaczyna si� rozpada�. Najszybciej jak potrafisz pr�bowa�e� biec w kierunku wyj�cia. Niestety, tym razem �ywio� okaza� si� szybszy od ciebie. Pot�na lawina kamieni spad�a na ciebie, zabijaj�c na miejscu";
			$gracz['hp'] = 0;
			mysql_query("update players set hp=0 where id=$stat[id]");
		} else {
			print "Nagle poczu�e�, jak ca�e wyrobisko powoli zaczyna si� rozpada�. Najszybciej jak potrafisz pr�bowa�e� biec w kierunku wyj�cia. W ostatnim momencie uda�o ci si� wybiec z zagro�onego wyrobiska, poczu�e� jedynie na plecach podmuch wal�cych si� ton ska�.";
		}
	}
	if ($gracz['hp'] > 0) {
		print "<br>Czy chcesz kopa� ponownie?<br><br>";
		print "<a href=kopalnia.php?akcja=kop>Tak</a><br>";
		print "<a href=gory.php>Nie</a>";
	}
}
require_once("footer.php"); ?>
