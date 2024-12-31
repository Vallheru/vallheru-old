<?php 
/***************************************************************************
 *                               tribes.php
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

$title = "Klany"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!isset($_GET['step2'])) {
     $_GET['step2'] = '';
}
if (!isset($_GET['step3'])) {
     $_GET['step3'] = '';
}
if (!isset($_GET['daj'])) {
     $_GET['daj'] = '';
}
if (!isset($_GET['step4'])) {
     $_GET['step4'] = '';
}
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if (!$_GET['view'] && !isset($_GET['join'])) {
	print "Witaj w Domu Klan�w. Tutaj mo�esz zobaczy�, do��czy� lub nawet stworzy� nowy klan.";
	print "<ul>";
	if ($gracz['tribe']) {
		$mytribe = mysql_fetch_array(mysql_query("select * from tribes where id=$gracz[tribe]"));
		print "<li><a href=tribes.php?view=my>M�j klan</a> ($mytribe[name])";
	} else {
		print "<li>M�j klan";
	}
	if (!$gracz['tribe'] && $gracz['credits'] >= 2500000) {
		print "<li><a href=tribes.php?view=make>Stw�rz nowy klan</a> (2,500,000 sztuk z�ota)";
	} else {
		print "<li>Stw�rz nowy klan (2,500,000 sztuk z�ota)";
	}
	print "<li><a href=tribes.php?view=all>Zobacz list� klan�w</a>";
	print "</ul>";
}

if ($_GET['view'] == 'all') {
	print "Tutaj jest lista wszystkich klan�w.";
	$numt = mysql_num_rows(mysql_query("select * from tribes"));
	if ($numt <= 0) {
		print "<br>Na razie nie ma jakiegokolwiek klanu.";
	} else {
		print "<ul>";
		$tsel = mysql_query("select * from tribes");
		while ($tribe = mysql_fetch_array($tsel)) {
			print "<li><a href=tribes.php?view=view&id=$tribe[id]>$tribe[name]</a>, ID Przyw�dcy <a href=view.php?view=$tribe[owner]>$tribe[owner]</a>.";
		}
	}
}

if ($_GET['view'] == 'view') {
	if (!$_GET['step']) {
	$tribe = mysql_fetch_array(mysql_query("select * from tribes where id=$_GET[id]"));
	if (!$tribe['id']) {
		print "Nie ten klan.";
	} else {
		print "<ul>";
		print "<li>Ogl�dasz: $tribe[name]<br><br>";
		$plik = 'images/tribes/'.$tribe['logo'];
		if (is_file($plik)) {
			print "<center><img src=$plik height=100></center><br>";
		}
		print "Przyw�dca: ID <a href=view.php?view=$tribe[owner]>$tribe[owner]</a><br><br>";
		$memnum = mysql_num_rows(mysql_query("select id from players where tribe=$tribe[id]"));
		print "Liczba cz�onk�w: $memnum<br>";
		print "<a href=tribes.php?view=view&step=members&tid=$tribe[id]>Cz�onkowie</a><br>";
		print "Wygranych walk: $tribe[wygr]<br>";
		print "Przegranych walk: $tribe[przeg]<br>";
		if (!empty($tribe['www'])) {
			print "Strona klanu: <a href=http://$tribe[www] target=_blank>$tribe[www]</a>";
		}
		print "$tribe[public_msg]<br><br>";
		print "<form method=post action=tribes.php?join=$tribe[id]>";
		print "Do��cz do klanu $tribe[name]<br>";
		print "<input type=submit value=Do��cz>";
		print "</form>";
	}
	}
	if ($_GET['step'] == 'members') {
	        if (!ereg("^[1-9][0-9]*$", $_GET[tid])) {
	           print "Zapomnij o tym!";
	           require_once("footer.php");
	           exit;
	        }
	        $tribename = mysql_fetch_array(mysql_query("select name, owner from tribes where id=$_GET[tid]"));
	        print "Lista cz�onk�w klanu $tribename[name]<br>";
		$msel = mysql_query("select id, user from players where tribe=$_GET[tid]");
		while ($mem = mysql_fetch_array($msel)) {
			if ($mem['id'] == $tribename['owner']) {
				print "- <a href=view.php?view=$mem[id]>$mem[user]</a> ($mem[id]) (Przyw�dca)<br>";
			} else {
				print "- <a href=view.php?view=$mem[id]>$mem[user]</a> ($mem[id])<br>";
			}
		}
	}
}

if (isset($_GET['join'])) {
	$tribe = mysql_fetch_array(mysql_query("select * from tribes where id=$_GET[join]"));
	$test = mysql_fetch_array(mysql_query("select gracz from tribe_oczek where gracz=$stat[id]"));
	if (!$_GET['change']) {
		if (!empty($test['gracz'])) {
			print "Oczekujesz ju� na wej�cie do innego klanu! Czy chcesz zmieni� swoje zg�oszenie?<br>";
			print "<a href=tribes.php?join&change=$test[gracz]>Tak</a><br>";
			print "<a href=tribes.php>Nie</a><br>";
		}
		if ($gracz['tribe']) {
			print "Jeste� w klanie!";
			require_once("footer.php");
			exit;
		}
		mysql_query("insert into tribe_oczek (gracz, klan) values($stat[id],$tribe[id])");
	} else {
		mysql_query("update tribe_oczek set klan=$tribe[id] where gracz=$stat[id]");
	}
	print "Wys�a�e� swoje zg�oszenie do klanu $tribe[name].";
	$czas = date("y-m-d H:i:s");
	mysql_query("insert into log (owner,log, czas) values($tribe[owner],'Gracz $gracz[user] o ID $stat[id] prosi o przyj�cie do klanu.','$czas')");

}

if ($_GET['view'] == 'make') {
	if ($gracz['credits'] < 2500000) {
		print "Nie masz tylu sztuk z�ota.";
		require_once("footer.php");
		exit;
	}
	if ($gracz['tribe']) {
		print "Jeste� ju� w klanie.";
		require_once("footer.php");
		exit;
	}
	print "<table><form method=post action=tribes.php?view=make&step=make>";
	print "<tr><td>Nazwa klanu:</td><td><input type=text name=name></td></tr>";
	print "<tr><td colspan=2 align=center><input type=submit value=Za��></td></tr>";
	print "</form></table>";
	if ($_GET['step'] == 'make') {
		if (!$_POST['name']) {
			print "Wype�nij obydwa pola.";
		} else {
			print "Stworzy�e� nowy klan, <i>".strip_tags($_POST['name'])."</i>.<br>";
			mysql_query("insert into tribes (name,owner) values('".strip_tags($_POST['name'])."',$stat[id])");
			mysql_query("update players set credits=credits-2500000 where id=$stat[id]");
			$newt = mysql_fetch_array(mysql_query("select * from tribes where owner=$stat[id]"));
			mysql_query("update players set tribe=$newt[id] where id=$stat[id]");
		}
	}
}
if ($_GET['view'] == 'my') {
	if (!$gracz['tribe']) {
		print "Nie jeste� w klanie!";
	} else {
		$mytribe = mysql_fetch_array(mysql_query("select * from tribes where id=$gracz[tribe]"));
		$perm = mysql_fetch_array(mysql_query("select * from tribe_perm where tribe=$mytribe[id]"));
		print "<br><center><table width=98% class=td cellpadding=0 cellspacing=0>";
		print "<tr><td align=center style=\"border-bottom: solid black 1px;\"><b>Moj klan: $mytribe[name]</td></tr>";
		print "</td><td width=100% valign=top>";
		if (!$_GET['step']) {
			$plik = 'images/tribes/'.$mytribe['logo'];
			if (is_file($plik)) {
				print "<center><img src=$plik height=100></center><br>";
			}
			print "Witaj w swoim klanie.";
			print "<ul>";
			print "<li>Nazwa klanu: $mytribe[name]";
			$memnum = mysql_num_rows(mysql_query("select * from players where tribe=$mytribe[id]"));
			print "<li>Liczba cz�onk�w: $memnum";
			$owner = mysql_fetch_array(mysql_query("select * from players where id=$mytribe[owner]"));
			print "<li>Przyw�dca: <a href=view.php?view=$owner[id]>$owner[user]</a>";
			print "<li>Sztuk z�ota: $mytribe[credits]</li>";
			print "<li>Sztuk mithrilu: $mytribe[platinum]</li>";
			print "<li>Wygranych walk: $mytribe[wygr]</li>";
			print "<li>Przegranych walk: $mytribe[przeg]</li>";
			print "<li>�o�nierzy: $mytribe[zolnierze]</li>";
			print "<li>Fotryfikacji: $mytribe[forty]</li>";
			if (!empty($mytribe['www'])) {
				print "<li>Strona klanu: <a href=http://$mytribe[www] target=_blank>$mytribe[www]</a>";
			}
			print "</ul>";
			print "$mytribe[private_msg]";
		}
		if ($_GET['step'] == 'donate') {
			print "Prosz� daj pieni�dze swojemu klanowi i pom� mu finansowo.";
			print "<form method=post action=tribes.php?view=my&step=donate&step2=donate>";
			print "Dotuj <input type=text size=5 name=amount value=0> <select name=type><option value=credits>Sztuk Z�ota</option><option value=platinum>Sztuk Mithrilu</option></select> do swojego klanu. <input type=submit value=Dotuj>";
			print "</form>";
			if ($_GET['step2'] == 'donate') {
				if ($_POST['type'] == 'credits') {
					$dot = 'sztuk z�ota';
				}
				if ($_POST['type'] == 'platinum') {
					$dot = 'sztuk mithrilu';
				}
				if ($_POST['type'] != 'credits' && $_POST['type'] != 'platinum') {
					print "Zapomnij o tym";
					require_once("footer.php");
					exit;
				}
				$_POST['amount'] = str_replace("--","", $_POST['amount']);
				if ($_POST['amount'] > $gracz[$_POST['type']] || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
					print "Nie masz wystarczaj�co du�o $dot.";
				} else {
					if ($_POST['amount'] < 0) {
						print "dotacja $amount ... ujemna ??";
					} else {
					mysql_query("update players set $_POST[type]=$_POST[type]-$_POST[amount] where id=$stat[id]");
					mysql_query("update tribes set $_POST[type]=$_POST[type]+$_POST[amount] where id=$mytribe[id]");
					print "Da�e� swojemu klanowi <b>$_POST[amount] $dot</b>.";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($mytribe[owner], 'Gracz $gracz[user] ID: $stat[id] doda� do skarbca klanu $_POST[amount] $dot','$czas')");
				}
				}
			}
		}

// zielnik klanu
		if ($_GET['step'] == 'zielnik') {
			if (!$_GET['step2'] && !$_GET['step3'] && !$_GET['daj'] && !$_GET['step4']) {
				print "Witaj w zielniku klanu. Tutaj s� sk�adowane zio�a nale��ce do klanu. Ka�dy cz�onek klanu mo�e ofiarowa� klanowi jakie� zio�a ale tylko przyw�dca lub osoba upowa�niona przez niego mo�e darowa� dane zio�a cz�onkom swojego klanu. Aby da� jakie� zio�a cz�onkom klanu, kliknij na nazw� owego zio�a<br>";
				print "<table>";
				if ($stat['id'] == $mytribe['owner'] || $stat['id'] == $perm['herbs']) {
					print "<tr><td width=100><a href=tribes.php?view=my&step=zielnik&daj=illani><b><u>Illani</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zielnik&daj=illanias><b><u>Illanias</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zielnik&daj=nutari><b><u>Nutari</u></b></a></td></tr>";
				} else {
					print "<tr><td width=100><b><u>Illani</u></b></td><td width=100><b><u>Illanias</u></b></td><td width=100><b><u>Nutari</u></b</td></tr>";
				}
				print "<tr><td align=center>$mytribe[illani]</td><td align=center>$mytribe[illanias]</td><td align=center>$mytribe[nutari]</td></tr>";
				print "</table>";
				print " Co chcesz zrobi�?<br>";
				print "<ul>";
				print "<li><a href=tribes.php?view=my&step=zielnik&step2=daj>Da� zio�a do klanu</a></li></ul>";
			}
			if ($_GET['daj']) {
				if (!$_GET['step4']) {
					if ($_GET['daj'] == 'illani') {
						$min1 = "Illani";
					} elseif ($_GET['daj'] == 'illanias') {
						$min1 = "Illanias";
					} elseif ($_GET['daj'] == 'nutari') {
						$min1 = "Nutari";
					} else {
						print "Zapomnij o tym";
						require_once("footer.php");
						exit;
					}
					print "<form method=post action=tribes.php?view=my&step=zielnik&daj=$_GET[daj]&step4=add>";
					print "Daj graczowi ID: <input type=text name=did><br>";
					print "<input type=text name=ilosc>$min1<br>";
					print "<input type=hidden name=min value=$min1>";
					print "<input type=submit value=Daj><br>";
					print "</form>";
				}
				if ($_GET['step4'] == 'add') {
					if (!ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
					if (!ereg("^[1-9][0-9]*$", $_POST['did'])) {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
					$dtrib = mysql_fetch_array(mysql_query("select tribe from players where id=$_POST[did]"));
					if ($dtrib['tribe'] != $mytribe['id']) {
						print "Ten gracz nie jest w twoim klanie!";
						require_once("footer.php");
						exit;
					}
					if ($mytribe[$daj] < $_POST['ilosc']) {
						print "Klan nie ma takiej ilo�ci $_POST[min]!";
						require_once("footer.php");
						exit;
					}
					$kop = mysql_fetch_array(mysql_query("select * from herbs where gracz=$_POST[did]"));
					if (!$kop) {
						mysql_query("insert into herbs ( gracz, $_GET[daj]) values($_POST[did],$_POST[ilosc])") or die ("Nie mog� doda�");
					} else {
						mysql_query("update herbs set $_GET[daj]=$_GET[daj]+$_POST[ilosc] where gracz=$_POST[did]");
					}
					mysql_query("update tribes set $_GET[daj]=$_GET[daj]-$_POST[ilosc] where id=$mytribe[id]");
					print "Przekaza�e� graczowi ID $_POST[did] $_POST[ilosc] $_POST[min]";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($_POST[did], 'Dosta�e� od klanu $_POST[ilosc] $_POST[min]','$czas')");
				}
			}
			if ($_GET['step2'] == 'daj') {
				print "Dodaj zio�a do zielnika<br><br>";
				print "<table><form method=post action=tribes.php?view=my&step=zielnik&step2=daj&step3=add>";
				print "<tr><td>Zio�o:</td><td><select name=mineral>";
				print "<option value=illani>Illani</option>";
				print "<option value=illanias>Illanias</option>";
				print "<option value=nutari>Nutari</option></select></td></tr>";
				print "<tr><td>Sztuk:</td><td><input type=text name=ilosc></td></tr>";
				print "<tr><td colspan=2 align=center><input type=submit value=Dodaj></td></tr>";
				print "</form></table>";
				if ($_GET['step3'] == 'add') {
					$gr = mysql_fetch_array(mysql_query("select * from herbs where gracz=$stat[id]"));
					if ($_POST['mineral'] == 'illani') {
						$min = 'illani';
						$nazwa = 'Illani';
						if ($_POST['ilosc'] > $gr['illani']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == 'illanias') {
						$min = 'illanias';
						$nazwa = 'Illanias';
						if ($_POST['ilosc'] > $gr['illanias']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == 'nutari') {
						$min = 'nutari';
						$nazwa = 'Nutari';
						if ($_POST['ilosc'] > $gr['nutari']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['ilosc'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
						print "Zapomnij o tym.";
						require_once("footer.php");
						exit;
					}
					mysql_query("update tribes set $min=$min+$_POST[ilosc] where id=$mytribe[id]") or die ("Nie mog� doda� $min!");
					mysql_query("update herbs set $min=$min-$_POST[ilosc] where gracz=$stat[id]");
					print "Doda�e� <b>$_POST[ilosc] $nazwa</b> do zielnika klanu.";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($mytribe[owner], 'Gracz $gracz[user] ID: $stat[id] doda� do zielnika klanu $_POST[ilosc] $nazwa','$czas')");
				}
			}
		}

// skarbiec klanu
		if ($_GET['step'] == 'skarbiec') {
			if (!$_GET['step2'] && !$_GET['step3'] && !$_GET['daj'] && !$_GET['step4']) {
				print "Witaj w skarbcu klanu. Tutaj s� sk�adowane minera�y nale��ce do klanu. Ka�dy cz�onek klanu mo�e ofiarowa� klanowi jaki� minera� ale tylko przyw�dca lub osoba upowa�niona przez niego mo�e darowa� dany minera� cz�onkom swojego klanu. Aby da� jaki� minera� cz�onkom klanu, kliknij na nazw� owego minera�u<br>";
				print "<table>";
				if ($stat['id'] == $mytribe['owner'] || $stat['id'] == $perm['bank']) {
					print "<tr><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=bronz><b><u>Br�z</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=zelazo><b><u>�elazo</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=wegiel><b><u>W�giel</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=adam><b><u>Adamantyt</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=meteo><b><u>Meteor</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=krysztal><b><u>Kryszta�</u></b></a></td></tr>";
				} else {
					print "<tr><td width=100><b><u>Br�z</u></b></td><td width=100><b><u>�elazo</u></b></td><td width=100><b><u>W�giel</u></b</td><td width=100><b><u>Adamantyt</u></b></td><td width=100><b><u>Meteor</u></b></td><td width=100><b><u>Kryszta�</u></b></td></tr>";
				}
				print "<tr><td align=center>$mytribe[bronz]</td><td align=center>$mytribe[zelazo]</td><td align=center>$mytribe[wegiel]</td><td align=center>$mytribe[adam]</td><td align=center>$mytribe[meteo]</td><td align=center>$mytribe[krysztal]</td>";
				print "</table>";
				print " Co chcesz zrobi�?<br>";
				print "<ul>";
				print "<li><a href=tribes.php?view=my&step=skarbiec&step2=daj>Da� minera�y do klanu</a></li></ul>";
			}
			if ($_GET['daj']) {
				if (!$_GET['step4']) {
					if ($_GET['daj'] == 'bronz') {
						$min1 = "br�zu";
					} elseif ($_GET['daj'] == 'zelazo') {
						$min1 = "�elaza";
					} elseif ($_GET['daj'] == 'wegiel') {
						$min1 = "w�gla";
					} elseif ($_GET['daj'] == 'adam') {
						$min1 = "adamantium";
					} elseif ($_GET['daj'] == 'meteo') {
						$min1 = "meteor�w";
					} elseif ($_GET['daj'] == 'krysztal') {
						$min1 = "kryszta��w";
					} else {
						print "Zapomnij o tym!";
						require_once("footer.php");
						exit;
					}
					print "<form method=post action=tribes.php?view=my&step=skarbiec&daj=$_GET[daj]&step4=add>";
					print "Daj graczowi ID: <input type=text name=did><br>";
					print "<input type=text name=ilosc> $min1<br>";
					print "<input type=hidden name=min value=$min1>";
					print "<input type=submit value=Daj><br>";
					print "</form>";
				}
				if ($_GET['step4'] == 'add') {
					if (!ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
					if ($_GET['daj'] != 'bronz' && $_GET['daj'] != 'zelazo' && $_GET['daj'] != 'wegiel' && $_GET['daj'] != 'adam' && $_GET['daj'] != 'meteo') {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
					if (!ereg("^[1-9][0-9]*$", $_POST['did'])) {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
					$dtrib = mysql_fetch_array(mysql_query("select tribe from players where id=$_POST[did]"));
					if ($dtrib['tribe'] != $mytribe['id']) {
						print "Ten gracz nie jest w twoim klanie!";
						require_once("footer.php");
						exit;
					}
					if ($mytribe[$daj] < $_POST['ilosc']) {
						print "Klan nie ma takiej ilo�ci $_POST[min]!";
						require_once("footer.php");
						exit;
					}
					$kop = mysql_fetch_array(mysql_query("select * from kopalnie where gracz=$_POST[did]"));
					if (!$kop) {
						mysql_query("insert into kopalnie ( gracz, $daj) values($_POST[did],$_POST[ilosc])") or die ("Nie mog� doda�");
					} else {
						mysql_query("update kopalnie set $daj=$daj+$_POST[ilosc] where gracz=$_POST[did]");
					}
					mysql_query("update tribes set $daj=$daj-$_POST[ilosc] where id=$mytribe[id]");
					print "Przekaza�e� graczowi ID $_POST[did] $_POST[ilosc] $_POST[min]";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($_POST[did], 'Dosta�e� od klanu $_POST[ilosc] $_POST[min]','$czas')");
				}
			}
			if ($_GET['step2'] == 'daj') {
				print "Dodaj minera��w do skarbca<br><br>";
				print "<table><form method=post action=tribes.php?view=my&step=skarbiec&step2=daj&step3=add>";
				print "<tr><td>Minera�:</td><td><select name=mineral>";
				print "<option value=br�z>Br�z</option>";
				print "<option value=�elazo>�elazo</option>";
				print "<option value=w�giel>W�giel</option>";
				print "<option value=adamantyt>Adamantyt</option>";
				print "<option value=meteoryt>Meteor</option>";
				print "<option value=kryszta�>Kryszta�</option></select></td></tr>";
				print "<tr><td>Ilo�� minera�u:</td><td><input type=text name=ilosc></td></tr>";
				print "<tr><td colspan=2 align=center><input type=submit value=Dodaj></td></tr>";
				print "</form></table>";
				if ($_GET['step3'] == 'add') {
					$gr = mysql_fetch_array(mysql_query("select * from kopalnie where gracz=$stat[id]"));
					if ($_POST['mineral'] == 'br�z') {
						$min = 'bronz';
						$nazwa = 'br�zu';
						if ($_POST['ilosc'] > $gr['bronz']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == '�elazo') {
						$min = 'zelazo';
						$nazwa = '�elaza';
						if ($_POST['ilosc'] > $gr['zelazo']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == 'w�giel') {
						$min = 'wegiel';
						$nazwa = 'w�gla';
						if ($_POST['ilosc'] > $gr['wegiel']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == 'adamantyt') {
						$min = 'adam';
						$nazwa = 'adamantium';
						if ($_POST['ilosc'] > $gr['adam']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == 'meteoryt') {
						$min = 'meteo';
						$nazwa = 'meteorytu';
						if ($_POST['ilosc'] > $gr['meteo']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['mineral'] == 'kryszta�') {
						$min = 'krysztal';
						$nazwa = 'kryszta��w';
						if ($_POST['ilosc'] > $gr['krysztal']) {
							print "Nie masz takiej ilo�ci $nazwa.";
							require_once("footer.php");
							exit;
						}
					}
					if ($_POST['ilosc'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
						print "Zapomnij o tym.";
						require_once("footer.php");
						exit;
					}
					mysql_query("update tribes set $min=$min+$_POST[ilosc] where id=$mytribe[id]") or die ("Nie mog� doda� $min!");
					mysql_query("update kopalnie set $min=$min-$_POST[ilosc] where gracz=$stat[id]");
					print "Doda�e� <b>$_POST[ilosc] $nazwa</b> do skarbca klanu.";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($mytribe[owner], 'Gracz $gracz[user] ID: $stat[id] doda� do skarbca klanu $_POST[ilosc] $nazwa','$czas')");
				}
			}
		}

// magazyn klanu
		if ($_GET['step'] == 'magazyn') {
			if (!$_GET['step2'] && !$_GET['step3'] && !$_GET['daj'] && !$_GET['step4']) {
				print "Witaj w magazynie klanu. Tutaj s� sk�adowane mikstury nale��ce do klanu. Ka�dy cz�onek klanu mo�e ofiarowa� klanowi jak�� mikstur� ale tylko przyw�dca lub osoba upowa�niona przez niego mo�e darowa� dan� mikstur� cz�onkom swojego klanu. Co chcesz zrobi�?<br>";
				print "<ul>";
				print "<li><a href=tribes.php?view=my&step=magazyn&step2=zobacz&lista=id&limit=0>Zobaczy� list� mikstur w magazynie klanu</a></li>";
				print "<li><a href=tribes.php?view=my&step=magazyn&step2=daj>Da� mikstur� do klanu</a></li></ul>";
			}
			if ($_GET['step2'] == 'zobacz') {
				$msel = mysql_query("select id from tribe_mag where klan=$mytribe[id]");
				$przed = mysql_num_rows($msel);
				print "W magazynie klanu jest $przed mikstur<br>";
				if ($_GET['limit'] < $przed) {
					print "<table>";
					print "<tr><td width=100><a href=tribes.php?view=my&step=magazyn&step2=zobacz&lista=nazwa&limit=0><b><u>Nazwa</u></b></a></td><td width=100><a href=tribes.php?view=my&step=magazyn&step2=zobacz&lista=efekt&limit=0><b><u>Efekt</u></b></a></td><td width=100><b><u>Opcje</u></b></td></tr>";
					$psel = mysql_query("select nazwa, id, efekt from tribe_mag where klan=$mytribe[id] order by $lista desc limit $limit,30");
					while ($pm = mysql_fetch_array($psel)) {
						print "<tr><td>$pm[nazwa]</td><td align=center>$pm[efekt]</td>";
						if ($stat[id] == $mytribe[owner] || $stat[id] == $perm[warehouse]) {
							print "<td>- <a href=tribes.php?view=my&step=magazyn&daj=$pm[id]>Daj</a></td>";
						} else {
							print "<td></td>";
						}
					}
					print "</table>";
					if ($limit >= 30) {
						$lim = $limit - 30;
						print "<a href=tribes.php?view=my&step=magazyn&step2=zobacz&limit=$lim&lista=$lista>Poprzednie 30 mikstur</a> ";
					}
					$limit = $limit + 30;
					if ($przed > 30 && $limit < $przed) {
						print " <a href=tribes.php?view=my&step=magazyn&step2=zobacz&limit=$limit&lista=$lista>Nast�pnych 30 mikstur</a>";
					}
				}
			}
			if ($_GET['daj']) {
				if (!$_GET['step4']) {
				print "<form method=post action=tribes.php?view=my&step=magazyn&daj=$_GET[daj]&step4=add>";
				print "Daj t� mikstur� graczowi ID: <input type=text name=did><br>";
				print "<input type=submit value=Daj><br>";
				print "</form>";
				}
				if ($_GET['step4'] == 'add') {
					if (!ereg("^[1-9][0-9]*$", $_POST['did'])) {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
				$dtrib = mysql_fetch_array(mysql_query("select tribe from players where id=$_POST[did]"));
				if ($dtrib['tribe'] != $mytribe['id']) {
					print "Ten gracz nie jest w twoim klanie!";
					require_once("footer.php");
					exit;
				}
				$zbroj = mysql_fetch_array(mysql_query("select nazwa, efekt, id from tribe_mag where id=$daj"));
				$przed = mysql_fetch_array(mysql_query("select typ, moc from mikstury where nazwa='$zbroj[nazwa]'"));
				mysql_query("insert into mikstury (nazwa, gracz, efekt, typ, moc, status) values('$zbroj[nazwa]',$_POST[did],'$zbroj[efekt]','$przed[typ]',$przed[moc],'K')") or die ("Nie mog� doda�");
				mysql_query("delete from tribe_mag where id=$zbroj[id]");
				print "Przekaza�e� graczowi ID $did $zbroj[nazwa]";
				$czas = date("y-m-d H:i:s");
				mysql_query("insert into log (owner,log, czas) values($_POST[did], 'Dosta�e� od klanu $zbroj[nazwa]','$czas')");

				}
			}
			if ($_GET['step2'] == 'daj') {
				print "Dodaj mikstur� do magazynu<br><br>";
				print "<table><form method=post action=tribes.php?view=my&step=magazyn&step2=daj&step3=add>";
				print "Mikstura: <select name=przedmiot>";
				$csel = mysql_query("select * from mikstury where status='K' and gracz=$stat[id]");
				while ($rzecz = mysql_fetch_array($csel)) {
					print "<option value=$rzecz[id]>$rzecz[nazwa]</option>";
				}
				print "<tr><td colspan=2 align=center><input type=submit value=Dodaj></td></tr>";
				print "</form></table>";
				if ($_GET['step3'] == 'add') {
					if (empty($_POST['przedmiot'])) {
						print "Zapomnij o tym!";
						require_once("footer.php");
						exit;
					}
					$przed = mysql_fetch_array(mysql_query("select nazwa, efekt from mikstury where id=$_POST[przedmiot]"));
					mysql_query("insert into tribe_mag (klan, nazwa, efekt) values($mytribe[id],'$przed[nazwa]','$przed[efekt]')") or die ("Nie mog� doda� przedmiotu");
					mysql_query("delete from mikstury where id=$_POST[przedmiot]");
					print "Doda�e� <b>$przed[nazwa]</b> do magazynu klanu.";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($mytribe[owner], 'Gracz $gracz[user] ID: $stat[id] doda� do magazynu klanu $przed[nazwa]','$czas')");
				}
			}
		}

// zbrojownia klanu
		if ($_GET['step'] == 'zbroj') {
			if (!$_GET['step2'] && !$_GET['step3'] && !$_GET['daj'] && !$_GET['step4']) {
				print "Witaj w zbrojowni klanu. Tutaj s� sk�adowane przedmioty nale��ce do klanu. Ka�dy cz�onek klanu mo�e ofiarowa� klanowi jaki� przedmiot ale tylko przyw�dca lub osoba upowa�niona przez niego mo�e darowa� dany przedmiot cz�onkom swojego klanu. Co chcesz zrobi�?<br>";
				print "<ul>";
				print "<li><a href=tribes.php?view=my&step=zbroj&step2=zobacz&lista=id&limit=0>Zobaczy� list� przedmiot�w w zbrojowni klanu</a></li>";
				print "<li><a href=tribes.php?view=my&step=zbroj&step2=daj>Da� przedmiot do klanu</a></li></ul>";
			}
			if ($_GET['step2'] == 'zobacz') {
				$msel = mysql_query("select id from tribe_zbroj where klan=$mytribe[id]");
				$przed = mysql_num_rows($msel);
				print "W zbrojowni klanu jest $przed przedmiot�w<br>";
				if ($_GET['limit'] < $przed) {
					print "<table>";
					print "<tr><td width=100><a href=tribes.php?view=my&step=zbroj&step2=zobacz&lista=name&limit=0><b><u>Nazwa</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zbroj&step2=zobacz&lista=power&limit=0><b><u>Si�a</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zbroj&step2=zobaczlista=wt&limit=0><b><u>Wytrzyma�o��</u></b></a></td><td width=100><b><u>Opcje</u></b></td></tr>";
					$psel = mysql_query("select name, power, wt, id from tribe_zbroj where klan=$mytribe[id] order by $lista desc limit $limit,30");
					while ($pm = mysql_fetch_array($psel)) {
						print "<tr><td>$pm[name]</td><td align=center>$pm[power]</td><td align=center>$pm[wt]</td>";
						if ($stat[id] == $mytribe[owner] || $stat[id] == $perm[armory]) {
							print "<td>- <a href=tribes.php?view=my&step=zbroj&daj=$pm[id]>Daj</a></td>";
						} else {
							print "<td></td>";
						}
					}
					print "</table>";
					if ($limit >= 30) {
						$lim = $limit - 30;
						print "<a href=tribes.php?view=my&step=zbroj&step2=zobacz&limit=$lim&lista=$lista>Poprzednie 30 przedmiot�w</a> ";
					}
					$limit = $limit + 30;
					if ($przed > 30 && $limit < $przed) {
						print " <a href=tribes.php?view=my&step=zbroj&step2=zobacz&limit=$limit&lista=$lista>Nast�pnych 30 przedmiot�w</a>";
					}
				}
			}
			if ($_GET['daj']) {
				if (!$_GET['step4']) {
				print "<form method=post action=tribes.php?view=my&step=zbroj&daj=$_GET[daj]&step4=add>";
				print "Daj ten przedmiot graczowi ID: <input type=text name=did><br>";
				print "<input type=submit value=Daj><br>";
				print "</form>";
				}
				if ($_GET['step4'] == 'add') {
					if (!ereg("^[1-9][0-9]*$", $_POST['did'])) {
						print "Zapomnij o tym<br>";
						require_once("footer.php");
						exit;
					}
				$dtrib = mysql_fetch_array(mysql_query("select tribe from players where id=$_POST[did]"));
				if ($dtrib['tribe'] != $mytribe['id']) {
					print "Ten gracz nie jest w twoim klanie!";
					require_once("footer.php");
					exit;
				}
				$zbroj = mysql_fetch_array(mysql_query("select name, power, wt, id, zr, szyb, maxwt, minlev, type from tribe_zbroj where id=$daj"));
				mysql_query("insert into equipment (name, owner, power, wt, zr, minlev, type, cost, status, szyb, maxwt) values('$zbroj[name]',$_POST[did],$zbroj[power],$zbroj[wt],$zbroj[zr],$zbroj[minlev],'$zbroj[type]',1,'U', $zbroj[szyb],$zbroj[maxwt])") or die ("Nie mog� doda�");
				mysql_query("delete from tribe_zbroj where id=$zbroj[id]");
				print "Przekaza�e� graczowi ID $did przedmiot $zbroj[name]";
				$czas = date("y-m-d H:i:s");
				mysql_query("insert into log (owner,log, czas) values($_POST[did], 'Dosta�e� od klanu $zbroj[name]','$czas')");

				}
			}
			if ($_GET['step2'] == 'daj') {
				print "Dodaj przedmiot do zbrojowni<br><br>";
				print "<table><form method=post action=tribes.php?view=my&step=zbroj&step2=daj&step3=add>";
				print "Przedmiot: <select name=przedmiot>";
				$csel = mysql_query("select * from equipment where status='U' and owner=$stat[id]");
				while ($rzecz = mysql_fetch_array($csel)) {
					print "<option value=$rzecz[id]>$rzecz[name]</option>";
				}
				print "<tr><td colspan=2 align=center><input type=submit value=Dodaj></td></tr>";
				print "</form></table>";
				if ($_GET['step3'] == 'add') {
					if (empty($_POST['przedmiot'])) {
						print "Zapomnij o tym!";
						require_once("footer.php");
						exit;
					}
					$przed = mysql_fetch_array(mysql_query("select name, power, wt, maxwt, zr, szyb, minlev, type from equipment where id=$_POST[przedmiot]"));
					mysql_query("insert into tribe_zbroj (klan, name, power, wt, maxwt, zr, szyb, minlev, type) values($mytribe[id],'$przed[name]',$przed[power],$przed[wt],$przed[maxwt],$przed[zr],$przed[szyb],$przed[minlev],'$przed[type]')") or die ("Nie mog� doda� przedmiotu");
					mysql_query("delete from equipment where id=$_POST[przedmiot]");
					print "Doda�e� <b>$przed[name]</b> do zbrojowni klanu.";
					$czas = date("y-m-d H:i:s");
					mysql_query("insert into log (owner,log, czas) values($mytribe[owner], 'Gracz $gracz[user] ID: $stat[id] doda� do zbrojowni klanu $przed[name]','$czas')");
				}
			}
		}
		if ($_GET['step'] == 'members') {
			$msel = mysql_query("select * from players where tribe=$mytribe[id]");
			while ($mem = mysql_fetch_array($msel)) {
				if ($mem['id'] == $mytribe['owner']) {
					print "- <a href=view.php?view=$mem[id]>$mem[user]</a> ($mem[id]) (Przyw�dca)<br>";
				} else {
					print "- <a href=view.php?view=$mem[id]>$mem[user]</a> ($mem[id])<br>";
				}
			}
		}
		if ($_GET['step'] == 'quit') {
			if ($mytribe['owner'] == $stat['id']) {
				print "Czy na pewno chcesz odej�� z klanu? Je�eli to zrobisz, klan zostanie zlikwidowany!<br>";
				print "<a href=tribes.php?view=my&step=quit&dalej=tak>Tak</a><br>";
				print "<a href=tribes.php?view=my>Nie</a><br>";
				if ($_GET['dalej']) {
					mysql_query("update players set tribe=0 where tribe=$mytribe[id]");
					mysql_query("delete from tribes where id=$mytribe[id]");
					mysql_query("delete from tribe_zbroj where klan=$mytribe[id]");
					mysql_query("delete from tribe_mag where klan=$mytribe[id]");
					mysql_query("delete from tribe_oczek where klan=$mytribe[id]");
					mysql_query("delete from tribe_prem where tribe=$mytribe[id]");
					print "Opuszczasz klan. Poniewa� jeste� przyw�dc�, klan zosta� usuni�ty.";
				}
			}  else {
				print "Czy na pewno chcesz odej�� z klanu?<br>";
				print "<a href=tribes.php?view=my&step=quit&dalej=tak>Tak</a><br>";
				print "<a href=tribes.php?view=my>Nie</a><br>";
				if ($_GET['dalej']) {
					mysql_query("update players set tribe=0 where id=$stat[id]");
					print "Opuszczasz klan.";
				}
			}
		}
		if ($_GET['step'] == 'owner') {
			$test = array($perm['messages'],$perm['wait'],$perm['kick'],$perm['army'],$perm['attack'],$perm['loan'],$perm['armory'],$perm['warehouse'],$perm['bank'],$perm['herbs']);
			if ($stat['id'] == $mytribe['owner'] || $stat['id'] == $test[0] || $stat['id'] == $test[1] || $stat['id'] == $test[2] || $stat['id'] == $test[3] || $stat['id'] == $test[4] || $stat['id'] == $test[5] || $stat['id'] == $test[6] || $stat['id'] == $test[7] || $stat['id'] == $test[8] || $stat['id'] == $test[9]) {
				if (!$_GET['step2']) {
				print "Witaj w panelu przyw�dcy klanu. Co chcesz zrobi�?";
				print "<ul>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=permissions>Ustawi� uprawnienia cz�onk�w klanu</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=messages>Edytowa� opis klanu, wiadomo�� dla cz�onk�w oraz herb gildii i stron� gildii</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=nowy>Sprawd� list� oczekuj�cych na do��czenie do klanu</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=kick>Wyrzuci� Cz�onka</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=wojsko>Dokupi� �o�nierzy lub fortyfikacji do klanu</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=walka>Zaatakowa� inny klan</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=loan>Po�ycz pieni�dze cz�onkowi</a></li>";
				print "<li><a href=tribes.php?view=my&step=owner&step2=te>Dodatki klanu</a>";
				print "</ul>";
				}

// Ustawianie uprawnie� dla cz�onk�w klanu - dost�p jedynie przyw�dca klanu
				if ($_GET['step2'] == 'permissions') {
					if ($stat['id'] != $mytribe['owner']) {
						print "Tylko przyw�dca mo�e ustawia� zezwolenia!";
						require_once("footer.php");
						exit;
					}
					if (!$_GET['step3']) {
						print "Tutaj mo�esz ustawi� uprawnienia do r�nych miejsc dowolnym cz�onkom klanu. W odpowiednie pola wpisz ID cz�onk�w klanu<br>";
						if (!$perm) {
							print "<form method=post action=tribes.php?view=my&step=owner&step2=permissions&step3=add>";
							print "ID osoby mog�cej edytowa� opisy klanu: <input type=text name=messages size=4 value=0><br>";
							print "ID osoby mog�cej do��cza� nowych cz�onk�w: <input type=text name=wait size=4 value=0><br>";
							print "ID osoby mog�cej wyrzuca� cz�onk�w z klanu: <input type=text name=kick size=4 value=0><br>";
							print "ID osoby mog�cej kupowa� �o�nie�y oraz fortyfikacje: <input type=text name=army size=4 value=0><br>";
							print "ID osoby mog�cej wykonywa� ataki na inny klan: <input type=text name=attack size=4 value=0><br>";
							print "ID osoby mog�cej po�ycza� pieni�dze cz�onkom klanu: <input type=text name=loan size=4 value=0><br>";
							print "ID osoby mog�cej dawa� przedmioty ze zbrojowni: <input type=text name=armory size=4 value=0><br>";
							print "ID osoby mog�cej dawa� przedmioty z magazynu: <input type=text name=warehouse size=4 value=0><br>";
							print "ID osoby mog�cej dawa� minera�y ze skarbca: <input type=text name=bank size=4 value=0><br>";
							print "ID osoby mog�cej dawa� zio�a z zielnika: <input type=text name=herbs size=4 value=0><br>";
							print "<input type=submit value=Zapisz></form>";
						} else {
							print "<form method=post action=tribes.php?view=my&step=owner&step2=permissions&step3=change>";
							print "ID osoby mog�cej edytowa� opisy klanu: <input type=text name=messages size=4 value=$perm[messages]><br>";
							print "ID osoby mog�cej do��cza� nowych cz�onk�w: <input type=text name=wait size=4 value=$perm[wait]><br>";
							print "ID osoby mog�cej wyrzuca� cz�onk�w z klanu: <input type=text name=kick size=4 value=$perm[kick]><br>";
							print "ID osoby mog�cej kupowa� �o�nie�y oraz fortyfikacje: <input type=text name=army size=4 value=$perm[army]><br>";
							print "ID osoby mog�cej wykonywa� ataki na inny klan: <input type=text name=attack size=4 value=$perm[attack]><br>";
							print "ID osoby mog�cej po�ycza� pieni�dze cz�onkom klanu: <input type=text name=loan size=4 value=$perm[loan]><br>";
							print "ID osoby mog�cej dawa� przedmioty ze zbrojowni: <input type=text name=armory size=4 value=$perm[armory]><br>";
							print "ID osoby mog�cej dawa� przedmioty z magazymu: <input type=text name=warehouse size=4 value=$perm[warehouse]><br>";
							print "ID osoby mog�cej dawa� minera�y ze skarbca: <input type=text name=bank size=4 value=$perm[bank]><br>";
							print "ID osoby mog�cej dawa� zio�a z zielnika: <input type=text name=herbs size=4 value=$perm[herbs]><br>";
							print "<input type=submit value=Zapisz></form>";
						}
					}
					if ($_GET['step3']) {
						$test = array($_POST['messages'],$_POST['wait'],$_POST['kick'],$_POST['army'],$_POST['attack'],$_POST['loan'],$_POST['armory'],$_POST['warehouse'],$_POST['bank'],$_POST['herbs']);
						for ($i=0;$i<10;$i++) {
							if (!ereg("^[0-9]*$", $test[$i])) {
								print "Zapomnij o tym!";
								require_once("footer.php");
								exit;
							}
							$ttribe = mysql_fetch_array(mysql_query("select tribe from players where id=$test[$i]"));
							if ($ttribe['tribe'] != $mytribe['id'] && $test[$i] != 0) {
								print "Gracz o id $test[$i] nie jest w twoim klanie! <a href=tribes.php?view=my&step=owner> Wr�� do menu przyw�dcy</a>";
								require_once("footer.php");
								exit;
							}
						}
					}
					if ($_GET['step3'] == 'add') {
						mysql_query("insert into tribe_perm (tribe, messages, wait, kick, army, attack, loan, armory, warehouse, bank, herbs) values ($mytribe[id],$_POST[messages],$_POST[wait],$_POST[kick],$_POST[army],$_POST[attack],$_POST[loan],$_POST[armory],$_POST[warehouse],$_POST[bank],$_POST[herbs])") or die ("nie mog� doda�!");
						print "Ustawi�e� uprawnienia cz�onkom klanu. <a href=tribes.php?view=my&step=owner>wr�� do menu</a>";
					}
					if ($_GET['step3'] == 'change') {
						mysql_query("update tribe_perm set messages=$_POST[messages] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set wait=$_POST[wait] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set kick=$_POST[kick] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set army=$_POST[army] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set attack=$_POST[attack] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set loan=$_POST[loan] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set armory=$_POST[armory] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set warehouse=$_POST[warehouse] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set bank=$_POST[bank] where tribe=$mytribe[id]");
						mysql_query("update tribe_perm set herbs=$_POST[herbs] where tribe=$mytribe[id]");
						print "Ustawi�e� uprawnienia cz�onkom klanu. <a href=tribes.php?view=my&step=owner>wr�� do menu</a>";
					}
				}

// kupowanie wojska oraz barykad do klanu
				if ($_GET['step2'] == 'wojsko') {
					if ($stat['id'] != $mytribe['owner'] && $stat['id'] != $perm['army']) {
						print "Tylko przyw�dca lub osoba upowa�niona mo�e kupowa� �o�nierzy i fortyfikacje do klanu!";
						require_once("footer.php");
						exit;
					}
					if (!$_GET['action']) {
						print "Tutaj mo�esz dokupi� �o�nierzy oraz fortyfikacje dla klanu. �o�nie�e dodaj� do si�y ataku twojego klanu, natomiast fortyfikacje dodaj� do jego obrony. Koszt pojedynczego �o�nie�a ub fortyfikacji wynosi: ilo�� �o�nie�y(fortyfikacji) kupowanych * 1000 sztuk z�ota.<br>";
						print "<form method=post action=tribes.php?view=my&step=owner&step2=wojsko&action=kup>";
						print "Ilu �o�nierzy chcesz kupi�? <input type=text name=zolnierze value=0><br>";
						print "Ile fortyfikacji chcesz kupi�? <input type=text name=forty value=0><br>";
						print "<input type=submit value=Kupuj></form>";
					}
					if ($_GET['action'] == 'kup') {
						if (!ereg("^[0-9][0-9]*$",$_POST['zolnierze'])) {
							print "Zapomnij o tym";
							require_once("footer.php");
							exit;
						}
						if (!ereg("^[0-9][0-9]*$",$_POST['forty'])) {
							print "Zapomnij o tym";
							require_once("footer.php");
							exit;
						}
						if ($_POST["zolnierze"] == 0 && $_POST["forty"] == 0) {
							print "Wype�nij chocia� jedno pole!";
							require_once("footer.php");
							exit;
						}
						$cenaz = ($_POST["zolnierze"] * 1000);
						$cenaf = ($_POST["forty"] * 1000);
						$suma = $cenaz + $cenaf;
						if ($suma > $mytribe['credits']) {
							print "Klan nie ma tyle sztuk z�ota";
							require_once("footer.php");
							exit;
						}
						if ($_POST["zolnierze"] > 0) {
							mysql_query("update tribes set zolnierze=zolnierze+$_POST[zolnierze] where id=$mytribe[id]");
							print "Kupi�e� dla swojego klanu $_POST[zolnierze] �o�nierzy za $cenaz sztuk z�ota<br>";
						}
						if ($_POST["forty"] > 0) {
							mysql_query("update tribes set forty=forty+$_POST[forty] where id=$mytribe[id]");
							print "Kupi�e� dla swojego klanu $_POST[forty] fortyfikacji za $cenaf sztuk z�ota<br>";
						}
						mysql_query("update tribes set credits=credits-$suma where id=$mytribe[id]");
						print "W sumie wyda�e� na wszystko $suma sztuk z�ota.<br>";
					}
				}

//Lista oczekuj�cych na przyj�cie do klanu
				if ($_GET['step2'] == 'nowy') {
					if ($stat['id'] != $mytribe['owner'] && $stat['id'] != $perm['wait']) {
						print "Tylko przyw�dca lub osoba upowa�niona mo�e przebywa� tutaj!";
						require_once("footer.php");
						exit;
					}
					if (!isset($_GET['odrzuc']) && !isset($_GET['dodaj'])) {
						print "Lista oczekuj�cych<br>";
						print "<table>";
						print "<tr><td width=100><b><u>ID gracza</u></b></td><td width=100><b><u>Dodaj</td><td width=100><b><u>Odrzu�</u></b></td></tr>";
						$ocz = mysql_query("select * from tribe_oczek where klan=$mytribe[id]");
						while ($czeka = mysql_fetch_array($ocz)) {
							print "<tr><td><a href=view.php?view=$czeka[gracz]>$czeka[gracz]</a></td><td><a href=tribes.php?view=my&step=owner&step2=nowy&dodaj=$czeka[id]>Tak</a></td><td><a href=tribes.php?view=my&step=owner&step2=nowy&odrzuc=$czeka[id]>Tak</a></td></tr>";
						}
						print "</table>";
					}
					if (isset($_GET['odrzuc'])) {
						$del = mysql_fetch_array(mysql_query("select * from tribe_oczek where id=$_GET[odrzuc]"));
						print "Odrzuci�e� kandydata o id $del[gracz].";
						$czas = date("y-m-d H:i:s");
						mysql_query("insert into log (owner, log, czas) values($del[gracz],'Klan <b>$mytribe[name]</b> odrzuci� twoj� kandydatur� ','$czas')") or die("Nie mog� doda� do dziennika.");
						mysql_query("delete from tribe_oczek where id=$del[id]");
					}
					if (isset($_GET['dodaj'])) {
						$dod = mysql_fetch_array(mysql_query("select * from tribe_oczek where id=$_GET[dodaj]"));
						print "Zaakceptowa�e� kandydata o id $dod[gracz].";
						$czas = date("y-m-d H:i:s");
						mysql_query("insert into log (owner, log, czas) values($dod[gracz],'Klan <b>$mytribe[name]</b> przyj�� twoj� kandydatur�. Jeste� ju� cz�onkiem klanu','$czas')") or die("Nie mog� doda� do dziennika.");
						mysql_query("update players set tribe=$dod[klan] where id=$dod[gracz]");
						mysql_query("delete from tribe_oczek where id=$dod[id]");
					}

				}

// walka klan�w
				if ($_GET['step2'] == 'walka') {
					if ($stat['id'] != $mytribe['owner'] && $stat['id'] != $perm['attack']) {
						print "Tylko przyw�dca lub osoba upowa�niona mo�e przebywa� tutaj!";
						require_once("footer.php");
						exit;
					}
					if ($mytribe['atak'] == 'Y') {
						print "Klan mo�e atakowa� inne klany tylko raz na reset!";
						require_once("footer.php");
						exit;
					}
					print "Wybierz klan, kt�ry chcecie zaatakowa�:<br>";
					$kl = mysql_query("select * from tribes where id!=$mytribe[id]");
					while ($klan1 = mysql_fetch_array($kl)) {
						print "<a href=tribes.php?view=my&step=owner&step2=walka&atak=$klan1[id]>Atakuj klan $klan1[name]<br></a>";
					}
					if (isset($_GET['atak'])) {
						if (!ereg("^[1-9][0-9]*$", $_GET['atak'])) {
							print "Zapomnij o tym!";
							require_once("footer.php");
							exit;
						}
						$matak = 0;
						$mobrona = 0;
						$eatak = 0;
						$eobrona = 0;
						mysql_query("update tribes set atak='Y' where id=$mytribe[id]");
						$mce = mysql_query("select * from players where tribe=$mytribe[id]");
						while ($mcechy = mysql_fetch_array($mce)) {
							if ($mcechy['klasa'] == 'Wojownik' || $mcechy['klasa'] == 'Obywatel') {
								$matak = ($matak + $mcechy['strength']);
							}
							if ($mcechy['klasa'] == 'Mag') {
								$matak = ($matak + $mcechy['inteli']);
							}
							$mobrona = ($mobrona + $mcechy['agility']);
						}
						$matak = $matak + $mytribe['zolnierze'];
						$mobrona = $mobrona + $mytribe['forty'];
						$ece = mysql_query("select * from players where tribe=$_GET[atak]");
						while ($ecechy = mysql_fetch_array($ece)) {
							if ($ecechy['klasa'] == 'Wojownik' || $ecechy['klasa'] == 'Obywatel') {
								$eatak = ($eatak + $ecechy['strength']);
							}
							if ($ecechy['klasa'] == 'Mag') {
								$eatak = ($eatak + $ecechy['inteli']);
							}
							$eobrona = ($eobrona + $ecechy['agility']);
						}
						$klan = mysql_fetch_array(mysql_query("select * from tribes where id=$_GET[atak]"));
						$eatak = $eatak + $klan['zolnierze'];
						$eobrona = $eobrona + $klan['forty'];
						$rzut = rand(1,1000);
						$matak = ($matak + $rzut);
						$mobrona = ($mobrona + $rzut);
						$eatak = ($eatak + $rzut);
						$eobrona = ($eobrona + $rzut);
						$matak = ($matak - $eobrona);
						$eatak = ($eatak - $mobrona);
						if ($matak >= $eatak) {
							if ($klan['credits'] > 0) {
								$gzloto = ceil($klan['credits'] / 10);
							} else {
								$gzloto = 0;
							}
							if ($klan['platinum'] > 0) {
								$gmith = ceil($klan['platinum'] / 10);
							} else {
								$gmith = 0;
							}
							print "Stoisz razem ze swoimi towarzyrzami i przyjaci�mi przed armi� . Zaraz zacznie si� bitwa... ATAK!!! S�yszysz jak przywodca klanu $klan[name] wykrzykn�� komend� do jego towarzyszy. Ruszasz razem z twoimi podw�adnymi w wir walki. W powietrzu lataj� ogniste kule, strza�y oraz inne pociski. Zabijasz jednego wroga po drugim. Patrz�c w chwili spokoju na swoich towarzyszy zauwa�asz i� oni tak�e z wielkim zapa�em niszcz� przeciwnik�w w imie klanu $mytribe[name]... Wygrali�cie t� wspania�� bitw�. Ze skarbca pokonanego klanu wynie�li�cie <b>$gzloto</b> sztuk z�ota oraz <b>$gmith</b> sztuk mithrilu!";
							mysql_query("update tribes set credits=credits+$gzloto where id=$mytribe[id]");
							mysql_query("update tribes set platinum=platinum+$gmith where id=$mytribe[id]");
							mysql_query("update tribes set wygr=wygr+1 where id=$mytribe[id]");
							mysql_query("update tribes set credits=credits-$gzloto where id=$klan[id]");
							mysql_query("update tribes set platinum=platinum-$gmith where id=$klan[id]");
							mysql_query("update tribes set przeg=przeg+1 where id=$klan[id]");
							$czas = date("y-m-d H:i:s");
							mysql_query("insert into log (owner,log, czas) values($klan[owner], 'Klan $mytribe[name] zaatakowa� i pokona� tw�j klan. Stacili�cie $gzloto sztuk z�ota oraz $gmith sztuk mithrilu!','$czas')");
						}
						if ($eatak > $matak) {
							if ($mytribe['credits'] > 0) {
								$gzloto = ceil($mytribe['credits'] / 10);
							} else {
								$gzloto = 0;
							}
							if ($mytribe['platinum'] > 0) {
								$gmith = ceil($mytribe['platinum'] / 10);
							} else {
								$gmith = 0;
							}
							print "Stoisz razem ze swoimi towarzyrzami i przyjaci�mi przed armi� . Zaraz zacznie si� bitwa... ATAK!!! S�yszysz jak przywodca klanu $klan[name] wykrzykn�� komende do jego towarzyszy. Ruszasz razem z twoimi podw�adnymi i zaczyna sie bitwa. W powietrzu lataj� ogniste kule, strza�y oraz inne pociski. Atakujesz przywodc� klanu $klan[name] i podczas walki giniesz. Padaj�c na ziemi� patrzysz jak inni twoi przyjaciele dziel� twoj los... Przegrali�cie t� walk�...  Z waszego skarbca przeciwnik wyni�s� <b>$gzloto</b> sztuk z�ota oraz <b>$gmith</b> sztuk mithrilu!";
							$czas = date("y-m-d H:i:s");
							mysql_query("insert into log (owner,log, czas) values($klan[owner], 'Klan $mytribe[name] zaatakowa� i zosta� pokonany przez tw�j klan. Zdobyli�cie $gzloto sztuk z�ota oraz $gmith sztuk mithrilu!','$czas')");
							mysql_query("update tribes set credits=credits-$gzloto where id=$mytribe[id]");
							mysql_query("update tribes set platinum=platinum-$gmith where id=$mytribe[id]");
							mysql_query("update tribes set przeg=przeg+1 where id=$mytribe[id]");
							mysql_query("update tribes set credits=credits+$gzloto where id=$klan[id]");
							mysql_query("update tribes set platinum=platinum+$gmith where id=$klan[id]");
							mysql_query("update tribes set wygr=wygr+1 where id=$klan[id]");
						}
					}
				}

// wiadomo�ci o klanie oraz jego herb i strona www
				if ($_GET['step2'] == 'messages') {
					if ($stat['id'] != $mytribe['owner'] && $stat['id'] != $perm['messages']) {
						print "Tylko przyw�dca lub osoba upowa�niona mo�e przebywa� tutaj!";
						require_once("footer.php");
						exit;
					}
					print "<table><form method=post action=tribes.php?view=my&step=owner&step2=messages&action=edit>";
					print "<tr><td valign=top>Opis klanu:</td><td><textarea name=public_msg>$mytribe[public_msg]</textarea></td></tr>";
					print "<tr><td valign=top>Wiadomo�� dla cz�onk�w:</td><td><textarea name=private_msg>$mytribe[private_msg]</textarea></td></tr>";
					print "<tr><td colspan=2 align=center><input type=submit value=Zmie�></td></tr>";
					print "</form></table>";
					print "<form method=post action=tribes.php?view=my&step=owner&step2=messages&action=www>";
					print "Adres strony klanu (wpisz bez http://): <input type=text name=www value=$mytribe[www]><br>";
					print "<input type=submit value=Zatwierd�></form><br>";
					$avatar = mysql_fetch_array(mysql_query("select logo from tribes where id=$mytribe[id]"));
					$plik = 'images/tribes/'.$avatar['logo'];
					if (is_file($plik)) {
						print "<center><img src=$plik heigth=100 width=100></center>";
					}
					print "Tutaj mo�esz zmieni� herb swojego klanu. <b>Uwaga!</b> Je�eli klan ju� posiada herb, stary zostanie skasowany. Maksymalny rozmiar herbu to 10 kB. Herb mo�esz za�adowa� tylko z w�asnego komputera. Musi on mie� rozszerzenie *.jpg, *.jpeg lub *.gif<br>";
					if (is_file($plik)) {
						print "<form action=\"tribes.php?view=my&step=owner&step2=messages&step4=usun\" method=\"post\">";
						print "<input type=hidden name=av value='$avatar[logo]'>";
						print "<input type=submit value=Skasuj>";
						print "</form>";
					}
					print "<form enctype=\"multipart/form-data\" action=\"tribes.php?view=my&step=owner&step2=messages&step4=dodaj\" method=\"post\">";
					print "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240\">";
					print "Nazwa pliku graficznego: <input name=\"plik\" type=\"file\"><br>";
					print "<input type=submit value=\"Wy�lij\"></form>";
					if ($_GET['action'] == 'www') {
					        $_POST['www'] = str_replace("'","",strip_tags($_POST['www']));
						mysql_query("update tribes set www='$_POST[www]' where id=$mytribe[id]");
						print "Adres strony ustawiony na <a href=http://$_POST[www] target=_blank>$_POST[www]</a>. <a href=tribes.php?view=my&step=owner&step2=messages>Od�wie�</a><br>";
					}
					if ($_GET['step4'] == 'usun') {
						$plik = 'images/tribes/'.$_POST['av'];
						if (is_file($plik)) {
							unlink($plik);
							mysql_query("update tribes set logo='' where id=$mytribe[id]") or die ("nie mog� skasowa�");
							print "Herb usuni�ty. <a href=tribes.php?view=my&step=owner&step2=messages>Od�wie�</a><br>";
						} else {
							print "Nie ma takiego pliku!<br>";
							require_once("footer.php");
							exit;
						}
					}
					if ($_GET['step4'] == 'dodaj') {
						$plik = $_FILES['plik']['tmp_name'];
						$nazwa = $_FILES['plik']['name'];
						$typ = $_FILES['plik']['type'];
						if ($typ != 'image/pjpeg' && $typ != 'image/jpeg' && $typ != 'image/gif') {
							print "Z�y typ pliku!";
							require_once("footer.php");
							exit;
						}
						if ($typ == 'image/pjpeg' && $typ != 'image/jpeg') {
							$liczba = rand(1,1000000);
							$newname = md5($liczba).'.jpg';
							$miejsce = 'images/tribes/'.$newname;
						}
						if ($typ == 'image/gif') {
							$liczba = rand(1,1000000);
							$newname = md5($liczba).'.gif';
							$miejsce = 'images/tribes/'.$newname;
						}
						if (is_uploaded_file($plik)) {
							if (!move_uploaded_file($plik,$miejsce)) {
								print "Nie skopiowano pliku!";
								require_once("footer.php");
								exit;
							}
						} else {
							print "Zapomij o tym";
							require_once("footer.php");
							exit;
						}
						mysql_query("update tribes set logo='$newname' where id=$mytribe[id]");
						print "Herb za�adowany! <a href=tribes.php?view=my&step=owner&step2=messages>Od�wie�</a><br>";
					}
					if ($_GET['action'] == 'edit') {
						$_POST['private_msg'] = strip_tags($_POST['private_msg'],"<hr><br><b><u><s><i>");
						$_POST['public_msg'] = strip_tags($_POST['public_msg'],"<hr><br><b><u><s><i>");
						mysql_query("update tribes set private_msg='$_POST[private_msg]' where id=$mytribe[id]");
						mysql_query("update tribes set public_msg='$_POST[public_msg]' where id=$mytribe[id]");
						print "Wiadomo�� zmieniona.";
					}
				}

// wyrzucanie cz�onk�w klanu
				if ($_GET['step2'] == 'kick') {
					if ($stat['id'] != $mytribe['owner'] && $stat['id'] != $perm['kick']) {
						print "Tylko przyw�dca lub osoba upowa�niona mo�e przebywa� tutaj!";
						require_once("footer.php");
						exit;
					}
					print "<form method=post action=tribes.php?view=my&step=owner&step2=kick&action=kick>";
					print "Wyrzu� ID <input type=text size=5 name=id> z klanu. <input type=submit value=Wyrzu�>";
					print "</form>";
					if ($_GET['action'] == 'kick') {
						if (!ereg("^[1-9][0-9]*$", $_POST['id'])) {
							print "Zapomnij o tym";
							require_once("footer.php");
							exit;
						}
						if ($_POST['id'] != $mytribe['owner']) {
							mysql_query("update players set tribe=0 where id=$id and tribe=$mytribe[id]");
							$czas = date("y-m-d H:i:s");
							mysql_query("insert into log (owner,log, czas) values($id,'Zosta�e� wyrzucony z $mytribe[name].','$czas')");
							print "ID $_POST[id] nie jest ju� cz�onkiem klanu.";
						} else {
							print "Nie mo�esz wyrzuci� Przyw�dcy.";
						}
					}
				}

// po�yczki z klanu
				if ($_GET['step2'] == 'loan') {
					if ($stat['id'] != $mytribe['owner'] && $stat['id'] != $perm['wait']) {
						print "Tylko przyw�dca lub osoba upowa�niona mo�e przebywa� tutaj!";
					} else {
						print "<form method=post action=tribes.php?view=my&step=owner&step2=loan&action=loan>";
						print "Po�ycz <input type=text size=5 name=amount> <select name=currency><option value=credits>sztuk z�ota</option><option value=platinum>sztuk mithrilu</option></select> osobie ID <input type=text size=5 name=id>. <input type=submit value=Po�ycz>";
						print "</form>";
						if ($_GET['action'] == 'loan') {
							if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
								print "Zapomnij o tym";
								require_once("footer.php");
								exit;
							}
							if ($_POST['currency'] != 'credits' && $_POST['currency'] != 'platinum') {
								print "Zapomnij o tym";
								require_once("footer.php");
								exit;
							}
							if ($_POST['currency'] == 'credits') {
								$poz = 'sztuk z�ota';
							}
							if ($_POST['currency'] == 'platinum') {
								$poz = 'sztuk mithrilu';
							}
							$rec = mysql_fetch_array(mysql_query("select tribe from players where id=$_POST[id]"));
							if ($rec['tribe'] != $mytribe['id']) {
								print "Ta osoba nie jest w klanie.";
							} else {
								$_POST['amount'] = str_replace("--","", $_POST['amount']);
								if (!$_POST['amount'] || !$_POST['id']) {
									print "Wype�nij wszystkie pola.";
								} else {
									if ($_POST['amount'] > $mytribe[$_POST['currency']] || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
										print "Klan nie ma tyle $poz.";
									} else {
										mysql_query("update players set $_POST[currency]=$_POST[currency]+$_POST[amount] where id=$id");
										mysql_query("update tribes set $_POST[currency]=$_POST[currency]-$_POST[amount] where id=$mytribe[id]");
										$czas = date("y-m-d H:i:s");
										mysql_query("insert into log (owner,log, czas) values($id,'Klan po�yczy� ci $amount $poz.','$czas')");
										print "Po�yczy�e� ID $_POST[id] $_POST[amount] $poz.";
									}
								}
							}
						}
					}
				}
				if ($_GET['step2'] == 'te') {
					if ($_GET['step3'] == 'hospass') {
					$tribe = mysql_fetch_array(mysql_query("select * from tribes where id=$gracz[tribe]"));
						if ($tribe['platinum'] < 100) {
							print "Klan nie ma tyle sztuk mithrilu<br>";
							print "<a href=tribes.php?view=my&step=owner>..wr��</a>";
						}else{
							mysql_query("update tribes set platinum=platinum -100 where id=$stat[id]");
						mysql_query("update tribes set hospass='Y' where id=$mytribe[id]");
						print "Kupi�e� darwowe leczenie dla cz�onk�w swojego klanu w szpitalu";
						print "<a href=tribes.php?view=my&step=owner>... wr��</a>";
						print "</td></tr>";
						print "<tr><td style=\"border-top: solid black 1px;\" align=center>";
						print "(<a href=tribes.php?view=my>G��wny</a>) (<a href=tribes.php?view=my&step=donate>Dotacja</a>) (<a href=tribes.php?view=my&step=members>Cz�onkowie</a>) (<a href=tribes.php?view=my&step=zbroj>Zbrojownia</a>) (<a href=tribes.php?view=my&step=magazyn>Magazyn</a>) (<a href=tribes.php?view=my&step=skarbiec>Skarbiec</a>) (<a href=tribes.php?view=my&step=zielnik>Zielnik</a>) (<a href=tribes.php?view=my&step=quit>Opu�� klan</a>) (<a href=tribes.php?view=my&step=owner>Opcje Przyw�dcy</a>) (<a href=tforums.php?view=topics>Forum klanu</a>)";
						print "</td></tr>";
						print "</table></center><br>";
						require_once("footer.php");
						exit;
						}
					}
						if ($mytribe['hospass'] == "Y") {
							print "Klan posiada darmowe leczenie w szpitalu<br>";
							print "<a href=tribes.php?view=my&step=owner>..wr��</a>";
							print "</td></tr>";
							print "<tr><td style=\"border-top: solid black 1px;\" align=center>";
							print "(<a href=tribes.php?view=my>G��wna</a>) (<a href=tribes.php?view=my&step=donate>Dotuj</a>) (<a href=tribes.php?view=my&step=members>Cz�onkowie</a>) (<a href=tribes.php?view=my&step=zbroj>Zbrojownia</a>) (<a href=tribes.php?view=my&step=magazyn>Magazyn</a>) (<a href=tribes.php?view=my&step=skarbiec>Skarbiec</a>) (<a href=tribes.php?view=my&step=zielnik>Zielnik</a>) (<a href=tribes.php?view=my&step=quit>Opu�� klan</a>) (<a href=tribes.php?view=my&step=owner>Opcje Przyw�dcy</a>) (<a href=tforums.php?view=topics>Forum klanu</a>)";
							print "</td></tr>";
							print "</table></center><br>";
							require_once("footer.php");
							exit;
						}


					print "Witaj w panelu dodatk�w klanu. Co chcesz zrobi�?";
					print "<ul>";
					print "<li><a href=tribes.php?view=my&step=owner&step2=te&step3=hospass>Kup darmowe leczenie w szpitalu dla klanu (100 sztuk mithrilu)</a>";
					print "</ul>";
				}
			} else {
				print "Nie masz prawa tutaj przebywa�.";
			}
		}
		print "</td></tr>";
		print "<tr><td style=\"border-top: solid black 1px;\" align=center>";
			print "(<a href=tribes.php?view=my>G��wna</a>) (<a href=tribes.php?view=my&step=donate>Dotuj</a>) (<a href=tribes.php?view=my&step=members>Cz�onkowie</a>) (<a href=tribes.php?view=my&step=zbroj>Zbrojownia</a>) (<a href=tribes.php?view=my&step=magazyn>Magazyn</a>) (<a href=tribes.php?view=my&step=skarbiec>Skarbiec</a>) (<a href=tribes.php?view=my&step=zielnik>Zielnik</a>) (<a href=tribes.php?view=my&step=quit>Opu�� klan</a>) (<a href=tribes.php?view=my&step=owner>Opcje Przyw�dcy</a>) (<a href=tforums.php?view=topics>Forum klanu</a>)";
		print "</td></tr>";
		print "</table></center><br>";
	}
}
?>

<?php require_once("footer.php"); ?>
