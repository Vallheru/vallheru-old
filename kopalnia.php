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
if ($stat['miejsce'] != 'Góry') {
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
	print "Witaj w kopaniach w górach Kazad-nar, czy chcesz wyruszyæ na poszukiwanie minera³ów?<br><br>";
	print "<a href=kopalnia.php?akcja=kop>Tak</a><br>";
	print "<a href=gory.php>Nie</a><br>";
}
if ($_GET['akcja'] == 'kop') {
	if ($gracz['energy'] < 0.5) {
		print "Nie mo¿esz poszukiwaæ minera³ów poniewa¿ nie masz energii!";
		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "Nie mo¿esz pracowaæ w kopalni, poniewa¿ jeste¶ martwy!";
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
		print "Uderza³e¶ przez jaki¶ czas kilofem w ska³ê, ale nic nie znalaz³e¶.";
	}
	if ($rzut == 5) {
		$ilosc = rand(1,10);
		print "W pewnym momencie zauwa¿y³e¶ w ¶cianie kilka niewielkich kryszta³ków koloru czerwonego. Delikatnie ob³upuj±c je ze ¶ciany zdoby³e¶ $ilosc kryszta³ów które mog± pos³u¿yæ do wykonania przedmiotów.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, krysztal) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set krysztal=krysztal+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 6) {
		$ilosc = (rand(1,10) + $premia);
		print "Przez pewien czas pracowa³e¶ w kopalni, gdy nagle na ¶cianie twoim oczom ukaza³a siê ma³a niebieska ¿y³ka minera³u. Zacz±³e¶ intensywniej pracowaæ i uda³o ci siê wydoby¶ $ilosc bry³ adamantium.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, adam) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set adam=adam+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 7) {
		$ilosc = (rand(1,50) + $premia);
		print "Pracuj±c w kopalni zauwa¿y³e¶ du¿± ¿y³ê adamantium. Od³upuj±c ska³y zyska³e¶ $ilosc bry³ adamantium.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, adam) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set adam=adam+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 8) {
		$ilosc = (rand(1,100) + $premia);
		print "Znalaz³e¶ ¿y³ê mithrilu! Uda³o ci siê wydobyæ $ilosc sztuk mithrilu.";
		mysql_query("update players set platinum=platinum+$ilosc where id=$stat[id]");
	}
	if ($rzut == 9) {
		$ilosc = (rand(1,1000) + $premia);
		print "Pracuj±c przez jaki¶ czas w kopalni, uda³o ci siê wydobyæ kilka diamentów, wartych $ilosc sztuk z³ota.";
		mysql_query("update players set credits=credits+$ilosc where id=$stat[id]");
	}
	if ($rzut == 10) {
		$rzut2 = rand(1,100);
		if ($rzut2 <= 50) {
			print "Nagle poczu³e¶, jak ca³e wyrobisko powoli zaczyna siê rozpadaæ. Najszybciej jak potrafisz próbowa³e¶ biec w kierunku wyj¶cia. Niestety, tym razem ¿ywio³ okaza³ siê szybszy od ciebie. Potê¿na lawina kamieni spad³a na ciebie, zabijaj±c na miejscu";
			$gracz['hp'] = 0;
			mysql_query("update players set hp=0 where id=$stat[id]");
		} else {
			print "Nagle poczu³e¶, jak ca³e wyrobisko powoli zaczyna siê rozpadaæ. Najszybciej jak potrafisz próbowa³e¶ biec w kierunku wyj¶cia. W ostatnim momencie uda³o ci siê wybiec z zagro¿onego wyrobiska, poczu³e¶ jedynie na plecach podmuch wal±cych siê ton ska³.";
		}
	}
	if ($gracz['hp'] > 0) {
		print "<br>Czy chcesz kopaæ ponownie?<br><br>";
		print "<a href=kopalnia.php?akcja=kop>Tak</a><br>";
		print "<a href=gory.php>Nie</a>";
	}
}
require_once("footer.php"); ?>
