<?php 
/***************************************************************************
 *                               temple.php
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

$title = "�wi�tynia";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['temp'])) {
     $_GET['temp'] = '';
}
$gr10 = mysql_fetch_array(mysql_query("select pw, inteli, rasa from players where id=$stat[id]"));
if (!$_GET['temp']) {
	print "Witaj w �wi�tyni. Mo�esz tutaj modli� si� do Illuminati - najwy�szego boga Vallheru. Aby twoja modlitwa zosta�a wys�uchana, musisz posiada� odpowiedni� ilo�� Punkt�w Wiary. Punkty zdobywasz s�u��c w �wi�tyni. To czym ciebie obdaruje b�g zale�y tylko od niego.<br><br>
	<ul>
	<li><a href=temple.php?temp=sluzba>Pracuj dla �wi�tyni</a></li>
	<li><a href=temple.php?temp=modlitwa>M�dl si� do boga</a></li></ul>";
}
if ($_GET['temp'] == 'sluzba') {
	print "Pracuj�c dla �wi�tyni, sprawiasz, �e Illuminati spogl�da na ciebie przychylniejszym okiem. Za ka�de 0,2 energii zdobywasz 1 Punkt Wiary. Czy chcesz s�u�y� w �wi�tyni?<br><br>";
print "<form method=post action=temple.php?temp=sluzba&dalej=tak>
Chc� pracowa� dla �wi�tyni <input type=text size=3 value=0 name=rep> razy. <input type=submit value=Pracuj>
</form>";
	if (isset($_GET['dalej'])) {
		if ($_POST['rep'] <= 0) {
			print "Wpisz il� czasu (energii) chcesz pracowa� w �wi�tyni!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['rep'])) {
			print "Zapomnij o tym";
			incude("footer.php");
			exit;
		}
		if ($gracz['hp'] == 0) {
			print "Nie mo�esz pracowa� dla �wi�tyni poniewa� jeste� martwy!";
			require_once("footer.php");
			exit;
		}
		$razy = ($_POST['rep'] * 0.2);
		if ($gracz['energy'] < $razy) {
			print "Nie masz tyle energii!";
			require_once("footer.php");
			exit;
		}
		print "Pracowa�e� przez pewien czas dla �wi�tyni i zdobywasz $_POST[rep] Punkt(�w) Wiary.";
		mysql_query("update players set energy=energy-$razy where id=$stat[id]");
		mysql_query("update players set pw=pw+$_POST[rep] where id=$stat[id]");
	}
}
if ($_GET['temp'] == 'modlitwa') {
	if ($gracz['hp'] == 0) {
		print "Nie mo�esz modli� si�, poniewa� jeste� martwy!";
		require_once("footer.php");
		exit;
	}
	print "Postanowi�e� pomodli� si� do Illuminati o dar z nieba. Czy jeste� pewien?<br><br>
		<ul>
		<li><a href=temple.php?temp=modlitwa&modl=tak>Tak</a></li>
		<li><a href=temple.php>Nie</a></li></ul>";
	if (isset($_GET['modl'])) {
		if ($gr10['pw'] < 1) {
			print "Nie masz Punkt�w Wiary aby si� modli�!";
			require_once("footer.php");
			exit;
		}
		$pw1 = 0;
		$rzut = rand(1,100);
		$pw = $gr10['pw'];
		if ($pw > 20 && $pw < 100) {
			$pw1 = 20;
		}
		if ($pw >= 100) {
			$pw1 = ($pw1 + (ceil($pw / 100)));
			if ($pw1 > 50) {
				$pw1 = 50;
			}
		}
		if ($rzut <= $pw1) {
			$rzut1 = rand(1,14);
			if ($rzut1 == 1) {
				if ($gracz['hp'] < $gracz['max_hp']) {
					print "Twoja modlitwa zosta�a wys�uchana. Illuminati uzdrowi� ciebie.";
					mysql_query("update players set hp=max_hp where id=$stat[id]");
				} else {
					print "Illuminati wys�ucha� twej modlitwy i ciesz si� z twej pobo�no�ci, Dostajesz 5 Punkt�w Wiary";
					mysql_query("update players set pw=pw+5 where id=$stat[id]");
					}
			}
			if ($rzut1 == 2) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak za spraw� Illuminati, opuszcza ciebie nieco zm�czenia. Odzyskujesz 1 punkt energii.";
				mysql_query("update players set energy=energy+1 where id=$stat[id]");
			}
			if ($rzut1 == 3) {
				if ($gracz['pm'] < $gr10['inteli']) {
					print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak wraca do ciebie magiczna energia. Odzyska�e� wszystkie Punkty Magii";
					mysql_query("update players set pm=$gr10[inteli] where id=$stat[id]");
				} else {
					print "Illuminati wys�ucha� twej modlitwy i ciesz si� z twej pobo�no�ci, Dostajesz 5 Punkt�w Wiary";
					mysql_query("update players set pw=pw+5 where id=$stat[id]");
					}
			}
			if ($rzut1 == 4) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� nagle, �e twoja energia �yciowa wzrasta. Dostajesz 1 Punkt �ycia na sta�e.";
				mysql_query("update players set max_hp=max_hp+1 where id=$stat[id]");
			}
			if ($rzut1 == 5) {
				print "Pot�ny grzmot rozleg� si� z oddali. Iluminati rozgniewa� si� twoj� zuchwa�o�ci�. Nagle pot�ny b�ysk otoczy� twoj� posta� i pad�e� nieprzytomny na ziemi�.";
				mysql_query("update players set hp=1 where id=$stat[id]");
			}
			if ($rzut1 == 6) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak za spraw� Illuminati, twoja si�a wzrasta. Dostajesz +1 do si�y.";
				mysql_query("update players set strength=strength+1 where id=$stat[id]");
			}
			if ($rzut1 == 7) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak twa zr�czno�� wzrasta. Dostajesz +1 do zr�czno�ci.";
				mysql_query("update players set agility=agility+1 where id=$stat[id]");
			}
			if ($rzut1 == 8) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak twoja m�dro�� wzrasta. Dostajesz +1 do inteligencji.";
				mysql_query("update players set inteli=inteli+1 where id=$stat[id]");
			}
			if ($rzut1 == 9) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak twoja si�a duchowa wzrasta. Dostajesz +1 do si�y woli.";
				mysql_query("update players set wisdom=wisdom+1 where id=$stat[id]");
			}
			if ($rzut1 == 10) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak twoja szybko�� wzrasta. Dostajesz +1 do szybko�ci.";
				mysql_query("update players set szyb=szyb+1 where id=$stat[id]");
			}
			if ($rzut1 == 11) {
				print "Twoja modlitwa zosta�a wys�uchana. Poczu�e� jak twoja wytrzyma�o�� wzrasta. Dostajesz +1 do wytrzyma�o�ci.";
				mysql_query("update players set wytrz=wytrz+1 where id=$stat[id]");
			}
			if ($rzut1 == 12) {
				print "Twoja modlitwa zosta�a wys�uchana. Obok ciebie pojawi�o si� nagle 10 sztuk mithrilu. Szybko zabierasz �w dar.";
				mysql_query("update players set platinum=platinum+10 where id=$stat[id]");
			}
			if ($rzut1 == 13) {
				print "Twoja modlitwa zosta�a wys�uchana. Obok ciebie pojawi� si� mieszek a w nim 500 sztuk z�ota.";
				mysql_query("update players set credits=credits+500 where id=$stat[id]");
			}
			if ($rzut1 == 14) {
				print "Twoja modlitwa zosta�a wys�uchana. Nagle poczu�e�, �e twoja wiedza na temat �wiata Vallheru powi�ksza si�. Zyskujesz 10 PD.";
				$texp = ($gracz['exp'] + 10);
				$expn = ($gracz['level'] * 200);
				if ($texp >= $expn) {
					if ($gr10['rasa'] == 'Cz�owiek') {
						$pz = 5;
					}
					if ($gr10['rasa'] == 'Elf') {
						$pz = 4;
					}
					if ($gr10['rasa'] == 'Krasnolud') {
						$pz = 6;
					}
					print "<b>$gracz[user]</b> zdobywa poziom! +5 AP oraz +1 Poziom i 0,5 energii.";
					mysql_query("update players set level=level+1 where id=$stat[id]");
					mysql_query("update players set ap=ap+5 where id=$stat[id]");
					mysql_query("update players set exp=0 where id=$stat[id]");
					mysql_query("update players set max_hp=max_hp+$pz where id=$stat[id]");
					mysql_query("update players set max_energy=max_energy+0.5 where id=$stat[id]");
				} else {
					mysql_query("update players set exp=exp+10 where id=$stat[id]");
				}
			}
		} else {
			print "Modli�e� si� przez pewien czas, ale Illuminati zosta� g�uchy na twe pro�by.";
			}
		mysql_query("update players set pw=pw-1 where id=$stat[id]");
	}
}
require_once("footer.php"); ?>
