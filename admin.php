<?php 
/***************************************************************************
 *                               admin.php
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

$title = "Panel Administracyjny"; require_once("header.php"); ?>

<?php
if ($gracz['rank'] != "Admin") {
	print "Nie jeste¶ W³adc±.";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!$_GET['view']) {
print "Witaj w panelu administracyjnym. Co chcesz zrobiæ?
<ul>
	<li><A href=addupdate.php>Dodaæ Wie¶æ</a>
	<li><A href=addnews.php>Dodaæ Plotkê</a>
	<li><a href=admin.php?view=del>Skasowaæ u¿ytkownika</a>
	<li><a href=admin.php?view=donate>Dotowaæ u¿ytkownika</a>
	<li><a href=admin.php?view=takeaway>Zabraæ sztuki z³ota</a>
	<li><a href=admin.php?view=add>Zmieniæ rangê</a>
	<li><a href=admin.php?view=tags>Daæ Immunitet</a>
	<li><a href=admin.php?view=clearf>Wyczy¶ciæ Forum</a>
	<li><a href=admin.php?view=clearc>Wyczy¶ciæ Czat</a>
	<li><a href=admin.php?view=equipment>Ekwipunek</a>
	<li><a href=admin.php?view=monster>Potwory</a>
	<li><a href=admin.php?view=kowal>Kowal</a>
	<li><a href=admin.php?view=czary>Czary</a>
	<li><a href=admin.php?view=poczta>Wy¶lij pocztê do wszystkich</a>
	<li><a href=admin.php?view=czat>Zablokuj/odblokuj wiadomo¶ci od gracza na czacie</a>
</ul>";
}
if ($_GET['view'] == 'del') {
	print
	"<form method=post action=admin.php?view=del&step=del>
	Skasuj ID<input type=text name=did>.<input type=submit value=Skasuj>
	</form>";
	if ($_GET['step'] == 'del') {
		if ($_POST['did'] != 1) {
			mysql_query("delete from players where id=".$_POST['did']);
			mysql_query("delete from core where owner=".$_POST['did']);
			mysql_query("delete from core_market where seller=".$_POST['did']);
			mysql_query("delete from equipment where owner=".$_POST['did']);
			mysql_query("delete from kowal where gracz=".$_POST['did']);
			mysql_query("delete from log where owner=".$_POST['did']);
			mysql_query("delete from mail where owner=".$_POST['did']);
			mysql_query("delete from outpost where owner=".$_POST['did']);
			mysql_query("delete from pmarket where seller=".$_POST['did']);
			mysql_query("delete from hmarket where seller=".$_POST['did']);
			mysql_query("delete from mikstury where gracz=".$_POST['did']);
			mysql_query("delete from herbs where gracz=".$_POST['did']);
			mysql_query("delete from kopalnie where gracz=".$_POST['did']);
			mysql_query("delete from alchemik where gracz=".$_POST['did']);
			mysql_query("delete from czary where gracz=".$_POST['did']);
			mysql_query("delete from kowal_praca where gracz=".$_POST['did']);
			mysql_query("delete from notatnik where gracz=".$_POST['did']);
			mysql_query("delete from tribe_oczek where gracz=".$_POST['did']);
			print "Skasowa³e¶ ID ".$_POST['did'];
		} else {
			print "Nie skasowa³e¶ u¿ytkownika.";
		}
	}
}

if ($_GET['view'] == 'add') {
	print
	"<form method=post action=admin.php?view=add&step=add>
	Dodaj ID <input type=text name=aid> jako
	<select name=rank>
	<option value=Member>Mieszkaniec</option>
	<option value=Admin>W³adca</option>
	<option value=Staff>Ksi±¿ê</option>
	<option value=Sêdzia>Sêdzia</option>
	<option value=£awnik>£awnik</option>
	<option value=Prawnik>Prawnik</option>
	<option value=¯ebrak>¯ebrak</option>
	<option value=Barbarzyñca>Barbarzyñca</option>";
	if ($gracz['user'] == 'Thindil') {
		print "<option value=Rycerz>Rycerz</option>";
		print "<option value=Dama>Dama</option>";
	}
	print "</select>. <input type=submit value=Dodaj>
	</form>";
	if ($_GET['step'] == 'add') {
		if ($_POST['aid'] != 1) {
			mysql_query("update players set rank='".$_POST['rank']."' where id=".$_POST['aid']);
			print "Doda³e¶ ID ".$_POST['aid']." jako ".$_POST['rank'].".";
		}
	}
}

if ($_GET['view'] == 'clearf') {
	mysql_query("delete from topics");
	mysql_query("delete from replies");
	print "Wyczy¶ci³e¶ forum.";
}

if ($_GET['view'] == 'clearc') {
	mysql_query("delete from chat");
	print "Wyczy¶ci³e¶ czat.";
}

if ($_GET['view'] == 'tags') {
	print
	"<form method=post action=admin.php?view=tags&step=tag>
	Daj immunitet ID <input type=text name=tag_id size=5>. <input type=submit value=Daj>
	</form>";
	if ($_GET['step'] == "tag") {
		mysql_query("update players set immu='Y' where id=".$_POST['tag_id']);
		print "Da³e¶ immunitet ID <b>".$_POST['tag_id']."</b>.";
	}
}

if ($_GET['view'] == 'equipment') {
	print "<form method=post action=admin.php?view=equipment&step=add>
	Nazwa <input type=text name=name> jako
	<select name=type id=type>
	<option value=W>broñ</option>
	<option value=A>zbroja</option>
	<option value=H>he³m</option>
	<option value=N>nagolenniki</option>
	</select>
	<br> z
	<input name=power type=number id=power> Si³±<br>
	i Kosztuj±c± <input type=number name=cost>
	<br> z minimalnym poziomem
	<input type=number name=minlev> z ograniczeniem zr (zbroja i nagolenniki)
	<input name=zr type=number><br> dodaj±ca do szybko¶ci (broñ tylko)
	<input type=number name=szyb><br>
	z wytrzyma³o¶ci± <input type=number name=maxwt><br>
	<input type=submit value=Dodaj>
	</form>";
	if ($_GET['step'] == 'add') {
		if (empty ($_POST['name']) || empty ($_POST['cost']) || empty ($_POST['power'])) {
			print "Wype³nij wszystkie pola.";
			require_once("footer.php");
			exit;
		}
		if (empty($_POST['zr'])) {
			$_POST['zr'] = 0;
		}
		if (empty($_POST['szyb'])) {
			$_POST['szyb'] = 0;
		}
		$sql = "INSERT INTO equipment ( id , owner , name , power , status , type , cost , minlev, zr, szyb, wt, maxwt ) ";
		$sql .= "VALUES ( '', '0', '".$_POST['name']."', '".$_POST['power']."', 'S', '".$_POST['type']."', '".$_POST['cost']."', '".$_POST['minlev']."', '".$_POST['zr']."', '".$_POST['szyb']."', '".$_POST['maxwt']."', '".$_POST['maxwt']."' )";
		mysql_query("$sql");
		print "Doda³e¶ ".$_POST['name']." jako ".$_POST['type']." z si³± ".$_POST['power']." kosztuj±c± ".$_POST['cost']." oraz tylko dla tych, którzy osi±gneli ".$_POST['minlev']." poziom ograniczaj±c± zrêczno¶æ (nagolenniki i zbroja) ".$_POST['zr']." % dodaj±c± do szybko¶ci (tylko broñ) ".$_POST['zr']." % oraz z wytrzyma³o¶ci± ".$_POST['maxwt']." .";
	}
}


if ($_GET['view'] == 'donate') {
	print "<form method=post action=admin.php?view=donate&step=donated> ID: <input type=text name=id> <br>ilo¶æ: <input type=text name=amount>  <input type=submit value=Dotuj></form>";
if ($_GET['step'] == 'donated') {
	$_POST['amount'] = str_replace("--","", $_POST['amount']);
	if ($_POST['amount'] < 0 ) {
	print "nie mo¿esz tak zrobiæ";
	require_once("footer.php");
	exit;
	}
	mysql_query("update players set credits=credits+$_POST[amount] where id=$_POST[id]");
	print "Pieni±dze przekazane";
	require_once("footer.php");
	exit;
}
}
if ($_GET['view'] == 'takeaway') {
	print "<form method=post action=admin.php?view=takeaway&step=takenaway> ID: <input type=text name=id> <br>ilo¶æ: <input type=text name=taken>  <input type=submit value=Zabierz></form>";
if ($_GET['step'] == 'takenaway') {
	$_POST['taken'] = str_replace("--","", $_POST['taken']);
	if ($_POST['taken'] < 0 ) {
	print "nie mo¿esz tak zrobiæ";
	require_once("footer.php");
	exit;
	}
	mysql_query("update players set credits=credits-$_POST[taken] where id=$_POST[id]");
	print "$_POST[taken] sztuk z³ota zosta³o zabranych $_POST[id]";
	require_once("footer.php");
	exit;
}
}
if ($_GET['view'] == 'monster') {
	print "<form method=post action=admin.php?view=monster&step=monster>Nazwa: <input type=text name=nazwa> <br>Poziom: <input type=text name=poziom> <br>P¯: <input type=text name=pz> <br>Zrêczno¶æ: <input type=text name=zr> <br>Si³a: <input type=text name=sila> <br>Min z³ota: <input type=text name=minzl> <br>Max z³ota: <input type=text name=maxzl> <br>Min PD: <input type=text name=minpd> <br>Max PD: <input type=text name=maxpd> <br><input type=submit value=Dodaj></form>";
	if ($_GET['step'] == 'monster') {
		if (!$_POST['nazwa'] || !$_POST['poziom'] || !$_POST['pz'] || !$_POST['zr'] || !$_POST['sila'] || !$_POST['minzl'] || !$_POST['maxzl'] || !$_POST['minpd'] || !$_POST['maxpd']) {
			print "wype³nij wszystkie pola!";
			require_once ("footer.php");
			exit;
		}
	mysql_query ("insert into monsters (name, level, hp, agility, strength, credits1, credits2, exp1, exp2) values('$_POST[nazwa]',$_POST[poziom],$_POST[pz],$_POST[zr],$_POST[sila],$_POST[minzl],$_POST[maxzl],$_POST[minpd],$_POST[maxpd])");
	}
}
if ($_GET['view'] == 'kowal') {
	print "<form method=post action=admin.php?view=kowal&step=kowal>Nazwa: <input type=text name=nazwa> <br>Cena: <input type=text name=cena> <br>¯elazo: <input type=text name=zelazo> <br>Wêgiel: <input type=text name=wegiel> <br>Br±z: <input type=text name=bronz> <br>Mithril: <input type=text name=mithril> <br>Adamantium: <input type=text name=adam> <br>Meteor: <input type=text name=meteo> <br>Kryszta³: <input type=text name=krysztal> <br>Poziom: <input type=text name=poziom> <br>Typ: 	<select name=type id=type>
	<option value=W>broñ</option>
	<option value=A>zbroja</option>
	<option value=H>he³m</option>
	<option value=N>nagolenniki</option>
	</select>
<br><input type=submit value=Dodaj></form>";
	if ($_GET['step'] == 'kowal') {
		if (!$_POST['nazwa'] || !$_POST['cena'] || !$_POST['poziom']) {
			print "Wype³nij wszystkie pola!";
			require_once ("footer.php");
			exit();
		}
		if (!$_POST['zelazo']) {
			$_POST['zelazo'] = 0;
		}
		if (!$_POST['wegiel']) {
			$_POST['wegiel'] = 0;
		}
		if (!$_POST['bronz']) {
			$_POST['bronz'] = 0;
		}
		if (!$_POST['mithril']) {
			$_POST['mithril'] = 0;
		}
		if (!$_POST['adam']) {
			$_POST['adam'] = 0;
		}
		if (!$_POST['meteo']) {
			$_POST['meteo'] = 0;
		}
		if (!$_POST['krysztal']) {
			$_POST['krysztal'] = 0;
		}
	mysql_query ("insert into kowal (nazwa, cena, zelazo, wegiel, bronz, poziom, mithril, adamant, meteor, krysztal, type) values('$_POST[nazwa]',$_POST[cena],$_POST[zelazo],$_POST[wegiel],$_POST[bronz],$_POST[poziom],$_POST[mithril],$_POST[adam],$_POST[meteo],$_POST[krysztal],'$_POST[type]')");
	}
}

if ($_GET['view'] == 'poczta') {
	print "<table>";
	print "<form method=post action=admin.php?view=poczta&step=send>";
	print "<tr><td>Temat:</td><td><input type=text name=subject value=$re></td></tr>";
	print "<tr><td valign=top>Tre¶æ:</td><td><textarea name=body rows=5 cols=19></textarea></td></tr>";
	print "<tr><td colspan=2 align=center><input type=submit value=Wy¶lij></td></tr>";
	print "</form></table>";
	if ($_GET['step'] == 'send') {
		if (empty ($_POST['body'])) {
			print "Wype³nij pole.";
			require_once("footer.php");
			exit;
		}
		if (empty ($_POST['subject'])) {
			$_POST['subject'] = "Brak";
		}
		$_POST['subject'] = strip_tags($_POST['subject']);
		$_POST['body'] = strip_tags($_POST['body']);
		$adresat = mysql_query("select * from players");
		$gracze = 0;
		while ($odbio = mysql_fetch_array($adresat)) {
			mysql_query("insert into mail (sender,senderid,owner,subject,body) values('$gracz[user]','$stat[id]',$odbio[id],'$_POST[subject]','$_POST[body]')") or die("Nie mogê wys³aæ listu.");
			mysql_query("insert into log (owner, log) values($odbio[id], '<b>$gracz[user]</b> wys³a³ ci wiadomo¶æ.')") or die("Nie mogê dodaæ do dziennika.");
			$gracze = $gracze+1;
		}
		print "Wys³a³e¶ wiadomo¶æ do $gracze graczy.";
	}
}
if ($_GET['view'] == 'czat') {
	$cz = mysql_query("select * from chat_config");
	print "Lista zablokowanych<br>";
	while ($czatb = mysql_fetch_array($cz)){
		print "ID: $czatb[gracz]";
	}
	print "<form method=post action=admin.php?view=czat&step=czat>";
	print "<select name=czat><option value=blok>Zablokuj</option><option value=odblok>Odblokuj</option></select> ID <input type=text name=czat_id size=5>. <input type=submit value=Zrób>";
	print "</form>";
	if ($_GET['step'] == 'czat') {
		if ($_POST['czat'] == 'blok') {
			mysql_query("insert into chat_config (gracz) values($_POST[czat_id])");
			print "Zablokowa³e¶ wysy³anie wiadomo¶ci na czacie przez gracza $_POST[czat_id]";
		}
		if ($_POST['czat'] == 'odblok') {
			mysql_query("delete from chat_config where gracz=$_POST[czat_id]");
			print "Odblokowa³e¶ wysy³anie wiadomo¶ci na czacie przez gracza $_POST[czat_id]";
		}
	}
}
if ($_GET['view'] == 'czary') {
	print "<form method=post action=admin.php?view=czary&step=add>Nazwa <input type=text name=name> jako czar <select name=type><option value=B>Bojowy</option><option value=O>Obronny</option></select><br> z <input name=power type=number> Si³±<br> i Kosztuj±c± <input type=number name=cost><br> z minimalnym poziomem <input type=number name=minlev> <input type=submit value=Dodaj></form>";
	if ($_GET['step'] == 'add') {
		if (empty($_POST['name']) || empty($_POST['power']) || empty($_POST['cost']) || empty($_POST['minlev'])) {
			print "Wype³nij wszystkie pola!";
			require_once("footer.php");
			exit;
		}
		mysql_query("insert into czary (nazwa, cena, poziom, typ, obr) values('$_POST[name]',$_POST[cost],$_POST[minlev],'$_POST[type]',$_POST[power])");
		print "Doda³e¶ czar $_POST[name] jako czar $_POST[type] z si³± $_POST[power] kosztuj±cy $_POST[cost] dla graczy, którzy osi±gneli poziom $_POST[minlev].";
	}
}
?>

<?php require_once("footer.php"); ?>
