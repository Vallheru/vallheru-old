<?php
/***************************************************************************
 *                               equip.php
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

 $title = "Ekwipunek"; require_once("header.php"); ?>

<u>Obecnie u¿ywane przedmioty</u>:<br>

<?php
$wep = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='W' and status='E'"));

if (!empty ($wep['id'])) {
	print "Broñ: $wep[name] (+$wep[power]) (+$wep[szyb]% szyb) ($wep[wt]/$wep[maxwt] wytrzyma³o¶ci) [<a href=\"equip.php?schowaj=".$wep['id']."\">schowaj broñ</a>]<br>\n";
} else {
	print "Broñ: brak<br>\n";
}

$helm = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='H' and status='E'"));

if (!empty ($helm['id'])) {
	print "He³m: $helm[name] (+$helm[power]) ($helm[wt]/$helm[maxwt] wytrzyma³o¶ci) [<a href=\"equip.php?schowaj=".$helm['id']."\">zdejmij</a>]<br>\n";
} else {
	print "He³m: brak<br>\n";
}

$arm = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='A' and status='E'"));

if (!empty ($arm['id'])) {
	print "Zbroja: $arm[name] (+$arm[power]) (-$arm[zr] % zr) ($arm[wt]/$arm[maxwt] wytrzyma³o¶ci) [<a href=\"equip.php?schowaj=".$arm['id']."\">zdejmij</a>]<br>\n";
} else {
	print "Zbroja: brak<br>\n";
}

$legs = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='N' and status='E'"));

if (!empty ($legs['id'])) {
	print "Nagolenniki: $legs[name] (+$legs[power]) (-$legs[zr] % zr) ($legs[wt]/$legs[maxwt] wytrzyma³o¶ci) [<a href=\"equip.php?schowaj=".$legs['id']."\">zdejmij</a>]<br>\n";
} else {
	print "Nagolenniki: brak<br>\n";
}

if (isset($_GET['schowaj'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['schowaj'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$bron = mysql_fetch_array(mysql_query("select * from equipment where id=".$_GET['schowaj']));
	if (empty ($bron['id'])) {
		print "Nie ta rzecz.\n";
		require_once("footer.php");
		exit;
	}

	if ($stat['id'] != $bron['owner']) {
		print "Nie posiadasz tego przedmiotu.\n";
		require_once("footer.php");
		exit;
	}

	mysql_query("update equipment set status='U' where id=".$bron['id']." and owner=".$stat['id']." and status='E'");
	print "<br>(<a href=\"equip.php\">od¶wie¿</a>)<br>\n";
}
if (!(empty ($arm['id']) && empty ($wep['id']))) {
	print "[<A HREF=\"equip.php?napraw_uzywane\">napraw u¿ywane</A>]<BR>\n";
	}
?>


<?php
$wsel = mysql_query("select * from equipment where owner=".$stat['id']." and type='W' and status='U'");

$posiada = false;

while ($wep = mysql_fetch_array($wsel)) {
	if(!$posiada) {
		print"<br><u>Zapasowa broñ</u>:<br>\n";
	}
	$posiada = true;
	$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='".$wep['name']."' and owner=0"));
	$koszt = ceil(($wtmax['cost'] / $wep['maxwt']) / 100);
	if ($koszt < 1) {
		$koszt = 1;
	}
	if ($wep['maxwt'] == $wep['wt']) {
		$koszt = 0;
	}
	$ckoszt = ($koszt * ($wep['maxwt'] - $wep['wt']));
	print $wep['name']." (+".$wep['power'].") (+$wep[szyb]% szyb) (".$wep['wt']."/".$wep['maxwt']." wytrzyma³o¶ci) [ <a href=equip.php?equip=".$wep['id'].">we¼ do rêki</a> | <A href=equip.php?sell=".$wep['id'].">sprzedaj</a> za ".$wep['cost']." sztuk z³ota | <a href=equip.php?napraw=".$wep['id'].">napraw</a> za ".$ckoszt." sztuk z³ota ]<br>";
	}
if($posiada) {
	print "(<a href=\"equip.php?sprzedaj=W\">sprzedaj wszystkie zapasowe bronie</a>)<br>";
}


$asel = mysql_query("select * from equipment where owner=$stat[id] and type='H' and status='U'");

$posiada = false;

while ($arm = mysql_fetch_array($asel)) {
	if(!$posiada) {
		print "<br><u>Zapasowe he³my</u>:<br>\n";
	}
	$posiada = true;
	$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='$arm[name]' and owner=0"));
	$koszt = ceil(($wtmax['cost'] / $arm['maxwt']) / 100);
	if ($koszt < 1) {
		$koszt = 1;
	}
	if ($arm['maxwt'] == $arm['wt']) {
		$koszt = 0;
	}
	$ckoszt = ($koszt * ($arm['maxwt'] - $arm['wt']));
	print "$arm[name] (+$arm[power]) ($arm[wt]/$arm[maxwt] wytrzyma³o¶ci) [ <a href=\"equip.php?equip=".$arm['id']."\">za³ó¿</a> | <A href=\"equip.php?sell=".$arm['id']."\">sprzedaj</a> za ".$arm['cost']." sztuk z³ota | <a href=\"equip.php?napraw=".$arm['id']."\">napraw</a> za ".$ckoszt." sztuk z³ota ]<br>";
}
if($posiada) {
	print "(<a href=\"equip.php?sprzedaj=H\">sprzedaj wszystkie zapasowe he³my</a>)<br>\n";
}


$asel = mysql_query("select * from equipment where owner=$stat[id] and type='A' and status='U'");

$posiada = false;

while ($arm = mysql_fetch_array($asel)) {
	if(!$posiada) {
		print "<br><u>Zapasowe zbroje</u>:<br>\n";
	}
	$posiada = true;
	$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='$arm[name]' and owner=0"));
	$koszt = ceil(($wtmax['cost'] / $arm['maxwt']) / 100);
	if ($koszt < 1) {
		$koszt = 1;
	}
	if ($arm['maxwt'] == $arm['wt']) {
		$koszt = 0;
	}
	$ckoszt = ($koszt * ($arm['maxwt'] - $arm['wt']));
	print "$arm[name] (+$arm[power]) (-$arm[zr]% zr) ($arm[wt]/$arm[maxwt] wytrzyma³o¶ci) [ <a href=\"equip.php?equip=".$arm['id']."\">za³ó¿</a> | <A href=\"equip.php?sell=".$arm['id']."\">sprzedaj</a> za ".$arm['cost']." sztuk z³ota | <a href=\"equip.php?napraw=".$arm['id']."\">napraw</a> za ".$ckoszt." sztuk z³ota ]<br>";
}
if($posiada) {
	print "(<a href=\"equip.php?sprzedaj=A\">sprzedaj wszystkie zapasowe zbroje</a>)<br>\n";
}


$asel = mysql_query("select * from equipment where owner=$stat[id] and type='N' and status='U'");

$posiada = false;

while ($arm = mysql_fetch_array($asel)) {
	if(!$posiada) {
		print "<br><u>Zapasowe nagolenniki</u>:<br>\n";
	}
	$posiada = true;
	$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='$arm[name]' and owner=0"));
	$koszt = ceil(($wtmax['cost'] / $arm['maxwt']) / 100);
	if ($koszt < 1) {
		$koszt = 1;
	}
	if ($arm['maxwt'] == $arm['wt']) {
		$koszt = 0;
	}
	$ckoszt = ($koszt * ($arm['maxwt'] - $arm['wt']));
	print "$arm[name] (+$arm[power]) (-$arm[zr]% zr) ($arm[wt]/$arm[maxwt] wytrzyma³o¶ci) [ <a href=\"equip.php?equip=".$arm['id']."\">za³ó¿</a> | <A href=\"equip.php?sell=".$arm['id']."\">sprzedaj</a> za ".$arm['cost']." sztuk z³ota | <a href=\"equip.php?napraw=".$arm['id']."\">napraw</a> za ".$ckoszt." sztuk z³ota ]<br>";
}
if($posiada) {
	print "(<a href=\"equip.php?sprzedaj=N\">sprzedaj wszystkie zapasowe nagolenniki</a>)<br>\n";
}


$miks = mysql_query("select * from mikstury where gracz=$stat[id] and status='K'");

$posiada = false;

while ($mik = mysql_fetch_array($miks)) {
	if(!$posiada) {
		print "<br><u>Mikstury</u>:<br>\n";
	}
	$posiada = true;
	if ($mik['typ'] == 'M') {
		print "$mik[nazwa] ($mik[efekt]) (moc: $mik[moc]%) [ <a href=\"equip.php?wypij=".$mik['id']."\">wypij</a> ] <br>";
	} else {
		print "$mik[nazwa] ($mik[efekt]) [ <a href=\"equip.php?wypij=".$mik['id']."\">wypij</a> ] <br>";
	}
}

if (isset($_GET['equip'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['equip'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$equip = mysql_fetch_array(mysql_query("select * from equipment where id=".$_GET['equip']." and status='U'"));

	if (empty ($equip['id'])) {
		print "Nie ta rzecz.\n";
		require_once("footer.php");
		exit;
	}

	if ($stat['id'] != $equip['owner']) {
		print "Nie posiadasz tego przedmiotu.\n";
		require_once("footer.php");
		exit;
	}

	if ($gracz['level'] < $equip['minlev']) {
		print "Nie masz odpowiednio wysokiego poziomu!\n";
		require_once("footer.php");
		exit;
	}

	mysql_query("update equipment set status='U' where type='".$equip['type']."' and owner=".$stat['id']." and status='E'");
	mysql_query("update equipment set status='E' where id=".$equip['id']." and owner=".$stat['id']);
	print "Wzi±³e¶ ".$equip['name'].". (<a href=\"equip.php\">od¶wie¿</a>)\n";
}

if (isset($_GET['sell'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['sell'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$sell = mysql_fetch_array(mysql_query("select * from equipment where id=".$_GET['sell']));
	$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='".$sell['name']."' and owner=0"));
	if (empty ($sell['id'])) {
		print "Nie ta rzecz.\n";
		require_once("footer.php");
		exit;
	}
	if ($sell['wt'] < $sell['maxwt']) {
		print "Nie mo¿esz sprzedaæ uszkodzonego przedmiotu.\n";
		require_once("footer.php");
		exit;
	}
	if ($stat['id'] != $sell['owner']) {
		print "Nie posiadasz tego przedmiotu.\n";
		require_once("footer.php");
		exit;
	}

	mysql_query("update players set credits=credits+".$sell['cost']." where id=".$stat['id']);
	mysql_query("delete from equipment where id=".$sell['id']);
	print "Sprzeda³e¶ ".$sell['name']." za ".$sell['cost']." sztuk z³ota. (<A href=\"equip.php\">od¶wie¿</a>)";
}
if (isset($_GET['sprzedaj'])) {
	$sprzedaj1 = mysql_query("select * from equipment where type='".$_GET['sprzedaj']."' and status='U' and owner=".$stat['id']);
	if (empty ($sprzedaj1)) {
		print "Nie masz rzeczy na sprzeda¿.\n";
		require_once("footer.php");
		exit;
	}
	$zysk = 0;
	while ($zysk1 = mysql_fetch_array($sprzedaj1)) {
		$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='$zysk1[name]' and owner=0"));
		if ($zysk1['maxwt'] == $zysk1['wt']) {
			$zysk=$zysk+$zysk1['cost'];
			if ($sprzedaj == 'A') {
				$typ = 'zbroje';
			}
			if ($sprzedaj == 'W') {
				$typ = 'bronie';
			}
			if ($sprzedaj == 'H') {
				$typ = 'he³my';
			}
			if ($sprzedaj == 'N') {
				$typ = 'nagolenniki';
			}
			mysql_query("delete from equipment where type='".$sprzedaj."' and status='U' and owner=".$stat['id']);
		}
	}
	mysql_query("update players set credits=credits+".$zysk." where id=".$stat['id']);
	print "<br>Sprzeda³e¶ wszystkie zapasowe ".$typ." za ".$zysk." sztuk z³ota.<br>\n";
	print "(<a href=\"equip.php\">od¶wie¿</a>)<br>\n";
}

if (isset($_GET['napraw_uzywane'])) {
	$rzecz_wynik = mysql_query("select * from equipment where owner = ".$stat['id']." AND status = 'E'");
	$rzecz_wiersz = mysql_fetch_array($rzecz_wynik);
	while($rzecz_wiersz) {
		$wtmax = mysql_fetch_array(mysql_query("select cost from equipment where name='".$rzecz_wiersz['name']."' and owner=0"));
		$koszt = ceil(($wtmax['cost'] / $rzecz_wiersz['maxwt']) / 100);
		if ($koszt < 1) {
			$koszt = 1;
		}
		if ($rzecz_wiersz['maxwt'] != $rzecz_wiersz['wt']) {
		$ckoszt = ($koszt * ($rzecz_wiersz['maxwt'] - $rzecz_wiersz['wt']));
		if ($ckoszt > $gracz['credits']) {
			print "Nie staæ ciê na to!";
			require_once("footer.php");
			exit;
		}
		mysql_query("update equipment set wt=".$rzecz_wiersz['maxwt']." where id=".$rzecz_wiersz['id']);
		mysql_query("update players set credits=credits-".$ckoszt." where id=".$stat['id']);
		print "<BR>Naprawi³e¶ ".$rzecz_wiersz['name']." i kosztowa³o Ciê to ".$ckoszt." szt. z³.<BR>";
		}
		$rzecz_wiersz = mysql_fetch_array($rzecz_wynik);
	}
}

if (isset($_GET['napraw'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['napraw'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$rzecz = mysql_fetch_array(mysql_query("select * from equipment where id=".$_GET['napraw']));
	$wtmax = mysql_fetch_array(mysql_query("select * from equipment where name='".$rzecz['name']."' and owner=0"));
	$koszt = ceil(($wtmax['cost'] / $rzecz['maxwt']) / 100);
	if ($koszt < 1) {
		$koszt = 1;
	}
	$ckoszt = ($koszt * ($rzecz['maxwt'] - $rzecz['wt']));
	if ($rzecz['wt'] == $rzecz['maxwt']) {
		print "Ta rzecz nie wymaga naprawy\n";
		require_once("footer.php");
		exit;
	}
	if (empty ($rzecz['id'])) {
		print "Nie ta rzecz.\n";
		require_once("footer.php");
		exit;
	}
	if ($gracz['credits'] < $ckoszt) {
		print "Nie masz tyle sztuk z³ota!\n";
		require_once("footer.php");
		exit;
	}
	if ($stat['id'] != $rzecz['owner']) {
		print "Nie posiadasz tego przedmiotu.\n";
		require_once("footer.php");
		exit;
	}
	mysql_query("update equipment set wt=".$rzecz['maxwt']." where id=".$_GET['napraw']);
	mysql_query("update players set credits=credits-".$ckoszt." where id=".$stat['id']);
	print "<br>Naprawi³e¶ <b>".$rzecz['name']."</b> za <b>".$ckoszt."</b> sztuk z³ota.<br>\n";
	print "(<a href=\"equip.php\">od¶wie¿</a>)<br>\n";
}
if (isset($_GET['wypij'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wypij'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$miks = mysql_fetch_array(mysql_query("select * from mikstury where status='K' and id=".$_GET['wypij']));
	$gr = mysql_fetch_array(mysql_query("select inteli, pm from players where id=$stat[id]"));
	if (empty ($miks['id'])) {
		print "Nie ta rzecz.\n";
		require_once("footer.php");
		exit;
	}

	if ($stat['id'] != $miks['gracz']) {
		print "Nie posiadasz tego przedmiotu.\n";
		require_once("footer.php");
		exit;
	}
	if ($miks['typ'] == 'M') {
		if ($gracz['pm'] == round($gr['inteli'],0)) {
			print "Nie musisz regenerowaæ punktów magii!";
			require_once("footer.php");
			exit;
		}
		if ($miks['moc'] == 100) {
			mysql_query("update players set pm=$gr[inteli] where id=$stat[id]");
			$efekt = "odzyska³e¶ wszystkie punkty magii";
		} else {
			$moc = ($miks['moc'] / 100);
			$pm = ceil($gr['inteli'] * $moc);
			$pm1 = ($pm + $gr['pm']);
			if ($pm1 > $gr['inteli']) {
				$pm1 = $gr['inteli'];
			}
			mysql_query("update players set pm=$pm1 where id=$stat[id]");
			$efekt = "odzyska³e¶ $pm punktów magii";
		}
	}
	if ($miks['typ'] == 'Z') {
		if ($gracz['hp'] > 0) {
			mysql_query("update players set hp=$gracz[max_hp] where id=$stat[id]");
			$efekt = "odzyska³e¶ wszystkie punkty ¿ycia";
		} else {
			print "Potrzebujesz mikstury wskrzeszaj±cej aby siê uleczyæ!";
			require_once("footer.php");
			exit;
		}
	}
	if ($miks['typ'] == 'W') {
		if ($gracz[hp] <= 0) {
			$pdpr1 = ceil($gracz[exp] / 100);
			$pdpr = ($pdpr1 * 2);
			$pd = ($gracz[exp] - $pdpr);
			mysql_query("update players set exp=$pd where id=$stat[id]");
			mysql_query("update players set hp=max_hp where id=$stat[id]");
			$efekt = "wróci³e¶ do ¿ycia ale straci³e¶ $pdpr punktów do¶wiadczenia";
		} else {
			print "Nie musisz siê wskrzeszaæ!";
			require_once("footer.php");
			exit;
		}
	}
	mysql_query("delete from mikstury where id=$miks[id]");
	print "Wypi³e¶ ".$miks['nazwa']." i $efekt. (<a href=\"equip.php\">od¶wie¿</a>)\n";
}

require_once("footer.php");
?>
