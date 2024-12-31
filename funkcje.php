<?php
/***************************************************************************
 *                               funkcje.php
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

// Funkcja sprawdzaj±ca czy postaæ zdoby³a tyle pd aby awansowaæ na poziom
function checkexp ($exp,$expgain,$level,$rasa,$user,$eid,$enemyid,$enemyuser,$player) {
	$poziom = 0;
	$ap = 0;
	$pz = 0;
	$energia = 0;
	$texp = ($exp + $expgain);
	$expn = ($level * 200);
	while ($texp >= $expn) {
		$poziom = ($poziom + 1);
		$ap = ($ap + 5);
		$texp = ($texp - $expn);
		$expn = ($level * 200);
		if ($rasa == 'Cz³owiek') {
			$pz = ($pz + 5);
		}
		if ($rasa == 'Elf') {
			$pz = ($pz + 4);
		}
		if ($rasa == 'Krasnolud') {
			$pz = ($pz + 6);
		}
		$energia = $energia + 0.5;
	}
	if ($poziom > 0) {
		if ($player == $eid) {
			print "<br><b>Zdoby³e¶ poziom</b> $user.<br>";
			print "$poziom Poziom(ów)<br>";
			print "$ap AP<br>";
			print "$pz Maksymalnych Punktów ¯ycia<br>";
			print "$energia Maksymalnej Energii<br>";
		}
		mysql_query("update players set exp=$texp where id=$eid");
		mysql_query("update players set level=level+$poziom where id=$eid");
		mysql_query("update players set ap=ap+$ap where id=$eid");
		mysql_query("update players set max_hp=max_hp+$pz where id=$eid");
		mysql_query("update players set max_energy=max_energy+$energia where id=$eid");
		$czas = date("y-m-d H:i:s");
		if ($enemyid != 0) {
			mysql_query("insert into log (owner, log, czas) values($eid,'Podczas walki z <b>$enemyuser ID:$enemyid</b>, zdobywasz poziom.','$czas')");
		}
	}
}

// Funkcja obliczaj±ca straty cech podczas walki
function loststat($lostid,$strength,$agility,$inteli,$wytrz,$szyb,$wisdom,$winid,$winuser) {
	$number = rand(1,6);
	$values = array($strength,$agility,$inteli,$wytrz,$szyb,$wisdom);
	$stats = array('strength','agility','inteli','wytrz','szyb','wisdom');
	$name = array('si³y','zrêczno¶ci','inteligencji','wytrzyma³o¶ci','szybko¶ci','si³y woli');
	$lost = ($values[$number] / 200);
	mysql_query("update players set ".$stats[$number]."=".$stats[$number]."-$lost where id=$lostid");
	$czas = date("y-m-d H:i:s");
	$stat = $name[$number];
	if ($winid) {
		mysql_query("insert into log (owner, log, czas) values($lostid,'Zosta³e¶ pokonany przez <b>$winuser ID:$winid</b>. Straci³e¶ $lost $stat','$czas')") or die("nie mogê dodaæ do dziennika!");
	}
	if ($winuser && !$winid) {
		print "<br><b>Wynik:</b> Zosta³e¶ pokonany przez <b>$winuser</b>. Straci³e¶ $lost $stat";
	}
}

// Funkcja obliczaj±ca podniesienie umiejêtno¶ci podczas walki
function gainability ($gid,$user,$gunik,$gatak,$gmagia,$pm,$player2) {
	if (($gunik || $gatak || $gmagia) && ($player2 == $gid)) {
		print "<br>$user zdobywa:<br>";
	}
	if ($gunik > 0) {
		$dunik = ($gunik / 100);
		if ($player2 == $gid) {
			print "<b>$dunik</b> w umiejêtno¶ci uniki<br>";
		}
		mysql_query("update players set unik=unik+$dunik where id=$gid");
	}
	if ($gatak > 0) {
		$datak = ($gatak / 100);
		if ($player2 == $gid) {
			print "<b>$datak</b> w umiejêtno¶ci walka broni±<br>";
		}
		mysql_query("update players set atak=atak+$datak where id=$gid");
	}
	if ($gmagia > 0) {
		$dmagia = ($gmagia / 100);
		if ($player2 == $gid) {
			print "<b>$dmagia</b> w umiejêtno¶ci rzucanie czarów<br>";
		}
		mysql_query("update players set magia=magia+$dmagia where id=$gid");
	}
	if ($pm <= 0) {
		$pm = 0;
	}
	mysql_query("update players set pm=$pm where id=$gid");
}

// Funkcja obliczaj±ca uszkodzenia broni oraz zbroi podczas walki
function lostitem($lostdur,$itemdur,$type,$player,$itemid,$player2,$lost) {
	$itemdur = ($itemdur - $lostdur);
	if ($itemdur < 1) {
		if ($player == $player2) {
			print "<br>$type $lost zniszczeniu!<br>";
		}
		mysql_query("delete from equipment where id=$itemid");
	} else {
		if ($player == $player2) {
			print "<br>$type traci $lostdur wytrzyma³o¶ci.<br>";
		}
		mysql_query("update equipment set wt=$itemdur where id=$itemid");
	}
}

//Funkcja sprawdzaj±ca jakie opancerzenie posiada na sobie gracz
function checkarmor($torso,$head,$legs) {
        global $armor;
        global $number;
	$test = array($torso,$head,$legs);
	$number = -1;
	$j = 0;
	$armor = array();
	for ($i=0;$i<3;$i++) {
		if ($test[$i] != 0) {
			$number = ($number + 1);
			if ($i == 0) {
				$armor[$j] = 'torso';
			}
			if ($i == 1) {
				$armor[$j] = 'head';
			}
			if ($i == 2) {
				$armor[$j] = 'legs';
			}
			$j = ($j + 1);
		}
	}
}
//Funkcja obliczaj±ca zrêczno¶æ gracza
function checkagility($agility,$armor,$legs) {
         $agi1 = ($agility - ($agility * ($armor / 100)));
         $agi2 = ($agility * ($legs / 100));
         $newagility = ($agi1 - $agi2);
         return $newagility;
}
//Funkcja obliczaj±ca szybko¶æ gracza
function checkspeed($speed,$armor,$legs,$weapon) {
	$speed1 = ($speed - ($speed * ($armor / 100)));
	$speed3 = ($speed * ($legs / 100));
	$speed2 = ($speed1 + ($speed * ($weapon / 100)));
	$newspeed = ($speed2 - $speed3);
	return $newspeed;
}
?>
