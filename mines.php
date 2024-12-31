<?php 
/***************************************************************************
 *                               mines.php
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

$title = "Kopalnie"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['kup'])) {
     $_GET['kup'] = '';
}
if (!isset($_GET['buy'])) {
     $_GET['buy'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
$kopalnie = mysql_fetch_array(mysql_query("select kbronz, kzel, kweg, bronz, zelazo, wegiel, ops from kopalnie where gracz=$stat[id]"));
$sila = mysql_fetch_array(mysql_query("select strength, klasa from players where id=$stat[id]"));
if (empty($kopalnie)) {
	print "Nie masz jakiejkolwiek kopalni! Czy chcesz kupiæ kopalniê? Koszt w sztukach mithrilu zale¿y od rodzaju kopalni.";
	print "<ul>";
	print "<li><a href=mines.php?kup=bronz>Kopalnia br±zu - 25 sztuk mithrilu</a></li>";
	print "<li><a href=mines.php?kup=zelaz>Kopalna ¿elaza - 50 sztuk mithrilu</a></li>";
	print "<li><a href=mines.php?kup=wegie>Kolapnia wêgla - 75 sztuk mithrilu</a></li>";
	print "</ul>";
}
	if ($_GET['kup'] == 'bronz') {
		if ($gracz['platinum'] < 25) {
			print "Nie masz wystarczaj±co du¿o sztuk mithrilu.";
			require_once("footer.php");
			exit;
		} else {
			print "Kupi³e¶ kopalniê br±zu! Kliknij <a href=mines.php>tutaj</a>.";
			mysql_query("update players set platinum=platinum-25 where id=$stat[id]");
			if (empty($kopalnie)) {
				mysql_query("insert into kopalnie (gracz, kbronz) values($stat[id],1)") or die("Nie mogê dodaæ kopalni");
			} else {
				mysql_query("update kopalnie set kbronz=1 where gracz=$stat[id]");
			}
		}
	}
	if ($_GET['kup'] == 'zelaz') {
		if ($gracz['platinum'] < 50) {
			print "Nie masz wystarczaj±co du¿o sztuk mithrilu.";
			require_once("footer.php");
			exit;
		} else {
			print "Kupi³e¶ kopalniê ¿elaza! Kliknij <a href=mines.php>tutaj</a>.";
			mysql_query("update players set platinum=platinum-50 where id=$stat[id]");
			if (empty($kopalnie)) {
				mysql_query("insert into kopalnie (gracz, kzel) values($stat[id],1)");
			} else {
				mysql_query("update kopalnie set kzel=1 where gracz=$stat[id]");
			}
		}
	}
	if ($_GET['kup'] == 'wegie') {
		if ($gracz['platinum'] < 75) {
			print "Nie masz wystarczaj±co du¿o sztuk mithrilu.";
			require_once("footer.php");
			exit;
		} else {
			print "Kupi³e¶ kopalniê wêgla! Kliknij <a href=mines.php>tutaj</a>.";
			mysql_query("update players set platinum=platinum-75 where id=$stat[id]");
			if (empty($kopalnie)) {
				mysql_query("insert into kopalnie (gracz, kweg) values($stat[id],1)");
			} else {
				mysql_query("update kopalnie set kweg=1 where gracz=$stat[id]");
			}
		}
	}

if (!$_GET['view'] && !$_GET['kup'] && !empty($kopalnie)) {
	print "Witaj w swojej kopalni.";
	print "<ul>";
	print "<li><a href=mines.php?view=stats>Statystyki</a>";
	print "<li><a href=mines.php?view=shop>Sklep</a>";
	print "<li><a href=mines.php?view=market>Rynek</a>";
	print "<li><a href=mines.php?view=mine>Kopalnia</a>";
	print "</ul>";
}

if ($_GET['view'] == 'stats') {
	print "Tutaj s± informacje na temat twojej kopalni.";
	print "<ul>";
	print "<li>Obszar kopalni br±zu: $kopalnie[kbronz]</li>";
	print "<li>Obszar kopalni ¿elaza: $kopalnie[kzel]</li>";
	print "<li>Obszar kopalni wêgla: $kopalnie[kweg]</li>";
	print "<li>Zosta³o Operacji: $kopalnie[ops]</li>";
	print "<li>Wêgiel: $kopalnie[wegiel]</li>";
	print "<li>¯elazo: $kopalnie[zelazo]</li>";
	print "<li>Br±z: $kopalnie[bronz]</li>";
	print "</ul>";
}

if ($_GET['view'] == 'shop') {
	print "Witaj w sklepie. Tutaj mo¿esz kupiæ dodatkow± ziemiê dla twojej kopalni. Czy chcesz kupiæ?";
	$minen = ($kopalnie['kbronz'] * 5000);
	$zelazo = ($kopalnie['kzel'] * 10000);
	$wegiel = ($kopalnie['kweg'] * 15000);
	print "<ul>";
	if ($kopalnie['kbronz'] > 0) {
		print "<li><a href=mines.php?view=shop&buy=mine&rodz=kbronz>1 obszar wiêcej kopalni br±zu</a> ($minen sztuk z³ota)</li>";
	} else {
		print "<li><a href=mines.php?kup=bronz>Kopalna br±zu - 25 sztuk mithrilu</a></li>";
	}
	if ($kopalnie['kzel'] > 0) {
		print "<li><a href=mines.php?view=shop&buy=mine&rodz=kzel>1 obszar wiêcej kopalni ¿elaza</a> ($zelazo sztuk z³ota)</li>";
	} else {
		print "<li><a href=mines.php?kup=zelaz>Kopalna ¿elaza - 50 sztuk mithrilu</a></li>";
	}
	if ($kopalnie['kweg'] > 0) {
		print "<li><a href=mines.php?view=shop&buy=mine&rodz=kweg>1 obszar wiêcej kopalni wêgla</a> ($wegiel sztuk z³ota)</li>";
	} else {
		print "<li><a href=mines.php?kup=wegie>Kopalnia wêgla - 75 sztuk mithrilu</a></li>";
	}
	print "</ul>";
	if ($_GET['buy'] == 'mine') {
		if ($_GET['rodz'] != 'kbronz' && $_GET['rodz'] != 'kzel' && $_GET['rodz'] != 'kweg') {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($_GET['rodz'] == 'kbronz') {
			$kopalnia = ($kopalnie['kbronz'] + 1);
			$cena = $minen;
			$nazwa = 'br±zu';
		}
		if ($_GET['rodz'] == 'kzel') {
			$kopalnia = ($kopalnie['kzel'] + 1);
			$cena = $zelazo;
			$nazwa = '¿elaza';
		}
		if ($_GET['rodz'] == 'kweg') {
			$kopalnia = ($kopalnie['kweg'] + 1);
			$cena = $wegiel;
			$nazwa = 'wêgla';
		}
		if ($gracz['credits'] >= $cena) {
			print "Kupi³e¶ dodatkowy obszar dla twojej kopalni $nazwa. (<a href=mines.php?view=shop>Od¶wie¿</a>)";
			mysql_query("update kopalnie set $rodz=$kopalnia where gracz=$stat[id]");
			mysql_query("update players set credits=credits-$cena where id=$stat[id]");
		} else {
			print "Nie staæ ciê na to!";
		}
	}

}

if ($_GET['view'] == 'market') {
	if (!$_GET['step']) {
		print "Mo¿esz tutaj sprzedawaæ minera³y z twojej kopalni.";
		print "<form method=post action=mines.php?view=market&step=sell>";
		print "<table>";
		print "<tr><td>Sprzedaj <input type=text name=wegiel size=5 value=$kopalnie[wegiel]> bry³ wêgla za 15 sztuk z³ota ka¿da.</td></tr>";
		print "<tr><td>Sprzedaj <input type=text name=zelazo size=5 value=$kopalnie[zelazo]> bry³ ¿elaza za 10 sztuk z³ota ka¿da.</td></tr>";
		print "<tr><td>Sprzedaj <input type=text name=bronz size=5 value=$kopalnie[bronz]> bry³ br±zu za 5 sztuk z³ota ka¿da.</td></tr>";
		print "<tr><td align=center><input type=submit value=Sprzedaj></td></tr>";
		print "</form></table>";
	}
	if ($_GET['step'] == 'sell') {
		if (!ereg("^[0-9]*$", $_POST['bronz']) || !ereg("^[0-9]*$", $_POST['zelazo']) || !ereg("^[0-9]*$", $_POST['wegiel'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$_POST['wegiel'] = str_replace("--","", $_POST['wegiel']);
		$_POST['zelazo'] = str_replace("--","", $_POST['zelazo']);
		$_POST['bronz'] = str_replace("--","", $_POST['bronz']);
		if ($_POST['wegiel'] > $kopalnie['wegiel'] || $_POST['zelazo'] > $kopalnie['zelazo'] || $_POST['bronz'] > $kopalnie['bronz'] || $_POST['wegiel'] < 0 || $_POST['zelazo'] < 0 || $_POST['bronz'] < 0) {
			print "Nie masz tyle minera³ów.";
			require_once("footer.php");
			exit;
		}
		$again = ($_POST['wegiel'] * 15);
		$bgain = ($_POST['zelazo'] * 10);
		$brgain = ($_POST['bronz'] * 5);
		$tgain = ($again + $bgain + $brgain);
		mysql_query("update kopalnie set wegiel=wegiel-$_POST[wegiel] where gracz=$stat[id]");
		mysql_query("update kopalnie set zelazo=zelazo-$_POST[zelazo] where gracz=$stat[id]");
		mysql_query("update kopalnie set bronz=bronz-$_POST[bronz] where gracz=$stat[id]");
		mysql_query("update players set credits=credits+$tgain where id=$stat[id]");
		print "Sprzeda³e¶ <b>$_POST[wegiel] bry³ wêgla</b> za <b>$again</b> sztuk z³ota.<br>";
		print "Sprzeda³e¶ <b>$_POST[zelazo] bry³ ¿elaza</b> za <b>$bgain</b> sztuk z³ota.<br>";
		print "Sprzeda³e¶ <b>$_POST[bronz] bry³ br±zu</b> za <b>$brgain</b> sztuk z³ota.<br>";
		print "Ogólnie, zarobi³e¶ <b>$tgain</b> sztuk z³ota.";
	}
}

if ($_GET['view'] == 'mine') {
	if ($gracz['hp'] == 0) {
		print "Nie mo¿esz wydobywaæ minera³ów poniewa¿ jeste¶ martwy!";
		require_once("footer.php");
		exit;
	}
	print "Zbierasz swój ekwipunek i wyruszasz do kopalni...<br>";
	print "<form method=post action=mines.php?view=mine&step=mine>Id¼ wydobywaæ z³o¿a <select name=zloze>";
	if($kopalnie['kbronz'] > 0) {
		print "<option value=bronz>br±zu</option>";
	}
	if ($kopalnie['kzel'] > 0) {
		print "<option value=zelazo>¿elaza</option>";
	}
	if ($kopalnie['kweg'] > 0) {
		print "<option value=wegiel>wêgla</option>";
	}
	print "</select> ";
	print "<input type=text name=razy> razy. <input type=submit value=Wydobywaj></form>";
	if ($_GET['step'] == 'mine') {
		if ($kopalnie['ops'] < $_POST['razy']) {
			print "Nie masz tyle punktów operacji!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$pr = ceil($sila['strength'] / 10);
		if ($sila['klasa'] == 'Obywatel') {
			$premia1 = ceil($gracz['level'] / 10);
			$premia = ($premia1 + $pr);
		} else {
			$premia = $pr;
		}
		$mrazem = 0;
		$mgain = 0;
		if ($_POST['zloze'] != 'bronz' && $_POST['zloze'] != 'zelazo' && $_POST['zloze'] != 'wegiel') {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($_POST['zloze'] == 'bronz') {
			for ($i=1;$i<=$_POST['razy'];$i++) {
				$mgain = (($kopalnie['kbronz'] * rand (0,7) + $premia));
				$mrazem = ($mrazem + $mgain);
				$nazwa = 'br±zu';
			}
		}
		if ($_POST['zloze'] == 'zelazo') {
			for ($i=1;$i<=$_POST['razy'];$i++) {
				$mgain = (($kopalnie['kzel'] * rand(0,5) + $premia));
				$mrazem = ($mrazem + $mgain);
				$nazwa = '¿elaza';
			}
		}
		if ($_POST['zloze'] == 'wegiel') {
			for ($i=1;$i<=$_POST['razy'];$i++) {
				$mgain = (($kopalnie['kweg'] * rand(0,3) + $premia));
				$mrazem = ($mrazem + $mgain);
				$nazwa = 'wêgla';
			}
		}
		mysql_query("update kopalnie set ops=ops-$_POST[razy] where gracz=$stat[id]");
		mysql_query("update kopalnie set $_POST[zloze]=$_POST[zloze]+$mrazem where gracz=$stat[id]");
		print "Wykopa³e¶ <b>$mrazem bry³ $nazwa</b>.";
	}
}
if ($_GET['view']) {
	print "<br><br>... <a href=mines.php>kopalnia</a>.";
}
?>

<?php require_once("footer.php"); ?>
