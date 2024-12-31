<?php
/***************************************************************************
 *                               alchemik.php
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

$title="Pracownia alchemiczna";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['alchemik'])) {
     $_GET['alchemik'] = '';
}
$gr6 = mysql_fetch_array(mysql_query("select alchemia, klasa, rasa from players where id=$stat[id]"));
$herb = mysql_fetch_array(mysql_query("select illani, illanias, nutari from herbs where gracz=$stat[id]"));
// funkcja sprawdzaj±ca czy gracz awansowa³ na poziom
function checkexp($exp,$level,$rasa,$eid,$user,$pd,$um) {
	$texp = ($exp + $pd);
	$expn = ($level * 200);
	$poziom = 0;
	$ap = 0;
	$pz = 0;
	$energia = 0;
	while ($texp >= $expn) {
		$poziom = ($poziom + 1);
		$ap = ($ap + 5);
		$texp = ($texp - $expn);
		$expn = ($level * 200);
		if ($rasa == 'Cz³owiek') {
			$pz = $pz + 5;
		}
		if ($rasa == 'Elf') {
			$pz = $pz + 4;
		}
		if ($rasa == 'Krasnolud') {
			$pz = $pz + 6;
		}
		$energia = $energia + 0.5;
	}
	if ($poziom > 0) {
		print "<b>$user</b> zdobywa poziom! <b>$ap</b> AP, <b>$poziom</b> Poziom(ów) oraz <b>$pz</b> Maksymalnych Punktów ¯ycia i <b>$energia</b> Maksymalnej Energii";
		mysql_query("update players set level=level+$poziom where id=$eid");
		mysql_query("update players set ap=ap+$ap where id=$eid");
		mysql_query("update players set exp=$texp where id=$eid");
		mysql_query("update players set alchemia=alchemia+$um where id=$eid");
		mysql_query("update players set max_hp=max_hp+$pz where id=$eid");
		mysql_query("update players set max_energy=max_energy+$energia where id=$eid");
	} else {
		mysql_query("update players set exp=exp+$pd where id=$eid");
		mysql_query("update players set alchemia=alchemia+$um where id=$eid");
	}
}
if (!$_GET['alchemik']) {
	print "Witaj w pracowni alchemika. Tutaj mo¿esz wyrabiaæ ró¿ne mikstury. Aby móc je wykonywaæ musisz najpierw posiadaæ przepis na odpowiedni± miksturê oraz odpowiedni± ilo¶æ zió³.<br><br>
	<ul>
	<li><a href=alchemik.php?alchemik=przepisy>Kup przepis na miksturê</a></li>
	<li><a href=alchemik.php?alchemik=pracownia>Id¼ do pracowni</a></li>
	</ul>";
}
if ($_GET['alchemik'] == 'przepisy') {
	print "Witaj w sklepie dla alchemików. Tutaj mo¿esz kupiæ przepisy mikstur, które chcesz wykonywaæ. Aby kupiæ dany przepis, musisz mieæ przy sobie odpowiedni± ilo¶æ sztuk z³ota. Oto lista dostêpnych przepisów:";
	print"<table><tr><td width=100><b><u>Nazwa</td><td width=50><b><u>Cena</td><td><b><u>Poziom</td><td><b><u>Opcje</td></tr>";
	$pla = mysql_query("select * from alchemik where status='S' and gracz=0 order by cena asc");
	while ($plany = mysql_fetch_array($pla)) {
		print "<tr><td>$plany[nazwa]</td><td>$plany[cena]</td><td>$plany[poziom]</td><td>- <A href=alchemik.php?alchemik=przepisy&buy=$plany[id]>Kup</a></td></tr>";
	}
	print "</table>";
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		}
		$plany = mysql_fetch_array(mysql_query("select * from alchemik where id=$_GET[buy]"));
	if (empty($plany['id'])) {
		print "Nie ma takiego przepisu. Wróæ do <a href=alchemik.php?alchemik=przepisy>sklepu</a>.";
		require_once("footer.php");
		exit;
	}
	if ($plany['status'] != 'S') {
		print "Tutaj tego nie sprzedasz.";
		require_once("footer.php");
		exit;
	}
	if ($plany['cena'] > $gracz['credits']) {
		print "Nie staæ ciê!";
		require_once("footer.php");
		exit;
	}
	$newcost = ceil($plany['cena'] * .75);
	mysql_query("insert into alchemik (gracz, nazwa, cena, status, poziom, illani, illanias, nutari) values($stat[id],'$plany[nazwa]',$newcost,'N',$plany[poziom],$plany[illani],$plany[illanias],$plany[nutari])") or die("Nie mogê dodaæ przepisu.");
	print "Zap³aci³e¶ <b>$plany[cena]</b> sztuk z³ota, i kupi³e¶ za to nowy przepis na: <b>$plany[nazwa]</b>.";
	mysql_query("update players set credits=credits-$plany[cena] where id=$stat[id]");
	}
}
if ($_GET['alchemik'] == 'pracownia') {
	if (!isset($_GET['rob'])) {
		print "Tutaj mo¿esz wykonywaæ mikstury co do których masz przepisy. Aby wykonaæ miksturê, musisz posiadaæ równie¿ odpowiedni± ilo¶æ zió³. Ka¿da próba kosztuje ciebie 1 punkt energii. Nawet za nieudan± próbê dostajesz 0,01 do umiejêtno¶ci.";
		print " Oto lista mikstur, które mo¿esz wykonywaæ:";
		print"<table><tr><td width=100><b><u>Nazwa</td><td width=50><b><u>Poziom</td><td><b><u>Illani</td><td><b><u>Illanias</td><td><b><u>Nutari</b></u></td></tr>";
		$ku = mysql_query("select * from alchemik where status='N' and gracz=$stat[id] order by poziom asc");
		while ($kuznia = mysql_fetch_array($ku)) {
			print "<tr><td><a href=alchemik.php?alchemik=pracownia&dalej=$kuznia[id]>$kuznia[nazwa]</a></td><td>$kuznia[poziom]</td><td>$kuznia[illani]</td><td>$kuznia[illanias]</td><td>$kuznia[nutari]</td></tr>";
		}
		print "</table>";
	}
	if (isset($_GET['dalej'])) {
		if ($gracz['hp'] == 0) {
			print "Nie mo¿esz wykonywaæ mikstur poniewa¿ jeste¶ martwy!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_GET['dalej'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$kuznia = mysql_fetch_array(mysql_query("select * from alchemik where id=$_GET[dalej]"));
		print "<form method=post action=alchemik.php?alchemik=pracownia&rob=$dalej>";
		print "Spróbuj wykonaæ <b>$kuznia[nazwa]</b> <input type=text name=razy> razy.";
		print "<input type=submit value=Wykonaj></form>";
	}
	if (isset($_GET['rob'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['rob'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$kuznia = mysql_fetch_array(mysql_query("select * from alchemik where id=$_GET[rob]"));
		$rillani = ($_POST['razy'] * $kuznia['illani']);
		$rillanias = ($_POST['razy'] * $kuznia['illanias']);
		$rnutari = ($_POST['razy'] * $kuznia['nutari']);
		if ($herb['illani'] < $rillani || $herb['illanias'] < $rillanias || $herb['nutari'] < $rnutari) {
			print "Nie masz tylu zió³!";
			require_once("footer.php");
			exit;
		}
		if ($gracz['energy'] < $_POST['razy']) {
			print "Nie masz tyle energii.";
			require_once("footer.php");
			exit;
		}
		if ($kuznia['gracz'] != $stat['id']) {
			print "Nie masz takiego przepisu";
			require_once("footer.php");
			exit;
		}
		if ($gr6['klasa'] == 'Obywatel') {
			$szansa = (($gr6['alchemia'] * 100) + ($gracz['level'] / 10));
		} else {
			$szansa = $gr6['alchemia'] * 100;
		}
		$rprzedmiot = 0;
		$rpd = 0;
		$rum = 0;
		$przedmiot = mysql_fetch_array(mysql_query("select * from mikstury where nazwa='$kuznia[nazwa]' and gracz=0")) or die("Nie mogê odczytaæ z bazy danych");
		for ($i=1;$i<=$_POST['razy'];$i++) {
			$rzut = (rand(1,100) * $kuznia['poziom']);
			if ($szansa >= $rzut) {
				$rprzedmiot = ($rprzedmiot + 1);
				$rpd = ($rpd + $kuznia['poziom']);
				$rum = ($rum + ($kuznia['poziom'] / 100));
				mysql_query("insert into mikstury (gracz, nazwa, typ, efekt, status, moc) values($stat[id],'$przedmiot[nazwa]','$przedmiot[typ]','$przedmiot[efekt]','K',$przedmiot[moc])") or die("Nie mogê dodaæ mikstury.");
			} else {
				$rum = ($rum + 0.01);
			}
		}
		print "Wykona³e¶ <b>$kuznia[nazwa]</b> <b>$rprzedmiot</b> razy. Zdobywasz <b>$rpd</b> PD oraz <b>$rum</b> poziomu w umiejêtno¶ci Alchemia.<br>";
		checkexp($gracz['exp'],$gracz['level'],$gr6['rasa'],$stat['id'],$gracz['user'],$rpd,$rum);
		mysql_query("update herbs set illani=illani-$rillani where gracz=$stat[id]");
		mysql_query("update herbs set illanias=illanias-$rillanias where gracz=$stat[id]");
		mysql_query("update herbs set nutari=nutari-$rnutari where gracz=$stat[id]");
		mysql_query("update players set energy=energy-$_POST[razy] where id=$stat[id]");
	}
}
if ($_GET['alchemik']) {
	print "<br><br><a href=alchemik.php>(wróæ)</a>";
}
require_once("footer.php"); ?>
