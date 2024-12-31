<?php 
/***************************************************************************
 *                               outposts.php
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

$title = "Stra�nica"; require_once("header.php"); ?>
<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!isset($_GET['buy'])) {
     $_GET['buy'] = '';
}
$out = mysql_fetch_array(mysql_query("select * from outposts where owner=$stat[id]"));
if (empty ($out['id'])) {
print "Nie masz dost�pu do mini gry w stra�nicy! Za 500 sztuk z�ota, mo�esz zagra� w t� pi�kn� gr�. Wi�c jak, chcesz kupi�?<br><br>";
print "\"<a href=outposts.php?action=buy>Tak</a>.\"<br>";
print "\"<a href=city.php>Nie</a>.\"<br>";
if ($_GET['action'] == 'buy') {
$out = mysql_fetch_array(mysql_query("select * from outposts where owner=$stat[id]"));		
if ($out['id']) {
print "Kupi�e� dost�p do gry! Kliknij <a href=outposts.php>tutaj</a> aby wr�ci�.";			
require_once("footer.php");
	exit;
	} else {
	if ($gracz['credits'] < 500) {
		print "Nie masz wystarczaj�co du�o pieni�dzy aby gra� tutaj.";					
                require_once("footer.php");
		exit;
	} else {
	mysql_query("update players set credits=credits-500 where id=$stat[id]");			
        mysql_query("insert into outposts (owner) values($stat[id])");					
        print "Mo�esz gra� tutaj! Kliknij <a href=outposts.php>tutaj</a> aby wr�ci�.";			}
	}
	}}
if (empty ($_GET['view']) && $out['id']) {
	print "Witaj w stra�nicy. Je�eli pierwszy raz grasz w t� gr�, powiniene� przeczyta� instrukcj�.";	
	print "<ul>";	
	print "<li><a href=outposts.php?view=myoutpost>Moja Stra�nica</a>	
	<li><a href=outposts.php?view=mines>Kopalnie</a>	
	<li><a href=outposts.php?view=shop>Sklep w Stra�nicy</a>
	<li><a href=outposts.php?view=kasa>Zamie� �etony na z�oto lub z�oto na �etony</a>
	<li><a href=outposts.php?view=battle>Atakuj Stra�nic�</a>	
	<li><a href=outposts.php?view=listing>Lista Stra�nic</a><br><br>	
	<li><a href=outposts.php?view=guide>Instrukcja Stra�nicy</a>";
}
if ($_GET['view'] == 'kasa') {
	print "Tutaj mo�esz zamieni� �etony ze Stra�nicy na z�oto lub z�oto z twojej postaci na �etony w Stra�nicy. Przelicznik jest 2:1 (czyli za 2 �etony dostajesz 1 sztuk� z�ota lub za 2 sztuki z�ota jeden �eton).";
	print "<form method=post action=outposts.php?view=kasa&step=zloto>Zamie� <input type=text name=zeton> �eton�w na sztuki z�ota. <input type=submit value=Zamie�></form>";
	print "<form method=post action=outposts.php?view=kasa&step=zetony>Zamie� <input type=text name=sztuki> sztuk z�ota na �etony. <input type=submit value=Zamie�></form>";
	if ($_GET['step'] == 'zloto') {
		if (!ereg("^[1-9][0-9]*$", $_POST['zeton'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($_POST['zeton'] > $out['tokens']) {
			print "Nie masz tyle �eton�w!";
			require_once("footer.php");
			exit;
		}
		$zmiana = floor($_POST['zeton'] / 2);
		mysql_query("update players set credits=credits+$zmiana where id=$stat[id]");
		mysql_query("update outposts set tokens=tokens-$_POST[zeton] where owner=$stat[id]");
		print "Zamieni�e� <b>$_POST[zeton]</b> �eton�w na <b>$zmiana</b> sztuk z�ota.";
	}
	if ($_GET['step'] == 'zetony') {
		if (!ereg("^[1-9][0-9]*$", $_POST['sztuki'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($_POST['sztuki'] > $gracz['credits']) {
			print "Nie masz tyle sztuk z�ota";
			require_once("footer.php");
			exit;
		}
		$zmiana = floor($_POST['sztuki'] / 2);
		mysql_query("update players set credits=credits-$_POST[sztuki] where id=$stat[id]");
		mysql_query("update outposts set tokens=tokens+$zmiana where owner=$stat[id]");
		print "Zamieni�e� <b>$_POST[sztuki]</b> sztuk z�ota na <b>$zmiana</b> �etony.";
	}
}
if ($_GET['view'] == 'guide') {
print "<u><b>Podstawy</b></u><br>";
print "Podstawowym zadaniem w grze jest posiadanie najwi�kszej stra�nicy i najwi�cej �eton�w (�etony to pieni�dze w tej grze.) Podczas ka�dego resetu, dostajesz 5 tur. Mo�esz zrobi� co chcesz z tymi turami.";
print "<br><br><u><b>Wydobywanie</b></u><br>";
print "Wydobywanie jest bardzo dobrym sposobem na zarobienie pieni�dzy. Wydobycie zabiera jedn� tur�. Za ka�dym razem, kiedy opiesz w kopalni, dostajesz �etony. Im wi�cej masz kopalni, tym wi�cej zarabiasz. Mo�esz mie� tylko tyle kopalni jaki rozmiar masz Stra�nicy.";
print "<br><br><u><b>Sklep w Stra�nicy</b></u><br>";
print "To jest podstawowy sklep, gdzie mo�esz kupowa� wi�cej �o�nierzy i fortyfikacji. Im wi�cej masz �o�nierzy tym wi�ksz� si�� ofensywn� ma twoja baza. Im wi�cej fortyfikacji, tym lepsza obrona twojej bazy.";
print "<br><br><b><u>Atakowanie Stra�nicy</b></u><br>";
print "Atakowanie jest najlepszym sposobem na zdobywanie �eton�w. Je�eli masz wi�cej �o�nierzy i fortyfikacji ni� przeciwnik, kt�rego atakujesz, zwyci�asz. W przeciwnym wypadku przegrywasz. Mo�esz mie� tylko 10 �o�nie�y i 10 fortyfikacji na jeden rozmiar Stra�nicy.";
}
if ($_GET['view'] == 'myoutpost') {
print "Witaj w swojej Stra�nicy, $gracz[user].<br><br>";
print "<br><br><b><u>Informacje o Stra�nicy</b></u><br>";
print "<table>";
print "<tr><td><b>Rozmiar</b>:</td><td>$out[size]</td></tr>";
print "<tr><td><b>Tur</b>:</td><td>$out[turns]</td></tr>";
print "<tr><td><b>�eton�w</b>:</td><td>$out[tokens]</td></tr>";
print "<tr><td><b>�o�nierzy</b>:</td><td>$out[troops]</td></tr>";
print "<tr><td><b>Fortyfikacji</b>:</td><td>$out[barricades]</td></tr>";
print "</table>";
}
if ($_GET['view'] == 'mines') {
if ($out['mines'] <= 0) {
	print "Nie masz jakichkolwiek kopalni! Chcesz kupi� jedn�? Tylko 500 �eton�w.<br>";
	print "\"<a href=outposts.php?view=mines&step=yes>Tak</a>.\"<br>";
	print "\"<a href=outposts.php?view=myoutpost>Nie</a>.\"";
	if ($_GET['step'] == 'yes') {
		if ($out['tokens'] < 500) {
			print "Nie masz tylu �eton�w.";							
                        require_once("footer.php");
			exit;
		}
	mysql_query("update outposts set tokens=tokens-500 where id=$out[id]");
	mysql_query("update outposts set mines=mines+1 where id=$out[id]");
	print "<br>W porz�dku! Teraz masz kopalni�. (<a href=outposts.php?view=mines>od�wie�</a>)";
	require_once("footer.php");
	exit;
	}
	} else {
	print "Witaj w kopalniach. Co chcesz robi�? Masz <b>$out[mines]</b> kopalni.";
	$needed = ($out['size'] * 500);
	print "<ul>";
	print "<li><a href=outposts.php?view=mines&step=buy>Kup kopalni�</a> ($needed �eton�w)</li></ul>";
	print "<form method=post action=outposts.php?view=mines&step=mine>Id� wydobywa� minera�y <input type=text name=razy> razy. <input type=submit value=Id�></form>";
	if ($_GET['step'] == 'mine') {
		if ($out['turns'] < $_POST['razy']) {
			print "Nie masz tylu tur.";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$razem = 0;
		for ($i=1;$i<=$_POST['razy'];$i++) {
			$gain = ($out['mines'] * rand(10,50));
			$razem = ($razem + $gain);
		}
		mysql_query("update outposts set turns=turns-$_POST[razy] where id=$out[id]");
		mysql_query("update outposts set tokens=tokens+$razem where id=$out[id]");
		print "Wydoby�e� nieco kamieni szlachetnych. Zarobi�e� <b>$razem</b> �eton�w.";
	}
	if ($_GET['step'] == 'buy') {
	if ($out['size'] == $out['mines']) {
	print "Osi�gn��e� maksymaln� ilo�� kopani. Wr�c, kiedy twoja Stra�nica b�dzie wi�ksza.";
	} else {
	$needed = ($out['size'] * 500);
	if ($out['tokens'] < $needed) {
		print "Nie sta� ci� na nast�pn� kopalni�.";
	} else {
	mysql_query("update outposts set tokens=tokens-$needed where id=$out[id]");			
        mysql_query("update outposts set mines=mines+1 where id=$out[id]");				
        print "Kupi�e� <b>1</b> kopalni� za  <b>$needed</b> �eton�w.";
	}
	}		
	}	
	}}
if ($_GET['view'] == 'shop') {
	print "Witaj w Sklepie w Stra�nicy! Kupisz tutaj �o�nierzy i fortyfikacje lub zwi�kszysz rozmiar twojej Stra�nicy.";
	print "<ul>";
	$needed = ($out['size'] * 750);
	print "<li><a href=outposts.php?view=shop&buy=s>Powi�ksz rozmiar Stra�nicy</a> ($needed �eton�w)</li></ul>";
	print "<form method=post action=outposts.php?view=shop&buy=t>Zakup <input type=text name=armia> �o�nierzy do stra�nicy. <input type=submit value=Kup></form>";
	print "<form method=post action=outposts.php?view=shop&buy=b>Zakup <input type=text name=fort> fortyfikacji do stra�nicy. <input type=submit value=Kup></form>";
	if ($_GET['buy'] == 's') {
		$needed = ($out['size'] * 750);
		if ($needed > $out['tokens']) {
			print "Nie masz wystarczaj�cej ilo�ci �eton�w.";
		} else {
		mysql_query("update outposts set tokens=tokens-$needed where id=$out[id]");
		mysql_query("update outposts set size=size+1 where id=$out[id]");
		print "Powi�kszy�e� rozmiar swojej Stra�nicy o <b>1</b> za <b>$needed</b> �eton�w.";
		}
	}
	if ($_GET['buy'] == 't') {
		if (!ereg("^[1-9][0-9]*$", $_POST['armia'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$koszt = ($_POST['armia']* 100);
		if ($koszt > $out['tokens']) {
			print "Nie masz wystarczaj�cej ilo�ci �eton�w.";
			require_once("footer.php");
			exit;
		}
		$max = ($out['size'] * 10);
		$maxarmia = ($_POST['armia'] + $out['troops']);
		if ($maxarmia > $max) {
			print "Nie mo�esz kupi� tak wielu �o�nierzy do Stra�nicy. Zwi�ksz jej rozmiar, zanim zakupisz wi�cej �o�nie�y.";
			require_once("footer.php");
			exit;
		}
		mysql_query("update outposts set tokens=tokens-$koszt where id=$out[id]");
		mysql_query("update outposts set troops=troops+$_POST[armia] where id=$out[id]");
		print "Doda�e� <b>$_POST[armia]</b> �o�nierzy do Stra�nicy za <b>$koszt</b> �eton�w.";
	}
	if ($_GET['buy'] == 'b') {
		if (!ereg("^[1-9][0-9]*$", $_POST['fort'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$koszt = ($_POST['fort']* 100);
		if ($koszt > $out['tokens']) {
			print "Nie masz wystarczaj�cej ilo�ci �eton�w.";
			require_once("footer.php");
			exit;
		}
		$max = ($out['size'] * 10);
		$maxfort = ($_POST['fort'] + $out['barricades']);
		if ($maxfort > $max) {
			print "Nie mo�esz kupi� tak wiele fortyfikacji do Stra�nicy. Zwi�ksz jej rozmiar, zanim zakupisz wi�cej fortyfikacji.";
			require_once("footer.php");
			exit;
		}
		mysql_query("update outposts set tokens=tokens-$koszt where id=$out[id]");
		mysql_query("update outposts set barricades=barricades+$_POST[fort] where id=$out[id]");
		print "Doda�e� <b>$_POST[fort]</b> fortyfikacji do Stra�nicy za <b>$koszt</b> �eton�w.";
	}
}
if ($_GET['view'] == 'battle') {
print "Witaj w pokoju narad. Wpisz po prostu ID Stra�nicy i atak rozpocznie si�.";
print "<table><form method=post action=outposts.php?view=battle&action=battle>";
print "<tr><td>ID Stra�nicy:</td><td><input type=text name=oid></td></tr>";
print "<tr><td colspan=2 align=center><input type=submit value=Atak></td></tr>";
print "</form></table>";
	if ($_GET['action'] == 'battle') {
	if ($out['turns'] <= 0) {
	print "Nie masz wystarczaj�cej ilo�ci tur.";
	} else {
	if (isset($_GET['oid'])) {
	    $_POST['oid'] = $_GET['oid'];
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['oid'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	if (empty($_POST['oid'])) {
		print "Podaj id stra�nicy do ataku";
		require_once ("footer.php");
		exit;
	}
	$enemy = mysql_fetch_array(mysql_query("select * from outposts where id=$_POST[oid]"));
	if (empty($enemy['id'])) {
		print "Nie ta Stra�nica.";
		} else {
	if ($_POST['oid'] == $out['id']) {
	print "Nie mo�esz zaatakowa� w�asnej Stra�nicy.";
	} else {
	mysql_query("update outposts set turns=turns-1 where owner=$stat[id]");
	$ypower = (($out['troops'] - $enemy['barricades']) + rand(1,$out['size']));
	$epower = (($enemy['troops'] - $out['barricades']) + rand(1,$enemy['size']));				        				
        if ($ypower <= 0) {
		$ypower = 1;
	}
	if ($epower <= 0) {
		$epower = 1;
	}
        if ($ypower == $epower) {
	print "Atakujesz na ID <b>$enemy[id]</b> z si�� <b>$ypower</b>. Przeciwnik odpowiada z tak� sam� ilo�ci� zadanych obra�e�.";
	}
	if ($ypower > $epower) {
	print "Atakujesz na ID $enemy[id] z si�� <b>$ypower</b>. Przeciwnik tylko odpowiada atakiem z si�� <b>$epower</b>.";
	$gain = ($enemy['size'] * rand(100,200));
	print "<br>Wygra�e�! Zdobywasz <b>$gain</b> �eton�w.";						
        mysql_query("update outposts set tokens=tokens+$gain where id=$out[id]");			}
	if ($ypower < $epower) {
	print "Atakujesz na ID $enemy[id] z si�� <b>$ypower</b>. Przeciwnik odpowiada z si��  <b>$epower</b>!";
	$gain = ($out['size'] * rand(100,200));
	print "<br>Przegrywasz. Przeciwnik ID $enemy[id] zdobywa <b>$gain</b> �eton�w.";		
        mysql_query("update outposts set tokens=tokens+$gain where id=$enemy[id]");			}
	}
	}
	}
	}}
if ($_GET['view'] == 'listing') {
	print "<table>";
	print "<tr><td width=100><b><u>ID Stra�nicy</td><td width=100><b><u>Rozmiar Stra�nicy</td><td width=100><b><u>W�a�ciciel</td><td width=100><b><u>Attakowa�?</td></tr>";		
        $osel = mysql_query("select * from outposts order by size desc");
	while ($op = mysql_fetch_array($osel)) {
	print "<tr><td>$op[id]</td><td>$op[size]</td><td><a href=view.php?view=$op[owner]>$op[owner]</a></td><td>- <a href=outposts.php?view=battle&action=battle&oid=$op[id]>Atak</a></td></tr>";
	}
	print "</table>";
	}
if ($_GET['view']) {
	print "<br><br>[<a href=outposts.php>Menu</a>]";
	}?>
<?php require_once("footer.php"); ?>
