<?php 
/***************************************************************************
 *                               battle.php
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

$title = "Arena Walk";
require_once("header.php");
require_once("funkcje.php");
?>

<?
global $stat;
global $gracz;
global $gr2;
global $enemy;
global $myarm;
global $mywep;
global $earm;
global $ewep;
global $myczar;
global $eczar;
global $myatak;
global $eatak;
global $gmyunik;
global $geunik;
global $gmyatak;
global $geatak;
global $gmymagia;
global $gemagia;
global $myczaro;
global $eczaro;
global $gmywtbr;
global $gewtbr;
global $myzmecz;
global $ezmecz;
global $runda;
global $myhelm;
global $mylegs;
global $ehelm;
global $elegs;
global $gmywt;
global $gewt;
global $armor;
global $number;
global $myagility;
global $eagility;
global $myspeed;
global $espeed;
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
?>

<?php
function attack() {
	global $stat;
	global $gracz;
	global $gr2;
	global $enemy;
	global $myarm;
	global $mywep;
	global $earm;
	global $ewep;
	global $myczar;
	global $eczar;
	global $gmyunik;
	global $geunik;
	global $gmyatak;
	global $geatak;
	global $gmymagia;
	global $gemagia;
	global $eczaro;
	global $myczaro;
	global $gmywtbr;
	global $gewtbr;
	global $myzmecz;
	global $ezmecz;
	global $runda;
	global $myhelm;
	global $mylegs;
	global $ehelm;
	global $elegs;
	global $gmywt;
	global $gewt;
	global $armor;
	global $number;
	global $myagility;
	global $eagility;
	global $myspeed;
	global $espeed;

        $krytyk = 0;
	$repeat = ($myspeed / $espeed);
	$attackstr = ceil($repeat);
	$runda = ($runda + 1);
        checkarmor($earm['id'],$ehelm['id'],$elegs['id']);
	if ($attackstr <= 0) {
		$attackstr = 1;
	}
	if ($mywep) {
		$unik = (($eagility - $myagility) + ($enemy['unik'] - $gr2['atak']));
		if ($gr2['klasa'] == 'Wojownik') {
			$mypower = (($mywep['power'] + $gr2['strength']) + $gracz['level']);
			$unik = ($unik - $gracz['level']);
		} else {
			$mypower = ($mywep['power'] + $gr2['strength']);
		}
		if ($gr2['atak'] < 1) {
			$krytyk = 1;
		}
		if ($gr2['atak'] > 5) {
			$kr = ceil($gr2['atak'] / 100);
			$krytyk = ($krytyk + $kr);
		}
	}
	if ($myczar) {
		$unik = (($eagility - $myagility) + ($enemy['unik'] - $gr2['magia']));
		$mypower = ($myczar['obr'] * $gr2['inteli']) - (($myczar['obr'] * $gr2['inteli']) * ($myarm['minlev'] / 100));
		if ($myhelm) {
			$mypower = ($mypower - (($myczar['obr'] * $gr2['inteli']) * ($myhelm['minlev'] / 100)));
			if ($mypower < 0) {
				$mypower = 0;
			}
		}
		if ($mylegs) {
			$mypower = ($mypower - (($myczar['obr'] * $gr2['inteli']) * ($mylegs['minlev'] / 100)));
			if ($mypower < 0) {
				$mypower = 0;
			}
		}
		$pech = floor($gr2['magia'] - $myczar['poziom']);
		if ($pech > 0) {
			$pech = 0;
		}
		$pech = ($pech + rand(1,100));
		if ($gr2['magia'] < 1) {
			$krytyk = 1;
		}
		if ($gr2['magia'] > 5) {
			$kr = ceil($gr2['magia']/100);
			$krytyk = ($krytyk + $kr);
		}
		if ($gracz['pm'] <= 0) {
			$mypower = 0;
		}
	}
	if ($enemy['klasa'] == 'Wojownik') {
		$epower = ($earm['power'] + $enemy['level'] + $enemy['wytrz'] + $ehelm['power'] + $elegs['power']);
		$unik = ($unik + $enemy['level']);
	}
	if ($enemy['klasa'] == 'Obywatel') {
		$epower = ($earm['power'] + $enemy['wytrz'] + $ehelm['power'] + $elegs['power']);
	}
	if ($enemy['klasa'] == 'Mag') {
		if ($enemy['pm'] <= 0) {
			$epower = ($earm['power'] + $enemy['wytrz'] + $ehelm['power'] + $elegs['power']);
		} else {
			$eczarobr = ($enemy['wisdom'] * $eczaro['obr']) - (($eczaro['obr'] * $enemy['wisdom']) * ($earm['minlev'] / 100));
			if ($ehelm) {
				$eczarobr = ($eczarobr - (($eczaro['obr'] * $enemy['wisdom']) * ($ehelm['minlev'] / 100)));
				if ($eczarobr < 0) {
					$eczarobr = 0;
				}
			}
			if ($elegs) {
				$eczarobr = ($eczarobr - (($eczaro['obr'] * $enemy['wisdom']) * ($elegs['minlev'] / 100)));
				if ($eczarobr < 0) {
					$eczarobr = 0;
				}
			}
			$epower = ($earm['power'] + $eczarobr + $enemy['wytrz'] + $ehelm['power'] + $elegs['power']);
		}
	}
	if ($unik < 1) {
		$unik = 1;
	}
	$round = 1;
	while ($round <= $attackstr && $enemy['hp'] >= 0) {
		$rzut1 = (rand(1,$gracz['level']) * 10);
		$mypower = ($mypower + $rzut1);
		$rzut2 = (rand(1,$enemy['level']) * 10);
		$epower = ($epower + $rzut2);
		if ($myzmecz > $gr2['wytrz']) {
			$mypower = 0;
			$unik = 0;
		}
		if ($ezmecz > $enemy['wytrz']) {
			$epower = 0;
			$unik = 0;
		}
		$attackdmg = ($mypower - $epower);
		if ($attackdmg <= 0) {
			$attackdmg = 0;
		}
		$szansa = rand(1,100);
		if ($unik >= $szansa && $szansa < 95 && $ezmecz <= $enemy['wytrzy']) {
			print "<b>$enemy[user]</b> unikn±³ ataku <b>$gracz[user]</b><br>";
			$geunik = ($geunik + 1);
			$ezmecz = ($ezmecz + $earm['minlev']);
		} elseif ($myzmecz <= $gr2['wytrz']) {
			$rzut = rand(1,100);
			if ($krytyk >= $rzut) {
				if ($earm || $ehelm || $elegs) {
					$efekt = rand(0,$number);
					if ($armor[$efekt] == 'torso') {
						$gewt[0] = ($gewt[0] + 1);
					}
					if ($armor[$efekt] == 'head') {
						$gewt[1] = ($gewt[1] + 1);
					}
					if ($armor[$efekt] == 'legs') {
						$gewt[2] = ($gewt[2] + 1);
					}
				}
				if ($eczaro) {
					$enemy['pm'] = ($enemy['pm'] - $eczaro['poziom']);
				}
				if ($mywep) {
					$gmywtbr = ($gmywtbr + 1);
					$gmyatak = ($gmyatak + 1);
					$enemy['hp'] = 0;
					print "<b>$gracz[user]</b> atakuje <b>$enemy[user]</b> jednym potê¿nym ciosem i zabija go! ($enemy[hp] zosta³o)<br>";
				}
				if ($myczar && $gracz['pm'] > $myczar['poziom']) {
					if ($pech > 5) {
						$gmymagia = ($gmymagia + 1);
						$enemy['hp'] = 0;
						print "<b>$gracz[user]</b> atakuje <b>$enemy[user]</b> jednym potê¿nym zaklêciem i zabija go! ($enemy[hp] zosta³o)<br>";
					} else {
						$pechowy = rand(1,100);
						if ($pechowy <= 70) {
							print "<b>$gracz[user]</b> próbowa³ rzuciæ czar, ale niestety nie uda³o mu siê opanowaæ mocy. Traci przez to <b>$myczar[poziom]</b> punktów magii.<br>";
							$gracz['pm'] = ($gracz['pm'] - $myczar['poziom']);
						}
						if ($pechowy > 70 and $pechowy <= 90) {
							print "<b>$gracz[user]</b> próbowa³ rzuciæ czar, ale straci³ panowanie nad swoj± koncentracj±. Traci przez to wszystkie punkty magii.<br>";
							$gracz['pm'] = 0;
						}
						if ($pechowy > 90) {
							print "<b>$gracz[user]</b> straci³ ca³kowicie panowanie nad czarem! Czar wybuch³ mu prosto w twarz! Traci przez to $mypower punktów ¿ycia!<br>";
							$gracz[hp] = ($gracz[hp] - $mypower);
						}
						break;
					}
				}
				break;
			} else {
				if ($earm || $ehelm || $elegs) {
					$efekt = rand(0,$number);
					if ($armor[$efekt] == 'torso') {
						$gewt[0] = ($gewt[0] + 1);
					}
					if ($armor[$efekt] == 'head') {
						$gewt[1] = ($gewt[1] + 1);
					}
					if ($armor[$efekt] == 'legs') {
						$gewt[2] = ($gewt[2] + 1);
					}
				}
				if ($eczaro) {
					$enemy['pm'] = ($enemy['pm'] - $eczaro['poziom']);
				}
				if ($mywep) {
					$gmywtbr = ($gmywtbr + 1);
					$myzmecz = ($myzmecz + $mywep['minlev']);
					$enemy['hp'] = ($enemy['hp'] - $attackdmg);
					print "<b>$gracz[user]</b> atakuje <b>$enemy[user]</b> i zadaje <b>$attackdmg</b> obra¿eñ! ($enemy[hp] zosta³o)<br>";
					if ($attackdmg > 0) {
						$gmyatak = ($gmyatak + 1);
					}
					if ($enemy['hp'] <= 0) {
						break;
					}
				}
				if ($myczar && $gracz['pm'] > $myczar['poziom']) {
					if ($pech > 5) {
						$gracz['pm'] = ($gracz['pm'] - $myczar['poziom']);
						$enemy['hp'] = ($enemy['hp'] - $attackdmg);
						print "<b>$gracz[user]</b> atakuje <b>$enemy[user]</b> i zadaje <b>$attackdmg</b> obra¿eñ! ($enemy[hp] zosta³o)<br>";
						if ($attackdmg > 0) {
							$gmymagia = ($gmymagia + 1);
						}
						if ($enemy['hp'] <= 0) {
							break;
						}
					} else {
						$pechowy = rand(1,100);
						if ($pechowy <= 70) {
							print "<b>$gracz[user]</b> próbowa³ rzuciæ czar, ale niestety nie uda³o mu siê opanowaæ mocy. Traci przez to <b>$myczar[poziom]</b> punktów magii.<br>";
							$gracz['pm'] = ($gracz['pm'] - $myczar['poziom']);
						}
						if ($pechowy > 70 and $pechowy <= 90) {
							print "<b>$gracz[user]</b> próbowa³ rzuciæ czar, ale straci³ panowanie nad swoj± koncentracj±. Traci przez to wszystkie punkty magii.<br>";
							$gracz['pm'] = 0;
						}
						if ($pechowy > 90) {
							print "<b>$gracz[user]</b> straci³ ca³kowicie panowanie nad czarem! Czar wybuch³ mu prosto w twarz! Traci przez to $mypower punktów ¿ycia!<br>";
							$gracz['hp'] = ($gracz[hp] - $mypower);
						}
						break;
					}
				}
			}
			}
		$round = ($round + 1);
	}
	if ((($myzmecz > $gr2['wytrz'] && $ezmecz > $enemy['wytrz']) || ($runda >= 25)) && ($gracz['hp'] > 0 && $enemy['hp'] > 0)) {
		print "<br>Walka nie rozstrzygniêta!<br>";
		gainability($stat['id'],$gracz['user'],$gmyunik,$gmyatak,$gmymagia,$gracz['pm'],$stat['id']);
		gainability($enemy['id'],$enemy['user'],$geunik,$geatak,$gemagia,$enemy['pm'],$stat['id']);
		if ($mywep) {
			lostitem($gmywtbr,$mywep['wt'],'Twoja broñ',$stat['id'],$mywep['id'],$stat['id'],'ulega');
		}
		if ($ewep) {
			lostitem($gewtbr,$ewep['wt'],'Twoja broñ',$enemy['id'],$ewep['id'],$stat['id'],'ulega');
		}
		if ($earm) {
			lostitem($gewt[0],$earm['wt'],'Twoja zbroja',$enemy['id'],$earm['id'],$stat['id'],'ulega');
		}
		if ($ehelm) {
			lostitem($gewt[1],$ehelm['wt'],'Twój he³m',$enemy['id'],$ehelm['id'],$stat['id'],'ulega');
		}
		if ($elegs) {
			lostitem($gewt[2],$elegs['wt'],'Twoje nagolenniki',$enemy['id'],$elegs['id'],$stat['id'],'ulegaj±');
		}
		if ($myarm) {
			lostitem($gmywt[0],$myarm['wt'],'Twoja zbroja',$stat['id'],$myarm['id'],$stat['id'],'ulega');
		}
		if ($myhelm) {
			lostitem($gmywt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
		}
		if ($mylegs) {
			lostitem($gmywt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
		}
		mysql_query("update players set hp=$gracz[hp] where id=$stat[id]");
		mysql_query("update players set hp=$enemy[hp] where id=$enemy[id]");
		$czas = date("y-m-d H:i:s");
		mysql_query("insert into log (owner, log. czas) values($stat[id],'Walka nierozstrzygniêta z  <b>$enemy[user] ID:$enemy[id]</b>.','$czas')");
		mysql_query("insert into log (owner, log, czas) values($enemy[id],'Walka nierozstrzygniêta z <b>$gracz[user] ID:$stat[id]</b>.','$czas')");

		require_once("footer.php");
		exit;
	}
	if ($enemy['hp'] <= 0) {
		$enemy['hp'] = 0;
		print "<br><b>$gracz[user]</b> zwyciê¿a!<br>";
		$expgain = (rand(5,10) * $enemy['level']);
		$creditgain = ($enemy['credits'] / 10);
		print "<b>$gracz[user]</b> otrzymuje <b>$expgain</b> PD i <b>$creditgain</b> sztuk z³ota.<br>";
		gainability($stat['id'],$gracz['user'],$gmyunik,$gmyatak,$gmymagia,$gracz['pm'],$stat['id']);
		gainability($enemy['id'],$enemy['user'],$geunik,$geatak,$gemagia,$enemy['pm'],$stat['id']);
		if ($mywep) {
			lostitem($gmywtbr,$mywep['wt'],'Twoja broñ',$stat['id'],$mywep['id'],$stat['id'],'ulega');
		}
		if ($ewep) {
			lostitem($gewtbr,$ewep['wt'],'Twoja broñ',$enemy['id'],$ewep['id'],$stat['id'],'ulega');
		}
		if ($earm) {
			lostitem($gewt[0],$earm['wt'],'Twoja zbroja',$enemy['id'],$earm['id'],$stat['id'],'ulega');
		}
		if ($ehelm) {
			lostitem($gewt[1],$ehelm['wt'],'Twój he³m',$enemy['id'],$ehelm['id'],$stat['id'],'ulega');
		}
		if ($elegs) {
			lostitem($gewt[2],$elegs['wt'],'Twoje nagolenniki',$enemy['id'],$elegs['id'],$stat['id'],'ulegaj±');
		}
		if ($myarm) {
			lostitem($gmywt[0],$myarm['wt'],'Twoja zbroja',$stat['id'],$myarm['id'],$stat['id'],'ulega');
		}
		if ($myhelm) {
			lostitem($gmywt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
		}
		if ($mylegs) {
			lostitem($gmywt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
		}
		mysql_query("update players set hp=$gracz[hp] where id=$stat[id]");
		mysql_query("update players set hp=0 where id=$enemy[id]");
		mysql_query("update players set exp=exp+$expgain where id=$stat[id]");
		mysql_query("update players set credits=credits+$creditgain where id=$stat[id]");
		mysql_query("update players set credits=credits-$creditgain where id=$enemy[id]");
		mysql_query("update players set wins=wins+1 where id=$stat[id]");
		mysql_query("update players set losses=losses+1 where id=$enemy[id]");
		mysql_query("update players set lastkilled='$enemy[user]' where id=$stat[id]");
		mysql_query("update players set lastkilledby='$gracz[user]' where id=$enemy[id]");
		$czas = date("y-m-d H:i:s");
		loststat($enemy['id'],$enemy['strength'],$enemy['agility'],$enemy['inteli'],$enemy['wytrz'],$enemy['szyb'],$enemy['wisdom'],$stat['id'],$gracz['user']);
		checkexp($gracz['exp'],$expgain,$gracz['level'],$gr2['rasa'],$gracz['user'],$stat['id'],$enemy['id'],$enemy['user'],$stat['id']);
		mysql_query("insert into log (owner, log. czas) values($stat[id],'Pokona³e¶ <b>$enemy[user] ID:$enemy[id]</b>. Zdoby³e¶ <b>$expgain</b> PD oraz <b>$creditgain</b> sztuk z³ota.','$czas')");
		require_once("footer.php");
		exit;
	} else {
		attackback();
	}
}

function attackback() {
	global $stat;
	global $gracz;
	global $gr2;
	global $enemy;
	global $myarm;
	global $mywep;
	global $earm;
	global $ewep;
	global $myczar;
	global $eczar;
	global $gmyunik;
	global $geunik;
	global $gmyatak;
	global $geatak;
	global $gmymagia;
	global $gemagia;
	global $myczaro;
	global $eczaro;
	global $gmywtbr;
	global $gewtbr;
	global $myzmecz;
	global $ezmecz;
	global $runda;
	global $myhelm;
	global $mylegs;
	global $ehelm;
	global $elegs;
	global $gmywt;
	global $gewt;
	global $armor;
	global $number;
	global $myagility;
	global $eagility;
	global $myspeed;
	global $espeed;

        $krytyk = 0;
	$repeat = ($espeed / $myspeed);
	$attackstr = ceil($repeat);
        checkarmor($myarm['id'],$myhelm['id'],$mylegs['id']);
	if ($attackstr <= 0) {
		$attackstr = 1;
	}
	if ($ewep) {
		$unik = (($myagility - $eagility) + ($gr2['unik'] - $enemy['atak']));
		if ($enemy['klasa'] == 'Wojownik') {
			$epower = (($ewep['power'] + $enemy['strength']) + $enemy['level']);
			$unik = ($unik - $enemy['level']);
		} else {
		$epower = ($ewep['power'] + $enemy['strength']);
		}
		if ($enemy['atak'] < 1) {
			$krytyk = 1;
		}
		if ($enemy['atak'] > 5) {
			$kr = ceil($enemy['atak'] / 100);
			$krytyk = ($krytyk + $kr);
		}
	}
	if ($eczar) {
		$unik = (($myagility - $eagility) + ($gr2['unik'] - $enemy['magia']));
		$epower = ($eczar['obr'] * $enemy['inteli']) - (($eczar['obr'] * $enemy['inteli']) * ($earm['minlev'] / 100));
		if ($ehelm) {
			$epower = ($epower - (($eczar['obr'] * $enemy['inteli']) * ($ehelm['minlev'] / 100)));
			if ($epower < 0) {
				$epower = 0;
			}
		}
		if ($elegs) {
			$epower = ($epower - (($eczar['obr'] * $enemy['inteli']) * ($elegs['minlev'] / 100)));
			if ($epower < 0) {
				$epower = 0;
			}
		}
		$pech = floor($enemy['magia'] - $eczar['poziom']);
		if ($pech > 0) {
			$pech = 0;
		}
		$pech = ($pech + rand(1,100));
		if ($enemy['magia'] < 1) {
			$krytyk = 1;
		}
		if ($enemy['magia'] > 5) {
			$kr = ceil($enemy['magia']/100);
			$krytyk = ($krytyk + $kr);
		}
		if ($enemy['pm'] <= 0) {
			$epower = 1;
		}
	}
	if ($gr2['klasa'] == 'Wojownik') {
		$mypower = ($myarm['power'] + $gracz['level'] + $gr2['wytrz'] + $myhelm['power'] + $mylegs['power']);
		$unik = ($unik + $gracz['level']);
	}
	if ($gr2['klasa'] == 'Obywatel') {
		$mypower = ($myarm['power'] +$gr2['wytrz'] + $myhelm['power'] + $mylegs['power']);
	}
	if ($gr2['klasa'] == 'Mag') {
		if ($enemy['pm'] <= 0) {
			$mypower = ($myarm['power'] + $gr2['wytrz'] + $myhelm['power'] + $mylegs['power']);
		} else {
			$myczarobr = ($gr2['wisdom'] * $myczaro['obr']) - (($myczaro['obr'] * $gr2['wisdom']) * ($myarm['minlev'] / 100));
			if ($myhelm) {
				$myczarobr = ($myczarobr - (($myczaro['obr'] * $gr2['wisdom']) * ($myhelm['minlev'] / 100)));
				if ($myczarobr < 0) {
					$myczarobr = 0;
				}
			}
			if ($mylegs) {
				$myczarobr = ($myczarobr - (($myczaro['obr'] * $gr2['wisdom']) * ($mylegs['minlev'] / 100)));
				if ($myczarobr < 0) {
					$myczarobr = 0;
				}
			}
			$mypower = ($myarm['power'] + $myczarobr + $gr2['wytrz'] + $myhelm['power'] + $mylegs['power']);
		}
	}
	if ($unik < 1) {
		$unik = 1;
	}
	$round = 1;
	while ($round <= $attackstr && $gracz['hp'] >= 0) {
		$szansa = rand(1,100);
		$rzut1 = (rand(1,$gracz['level']) * 10);
		$mypower = ($mypower + $rzut1);
		$rzut2 = (rand(1,$enemy['level']) * 10);
		$epower = ($epower + $rzut2);
		if ($myzmecz > $gr2['wytrz']) {
			$mypower = 0;
			$unik = 0;
		}
		if ($ezmecz > $enemy['wytrz']) {
			$epower = 0;
			$unik = 0;
		}
		$attackdmg = ($epower - $mypower);
		if ($attackdmg <= 0) {
			$attackdmg = 0;
		}
		if ($unik >= $szansa && $szansa < 95 && $myzmecz <= $gr2['wytrz']) {
			print "<b>$gracz[user]</b> unikn±³ ataku <b>$enemy[user]</b><br>";
			$gmyunik = ($gmyunik + 1);
			$myzmecz = ($myzmecz + $myarm['minlev']);
		} elseif ($ezmecz <= $enemy['wytrz']) {
			$rzut = rand(1,100);
			if ($krytyk >= $rzut) {
				if ($myarm || $myhelm || $mylegs) {
					$efekt = rand(0,$number);
					if ($armor[$efekt] == 'torso') {
						$gmywt[0] = ($gmywt[0] + 1);
					}
					if ($armor[$efekt] == 'head') {
						$gmywt[1] = ($gmywt[1] + 1);
					}
					if ($armor[$efekt] == 'legs') {
						$gmywt[2] = ($gmywt[2] + 1);
					}
				}
				if ($myczaro) {
					$gracz['pm'] = ($gracz['pm'] - $myczaro['poziom']);
				}
				if ($ewep) {
					$gracz['hp'] = 0;
					print "<b>$enemy[user]</b> atakuje <b>$gracz[user]</b> jednym potê¿nym ciosem i zabija go! ($gracz[hp] zosta³o)<br>";
					$gewtbr = ($gewtbr + 1);
					$geatak = ($geatak + 1);
				}
				if ($eczar && $enemy['pm'] > $eczar['poziom']) {
					if ($pech > 5) {
						$gemagia = ($gemagia + 1);
						$gracz['hp'] = 0;
						print "<b>$enemy[user]</b> atakuje <b>$gracz[user]</b> jednym potê¿nym zaklêciem i zabija go! ($gracz[hp] zosta³o)<br>";
					} else {
						$pechowy = rand(1,100);
						if ($pechowy <= 70) {
							print "<b>$enemy[user]</b> próbowa³ rzuciæ czar, ale niestety nie uda³o mu siê opanowaæ mocy. Traci przez to <b>$eczar[poziom]</b> punktów magii.<br>";
							$enemy['pm'] = ($enemy['pm'] - $eczar['poziom']);
						}
						if ($pechowy > 70 and $pechowy <= 90) {
							print "<b>$enemy[user]</b> próbowa³ rzuciæ czar, ale straci³ panowanie nad swoj± koncentracj±. Traci przez to wszystkie punkty magii.<br>";
							$enemy['pm'] = 0;
						}
						if ($pechowy > 90) {
							print "<b>$enemy[user]</b> straci³ ca³kowicie panowanie nad czarem! Czar wybuch³ mu prosto w twarz! Traci przez to $epower punktów ¿ycia!<br>";
							$enemy['hp'] = ($enemy['hp'] - $epower);
						}
						break;
					}
				}
				break;
			} else {	
				if ($myarm || $myhelm || $mylegs) {
					$efekt = rand(0,$number);
					if ($armor[$efekt] == 'torso') {
						$gmywt[0] = ($gmywt[0] + 1);
					}
					if ($armor[$efekt] == 'head') {
						$gmywt[1] = ($gmywt[1] + 1);
					}
					if ($armor[$efekt] == 'legs') {
						$gmywt[2] = ($gmywt[2] + 1);
					}
				}
				if ($myczaro) {
					$gracz['pm'] = ($gracz['pm'] - $myczaro['poziom']);
				}
				if ($ewep) {
					$gracz['hp'] = ($gracz['hp'] - $attackdmg);
					print "<b>$enemy[user]</b> atakuje <b>$gracz[user]</b> i zadaje <b>$attackdmg</b> obra¿eñ! ($gracz[hp] zosta³o)<br>";
					$gewtbr = ($gewtbr + 1);
					$ezmecz = ($ezmecz + $ewep['minlev']);
					if ($attackdmg > 0) {
						$geatak = ($geatak + 1);
					}
					if ($gracz['hp'] <= 0) {
						break;
					}
				}
				if ($eczar && $enemy['pm'] > $eczar['poziom']) {
					if ($pech > 5) {
						$enemy['pm'] = ($enemy['pm'] - $eczar['poziom']);
						$gracz['hp'] = ($gracz['hp'] - $attackdmg);
						print "<b>$enemy[user]</b> atakuje <b>$gracz[user]</b> i zadaje <b>$attackdmg</b> obra¿eñ! ($gracz[hp] zosta³o)<br>";
						if ($attackdmg > 0) {
							$gemagia = ($gemagia + 1);
						}
						if ($gracz['hp'] <= 0) {
							break;
						}
					} else {
						$pechowy = rand(1,100);
						if ($pechowy <= 70) {
							print "<b>$enemy[user]</b> próbowa³ rzuciæ czar, ale niestety nie uda³o mu siê opanowaæ mocy. Traci przez to <b>$eczar[poziom]</b> punktów magii.<br>";
							$enemy['pm'] = ($enemy['pm'] - $eczar['poziom']);
						}
						if ($pechowy > 70 and $pechowy <= 90) {
							print "<b>$enemy[user]</b> próbowa³ rzuciæ czar, ale straci³ panowanie nad swoj± koncentracj±. Traci przez to wszystkie punkty magii.<br>";
							$enemy['pm'] = 0;
						}
						if ($pechowy > 90) {
							print "<b>$enemy[user]</b> straci³ ca³kowicie panowanie nad czarem! Czar wybuch³ mu prosto w twarz! Traci przez to $epower punktów ¿ycia!<br>";
							$enemy['hp'] = ($enemy['hp'] - $epower);
						}
						break;
					}
				}
			}
			}
		$round = ($round + 1);
	}
	if ((($myzmecz > $gr2['wytrz'] && $ezmecz > $enemy['wytrz']) || ($runda >= 25)) && ($gracz['hp'] > 0 && $enemy['hp'] > 0)) {
		print "<br>Walka nie rozstrzygniêta!<br>";
		gainability($stat['id'],$gracz['user'],$gmyunik,$gmyatak,$gmymagia,$gracz['pm'],$stat['id']);
		gainability($enemy['id'],$enemy['user'],$geunik,$geatak,$gemagia,$enemy['pm'],$stat['id']);
		if ($mywep) {
			lostitem($gmywtbr,$mywep['wt'],'Twoja broñ',$stat['id'],$mywep['id'],$stat['id'],'ulega');
		}
		if ($ewep) {
			lostitem($gewtbr,$ewep['wt'],'Twoja broñ',$enemy['id'],$ewep['id'],$stat['id'],'ulega');
		}
		if ($earm) {
			lostitem($gewt[0],$earm['wt'],'Twoja zbroja',$enemy['id'],$earm['id'],$stat['id'],'ulega');
		}
		if ($ehelm) {
			lostitem($gewt[1],$ehelm['wt'],'Twój he³m',$enemy['id'],$ehelm['id'],$stat['id'],'ulega');
		}
		if ($elegs) {
			lostitem($gewt[2],$elegs['wt'],'Twoje nagolenniki',$enemy['id'],$elegs['id'],$stat['id'],'ulegaj±');
		}
		if ($myarm) {
			lostitem($gmywt[0],$myarm['wt'],'Twoja zbroja',$stat['id'],$myarm['id'],$stat['id'],'ulega');
		}
		if ($myhelm) {
			lostitem($gmywt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
		}
		if ($mylegs) {
			lostitem($gmywt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
		}
		mysql_query("update players set hp=$gracz[hp] where id=$stat[id]");
		mysql_query("update players set hp=$enemy[hp] where id=$enemy[id]");
		$czas = date("y-m-d H:i:s");
		mysql_query("insert into log (owner, log. czas) values($stat[id],'Walka nierozstrzygniêta z  <b>$enemy[user] ID:$enemy[id]</b>.','$czas')");
		mysql_query("insert into log (owner, log, czas) values($enemy[id],'Walka nierozstrzygniêta z <b>$gracz[user] ID:$stat[id]</b>.','$czas')");

		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "<br><b>$enemy[user]</b> zwyciê¿a!<br>";
		$expgain = (rand(5,10) * $gracz['level']);
		$creditgain = ($gracz['credits'] / 10);
		print "<b>$enemy[user]</b> zdobywa <b>$expgain</b> PD oraz <b>$creditgain</b> sztuk z³ota.<br>";
		gainability($stat['id'],$gracz['user'],$gmyunik,$gmyatak,$gmymagia,$gracz['pm'],$stat['id']);
		gainability($enemy['id'],$enemy['user'],$geunik,$geatak,$gemagia,$enemy['pm'],$stat['id']);
		if ($mywep) {
			lostitem($gmywtbr,$mywep['wt'],'Twoja broñ',$stat['id'],$mywep['id'],$stat['id'],'ulega');
		}
		if ($ewep) {
			lostitem($gewtbr,$ewep['wt'],'Twoja broñ',$enemy['id'],$ewep['id'],$stat['id'],'ulega');
		}
		if ($earm) {
			lostitem($gewt[0],$earm['wt'],'Twoja zbroja',$enemy['id'],$earm['id'],$stat['id'],'ulega');
		}
		if ($ehelm) {
			lostitem($gewt[1],$ehelm['wt'],'Twój he³m',$enemy['id'],$ehelm['id'],$stat['id'],'ulega');
		}
		if ($elegs) {
			lostitem($gewt[2],$elegs['wt'],'Twoje nagolenniki',$enemy['id'],$elegs['id'],$stat['id'],'ulegaj±');
		}
		if ($myarm) {
			lostitem($gmywt[0],$myarm['wt'],'Twoja zbroja',$stat['id'],$myarm['id'],$stat['id'],'ulega');
		}
		if ($myhelm) {
			lostitem($gmywt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
		}
		if ($mylegs) {
			lostitem($gmywt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
		}
		mysql_query("update players set hp=$enemy[hp] where id=$enemy[id]");
		mysql_query("update players set hp=0 where id=$stat[id]");
		mysql_query("update players set exp=exp+$expgain where id=$enemy[id]");
		mysql_query("update players set credits=credits+$creditgain where id=$enemy[id]");
		mysql_query("update players set credits=credits-$creditgain where id=$stat[id]");
		mysql_query("update players set wins=wins+1 where id=$enemy[id]");
		mysql_query("update players set losses=losses+1 where id=$stat[id]");
		mysql_query("update players set lastkilled='$gracz[user]' where id=$enemy[id]");
		mysql_query("update players set lastkilledby='$enemy[user]' where id=$stat[id]");
		$czas = date("y-m-d H:i:s");
		loststat($stat['id'],$gr2['strength'],$gr2['agility'],$gr2['inteli'],$gr2['wytrz'],$gr2['szyb'],$gr2['wisdom'],$enemy['id'],$enemy['user']);
		checkexp($enemy['exp'],$expgain,$enemy['level'],$enemy['rasa'],$enemy['user'],$enemy['id'],$stat['id'],$gracz['user'],$stat['id']);
		mysql_query("insert into log (owner, log, czas) values($enemy[id],'Pokona³e¶ <b>$gracz[user] ID:$stat[id]</b>. Zdoby³e¶ <b>$expgain</b> PD oraz <b>$creditgain</b> sztuk z³ota.','$czas')");
		require_once("footer.php");
		exit;
	} else {
		attack();
	}
}
?>

<?php
if (!$_GET['action'] && !isset($_GET['battle'])) {
	print "Idziesz sobie alejk± pod górê i naglê widzisz t³umy magów, wojowników a nawet obywateli pod±¿aj±cych do pewnego budynku. Gdy zbli¿y³e¶ siê do niego bli¿ej zauwa¿y³e¶, ¿e jest od wykonany z mocnego kamienia w kolorze jasno szarym w niektórych miejscach poz³acanym. Na górze owego budynku znajduj± siê trzy wie¿e ka¿da z nich jest pokryta innym materia³em pierwsza br±zem, druga srebrem, i koñcu trzecia z³otem. Przy wej¶ciu do budynku jest wyryty w skale napis Arena Walk. Wchodzisz do ¶rodka gdzie widzisz t³umy wojowników ¶ciany s± tu z twardego kamienia w czê¶ciach poz³acane. Ciekawy wbiegasz do najwiêkszej z sal gdzie wszystko jest pokryte kamieniem i znajduj± siê trzy drzwi ju¿ zaciekawiony chcia³e¶ owe drzwi otworzyæ, ale w tym momencie z³apa³ ciê za d³oñ silny wojownik i powiedzia³ <i>Witaj, czego tutaj szukasz?</i> Ty odpowiadasz:

.<br><br>
	- <a href=battle.php?action=levellist>Poka¿ mi listê wszystkich osób na danym poziomie.</a><br>
	- <a href=battle.php?action=showalive>Chcê walczyæ z osobami na tym samym poziomie, co ja...</a><br>
	- <a href=battle.php?action=monster>Chcê trenowaæ z potworami.</a><br>";
}

if ($_GET['action'] == 'showalive') {
	print "Poka¿ wszystkich ¿ywych na poziomie $gracz[level]...<br><br>";
	print "<table><tr><td width=20><b><u>ID</td><td width=100><b><u>Imiê</td><td width=100><b><u>Ranga</td><td width=20><b><u>Klan</td><td width=60><b><u>Opcje</td></tr>";
	$esel = mysql_query("select id, user, rank, tribe from players where level=$gracz[level] and hp>0 and miejsce='$stat[miejsce]' and id!=$stat[id] limit 50 ");
	while ($elist = mysql_fetch_array($esel)) {
		print "<tr><td>$elist[id]</td><td><a href=view.php?view=$elist[id]>$elist[user]</a></td><td>$elist[rank]</td><td>$elist[tribe]</td><td>- <A href=battle.php?battle=$elist[id]>Atakuj</a></td></tr>";
	}
	print "</table><br>";
	print "Lub mo¿esz zawsze... <a href=battle.php>zawróciæ</a>.";
}

if ($_GET['action'] == 'levellist') {
	print "<form method=post action=battle.php?action=levellist&step=go>";
	print "Poka¿ wszystkich ¿ywych... <select name=slevel>";
	for ($i = 1; $i < 100; ++$i) {
		print "<option value=$i>Poziom $i</option>";
	}
	print "</select> <input type=submit value=Id¼></form>";

	if ($_GET['step'] == 'go') {
		if (!ereg("^[1-9][0-9]*$", $_POST['slevel'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		print "<table><tr><td width=20><b><u>ID</td><td width=100><b><u>Imiê</td><td width=100><b><u>Ranga</td><td width=20><b><u>Klan</td><td width=60><b><u>Opcje</td></tr>";
		$esel = mysql_query("select id, user, rank, tribe from players where level=$_POST[slevel] and hp>0 and miejsce='$stat[miejsce]' and id!=$stat[id] limit 50");
		while ($elist = mysql_fetch_array($esel)) {
			print "<tr><td>$elist[id]</td><td><a href=view.php?view=$elist[id]>$elist[user]</a></td><td>$elist[rank]</td><td>$elist[tribe]</td><td>- <A href=battle.php?battle=$elist[id]>Atakuj</a></td></tr>";
		}
		print "</table><br>";
		print "Lub mo¿esz zawsze... <a href=battle.php>zawróciæ</a>.";
	}
}

if (isset($_GET['battle'])) {
	global $stat;
	global $gracz;
	global $gr2;
	global $enemy;
	global $myarm;
	global $mywep;
	global $earm;
	global $ewep;
	global $myczar;
	global $eczar;
	global $gmyunik;
	global $geunik;
	global $gmyatak;
	global $geatak;
	global $gmymagia;
	global $gemagia;
	global $myczaro;
	global $eczaro;
	global $gmywtbr;
	global $gewtbr;
	global $gmywt;
	global $gewt;
	global $myzmecz;
	global $ezmecz;
	global $runda;
	global $myhelm;
	global $mylegs;
	global $ehelm;
	global $elegs;
	global $armor;
	global $number;
	global $myagility;
	global $eagility;
	global $myspeed;
	global $espeed;

	$enemy = mysql_fetch_array(mysql_query("select id, user, level, age, klasa, tribe, immu, credits, miejsce, strength, agility, inteli, atak, unik, magia, hp, pm, exp, szyb, wytrz, rasa, wisdom from players where id=$_GET[battle]"));
	$gr2 = mysql_fetch_array(mysql_query("select age, inteli, klasa, immu, strength, agility, inteli, atak, unik, magia, szyb, wytrz, rasa, wisdom from players where id=$stat[id]"));
	$mywep = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='W' and status='E'"));
	$myarm = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='A' and status='E'"));
	$myhelm = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='H' and status='E'"));
	$mylegs = mysql_fetch_array(mysql_query("select * from equipment where owner=$stat[id] and type='N' and status='E'"));
	$ewep = mysql_fetch_array(mysql_query("select * from equipment where owner=$enemy[id] and type='W' and status='E'"));
	$earm = mysql_fetch_array(mysql_query("select * from equipment where owner=$enemy[id] and type='A' and status='E'"));
	$ehelm = mysql_fetch_array(mysql_query("select * from equipment where owner=$enemy[id] and type='H' and status='E'"));
	$elegs = mysql_fetch_array(mysql_query("select * from equipment where owner=$enemy[id] and type='H' and status='E'"));
	$myczar = mysql_fetch_array(mysql_query("select * from czary where gracz=$stat[id] and status='E' and typ='B'"));
	$eczar = mysql_fetch_array(mysql_query("select * from czary where gracz=$enemy[id] and status='E' and typ='B'"));
	$myczaro = mysql_fetch_array(mysql_query("select * from czary where gracz=$stat[id] and status='E' and typ='O'"));
	$eczaro = mysql_fetch_array(mysql_query("select * from czary where gracz=$enemy[id] and status='E' and typ='O'"));
	$geunik = 0;
	$gmyunik = 0;
	$gmyatak = 0;
	$geatak = 0;
	$gmymagia = 0;
	$gemagia = 0;
	$gmywtbr = 0;
	$gmywt = array(0,0,0);
	$gewtbr = 0;
	$gewt = array(0,0,0);
	$myzmecz = 0;
	$ezmecz = 0;
	$runda = 0;
	$myagility = checkagility($gr2['agility'],$myarm['zr'],$mylegs['zr']);
	$eagility = checkagility($enemy['agility'],$earm['zr'],$elegs['zr']);
	$myspeed = checkspeed($gr2['szyb'],$myarm['zr'],$mylegs['zr'],$mywep['szyb']);
	$espeed = checkspeed($enemy['szyb'],$earm['zr'],$elegs['zr'],$ewep['szyb']);
	if (!$enemy['id']) {
		print "Nie ten gracz.";
		require_once("footer.php");
		exit;
	}
	if ($enemy['id'] == $stat['id']) {
		print "Nie mo¿esz zaatakowaæ siebie.";
		require_once("footer.php");
		exit;
	}
	if ($enemy['hp'] <= 0) {
		print "$enemy[user] jest obecnie martwy.";
		require_once("footer.php");
		exit;
	}
	if ($gracz['energy'] < 1) {
		print "Nie masz wystarczaj±co du¿o energii.";
		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "Jeste¶ martwy.";
		require_once("footer.php");
		exit;
	}
	if ($enemy['tribe'] == $gracz['tribe'] && $enemy['tribe'] > 0) {
		print "Nie atakuj cz³onków swojego klanu!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['age'] < 3) {
		print "Nie mo¿esz atakowaæ innych, tak samo jak inni nie mog± atakowaæ ciebie, poniewa¿ jeste¶ m³odym graczem";
		require_once("footer.php");
		exit;
	}
	if ($enemy['age'] < 3) {
		print "Nie mo¿esz atakowaæ m³odych graczy!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['klasa'] == '') {
		print "Nie mo¿esz atakowaæ innych graczy, dopóki nie wybierzesz profesji!";
		require_once("footer.php");
		exit;
	}
	if ($enemy['klasa'] == '') {
		print "Nie mo¿esz atakowaæ gracza, który nie wybra³ jeszcze profesji!";
		require_once("footer.php");
		exit;
	}
	if ($mywep && $myczar) {
		print "Nie mo¿esz jednocze¶nie walczyæ broni± i czarem. Wybierz jeden rodzaj walki!";
		require_once("footer.php");
		exit;
	}
	if (!$mywep && !$myczar) {
		print "Wybierz jaki¶ rodzaj walki(magia lub broñ)!";
		require_once ("footer.php");
		exit;
	}
	if ($gr2['klasa'] == 'Wojownik' && $myczar) {
		print "Tylko mag mo¿e walczyæ u¿ywaj±c czarów!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['klasa'] == 'Obywatel' && $myczar) {
		print "Tylko mag mo¿e walczyæ u¿ywaj±c czarów!";
		require_once("footer.php");
		exit;
	}
	$span =  ($gracz['level'] - $enemy['level']);
	if ($span > 0) {
		print "Nie mo¿esz zaatakowaæ gracza na ni¿szym poziomie.";
		require_once("footer.php");
		exit;
	}
	if ($gr2['immu'] == 'Y') {
		print "Nie mo¿esz walczyæ, poniewa¿ masz immunitet!";
		require_once("footer.php");
		exit;
	}
	if ($enemy['immu'] == 'Y') {
		print "Nie mo¿esz zaatakowaæ gracza z immunitetem!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['klasa'] == 'Mag' && $gracz['pm'] == 0 && $myczar) {
		print "Nie mo¿esz atakowaæ przy pomocy czaru, poniewa¿ nie masz punktów magii!";
		require_once("footer.php");
		exit;
	}
	if ($gracz['credits'] < 0) {
		print "Nie mo¿esz zaatakowaæ gracza, poniewa¿ masz ujemn± ilo¶æ z³ota!";
		require_once("footer.php");
		exit;
	}
	if ($enemy['credits'] < 0) {
		print "Nie mo¿esz zaatakowaæ gracza, poniewa¿ posiada on ujemn± ilo¶æ sztuk z³ota!";
		require_once("footer.php");
		exit;
	}
	if ($stat['miejsce'] != $enemy['miejsce']) {
		print "Nie mo¿esz zaatakowaæ gracza, poniewa¿ nie przebywa on w tej samej lokacji co ty!";
		require_once("footer.php");
		exit;
	}
	print "<b><u>$gracz[user] przeciwko $enemy[user]</b></u><br>";
	mysql_query("update players set energy=energy-1 where id=$stat[id]");
	if ($gr2['agility'] >= $enemy['agility']) {
		attack();
	} else {
		attackback();
	}
}
if ($_GET['action'] == 'monster') {
if (!isset($_GET['fight'])) {
	print "S± tutaj potwory z którymi mo¿esz walczyæ. Ale uwa¿aj... nie chcesz przecie¿ atakowaæ kogo¶ znacznie silniejszego od siebie, prawda?<br><br>";
	print "<table>";
	print "<tr><td width=100><b><u>Nazwa</td><td width=50><b><u>Poziom</td><td width=50><b><u>Zdrowie</td></tr>";
	$msel = mysql_query("select * from monsters order by level asc");
	while ($monster = mysql_fetch_array($msel)) {
		print "<tr><td><a href=battle.php?action=monster&dalej=$monster[id]>$monster[name]</td><td>$monster[level]</td><td>$monster[hp]</td></tr>";
	}
	print "</table><br>";
	print "Lub mo¿esz zawsze... <a href=battle.php>zawróciæ</a>.";
}
if (isset($_GET['dalej'])) {
	$en = mysql_fetch_array(mysql_query("select * from monsters where id=$_GET[dalej]"));
	print "<form method=post action=battle.php?action=monster&fight=$en[id]>Walcz jednocze¶nie z <input type=text size=5 name=razy> $en[name](ami) <input type=submit value=Walcz></form>";
}
if (isset($_GET['fight'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['fight'])) {
		print "Zapomnij o tym";
		require_once("footer.php");
		exit;
	}
	$enemy = mysql_fetch_array(mysql_query("select * from monsters where id=$_GET[fight]"));
	$myweapon = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='W' and owner=$stat[id]"));
	$myarmor = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='A' and owner=$stat[id]"));
	$myhelm = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='H' and owner=$stat[id]"));
	$mylegs = mysql_fetch_array(mysql_query("select * from equipment where status='E' and type='N' and owner=$stat[id]"));
	$mczar = mysql_fetch_array(mysql_query("select * from czary where status='E' and gracz=$stat[id] and typ='B'"));
	$mczaro = mysql_fetch_array(mysql_query("select * from czary where status='E' and gracz=$stat[id] and typ='O'"));		
	$gr2 = mysql_fetch_array(mysql_query("select inteli, klasa, strength, agility, inteli, atak, unik, magia, szyb, wytrz, rasa, wisdom from players where id=$stat[id]"));
	$ehp= ($enemy['hp'] * $_POST['razy']);
	if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
		print "Zapomnij o tym";
		require_once("footer.php");
		exit;
	}
	if ($gracz['hp'] <= 0) {
		print "Nie masz wystarczaj±co du¿o ¿ycia aby walczyæ.";
		require_once("footer.php");
		exit();
	}
	if ($gr2['klasa'] == '') {
		print "Nie mo¿esz atakowaæ potwora, dopóki nie wybierzesz profesji!";
		require_once("footer.php");
		exit;
	}
	if ($gracz['energy'] < $_POST['razy']) {
		print "Nie masz wystarczaj±co du¿o energii aby walczyæ.";
		require_once("footer.php");
		exit();
	}
	if (!$enemy['id']) {
		print "Tu nie ma potwora.";
		require_once("footer.php");
		exit();
	}
	if ($myweapon && $mczar) {
		print "Nie mo¿esz walczyæ jednocze¶nie broni± i czarem. Wybierz jeden rodzaj walki!";
		require_once("footer.php");
		exit;
	}
	if (!$myweapon && !$mczar) {
		print "Wybierz jaki¶ rodzaj walki!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['klasa'] == 'Wojownik' && $mczar) {
		print "Tylko mag mo¿e walczyæ u¿ywaj±c czarów!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['klasa'] == 'Obywatel' && $mczar) {
		print "Tylko mag mo¿e walczyæ u¿ywaj±c czarów!";
		require_once("footer.php");
		exit;
	}
	if ($gr2['klasa'] == 'Mag' && $mczar && $gracz['pm'] == 0) {
		print "Nie mo¿esz atakowaæ poniewa¿ nie masz punktów magii!";
		require_once("footer.php");
		exit;
	}
	$premia = 0;
	if ($myhelm) {
		$premia = ($premia + $myhelm['power']);
	}
	if ($mylegs) {
		$premia = ($premia + $mylegs['power']);
	}
	if ($myarmor) {
		$premia = ($premia + $myarmor['power']);
	}
	if ($myweapon) {
		if ($gr2['klasa'] == 'Wojownik') {
			$stat['damage'] = (($gr2['strength'] + $myweapon['power']) + $gracz['level']);
			$enemy['damage'] = ($enemy['strength'] - ($gracz['level'] + $gr2['wytrz'] + $premia));
		} else {
			$stat['damage'] = ($gr2['strength'] + $myweapon['power']);
			$enemy['damage'] = ($enemy['strength'] - ($gr2['wytrz'] + $premia));
		}
		if ($gr2['atak'] < 1) {
			$krytyk = 1;
		}
		if ($gr2['atak'] > 5) {
			$kr = ceil($gr2['atak'] / 100);
			$krytyk = ($krytyk + $kr);
		}
	}
	if ($mczar) {
		$damage = ($mczar['obr'] * $gr2['inteli']);
		$stat['damage'] = $damage - ($damage * ($myarmor['minlev'] / 100));
		if ($myhelm) {
			$stat['damage'] = $stat['damage'] - ($damage * ($myhelm['minlev'] / 100));
		}
		if ($mylegs) {
			$stat['damage'] = $stat['damage'] - ($damage * ($mylegs['minlev'] / 100));
		}
		if ($stat['damage'] < 0) {
			$stat['damage'] = 0;
		}
		if ($gr2['magia'] < 1) {
			$krytyk = 1;
		}
		if ($gr2['magia'] > 5) {
			$kr = ceil($gr2['magia'] / 100);
			$krytyk = ($krytyk + $kr);
		}
	}
	$minus = 0;
	if ($mczaro) {
		$strength = ($mczaro['obr'] * $gr2['wisdom']);
		if ($myarmor) {
			$minus = ($minus + ($strength * ($myarmor['minlev'] / 100)));
		}
		if ($myhelm) {
			$minus = ($minus + ($strength * ($myhelm['minlev'] / 100)));
		}
		if ($mylegs) {
			$minus = ($minus + ($strength * ($mylegs['minlev'] / 100)));
		}
		$myczarobr = ($strength - $minus);
		if ($myczarobr < 0) {
			$myczarobr = 0;
		}
		$myobrona = ($myczarobr + $gr2['wytrz'] + $premia);
		$enemy['damage'] = ($enemy['strength'] - $myobrona);
	}
	$myagility = checkagility($gr2['agility'],$myarmor['zr'],$mylegs['zr']);
	$myspeed = checkspeed($gr2['szyb'],$myarmor['zr'],$mylegs['zr'],$myweapon['szyb']);
	if ($gr2['klasa'] == 'Wojownik') {
		$myunik = (($myagility - $enemy['agility']) + $gracz['level']);
		$eunik = (($enemy['agility'] - $myagility) - ($gr2['atak'] + $gracz['level']));
	}
	if ($gr2['klasa'] == 'Obywatel') {
		$myunik = ($myagility - $enemy['agility']);
		$eunik = (($enemy['agility'] - $myagility) - $gr2['atak']);
	}
	if ($gr2['klasa'] == 'Mag') {
		$myunik = ($myagility - $enemy['agility']);
		$eunik = (($enemy['agility'] - $myagility) - ($gr2['magia'] + $gracz['level']));
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
	$zmecz = 0;
	$runda = 0;
	$rzut1 = (rand(1,$gracz['level']) * 10);
	$enemy['damage'] = ($enemy['damage'] + $rzut1);
	$rzut2 = (rand(1,$enemy['level']) * 10);
	$stat['damage'] = ($stat['damage'] + $rzut2);
	if ($enemy['damage'] < 1) { $enemy['damage'] = 0; }
	if ($stat['damage'] < 1) { $stat['damage'] = 0 ; }
	$stat['attackstr'] = ceil($myspeed / $enemy['agility']);
	$enemy['attackstr'] = ceil($enemy['agility'] / $myspeed);

	mysql_query("update players set energy=energy-$_POST[razy] where id=$stat[id]");
	print "<ul>";
	print "<li><b>$gracz[user]</b> przeciwko <b>$enemy[name](om)</b>";
	print "<li><b>Walka:</b><br>";

	while ($gracz['hp'] > 0 && $ehp > 0 && $runda < 25) {
		$runda = ($runda + 1);
		if ($zmecz > $gr2['wytrz']) {
			$enemy['damage'] = $enemy['strength'];
		}
		if ($gracz['pm'] < $mczar['poziom']) {
			$stat['damage'] = 0;
		}
		if ($gracz['pm'] < $mczaro['poziom']) {
			$enemy['damage'] = $enemy['strength'];
		}
		for ($i = 1;$i <= $stat['attackstr']; ++$i) {
			if ($ehp > 0 && $gracz['hp'] > 0) {
				$szansa = rand(1,100);
				if ($eunik >= $szansa && $szansa < 95) {
					print "<b>$enemy[name](i)</b> unikn±³y twojego ciosu!<br>";
				} elseif ($zmecz <= $gr2['wytrz']) {
					if ($myweapon) {
						$ehp = ($ehp - $stat['damage']);
						print "Atakujesz <b>$enemy[name](i)</b> i zadajesz <b>$stat[damage]</b> obra¿eñ! ($ehp zosta³o)</font><br>";
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
							$ehp = ($ehp - $stat['damage']);
							print "Atakujesz <b>$enemy[name](i)</b> i zadajesz <b>$stat[damage]</b> obra¿eñ! ($ehp zosta³o)</font><br>";
							if ($stat['damage'] > 0) {
								$gmagia = ($gmagia + 1);
							}
							$gracz['pm'] = ($gracz['pm'] - $mczar['poziom']);
						} else {
							$pechowy = rand(1,100);
							if ($pechowy <= 70) {
								print "<b>$gracz[user]</b> próbowa³ rzuciæ czar, ale niestety nie uda³o mu siê opanowaæ mocy. Traci przez to <b>$mczar[poziom]</b> punktów magii.<br>";
								$gracz['pm'] = ($gracz['pm'] - $mczar['poziom']);
							}
							if ($pechowy > 70 and $pechowy <= 90) {
								print "<b>$gracz[user]</b> próbowa³ rzuciæ czar, ale straci³ panowanie nad swoj± koncentracj±. Traci przez to wszystkie punkty magii.<br>";
								$gracz['pm'] = 0;
							}
							if ($pechowy > 90) {
								print "<b>$gracz[user]</b> straci³ ca³kowicie panowanie nad czarem! Czar wybuch³ mu prosto w twarz! Traci przez to $stat[damage] punktów ¿ycia!<br>";
								$gracz['hp'] = ($gracz['hp'] - $stat['damage']);
							}
							break;
						}
					}
				}
			}
		}
		for ($i = 1;$i <= $enemy['attackstr']; ++$i) {
			if ($gracz['hp'] > 0 && $ehp > 0) {
				$szansa = rand(1,100);
				if ($myunik >= $szansa && $szansa < 95 && $zmecz <= $gr2['wytrz']) {
					print "Unikn±³e¶ ciosu <b>$enemy[name](ów)</b>!<br>";
					$gunik = ($gunik + 1);
					$zmecz = ($zmecz + $myarmor['minlev']);
				} else {
					$gracz['hp'] = ($gracz['hp'] - $enemy['damage']);
					print "<b>$enemy[name](i)</b> atakuje(±) ciebie i zadaje(±) <b>$enemy[damage]</b> obra¿eñ! ($gracz[hp] zosta³o)<br>";
					if ($myarmor || $myhelm || $mylegs) {
						$efekt = rand(0,$number);
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
	}
	if ($gracz['hp'] <= 0) {
		print "<br><li><b>Wynik:</b> Zosta³e¶ pokonany przez <b>$_POST[razy] $enemy[name](ów)</b>.";
		if ($myweapon) {
			lostitem($gwtbr,$myweapon['wt'],'Twoja broñ',$stat['id'],$myweapon['id'],$stat['id'],'ulega');
		}
		if ($myarmor) {
			lostitem($gwt[0],$myarmor['wt'],'Twoja zbroja',$stat['id'],$myarmor['id'],$stat['id'],'ulega');
		}
		if ($myhelm) {
			lostitem($gwt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
		}
		if ($mylegs) {
			lostitem($gwt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
		}
		gainability($stat['id'],$gracz['user'],$gunik,$gatak,$gmagia,$gracz['pm'],$stat['id']);
	} else {
		if ($runda > 24) {
			print "<br><li><b>Wynik:</b> Walka nie rozstrzygniêta!</b>.";
			if ($myweapon) {
				lostitem($gwtbr,$myweapon['wt'],'Twoja broñ',$stat['id'],$myweapon['id'],$stat['id'],'ulega');
			}
			if ($myarmor) {
				lostitem($gwt[0],$myarmor['wt'],'Twoja zbroja',$stat['id'],$myarmor['id'],$stat['id'],'ulega');
			}
			if ($myhelm) {
				lostitem($gwt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
			}
			if ($mylegs) {
				lostitem($gwt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
			}
			print "<li>Zdobywasz: ";
			gainability($stat['id'],$gracz['user'],$gunik,$gatak,$gmagia,$gracz['pm'],$stat['id']);
		}
		if ($gracz['hp'] > 0 && $runda < 25) {
			print "<br><li><b>Wynik:</b> Pokona³e¶ <b>$_POST[razy] $enemy[name](i)</b>.";
			if ($myweapon) {
				lostitem($gwtbr,$myweapon['wt'],'Twoja broñ',$stat['id'],$myweapon['id'],$stat['id'],'ulega');
			}
			if ($myarmor) {
				lostitem($gwt[0],$myarmor['wt'],'Twoja zbroja',$stat['id'],$myarmor['id'],$stat['id'],'ulega');
			}
			if ($myhelm) {
				lostitem($gwt[1],$myhelm['wt'],'Twój he³m',$stat['id'],$myhelm['id'],$stat['id'],'ulega');
			}
			if ($mylegs) {
				lostitem($gwt[2],$mylegs['wt'],'Twoje nagolenniki',$stat['id'],$mylegs['id'],$stat['id'],'ulegaj±');
			}
			$expgain = (rand($enemy['exp1'],$enemy['exp2']) * $_POST['razy']);
			$goldgain = (rand($enemy['credits1'],$enemy['credits2']) * $_POST['razy']);
			mysql_query("update players set exp=exp+$expgain where id=$stat[id]");
			mysql_query("update players set credits=credits+$goldgain where id=$stat[id]");
			print "<li><b>Nagroda</b><br> Zdoby³e¶ <b>$expgain</b> PD oraz <b>$goldgain</b> sztuk z³ota oraz ";
			gainability($stat['id'],$gracz['user'],$gunik,$gatak,$gmagia,$gracz['pm'],$stat['id']);
			checkexp($gracz['exp'],$expgain,$gracz['level'],$gr2['rasa'],$gracz['user'],$stat['id'],0,0,$stat['id']);
		}
	}
	print "<li><b>Opcje</b><br>";
	print "<a href=battle.php?action=monster>Odejd¼</a><br></li></ul>";
}
} 
	
?>

<?php require_once("footer.php"); ?>
