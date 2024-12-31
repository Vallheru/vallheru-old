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

$title = "¦wi±tynia";
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
	print "Witaj w ¶wi±tyni. Mo¿esz tutaj modliæ siê do Illuminati - najwy¿szego boga Vallheru. Aby twoja modlitwa zosta³a wys³uchana, musisz posiadaæ odpowiedni± ilo¶æ Punktów Wiary. Punkty zdobywasz s³u¿±c w ¶wi±tyni. To czym ciebie obdaruje bóg zale¿y tylko od niego.<br><br>
	<ul>
	<li><a href=temple.php?temp=sluzba>Pracuj dla ¶wi±tyni</a></li>
	<li><a href=temple.php?temp=modlitwa>Módl siê do boga</a></li></ul>";
}
if ($_GET['temp'] == 'sluzba') {
	print "Pracuj±c dla ¶wi±tyni, sprawiasz, ¿e Illuminati spogl±da na ciebie przychylniejszym okiem. Za ka¿de 0,2 energii zdobywasz 1 Punkt Wiary. Czy chcesz s³u¿yæ w ¶wi±tyni?<br><br>";
print "<form method=post action=temple.php?temp=sluzba&dalej=tak>
Chcê pracowaæ dla ¶wi±tyni <input type=text size=3 value=0 name=rep> razy. <input type=submit value=Pracuj>
</form>";
	if (isset($_GET['dalej'])) {
		if ($_POST['rep'] <= 0) {
			print "Wpisz ilê czasu (energii) chcesz pracowaæ w ¶wi±tyni!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['rep'])) {
			print "Zapomnij o tym";
			incude("footer.php");
			exit;
		}
		if ($gracz['hp'] == 0) {
			print "Nie mo¿esz pracowaæ dla ¶wi±tyni poniewa¿ jeste¶ martwy!";
			require_once("footer.php");
			exit;
		}
		$razy = ($_POST['rep'] * 0.2);
		if ($gracz['energy'] < $razy) {
			print "Nie masz tyle energii!";
			require_once("footer.php");
			exit;
		}
		print "Pracowa³e¶ przez pewien czas dla ¶wi±tyni i zdobywasz $_POST[rep] Punkt(ów) Wiary.";
		mysql_query("update players set energy=energy-$razy where id=$stat[id]");
		mysql_query("update players set pw=pw+$_POST[rep] where id=$stat[id]");
	}
}
if ($_GET['temp'] == 'modlitwa') {
	if ($gracz['hp'] == 0) {
		print "Nie mo¿esz modliæ siê, poniewa¿ jeste¶ martwy!";
		require_once("footer.php");
		exit;
	}
	print "Postanowi³e¶ pomodliæ siê do Illuminati o dar z nieba. Czy jeste¶ pewien?<br><br>
		<ul>
		<li><a href=temple.php?temp=modlitwa&modl=tak>Tak</a></li>
		<li><a href=temple.php>Nie</a></li></ul>";
	if (isset($_GET['modl'])) {
		if ($gr10['pw'] < 1) {
			print "Nie masz Punktów Wiary aby siê modliæ!";
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
					print "Twoja modlitwa zosta³a wys³uchana. Illuminati uzdrowi³ ciebie.";
					mysql_query("update players set hp=max_hp where id=$stat[id]");
				} else {
					print "Illuminati wys³ucha³ twej modlitwy i ciesz siê z twej pobo¿no¶ci, Dostajesz 5 Punktów Wiary";
					mysql_query("update players set pw=pw+5 where id=$stat[id]");
					}
			}
			if ($rzut1 == 2) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak za spraw± Illuminati, opuszcza ciebie nieco zmêczenia. Odzyskujesz 1 punkt energii.";
				mysql_query("update players set energy=energy+1 where id=$stat[id]");
			}
			if ($rzut1 == 3) {
				if ($gracz['pm'] < $gr10['inteli']) {
					print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak wraca do ciebie magiczna energia. Odzyska³e¶ wszystkie Punkty Magii";
					mysql_query("update players set pm=$gr10[inteli] where id=$stat[id]");
				} else {
					print "Illuminati wys³ucha³ twej modlitwy i ciesz siê z twej pobo¿no¶ci, Dostajesz 5 Punktów Wiary";
					mysql_query("update players set pw=pw+5 where id=$stat[id]");
					}
			}
			if ($rzut1 == 4) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ nagle, ¿e twoja energia ¿yciowa wzrasta. Dostajesz 1 Punkt ¯ycia na sta³e.";
				mysql_query("update players set max_hp=max_hp+1 where id=$stat[id]");
			}
			if ($rzut1 == 5) {
				print "Potê¿ny grzmot rozleg³ siê z oddali. Iluminati rozgniewa³ siê twoj± zuchwa³o¶ci±. Nagle potê¿ny b³ysk otoczy³ twoj± postaæ i pad³e¶ nieprzytomny na ziemiê.";
				mysql_query("update players set hp=1 where id=$stat[id]");
			}
			if ($rzut1 == 6) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak za spraw± Illuminati, twoja si³a wzrasta. Dostajesz +1 do si³y.";
				mysql_query("update players set strength=strength+1 where id=$stat[id]");
			}
			if ($rzut1 == 7) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak twa zrêczno¶æ wzrasta. Dostajesz +1 do zrêczno¶ci.";
				mysql_query("update players set agility=agility+1 where id=$stat[id]");
			}
			if ($rzut1 == 8) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak twoja m±dro¶æ wzrasta. Dostajesz +1 do inteligencji.";
				mysql_query("update players set inteli=inteli+1 where id=$stat[id]");
			}
			if ($rzut1 == 9) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak twoja si³a duchowa wzrasta. Dostajesz +1 do si³y woli.";
				mysql_query("update players set wisdom=wisdom+1 where id=$stat[id]");
			}
			if ($rzut1 == 10) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak twoja szybko¶æ wzrasta. Dostajesz +1 do szybko¶ci.";
				mysql_query("update players set szyb=szyb+1 where id=$stat[id]");
			}
			if ($rzut1 == 11) {
				print "Twoja modlitwa zosta³a wys³uchana. Poczu³e¶ jak twoja wytrzyma³o¶æ wzrasta. Dostajesz +1 do wytrzyma³o¶ci.";
				mysql_query("update players set wytrz=wytrz+1 where id=$stat[id]");
			}
			if ($rzut1 == 12) {
				print "Twoja modlitwa zosta³a wys³uchana. Obok ciebie pojawi³o siê nagle 10 sztuk mithrilu. Szybko zabierasz ów dar.";
				mysql_query("update players set platinum=platinum+10 where id=$stat[id]");
			}
			if ($rzut1 == 13) {
				print "Twoja modlitwa zosta³a wys³uchana. Obok ciebie pojawi³ siê mieszek a w nim 500 sztuk z³ota.";
				mysql_query("update players set credits=credits+500 where id=$stat[id]");
			}
			if ($rzut1 == 14) {
				print "Twoja modlitwa zosta³a wys³uchana. Nagle poczu³e¶, ¿e twoja wiedza na temat ¶wiata Vallheru powiêksza siê. Zyskujesz 10 PD.";
				$texp = ($gracz['exp'] + 10);
				$expn = ($gracz['level'] * 200);
				if ($texp >= $expn) {
					if ($gr10['rasa'] == 'Cz³owiek') {
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
			print "Modli³e¶ siê przez pewien czas, ale Illuminati zosta³ g³uchy na twe pro¶by.";
			}
		mysql_query("update players set pw=pw-1 where id=$stat[id]");
	}
}
require_once("footer.php"); ?>
