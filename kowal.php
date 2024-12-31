<?php 
/***************************************************************************
 *                               kowal.php
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

$title="Ku¼nia";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['kowal'])) {
     $_GET['kowal'] = '';
}
$gr6 = mysql_fetch_array(mysql_query("select platinum, ability, klasa, rasa from players where id=$stat[id]"));
$mineraly = mysql_fetch_array(mysql_query("select bronz, zelazo, wegiel, adam, meteo, krysztal from kopalnie where gracz=$stat[id]"));
// funkcja sprawdzaj±ca czy postaæ awansowa³a na poziom
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
		mysql_query("update players set ability=ability+$um where id=$eid");
		mysql_query("update players set max_hp=max_hp+$pz where id=$eid");
		mysql_query("update players set max_energy=max_energy+$energia where id=$eid");
	} else {
		mysql_query("update players set exp=exp+$pd where id=$eid");
		mysql_query("update players set ability=ability+$um where id=$eid");
	}
}
if (!$_GET['kowal']) {
	print "Witaj w ku¼ni. Tutaj mo¿esz wyrabiaæ ró¿ne przedmioty. Aby móc je wykonywaæ musisz najpierw posiadaæ plany odpowiedniej rzeczy oraz odpowiedni± ilo¶æ surowców.<br><br>
	<ul>
	<li><a href=kowal.php?kowal=plany>Kup plany przedmiotu</a></li>
	<li><a href=kowal.php?kowal=kuznia>Id¼ do ku¼ni</a></li>
	</ul>";
}
if ($_GET['kowal'] == 'plany') {
	print "Witaj w sklepie dla kowali. Tutaj mo¿esz kupiæ plany przedmiotów, które chcesz wykonywaæ. Aby kupiæ dany plan, musisz mieæ przy sobie odpowiedni± ilo¶æ sztuk z³ota.<br>";
	print "<ul>";
	print "<li><a href=kowal.php?kowal=plany&dalej=W>Kup plany broni</a></li>";
	print "<li><a href=kowal.php?kowal=plany&dalej=A>Kup plany zbroi</a></li>";
	print "<li><a href=kowal.php?kowal=plany&dalej=H>Kup plany he³mu</a></li>";
	print "<li><a href=kowal.php?kowal=plany&dalej=N>Kup plany nagolenników</a></li></ul>";
	if (isset($_GET['dalej'])) {
		if ($_GET['dalej'] != 'W' && $_GET['dalej'] != 'A' && $_GET['dalej'] != 'H' && $_GET['dalej'] != 'N') {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		}
		print " Oto lista dostêpnych planów:";
		print"<table><tr><td width=100><b><u>Nazwa</td><td width=50><b><u>Cena</td><td><b><u>Poziom</td><td><b><u>Opcje</td></tr>";
		$pla = mysql_query("select * from kowal where status='S' and gracz=0 and type='$_GET[dalej]' order by cena asc");
		while ($plany = mysql_fetch_array($pla)) {
			print "<tr><td>$plany[nazwa]</td><td>$plany[cena]</td><td>$plany[poziom]</td><td>- <A href=kowal.php?kowal=plany&buy=$plany[id]>Kup</a></td></tr>";
		}
		print "</table>";
	}
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$plany = mysql_fetch_array(mysql_query("select * from kowal where id=$_GET[buy]"));
	if (empty ($plany['id'])) {
		print "Nie ma takiego planu. Wróæ do <a href=kowal.php?kowal=plany>sklepu</a>.";
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
	mysql_query("insert into kowal (gracz, nazwa, cena, zelazo, wegiel, bronz, status, poziom, mithril, adamant, meteor, krysztal, type) values($stat[id],'$plany[nazwa]',$newcost,$plany[zelazo],$plany[wegiel],$plany[bronz],'N',$plany[poziom], $plany[mithril],$plany[adamant],$plany[meteor],$plany[krysztal],'$plany[type]')") or die("Nie mogê dodaæ planu.");
	print "Zap³aci³e¶ <b>$plany[cena]</b> sztuk z³ota, i kupi³e¶ za to nowy plan przedmiotu: <b>$plany[nazwa]</b>.";
	mysql_query("update players set credits=credits-$plany[cena] where id=$stat[id]");
	}
}
if ($_GET['kowal'] == 'kuznia') {
	if (!isset($_GET['rob']) && !isset($_GET['konty'])) {
		print "Tutaj mo¿esz wykonywaæ przedmioty co do których masz plany. Aby wykonaæ przedmiot, musisz posiadaæ równie¿ odpowiedni± ilo¶æ surowców. Ka¿da próba kosztuje ciebie tyle energii jaki jest poziom przedmiotu. Nawet za nieudan± próbê dostajesz 0,01 do umiejêtno¶ci.";
		$robione = mysql_fetch_array(mysql_query("select * from kowal_praca where gracz=$stat[id]"));
		if (!$robione['nazwa']) {
			print "<ul>";
			print "<li><a href=kowal.php?kowal=kuznia&type=W>Wykonuj broñ</a></li>";
			print "<li><a href=kowal.php?kowal=kuznia&type=A>Wykonuj zbroje</a></li>";
			print "<li><a href=kowal.php?kowal=kuznia&type=H>Wykonuj he³my</a></li>";
			print "<li><a href=kowal.php?kowal=kuznia&type=N>Wykonuj nagolenniki</a></li></ul>";
			if (isset($_GET['type'])) {
				if ($_GET['type'] != 'W' && $_GET['type'] != 'A' && $_GET['type'] != 'H' && $_GET['type'] != 'N') {
					print "Zapomnij o tym!";
					require_once("footer.php");
					exit;
				}
				print " Oto lista przedmiotów, które mo¿esz wykonywaæ. Je¿eli nie masz tyle energii aby wykonaæ ów przedmiot, mo¿esz po prostu wykonywaæ go po kawa³ku:";
				print"<table><tr><td width=100><b><u>Nazwa</td><td width=50><b><u>Poziom</td><td><b><u>Br±zu</td><td><b><u>¯elaza</td><td><b><u>Wêgla</b></u></td><td><b><u>Mithril</u></b></td><td><b><u>Adamantyt</u><b></td><td><b><u>Meteor</u></b></td><td><b><u>Kryszta³</u></b></td></tr>";
				$ku = mysql_query("select * from kowal where status='N' and gracz=$stat[id] and type='$_GET[type]' order by poziom asc");
				while ($kuznia = mysql_fetch_array($ku)) {
					print "<tr><td><a href=kowal.php?kowal=kuznia&dalej=$kuznia[id]>$kuznia[nazwa]</a></td><td>$kuznia[poziom]</td><td>$kuznia[bronz]</td><td>$kuznia[zelazo]</td><td>$kuznia[wegiel]</td><td>$kuznia[mithril]</td><td>$kuznia[adamant]</td><td>$kuznia[meteor]</td><td>$kuznia[krysztal]</td></tr>";
				}
				print "</table>";
			}
		} else {
			print "Oto przedmiot jaki obecnie wykonujesz:";
			print "<table><tr><td width=100><b><u>Nazwa</u></b></td><td width=50><b><u>Wykonany(w %)</u></b></td><td width=50><b><u>Potrzebnej energii</u></b></td></tr>";
			$procent = (($robione['u_energia'] / $robione['c_energia']) * 100);
			$procent = round($procent,"0");
			$need = ($robione['c_energia'] - $robione['u_energia']);
			print "<tr><td><a href=kowal.php?kowal=kuznia&ko=$robione[id]>$robione[nazwa]</a></td><td>$procent</td><td>$need</td></tr></table>";
		}
	}
	if (isset($_GET['ko'])) {
		if ($gracz['hp'] == 0) {
			print "Nie mo¿esz kuæ poniewa¿ jeste¶ martwy!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_GET['ko'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$robione = mysql_fetch_array(mysql_query("select nazwa from kowal_praca where id=$_GET[ko]"));
		print "<form method=post action=kowal.php?kowal=kuznia&konty=$_GET[ko]>";
		print "Przeznacz na wykonanie <b>$robione[nazwa]</b> <input type=text name=razy> energii.";
		print "<input type=submit value=Wykonaj></form>";
	}
	if (isset($_GET['dalej'])) {
		if ($gracz['hp'] == 0) {
			print "Nie mo¿esz kuæ poniewa¿ jeste¶ martwy!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_GET['dalej'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$kuznia = mysql_fetch_array(mysql_query("select * from kowal where id=$_GET[dalej]"));
		print "<form method=post action=kowal.php?kowal=kuznia&rob=$_GET[dalej]>";
		print "Przeznacz na wykonanie <b>$kuznia[nazwa]</b> <input type=text name=razy> energii.";
		print "<input type=submit value=Wykonaj></form>";
	}
	if (isset($_GET['konty'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['konty'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$kont = mysql_fetch_array(mysql_query("select * from kowal_praca where id=$_GET[konty]"));
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($gracz['energy'] < $_POST['razy']) {
			print "Nie masz tyle energii.";
			require_once("footer.php");
			exit;
		}
		$need = ($kont['c_energia'] - $kont['u_energia']);
		if ($_POST['razy'] > $need) {
			print "Nie mo¿esz przeznaczyæ na przedmiot wiêcej energii ni¿ trzeba!";
			require_once("footer.php");
			exit;
		}
		if ($kont['gracz'] != $stat['id']) {
			print "Nie wykonujesz takiego przedmiotu!";
			require_once("footer.php");
			exit;
		}
		if ($gr6['klasa'] == 'Obywatel') {
			$szansa = (($gr6['ability'] * 100) + ($gracz['level'] / 10));
		} else {
			$szansa = $gr6['ability'] * 100;
		}
		$przedmiot = mysql_fetch_array(mysql_query("select * from equipment where name='$kont[nazwa]' and owner=0")) or die("Nie mogê odczytaæ z bazy danych");
		if ($_POST['razy'] == $need) {
			$rzut = (rand(1,100) * $przedmiot['poziom']);
			if ($szansa >= $rzut) {
				$rzut2 = rand(1,100);
				if ($gr6['klasa'] == 'Obywatel') {
					$rzut2 = ($rzut2 + ($gracz['level'] / 10));
				}
				$sila = $przedmiot['power'];
				$zr = $przedmiot['zr'];
				$szyb = $przedmiot['szyb'];
				$wt = $przedmiot['wt'];
				$nazwa = $przedmiot['name'];
				if ($rzut2 >= 90 && $rzut2 < 95) {
					$sila =($przedmiot['power'] + ceil($gr6['ability']));
					$rpd = ($przedmiot['minlev'] *100);
					if ($przedmiot['type'] == 'W') {
						$nazwa = "Smoczy $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'A') {
						$nazwa = "Smocza $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'H') {
						$nazwa = "Smoczy $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'N') {
						$nazwa = "Smocze $przedmiot[name]";
					}
				}
				if ($rzut2 > 98 && $gr6['klasa'] == 'Obywatel') {
					$premia = ceil($gr6['ability'] / 10);
					if ($przedmiot['type'] == 'W') {
						$szyb = $szyb + $premia;
						$nazwa = "Elfi $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'A') {
						$zr = $zr - $premia;
						$nazwa = "Elfia $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'H') {
						$nazwa = "Elfi $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'N') {
						$zr = $zr - $premia;
						$nazwa = "Elfie $przedmiot[name]";
					}
					$rpd = ($przedmiot['minlev'] * 200);
				}
				if ($rzut2 > 94 && $rzut2 < 99 && $gr6['klasa'] == 'Obywatel') {
					$wt = ($wt + ceil($gr6['ability']));
					$rpd = ($przedmiot['minlev'] * 150);
					if ($przedmiot['type'] == 'W') {
						$nazwa = "Krasnoludzki $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'A') {
						$nazwa = "Krasnoludzka $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'H') {
						$nazwa = "Krasnoludzki $przedmiot[name]";
					}
					if ($przedmiot['type'] == 'N') {
						$nazwa = "Krasnoludzkie $przedmiot[name]";
					}
				}
				if ($rzut2 < 90) {
					$rpd = $przedmiot['minlev'];
				}
				$rum = ($przedmiot['minlev'] / 100);
				$cena = ($przedmiot['cost'] / 20);
				mysql_query("insert into equipment (owner, name, power, type, cost, status, minlev, zr, wt, szyb, maxwt) values($stat[id],'$nazwa',$sila,'$przedmiot[type]',$cena,'U',$przedmiot[minlev],$zr,$wt,$szyb,$wt)") or die("Nie mogê dodaæ przedmiotu.");
				print "Wykona³e¶ <b>$kont[nazwa]</b>. Zdobywasz <b>$rpd</b> PD oraz <b>$rum</b> poziomu w umiejêtno¶ci Kowalstwo.<br>";
			} else {
				$rum = 0.01;
				$rpd = 0;
				print "Próbowa³e¶ wykonaæ <b>$kont[nazwa]</b>, niestety nie uda³o siê. Zdobywasz <b>$rum</b> poziomu w umiejêtno¶ci Kowalstwo.<br>";
			}
			mysql_query("delete from kowal_praca where gracz=$stat[id]");
			checkexp($gracz['exp'],$gracz['level'],$gr6['rasa'],$stat['id'],$gracz['user'],$rpd,$rum);
		} else {
			$uenergia = ($_POST['razy'] + $kont['u_energia']);
			$procent = (($uenergia / $kont['c_energia']) * 100);
			$procent = round($procent,"0");
			$need = $kont['c_energia'] - $uenergia;
			print "Po¶wiêci³e¶ na wykonanie $kont[nazwa] kolejne $_POST[razy] energii. Teraz jest on wykonany w $procent procentach. Aby go ukonczyæ potrzebujesz $need energii.";
			mysql_query("update kowal_praca set u_energia=u_energia+$_POST[razy] where gracz=$stat[id]");
		}
		mysql_query("update players set energy=energy-$_POST[razy] where id=$stat[id]");
	}
	if (isset($_GET['rob'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['rob'])) {
			print "Zapomnij o tym.";
			require_once("footer.php");
			exit;
		}
		$kuznia = mysql_fetch_array(mysql_query("select * from kowal where id=$_GET[rob]"));
		$ilosc = floor($_POST['razy'] / $kuznia['poziom']);
		if ($ilosc >= 1) {
			$rbronz = ($ilosc * $kuznia['bronz']);
			$rzelazo = ($ilosc * $kuznia['zelazo']);
			$rwegiel = ($ilosc * $kuznia['wegiel']);
			$rmithril = ($ilosc * $kuznia['mithril']);
			$radam = ($ilosc * $kuznia['adamant']);
			$rmeteo = ($ilosc * $kuznia['meteor']);
			$rkrysztal = ($ilosc * $kuznia['krysztal']);
		} else {
			$rbronz = ($kuznia['bronz']);
			$rzelazo = ($kuznia['zelazo']);
			$rwegiel = ($kuznia['wegiel']);
			$rmithril = ($kuznia['mithril']);
			$radam = ($kuznia['adamant']);
			$rmeteo = ($kuznia['meteor']);
			$rkrysztal = ($kuznia['krysztal']);
		}
		if ($mineraly['bronz'] < $rbronz || $mineraly['zelazo'] < $rzelazo || $mineraly['wegiel'] < $rwegiel || $gr6['platinum'] < $rmithril || $mineraly['adam'] < $radam || $mineraly['meteo'] < $rmeteo || $mineraly['krysztal'] < $krysztal) {
			print "Nie masz tylu materia³ów!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($gracz['energy'] < $_POST['razy']) {
			print "Nie masz tyle energii.";
			require_once("footer.php");
			exit;
		}
		if ($kuznia['gracz'] != $stat['id']) {
			print "Nie masz takiego planu";
			require_once("footer.php");
			exit;
		}
		if ($gr6['klasa'] == 'Obywatel') {
			$szansa = (($gr6['ability'] * 100) + ($gracz['level'] / 10));
		} else {
			$szansa = $gr6['ability'] * 100;
		}
		$rprzedmiot = 0;
		$rpd = 0;
		$rum = 0;
		$przedmiot = mysql_fetch_array(mysql_query("select * from equipment where name='$kuznia[nazwa]' and owner=0")) or die("Nie mogê odczytaæ z bazy danych");
		if ($ilosc > 0) {
			for ($i=1;$i<=$ilosc;$i++) {
				$rzut = (rand(1,100) * $kuznia['poziom']);
				if ($szansa >= $rzut) {
					$rzut2 = rand(1,100);
					if ($gr6['klasa'] == 'Obywatel') {
						$rzut2 = ($rzut2 + ($gracz['level'] / 10));
					}
					$sila = $przedmiot['power'];
					$zr = $przedmiot['zr'];
					$szyb = $przedmiot['szyb'];
					$wt = $przedmiot['wt'];
					$nazwa = $przedmiot['name'];
					if ($rzut2 >= 90 && $rzut2 < 95) {
						$sila =($przedmiot['power'] + ceil($gr6['ability']));
						$rpd = ($rpd + ($przedmiot['minlev'] * 100));
						if ($przedmiot['type'] == 'W') {
							$nazwa = "Smoczy $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'A') {
							$nazwa = "Smocza $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'H') {
							$nazwa = "Smoczy $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'N') {
							$nazwa = "Smocze $przedmiot[name]";
						}
					}
					if ($rzut2 > 98 && $gr6['klasa'] == 'Obywatel') {
						$premia = ceil($gr6['ability'] / 10);
						if ($przedmiot['type'] == 'W') {
							$szyb = $szyb + $premia;
							$nazwa = "Elfi $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'A') {
							$zr = $zr - $premia;
							$nazwa = "Elfia $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'H') {
							$nazwa = "Elfi $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'N') {
							$zr = $zr - $premia;
							$nazwa = "Elfie $przedmiot[name]";
						}
						$rpd = ($rpd + ($przedmiot['minlev'] * 200));
					}
					if ($rzut2 > 94 && $rzut2 < 99 && $gr6['klasa'] == 'Obywatel') {
						$wt = ($wt + ceil($gr6['ability']));
						$rpd = ($rpd + ($przedmiot['minlev'] *150));
						if ($przedmiot['type'] == 'W') {
							$nazwa = "Krasnoludzki $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'A') {
							$nazwa = "Krasnoludzka $przedmiot[name]";
						}
						if ($przedmiot['type'] == 'H') {
							$nazwa = "Krasnoludzki $przedmiot[name]";
						}
						if ($przedmiot ['type'] == 'N') {
							$nazwa = "Krasnoludzkie $przedmiot[name]";
						}
					}
					if ($rzut2 < 90) {
						$rpd = ($rpd + ($przedmiot['minlev']));
					}
					$rprzedmiot = ($rprzedmiot + 1);
					$rum = ($rum + ($kuznia['poziom'] / 100));
					$cena = ($przedmiot['cost'] / 20);
					mysql_query("insert into equipment (owner, name, power, type, cost, status, minlev, zr, wt, szyb, maxwt) values($stat[id],'$nazwa',$sila,'$przedmiot[type]',$cena,'U',$przedmiot[minlev],$zr,$wt,$szyb,$wt)") or die("Nie mogê dodaæ przedmiotu.");
				} else {
					$rum = ($rum + 0.01);
				}
			}
			print "Wykona³e¶ <b>$kuznia[nazwa]</b> <b>$rprzedmiot</b> razy. Zdobywasz <b>$rpd</b> PD oraz <b>$rum</b> poziomu w umiejêtno¶ci Kowalstwo.<br>";
			checkexp($gracz['exp'],$gracz['level'],$gr6['rasa'],$stat['id'],$gracz['user'],$rpd,$rum);
		} else {
			$procent = (($_POST['razy'] / $kuznia['poziom']) * 100);
			$procent = round($procent,"0");
			$need = ($kuznia['poziom'] - $_POST['razy']);
			print "Pracowa³e¶ nad $kuznia[nazwa], zu¿ywaj±c $_POST[razy] energii i wykona³e¶ go w $procent procentach. Aby ukoñczyæ przedmiot potrzebujesz jeszcze $need energii.";
			mysql_query("insert into kowal_praca (gracz, nazwa, u_energia, c_energia) values($stat[id],'$kuznia[nazwa]',$_POST[razy],$kuznia[poziom])") or die ("nie mogê dodaæ przedmiotu");
		}
		mysql_query("update kopalnie set bronz=bronz-$rbronz where gracz=$stat[id]");
		mysql_query("update kopalnie set zelazo=zelazo-$rzelazo where gracz=$stat[id]");
		mysql_query("update kopalnie set wegiel=wegiel-$rwegiel where gracz=$stat[id]");
		mysql_query("update kopalnie set platinum=platinum-$rmithril where gracz=$stat[id]");
		mysql_query("update kopalnie set adam=adam-$radam where gracz=$stat[id]");
		mysql_query("update kopalnie set meteo=meteo-$rmeteo where gracz=$stat[id]");
		mysql_query("update kopalnie set krysztal=krysztal-$rkrysztal where gracz=$stat[id]");
		mysql_query("update players set energy=energy-$_POST[razy] where id=$stat[id]");
	}
}
if ($_GET['kowal']) {
	print "<br><br><a href=kowal.php>(wróæ)</a>";
}
require_once("footer.php"); ?>
