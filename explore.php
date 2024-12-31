<?php
/***************************************************************************
 *                               explore.php
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

 $title = "Poszukiwania";
require_once("header.php");
if ($stat['miejsce'] == 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['akcja'])) {
     $_GET['akcja'] = '';
}
$kop = mysql_fetch_array(mysql_query("select meteo from kopalnie where gracz=$stat[id]"));
$herb = mysql_fetch_array(mysql_query("select gracz from herbs where gracz=$stat[id]"));
if ($gracz['hp'] > 0 && !$_GET['akcja']) {
	print "Dooko�a siebie widzisz wysokie szczyty G�r Kazad-nar. Czy chcesz zobaczy� co znajduje si� w�r�d nich? Ka�de zwiedzanie kosztuje 0,5 energii.<br>";
	print "<a href=explore.php?akcja=gory>Tak</a><br>";
	print "<a href=gory.php>Nie</a><br>";
}
if ($_GET['akcja'] == 'gory') {
	if ($gracz['energy'] < 0.5) {
		print "Jeste� zbyt zm�czony aby podr�owa� po g�rach";
		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "Nie mo�esz zwiedza� g�r poniewa� jeste� martwy";
		require_once("footer.php");
		exit;
	}
	$rzut = rand(1,16);
	mysql_query("update players set energy=energy-0.5 where id=$stat[id]");
	if ($rzut < 6) {
		print "Podr�owa�e� jaki� czas w�r�d szczyt�w, ale nie znalaz�e� nic ciekawego";
	}
	if ($rzut == 9) {
		$ilosc = rand(1,1000);
		print "Podczas podr�y zauwa�y�e� �lady dawnego obozowiska w tym miejscu. Zaintrygowany postanowi�e� nieco rozejrze� si� po okolicy. Bacznie obserwuj�c ziemi�, spostrzeg�e� lekko poruszon� ziemi�. Odgarniaj�c j� na boki, ods�oni�e� zniszczony mocno worek, kt�ry rozlecia� si� w momemcie kiedy podnosi�e� go do g�ry. Lecz nie zwr�ci�e� na to uwagi, poniewa� z jego wn�trza wysypa�o si� $ilosc sztuk z�ota!";
		mysql_query("update players set credits=credits+$ilosc where id=$stat[id]");
	}
	if ($rzut == 10) {
		$ilosc = rand (1,10);
		print "W�druj�c w pewnym momencie spostrzegasz, i� niedaleko �cie�ki wida� du��, mocno osmalon� dziur�. Podchodz�c bli�ej zauwa�asz, �e na jej dnie znajduje si� kilka dziwnych, niewielkich bry�. Zbli�aj�c si� do owego znaleziska, rozpoznajesz owe bry�y. To meteoryt! Zdobywasz $ilosc kawa�k�w meteoru.";
		if (empty($kop)) {
			mysql_query("insert into kopalnie (gracz, meteo) values($stat[id],$ilosc)");
		} else {
			mysql_query("update kopalnie set meteo=meteo+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut >= 11 && $rzut <= 13) {
		$ilosc = rand(1,10);
		print "W�druj�c przez jaki� czas po g�rach natykasz si� na ma�y zagajnik w�r�d ska�. Rozgl�daj�c si� po nim, zauwa�asz kilka niewielkich ��to - niebieskich kwiat�w rosn�cych niedaleko. To Illani! Delikatnie, aby nie uszkodzi� ro�lin wyci�gasz si� z ziemi. Zdobywasz $ilosc Illani.";
		if (empty($herb)) {
			mysql_query("insert into herbs (gracz, illani) values($stat[id],$ilosc)");
		} else {
			mysql_query("update herbs set illani=illani+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut >= 14 && $rzut <= 15) {
		$ilosc = rand(1,10);
		print "Podr�uj�c dostrzegasz z oddali niewielkie g�rskie jeziorko. Woda w nim jest krystalicznie czysta. Gasisz pragnienie wod� i zaczynasz rozgl�da� si� po brzegach jeziorka w poszukiwaniu interesuj�cych ciebie rzeczy. Tu� nad zbiornikiem dostrzegasz k�p� jasno-zielonego mchu. To Illanias! Starannie wydobywasz go z ziemi. Zdobywasz $ilosc Illanias.";
		if (empty($herb)) {
			mysql_query("insert into herbs (gracz, illanias) values($stat[id],$ilosc)");
		} else {
			mysql_query("update herbs set illanias=illanias+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut == 16) {
		$ilosc = rand(1,10);
		print "W pewnym momencie �cie�ka gwa�townie opada. Pod��aj�c dalej tym szlakiem zauwa�asz �e prowadzi do ma�ej kotlinki w�r�d szczyt�w. W kotlinie tej, na samym jej �rodku znajduje si� niewielki, staro�ytny kr�g zbudawany z du�ych kamieni. G�azy s� stare i nieco pop�kane, napisy jakie niegdy� na nich si� chyba znajdowa�y, dawno ju� zatar� wiatr i deszcz. Dos�ownie czujesz niesamowit� cisz� otaczaj�c� zewsz�d. Chodz�c w skupieniu po kotlince, widzisz nieco na uboczu owego kr�gu przewr�cony g�az. Jest on poro�ni�ty podobn� do bluszczu ro�lin� o niebiesko-zielonych listkach. To Nutari! Delikatnie zrywasz kilka listk�w i odchodzisz z tego miejsca. Zdobywasz $ilosc Nutari";
		if (empty($herb)) {
			mysql_query("insert into herbs (gracz, nutari) values($stat[id],$ilosc)");
		} else {
			mysql_query("update herbs set nutari=nutari+$ilosc where gracz=$stat[id]");
		}
	}
	if ($rzut >5 && $rzut < 9) {
		require_once("funkcje.php");
		$rzut2 = rand(1,8);
		if ($rzut2 == 1) {
			$mid = 2;
		}
		if ($rzut2 == 2) {
			$mid = 3;
		}
		if ($rzut2 == 3) {
			$mid = 6;
		}
		if ($rzut2 == 4) {
			$mid = 7;
		}
		if ($rzut2 == 5) {
			$mid = 16;
		}
		if ($rzut2 == 6) {
			$mid = 17;
		}
		if ($rzut2 == 7) {
			$mid = 22;
		}
		if ($rzut2 == 8) {
			$mid = 23;
		}
		$enemy = mysql_fetch_array(mysql_query("select * from monsters where id=$mid"));
		$gr4 = mysql_fetch_array(mysql_query("select agility, strength, inteli, unik, atak, magia, klasa, szyb, wytrz, rasa, wisdom from players where id=$stat[id]"));
		$myweapon = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='W' and owner=$stat[id]"));
		$myarmor = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='A' and owner=$stat[id]"));
		$myhelm = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='H' and owner=$stat[id]"));
		$mylegs = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='N' and owner=$stat[id]"));
		$mczar = mysql_fetch_array(mysql_query("select * from czary where status='E' and gracz=$stat[id] and typ='B'"));
		$mczaro = mysql_fetch_array(mysql_query("select * from czary where status='E' and gracz=$stat[id] and typ='O'"));
		if ($gracz['hp'] <= 0) {
			print "Nie masz wystarczaj�co du�o �ycia aby walczy�.";
			require_once("footer.php");
			exit();
		}
		$premia = 0;
		if ($myhelm) {
			$premia = ($premia + $myhelm['power']);
		}
		if ($mylegs) {
			$premia = ($premia + $mylegs['power']);
		}
		if ($myweapon) {
			if ($gr4['klasa'] == 'Wojownik') {
				$stat['damage'] = (($gr4['strength'] + $myweapon['power']) + $gracz['level']);
				$enemy['damage'] = ($enemy['strength'] - ($myarmor['power'] + $gracz['level'] + $gr4['wytrz'] + $premia));
			} else {
				$stat['damage'] = ($gr4['strength'] + $myweapon['power']);
				$enemy['damage'] = ($enemy['strength'] - ($myarmor['power'] + $gr4['wytrz'] + $premia));
			}
			if ($gr4['atak'] < 1) {
				$krytyk = 1;
			}
			if ($gr4['atak'] > 5) {
				$kr = ceil($gr4['atak'] / 100);
				$krytyk = ($krytyk + $kr);
			}
         	}
		if ($mczar) {
			$stat['damage'] = ($mczar['obr'] * $gr4['inteli']) - (($mczar['obr'] * $gr4['inteli']) * ($myarmor['minlev'] / 100));
			if ($myhelm) {
				$stat['damage'] = $damage - ($damage * ($myhelm['minlev'] / 100));
			}
			if ($mylegs) {
				$stat['damage'] = $damage - ($damage * ($mylegs['minlev'] / 100));
			}
			if ($stat['damage'] < 0) {
				$stat['damage'] = 0;
			}
			if ($gr4['magia'] < 1) {
				$krytyk = 1;
			}
			if ($gr4['magia'] > 5) {
				$kr = ceil($gr4['magia'] / 100);
				$krytyk = ($krytyk + $kr);
			}
		}
		if ($mczaro) {
			$myczarobr = ($gr4['wisdom'] * $mczaro['obr']) - (($mczaro['obr'] * $gr4['wisdom']) * ($myarmor['minlev'] / 100));
			if ($myhelm) {
				$myczarobr = ($myczarobr - (($mczaro['obr'] * $gr4['wisdom']) * ($myhelm['minlev'] / 100)));
			}
			if ($mylegs) {
				$myczarobr = ($myczarobr - (($mczaro['obr'] * $gr4['wisdom']) * ($mylegs['minlev'] / 100)));
			}
			if ($myczarobr < 0) {
				$myczarobr = 0;
			}
			$myobrona = ($myarmor['power'] + $myczarobr + $gr4['wytrz'] + $premia);
			$enemy['damage'] = ($enemy['strength'] - $myobrona);
		}
        	$myagility = checkagility($gr4['agility'],$myarmor['zr'],$mylegs['zr']);
                $myspeed = checkspeed($gr4['szyb'],$myarmor['zr'],$mylegs['zr'],$myweapon['szyb']);
		if ($gr4['klasa'] == 'Wojownik') {
			$myunik = (($myagility - $enemy['agility']) + $gracz['level']);
			$eunik = (($enemy['agility'] - $myagility) - ($gr4['atak'] + $gracz['level']));
		}
		if ($gr4['klasa'] == 'Obywatel') {
			$myunik = ($myagility - $enemy['agility']);
			$eunik = (($enemy['agility'] - $myagility) - $gr4['atak']);
		}
		if ($gr4['klasa'] == 'Mag') {
			$myunik = ($myagility - $enemy['agility']);
			$eunik = (($enemy['agility'] - $myagility) - ($gr4['magia'] + $gracz['level']));
		}
		if ($myunik < 1) {
			$myunik = 1;
		}
		if ($eunik < 1) {
			$eunik = 1;
		}
		$gunik = 0;
		$gatak = 0;
		$gmagia = 0;
		$gwtbr = 0;
		$gwt = array(0,0,0);
                checkarmor($myarmor['id'],$myhelm['id'],$mylegs['id']);
		$zmeczenie = 0;
		$runda = 1;
		$rzut1 = (rand(1,$enemy['level']) * 10);
		$enemy['damage'] = ($enemy['damage'] + $rzut1);
		$rzut2 = (rand(1,$gracz['level']) * 10);
		$stat['damage'] = ($stat['damage'] + $rzut2);
		if ($enemy['damage'] < 1) { $enemy['damage'] = 0; }
		if ($stat['damage'] < 1) { $stat['damage'] =0 ; }
		$stat['attackstr'] = ceil($myspeed / $enemy['agility']);
		$enemy['attackstr'] = ceil($enemy['agility'] / $myspeed);
		print "<ul>";
		print "<li><b>$gracz[user]</b> przeciwko <b>$enemy[name]</b>";
		print "<li><b>Walka:</b><br>";

		while ($gracz['hp'] > 0 && $enemy['hp'] > 0 && $runda < 25) {
			if ($zmeczenie > $gr4['wytrz']) {
				$enemy['damage'] = $enemy['strength'];
			}
			if ($gracz['pm'] < $mczar['poziom']) {
				$stat['damage'] = 0;
			}
			if ($gracz['pm'] < $mczaro['poziom']) {
				$enemy['damage'] = $enemy['strength'];
			}
			for ($i = 1;$i <= $stat['attackstr']; ++$i) {
				if ($enemy['hp'] > 0 && $gracz['hp'] > 0) {
					$szansa = rand(1,100);
					if ($eunik >= $szansa && $szansa < 95) {
						print "<b>$enemy[name]</b> unikn�� twojego ciosu!<br>";
					} elseif ($zmeczenie <= $gr4['wytrz']) {
						if ($myweapon) {
							$enemy['hp'] = ($enemy['hp'] - $stat['damage']);
							print "Atakujesz <b>$enemy[name](i)</b> i zadajesz <b>$stat[damage]</b> obra�e�! ($enemy[hp] zosta�o)</font><br>";
							$gwtbr = ($gwtbr + 1);
							$zmecz = ($zmecz + $myweapon['minlev']);
							if ($stat['damage'] > 0) {
								$gatak = ($gatak + 1);
							}
						}
						if ($mczar && $gracz['pm'] > $mczar['poziom']) {
							$pech = floor($gr2['magia'] - $mczar['poziom']);
							if ($pech > 0) {
								$pech = 0;
							}
							$pech = ($pech + rand(1,100));
							if ($pech > 5) {
								$enemy['hp'] = ($enemy['hp'] - $stat['damage']);
								print "Atakujesz <b>$enemy[name](i)</b> i zadajesz <b>$stat[damage]</b> obra�e�! ($enemy[hp] zosta�o)</font><br>";
								if ($stat['damage'] > 0) {
									$gmagia = ($gmagia + 1);
								}
							} else {
								$pechowy = rand(1,100);
								if ($pechowy <= 70) {
									print "<b>$gracz[user]</b> pr�bowa� rzuci� czar, ale niestety nie uda�o mu si� opanowa� mocy. Traci przez to <b>$mczar[poziom]</b> punkt�w magii.<br>";
									$gracz['pm'] = ($gracz['pm'] - $mczar['poziom']);
								}
								if ($pechowy > 70 and $pechowy <= 90) {
									print "<b>$gracz[user] pr�bowa� rzuci� czar, ale straci� panowanie nad swoj� koncentracj�. Traci przez to wszystkie punkty magii.<br>";
									$gracz['pm'] = 0;
								}
								if ($pechowy > 90) {
									print "<b>$gracz[user] straci� ca�kowicie panowanie nad czarem! Czar wybuch� mu prosto w twarz! Traci przez to $mypower punkt�w �ycia!<br>";
									$gracz['hp'] = ($gracz['hp'] - $stat['damage']);
								}
								break;
							}
						}
					}
				}
			}
			for ($i = 1;$i <= $enemy['attackstr']; ++$i) {
				if ($gracz['hp'] > 0 && $enemy['hp'] > 0) {
					$szansa = rand(1,100);
					if ($myunik >= $szansa && $zmeczenie <= $gr4['wytrz'] && $szansa < 95) {
						print "Unikn��e� ciosu <b>$enemy[name](�w)</b>!<br>";
						$gunik = ($gunik + 1);
						$zmeczenie = ($zmeczenie + $myarmor['minlev']);
					} else {
					$gracz['hp'] = ($gracz['hp'] - $enemy['damage']);
					print "<b>$enemy[name](i)</b> atakuje(�) ciebie i zadaje(�) <b>$enemy[damage]</b> obra�e�! ($gracz[hp] zosta�o)<br>";
					if ($myarmor || $myhelm || $mylegs) {
						$efekt = rand(0,$liczba);
						if ($armor[$efekt] == 'torso') {
							$gwt[0] = ($gwt[0] + 1);
						}
						if ($armor[$efekt] == 'head') {
							$gwt[1] = ($gwt[1] + 1);
						}
						if ($armor[$efekt] == 'legs') {
							$gwt[2] = ($gwt[2] + 1);
						}
					}
					if ($mczaro) {
						$gracz['pm'] = ($gracz['pm'] - $mczaro['poziom']);
					}
				}
				}
			}
			$runda = ($runda + 1);
		}
		if ($gracz['hp'] <= 0) {
			loststat($stat['id'],$gr4['strength'],$gr4['agility'],$gr4['inteli'],$gr4['wytrz'],$gr4['szyb'],$gr4['wisdom'],0,$enemy['name']);
			if ($myweapon) {
				lostitem($gwtbr,$myweapon['wt'],'Twoja bro�',$stat['id'],$myweapon['id'],$stat['id'],'ulega');
			}
			if ($myarmor) {
				lostitem($gwt[0],$myarmor['wt'],'Twoja zbroja',$stat['id'],$myarmor['id'],$stat['id'],'ulega');
			}
			if ($myhelm) {
				lostitem($gwt[1],$myhelm['wt'],'Tw�j he�m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
			}
			if ($mylegs) {
				lostitem($gwt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj�');
			}
			gainability($stat['id'],$gracz['user'],$gunik,$gatak,$gmagia,$gracz['pm'],$stat['id']);
		} else {
			if ($runda > 24) {
				print "<br><li><b>Wynik:</b> Walka nie rozstrzygni�ta!</b>.";
				if ($myweapon) {
					lostitem($gwtbr,$myweapon['wt'],'Twoja bro�',$stat['id'],$myweapon['id'],$stat['id'],'ulega');
				}
				if ($myarmor) {
					lostitem($gwt[0],$myarmor['wt'],'Twoja zbroja',$stat['id'],$myarmor['id'],$stat['id'],'ulega');
				}
				if ($myhelm) {
					lostitem($gwt[1],$myhelm['wt'],'Tw�j he�m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
				}
				if ($mylegs) {
					lostitem($gwt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj�');
				}
				print "<li>Zdobywasz: ";
				gainability($stat['id'],$gracz['user'],$gunik,$gatak,$gmagia,$gracz['pm'],$stat[id]);
			}
			if ($gracz[hp] > 0 && $runda < 25) {
				print "<br><li><b>Wynik:</b> Pokona�e� <b>$_POST[razy] $enemy[name](i)</b>.";
				if ($myweapon) {
					lostitem($gwtbr,$myweapon['wt'],'Twoja bro�',$stat['id'],$myweapon['id'],$stat['id'],'ulega');
				}
				if ($myarmor) {
					lostitem($gwt[0],$myarmor['wt'],'Twoja zbroja',$stat['id'],$myarmor['id'],$stat['id'],'ulega');
				}
				if ($myhelm) {
					lostitem($gwt[1],$myhelm['wt'],'Tw�j he�m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
				}
				if ($mylegs) {
					lostitem($gwt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj�');
				}
				$expgain = rand($enemy['exp1'],$enemy['exp2']);
				$goldgain = rand($enemy['credits1'],$enemy['credits2']);
				mysql_query("update players set exp=exp+$expgain where id=$stat[id]");
				mysql_query("update players set credits=credits+$goldgain where id=$stat[id]");
				mysql_query("update players set hp=$gracz[hp] where id=$stat[id]");
				print "<li><b>Nagroda</b><br> Zdoby�e� <b>$expgain</b> PD oraz <b>$goldgain</b> sztuk z�ota oraz ";
				gainability($stat['id'],$gracz['user'],$gunik,$gatak,$gmagia,$gracz['pm'],$stat['id']);
				checkexp($gracz['exp'],$expgain,$gracz['level'],$gr2['rasa'],$gracz['user'],$stat['id'],0,0,$stat['id']);
			}
		}
	if ($gracz['hp'] < 0) {
		$gracz['hp'] = 0;
	}
	mysql_query("update players set hp=$gracz[hp] where id=$stat[id]");
	}
	if ($gracz['hp'] > 0) {
		print "<br>Czy chcesz zwiedza� dalej?<br>";
		print "<a href=explore.php?akcja=gory>Tak</a><br>";
		print "<a href=gory.php>Nie</a><br>";
	}
}

require_once("footer.php"); ?>
