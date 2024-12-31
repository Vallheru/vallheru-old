<?php
/***************************************************************************
 *                               core.php
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

 $title = "Polana Chowañców"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['answer'])) {
     $_GET['answer'] = '';
}
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if (!isset($_GET['explore'])) {
     $_GET['explore'] = '';
}
$gr3 = mysql_fetch_array(mysql_query("select corepass, trains from players where id=$stat[id]"));
if ($gr3['corepass'] != 'Y') {
	print "Witaj na Polanie Chowañców. Polana Chowañców jest o miescje gdzie trzymane s± zwierzêta wystêpuj±ce na Vallheru. Normalnie poluje siê na nie jako na zwierzynê ³own±, ale tutaj s± trzymane pod stra¿±. Je¿eli kupisz Licencje na Chowañca, bêdziesz móg³ z³apaæ i trenowaæ w³asnego chowañca.";
	if ($gracz['credits'] < 500) {
		print "<br>Licencja kosztuje 500 sztuk z³ota - których akurat nie masz przy sobie. Proszê, wróæ kiedy bêdziesz mia³ odpowiedni± sumê.";
	} else {
		print "<br>Masz 500 sztuk z³ota - dlaczego nie kupisz licencji? To otworzy ci kolejne miejsce w grze.";
		print "<ul>";
		print "<li><a href=core.php?answer=yes>Jasne, kupujê.</a></li>";
		print "<li><a href=core.php?answer=no>Niee...</a></li>";
		print "</ul>";
		if ($_GET['answer'] == 'yes') {
			if ($gracz['credits'] < 500) {
				print "Nie masz tyle sztuk z³ota.";
			} else {
				mysql_query("update players set credits=credits-500 where id=$stat[id]");
				mysql_query("update players set corepass='Y' where id=$stat[id]");
				print "¦wietnie - masz ju¿ Licencjê na Chowañca. Kliknij <a href=core.php>tutaj</a> aby kontynuowaæ.";
			}
		}
	}
	require_once("footer.php");
	exit;
}

if (empty ($_GET['view'])) {
	print "Witaj w Sektorze! Widzê, ¿e masz swoj± licencjê... w porz±dku, baw siê dobrze.
	<ul>
	<li><a href=core.php?view=mycores>Moje Chowañce</a>
	<li><a href=core.php?view=arena>Arena Chowañców</a>
	<li><a href=core.php?view=train>Sala Treningowa Chowañców</a>
	<li><a href=core.php?view=market>Sklep z Chowañcami</a>
	<li><a href=core.php?view=explore>Szukaj</a>
	<li><a href=core.php?view=library>Biblioteka Chowañców</a><br><br>
	<li><a href=core.php?view=help>Opis Polany Chowañców</a>
	</ul>";
}

if ($_GET['view'] == 'mycores') {
	if (!isset($_GET['id'])) {
		print "Tutaj jest lista wszystkich Chowañców jakie znalaz³e¶.";
		print "<ul>";
		$csel = mysql_query("select * from core where owner=$stat[id]");
		while ($core = mysql_fetch_array($csel)) {
			if ($core['active'] == 'T') {
				print "<li><a href=core.php?view=mycores&id=$core[id]>$core[name] Chowaniec</a> (Aktywny)";
			} else {
				print "<li><a href=core.php?view=mycores&id=$core[id]>$core[name] Chowaniec</a>";
			}
		}
		print "</ul>";
	} else {
		$coreinfo = mysql_fetch_array(mysql_query("select * from core where id=$_GET[id]"));
		if ($coreinfo['type'] == 'Plant') {
			$typ = 'Le¶ny';
		}
		if ($coreinfo['type'] == 'Aqua') {
			$typ = 'Wodny';
		}
		if ($coreinfo['type'] == 'Material') {
			$typ = 'Górski';
		}
		if ($coreinfo['type'] == 'Element') {
			$typ = 'Polny';
		}
		if ($coreinfo['type'] == 'Alien') {
			$typ = 'Pustynny';
		}
		if ($coreinfo['type'] == 'Ancient') {
			$typ = 'Magiczny';
		}
		if ($coreinfo['status'] == 'Alive') {
			$status = '¯ywy';
		}
		if ($coreinfo['status'] == 'Dead') {
			$status = 'Martwy';
		}
		if (empty ($coreinfo['id'])) {
			print "Nie ma chowañca.";
		} else {
			if ($coreinfo['owner'] != $stat['id']) {
				print "To nie twój chowaniec!";
			} else {
				print "<center><br><table class=td width=300 cellpadding=0 cellspacing=0>";
				print "<tr><td align=center style=\"border-bottom: solid black 1px;\" colspan=2><b>Zobacz Chowañca</b></td></tr>";
				print "<tr><td width=150 valign=top>+ <b>Podstawowe Informacje</b>";
					print "<ul>";
					print "<li>ID: $coreinfo[id]";
					print "<li>Imiê: $coreinfo[name]";
					print "<li>Typ: $typ";
					print "</ul>";
				print "</td><td width=150 valign=top style=\"border-left: solid black 1px\">";
					print "+ <b>Fizyczne informacje</b>";
					print "<ul>";
					print "<li>Status: $status";
					print "<li>Si³a: $coreinfo[power]";
					print "<li>Obrona: $coreinfo[defense]";
					print "</ul>";
				print "</td></tr>";
				print "<tr><td colspan=2 align=center style=\"border-top: solid black 1px;\">Opcje: (<a href=core.php?view=library&id=$coreinfo[ref_id]>Zobacz opis</a>)";
				if ($coreinfo['active'] == 'N') {
					print " (<a href=core.php?view=mycores&activate=$coreinfo[id]>Aktywuj</a>)";
				}
				if ($coreinfo['active'] == 'T') {
					print " (<a href=core.php?view=mycores&dezaktywuj=$coreinfo[id]>Dezaktywuj</a>)";
				}
				print " (<a href=core.php?view=mycores&release=$coreinfo[id]>Uwolnij</a>)</td></tr>";
				print "</table></center>";
			}
		}
	}
	if (isset($_GET['activate'])) {
		$active = mysql_fetch_array(mysql_query("select * from core where id=$_GET[activate]"));
		if ($active['owner'] != $stat['id']) {
			print "Nie posiadasz tego chowañca.";
		} else {
			mysql_query("update core set active='N' where owner=$stat[id]");
			mysql_query("update core set active='T' where id=$active[id]");
			print "Aktywowa³e¶ swojego <b>$active[name] Chowañca</b> (<a href=core.php?view=mycores>od¶wie¿</a>).";
		}
	}
	if (isset($_GET['dezaktywuj'])) {
		$dez = mysql_fetch_array(mysql_query("select * from core where id=$_GET[dezaktywuj]"));
		if ($dez['owner'] != $stat['id']) {
			print "Nie posiadasz tego chowañca.";
		} else {
			mysql_query("update core set active='N' where id=$dez[id]");
			print "Dezaktywowa³e¶ swojego <b>$dez[name] Chowañca</b> (<a href=core.php?view=mycores>od¶wie¿</a>).";
			}
	}
	if (isset($_GET['release'])) {
		$rel = mysql_fetch_array(mysql_query("select * from core where id=$_GET[release]"));
		if ($rel['owner'] != $stat['id']) {
			print "Nie posiadasz tego chowañca.";
		} else {
			mysql_query("delete from core where id=$rel[id]");
			print "Uwolni³e¶ swojego <b>$rel[name] Chowañca</b> (<a href=core.php?view=mycores>od¶wie¿</a>).";
		}
	}
}

if ($_GET['view'] == 'library') {
	if (!isset($_GET['id'])) {
		$numys = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and type='Secret'"));
		$numyh = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and type='Hybrid'"));
		$numcores = mysql_num_rows(mysql_query("select * from cores where type!='Secret' and type!='Hybrid'"));
		$tnumc = ($numcores + $numys + $numyh);
		$yourc = mysql_num_rows(mysql_query("select * from core where owner=$stat[id]"));
		print "Witaj w Bibliotece Chowañców, $gracz[user]. Znajdziesz tutaj informacje o twoich <b>$yourc</b> chowañcach po¶ród informacji o wszystkich <b>$tnumc</b> znajduj±cych siê w bibliotece.";
		print "<br><br>Mo¿esz u¿ywaæ naszej biblioteki aby zobaczyæ informacje tylko o tych chowañcach, które ju¿ widzia³e¶.";
		print "<br><br>+ <b>Podstawowe Chowañce</b><br>";
		print "<ul>";
		$csel = mysql_query("select * from cores where type!='Hybrid' and type!='Secret'");
		while ($cr = mysql_fetch_array($csel)) {
			$yh = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$cr[name]'"));
			if ($cr['type'] == 'Plant') {
				$typ = 'Le¶ny';
			}
			if ($cr['type'] == 'Aqua') {
				$typ = 'Wodny';
			}
			if ($cr['type'] == 'Material') {
				$typ = 'Górski';
			}
			if ($cr['type'] == 'Element') {
				$typ = 'Polny';
			}
			if ($cr['type'] == 'Alien') {
				$typ = 'Pustynny';
			}
			if ($cr['type'] == 'Ancient') {
				$typ = 'Magiczny';
			}
			if ($yh > 0) {
				print "<li><a href=core.php?view=library&id=$cr[id]>$cr[name]</a> ($typ)";
			} else {
				print "<li>? (?)";
			}
		}
		print "</ul>";
		$yhc = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and type='Hybrid'"));
		if ($yhc > 0) {
			print "+ <b>£±czone chowañce</b>";
			print "<ul>";
			$csel = mysql_query("select * from cores where type='Hybrid'");
			while ($cr = mysql_fetch_array($csel)) {
				$yh = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$cr[name]'"));
				if ($yh > 0) {
					print "<li><a href=core.php?view=library&id=$cr[id]>$cr[name]</a> ($cr[type])";
				} else {
					print "<li>? (?)";
				}
			}
			print "</ul>";
		}
		$yhc = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and type='Secret'"));
		if ($yhc > 0) {
			print "+ <b>Specjalne chowañce</b>";
			print "<ul>";
			$csel = mysql_query("select * from cores where type='Secret'");
			while ($cr = mysql_fetch_array($csel)) {
				$yh = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$cr[name]'"));
				if ($yh > 0) {
					print "<li><a href=core.php?view=library&id=$cr[id]>$cr[name]</a> ($cr[type])";
				} else {
					print "<li>? (?)";
				}
			}
		}
	} else {
		if (!ereg("^[1-9][0-9]*$", $_GET['id'])) {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		}
		$coreinfo = mysql_fetch_array(mysql_query("select * from cores where id=$_GET[id]"));
		if ($coreinfo['type'] == 'Plant') {
			$typ = 'Le¶ny';
		}
		if ($coreinfo['type'] == 'Aqua') {
			$typ = 'Wodny';
		}
		if ($coreinfo['type'] == 'Material') {
			$typ = 'Górski';
		}
		if ($coreinfo['type'] == 'Element') {
			$typ = 'Polny';
		}
		if ($coreinfo['type'] == 'Alien') {
			$typ = 'Pustynny';
		}
		if ($coreinfo['type'] == 'Ancient') {
			$typ = 'Magiczny';
		}
		$ycore = mysql_num_rows(mysql_query("select * from core where name='$coreinfo[name]' and owner=$stat[id]"));
		if ($ycore > 0) {
			print "<br><center>";
			print "<table cellpadding=0 cellspacing=0 class=td align=center width=300>";
			print "<tr><td colspan=2 align=center style=\"border-bottom: solid black 1px;\"><b>Obejrzyj chowañca</td></tr>";
			print "<tr><td colspan=2 align=center><img src=images/pets/$coreinfo[id].jpg></td></tr>";
			print "<tr><td valign=top width=150>";
				print "+ <b>Podstawowe informacje</b>";
				print "<ul>";
				print "<li>Standardowy ID: $coreinfo[id]";
				print "<li>Nazwa: $coreinfo[name]";
				$caught = mysql_num_rows(mysql_query("select * from core where name='$coreinfo[name]'"));
				print "<li>Typ: $typ";
				print "<li>Rzadko¶æ: $coreinfo[rarity]";
				print "<li>Zdobywalno¶æ: $caught";
				print "</ul>";
			print "</td><td width=150 valign=top style=\"border-left: solid black 1px;\">";
				print " + <b>Opis</b><br><br>";
				print "<ul><li>$coreinfo[desc]</ul>";
			print "</td></tr>";
			print "</table></center>";
		} else {
			print "Nie zdoby³e¶ tego chowañca.";
		}
	}
}

if ($_GET['view'] == 'arena') {
	if (!$_GET['step'] && !isset($_GET['attack'])) {
		print "Witaj na Arenie Chowañców. S± pewne ró¿nice w stosunku do walki na Arenie Walk - ka¿dy Chowaniec zadaje jeden cios innemu. Ten, który zada najwiêcej obra¿eñ jest uznawany za zwyciêzcê.";
		print "<ul>";
		$chowaniec = mysql_fetch_array(mysql_query("select * from core where status='Alive' and active='T' and owner=$stat[id]"));
		if ($chowaniec['type'] == 'Plant') {
			print "<li><a href=core.php?view=arena&step=battles&typ=1>Arena le¶na</a>.";
			print "<li>Arena morska";
			print "<li>Arena górska";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Aqua') {
			print "<li>Arena le¶na";
			print "<li><a href=core.php?view=arena&step=battles&typ=2>Arena morska</a>.";
			print "<li>Arena górska";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Material') {
			print "<li>Arena le¶na";
			print "<li>Arena morska";
			print "<li><a href=core.php?view=arena&step=battles&typ=3>Arena górska</a>.";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Element') {
			print "<li>Arena le¶na";
			print "<li>Arena morska";
			print "<li>Arena górska";
			print "<li><a href=core.php?view=arena&step=battles&typ=4>Arena polna</a>.";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Alien') {
			print "<li>Arena le¶na";
			print "<li>Arena morska";
			print "<li>Arena górska";
			print "<li>Arena polna";
			print "<li><a href=core.php?view=arena&step=battles&typ=5>Arena pustynna</a>.";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Ancient') {
			print "<li>Arena le¶na";
			print "<li>Arena morska";
			print "<li>Arena górska";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li><a href=core.php?view=arena&step=battles&typ=6>Arena magiczna</a>.<br><br>";
		}
		print "<li><a href=core.php?view=arena&step=heal>Ulecz moje chowañce</a>.";
		print "</ul>";
	}
	if ($_GET['step'] == 'battles') {
		$chowaniec = mysql_fetch_array(mysql_query("select type, name from core where status='Alive' and active='T' and owner=$stat[id]"));
		if ($_GET['typ'] == '1') {
			$csel = mysql_query("select * from core where status='Alive' and active='T' and owner!=$stat[id] and type='Plant'");
			$test = 'Plant';
		}
		if ($_GET['typ'] == '2') {
			$csel = mysql_query("select * from core where status='Alive' and active='T' and owner!=$stat[id] and type='Aqua'");
			$test = 'Aqua';
		}
		if ($_GET['typ'] == '3') {
			$csel = mysql_query("select * from core where status='Alive' and active='T' and owner!=$stat[id] and type='Material'");
			$test = 'Material';
		}
		if ($_GET['typ'] == '4') {
			$csel = mysql_query("select * from core where status='Alive' and active='T' and owner!=$stat[id] and type='Element'");
			$test = 'Element';
		}
		if ($_GET['typ'] == '5') {
			$csel = mysql_query("select * from core where status='Alive' and active='T' and owner!=$stat[id] and type='Alien'");
			$test = 'Alien';
		}
		if ($_GET['typ'] == '6') {
			$csel = mysql_query("select * from core where status='Alive' and active='T' and owner!=$stat[id] and type='Ancient'");
			$test = 'Ancient';
		}
		if ($chowaniec['type'] != $test) {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		}
		print "<table>";
		print "<tr><td width=100><b><u>Chowaniec</td><td width=100><b><u>W³a¶ciciel</td><td width=100><b><u>Opcje</td></tr>";
		while ($clist = mysql_fetch_array($csel)) {
			print "<tr><td><a href=core.php?view=library&id=$clist[ref_id]>$clist[name]</a> Chowaniec</td><td><a href=view.php?view=$clist[owner]>$clist[owner]</a></td><td><a href=core.php?view=arena&attack=$clist[id]>Atak</a></td></tr>";
		}
		print "</table>";
	}
	if (isset($_GET['attack'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['attack'])) {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		}
		if ($gracz['energy'] < 0) {
			print "Nie masz tyle energii!";
		} else {
			$mycore = mysql_fetch_array(mysql_query("select * from core where active='T' and owner=$stat[id]"));
			if (empty ($mycore['id'])) {
				print "Nie masz aktywnych chowañców!";
			} else {
				if ($mycore['status'] == 'Dead') {
					print "Twój aktywny chowaniec jest martwy!";
				} else {
					print "+ <b>Walka Chowañców</b><br>";
					$enemy = mysql_fetch_array(mysql_query("select * from core where id=$_GET[attack]"));
					if (empty ($enemy['id'])) {
						print "Nie ma takiego chowañca!";
						require_once("footer.php");
						exit;
					}
					$numy = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and id=$enemy[id]"));
					if ($numy > 0) {
						print "Nie mo¿esz walczyæ z w³asnym Chowañcem!";
					} else {
						if ($enemy['status'] == 'Dead') {
							print "Ten chowaniec jest martwy.";
						} else {
							if  ($mycore['type'] != $enemy['type']) {
								print "Nie mo¿esz walczyæ chowañcem $mycore[name] z chowañcem $enemy[name] poniewa¿ s± ró¿nych typów";
								require_once("footer.php");
								exit;
							}
							if ($enemy['active'] != 'T') {
								print "Nie mo¿esz walczyæ z chowañcem $enemy[name] poniewa¿ nie jest on aktywny!";
								require_once("footer.php");
								exit;
							}
							print "Twój Chowaniec $mycore[name] przeciwko ID $enemy[owner] $enemy[name] Chowañcowi.<br><br>";
							$yattack = ($mycore['power'] - $enemy['defense']);
							if ($yattack <= 0) {
								$yattack = 0;
							}
							$eattack = ($enemy['power'] - $mycore['defense']);
							if ($eattack <= 0) {
								$eattack = 0;
							}
							print "Wrogi Chowaniec <b>$enemy[name]</b> atakuje za $eattack!<br>";
							print "Twój Chowaniec <b>$mycore[name]</b> atakuje za $yattack!<br><br>";
							if ($eattack == $yattack) {
								print "Bitwa nie  <b>rozstrzygniêta</b>.";
							} else {
								if ($eattack > $yattack) {
									$victor = mysql_fetch_array(mysql_query("select user, id from players where id=$enemy[owner]"));
									$loser = mysql_fetch_array(mysql_query("select user, id from players where id=$stat[id]"));
								} else {
									$victor = mysql_fetch_array(mysql_query("select user, id from players where id=$stat[id]"));
									$loser = mysql_fetch_array(mysql_query("select user, id from players where id=$enemy[owner]"));
								}
								print "$victor[user] Chowaniec pokona³ $loser[user] Chowañca.<br>";
								if ($victor['user'] == $gracz['user']) {
									print "Twój <b>Chowaniec $mycore[name]</b> pokona³  $loser[user] <b>$enemy[name] Chowañca</b>!<br><br>";
									mysql_query("update core set status='Dead' where id=$enemy[id]");
								} else {
									print "Twój <b>Chowaniec $mycore[name]</b> zosta³ pokonany przez $victor[user] <b>$enemy[name] Chowañca</b>!<br><br>";
									mysql_query("update core set status='Dead' where id=$mycore[id]");
								}
								$crgain = rand(0,100);
								$plgain = rand(0,3);
								print "$victor[user] zdobywa <b>$crgain</b> sztuk z³ota za bitwê oraz <b>$plgain</b> mithrilu!";
								mysql_query("update players set platinum=platinum+$plgain where id=$victor[id]");
								mysql_query("update players set credits=credits+$crgain where id=$victor[id]");
							}
						}
					}
				}
			}
		}
	}
	if ($_GET['step'] == 'heal') {
		$numdead = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and status='Dead'"));
		$cost = ($numdead * 10);
		print "To bêdzie kosztowaæ <b>$cost</b> sztuk z³ota, aby wyleczyæ wszystkie twoich <b>$numdead</b> martwych Chowañców.";
		print "<ul>";
		print "<li><a href=core.php?view=arena&step=heal&answer=yes>Wylecz je</a>.";
		print "<li><a href=core.php>Nie chcê leczyæ ich teraz</a>.";
		print "</ul>";
		if ($_GET['answer'] == 'yes') {
			if ($gracz['credits'] < $cost) {
				print "Nie masz tyle sztuk z³ota.";
			} else {
				mysql_query("update core set status='Alive' where owner=$stat[id] and status='Dead'");
				mysql_query("update players set credits=credits-$cost where id=$stat[id]");
				print "Wszystkie twoje chowañce s± ponownie gotowe do walki.";
			}
		}
	}
}

if ($_GET['view'] == 'train') {
	print "Witaj w sali treningowej. Dostajesz 15 punktów treningu ka¿dego dnia. Ka¿dy punkt podwy¿sza Chowañcowi .125 w odpowiedniej statystyce. Obecnie masz <b>$gr3[trains]</b> wolnych punktów treningowych.";
	print "<form method=post action=core.php?view=train&step=train>";
	print "Trenuj mojego <select name=train_core>";
	$csel = mysql_query("select * from core where owner=$stat[id]");
	while ($myc = mysql_fetch_array($csel)) {
		print "<option value=$myc[id]>$myc[name]</option>";
	}
	print "</select> Chowañca <input type=text size=5 name=reps> razy w <select name=technique><option value=power>Sile</option><option value=defense>Obronie</option></select>. <input type=submit value=Trenuj>";
	print "</form>";
	if ($_GET['step'] == 'train') {
		if (!ereg("^[1-9][0-9]*$", $_POST['train_core'])) {
			print "Zapomnij o tym!";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST["reps"])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		if ($_POST['reps'] <= 0) {
			print "Nie poda³e¶ ile razy.";
		} else {
			if ($_POST['technique'] != 'power' && $_POST['technique'] != 'defense') {
				print "Zapomnij o tym.";
				require_once("footer.php");
				exit;
			}
			if ($gracz['hp'] == 0) {
				print "Nie mo¿esz trenowaæ chowañca, poniewa¿ jeste¶ martwy!";
				require_once("footer.php");
				exit;
			}
			if ($_POST['reps'] > $gr3['trains']) {
				print "Nie masz wystarczaj±co du¿o punktów treningowych.";
			} else {
				$gain = ($_POST['reps'] * .125);
				mysql_query("update core set $_POST[technique]=$_POST[technique]+$gain where id=$train_core") or print "stage 1 failed<br>";
				mysql_query("update players set trains=trains-$_POST[reps] where id=$stat[id]") or print "stage 2 failed<br>";
				if ($technique == 'power') {
					$cecha = 'Si³y';
				}
				if ($technique == 'defense') {
					$cecha = 'Obrony';
				}
				print "Trenowa³e¶ swojego Chowañca <b>$_POST[reps]</b> razy, zu¿ywaj±c <b>$trains</b> punktów treningowych. Dostaje za to <b>$gain $cecha</b>.";
			}
		}
	}
}

if ($_GET['view'] == 'market') {
	if (empty ($_GET['step'])) {
		print "Witaj w sklepie z Chowañcami. Tutaj mo¿esz kupiæ Chowañca od innych graczy. Co chcesz zrobiæ?";
		print "<ul>";
		print "<li><A href=core.php?view=market&step=market>Zobacz oferty</a>";
		print "<li><A href=core.php?view=market&step=add>Dodaj ofertê</a>";
		print "</ul>";
	}
	if ($_GET['step'] == 'market') {
		print "Tutaj s± oferty sprzeda¿y Chowañców przez innych graczy.<br><br>";
		print "<table>";
		print "<tr><td width=100><b><u>Nazwa Chowañca</td><td width=100><b><u>ID Sprzedaj±cego</td><td width=100><b><u>Cena</td><td width=100><b><u>Opcje</td></tr>";
		$msel = mysql_query("select * from core_market order by id desc");
		while ($market = mysql_fetch_array($msel)) {
			if ($market['seller'] == $stat['id']) {
				print "<tr><td>$market[name]</td><td>Mój</td><td>$market[cost] sz</td><td><a href=core.php?view=market&step=market&remove=$market[id]>Usuñ</a></td></tr>";
			} else {
				print "<tr><td>$market[name]</td><td><a href=view.php?view=$market[seller]>$market[seller]</a></td><td>$market[cost] sz</td><td><a href=core.php?view=market&step=market&buy=$market[id]>Kup</a></td></tr>";
			}
		}
		print "</table>";
		if (isset($_GET['remove'])) {
			$rem = mysql_fetch_array(mysql_query("select * from core_market where id=$_GET[remove]"));
			if ($rem['seller'] != $stat['id']) {
				print "To nie twoja oferta.";
			} else {
				mysql_query("insert into core (owner,name,type,power,defense) values($stat[id],'$rem[name]','$rem[type]',$rem[power],$rem[defense])") or die("Could not get back.");
				mysql_query("delete from core_market where id=$rem[id]");
				print "Usun±³e¶ ofertê. Twój Chowaniec <b>$rem[name]</b> wróci³ do ciebie.";
			}
		}
		if (isset($_GET['buy'])) {
			if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
				print "Zapomnij o tym!";
				require_once("footer.php");
				exit;
			}
			$buy = mysql_fetch_array(mysql_query("select * from core_market where id=$_GET[buy]"));
			if ($buy['seller'] == $stat['id']) {
				print "Nie mo¿esz kupiæ swojego Chowañca..";
			} else {
				if ($gracz['credits'] < $buy['cost']) {
					print "Nie staæ ciê.";
				} else {
					mysql_query("insert into core (owner,name,type,power,defense) values($stat[id],'$buy[name]','$buy[type]',$buy[power],$buy[defense])") or die("Could not get back.");
					mysql_query("update players set credits=credits-$buy[cost] where id=$stat[id]");
					mysql_query("update players set credits=credits+$buy[cost] where id=$buy[seller]");
					mysql_query("delete from core_market where id=$buy[id]");
					mysql_query("insert into log (owner,log) values($buy[seller],'$gracz[user] kupi³ twojego $buy[name] Chowañca za $buy[cost] sztuk z³ota.')");
					print "Kupi³e¶ <b>Chowañca $buy[name]</b> za <b>$buy[cost]</b> sztuk z³ota.";
				}
			}
		}

	}
	if ($_GET['step'] == 'add') {
                if (!isset($_GET['action'])) {
                        $_GET['action'] = '';
                }
		print "Tutaj dodasz swoj± ofertê sprzeda¿y chowañca.";
		print "<form method=post action=core.php?view=market&step=add&action=add>";
		print "Dodaj mojego <select name=add_core>";
		$csel = mysql_query("select * from core where owner=$stat[id]");
		while ($mc = mysql_fetch_array($csel)) {
			print "<option value=$mc[id]>$mc[name]</option>";
		}
		print "</select> Chowañca za <input type=text size=7 name=cost> sztuk z³ota. <input type=submit value=Sprzedaj>";
		print "</form>";
		if ($_GET['action'] == 'add') {
			if (!ereg("^[1-9][0-9]*$", $_POST['cost'])) {
				print "Zapomnij o tym!";
				require_once("footer.php");
				exit;
			}
			if ($_POST['cost'] <= 0) {
				print "Nie ma za darmo.";
			} else {
				$numon = mysql_num_rows(mysql_query("select * from core_market where seller=$stat[id]"));
				if ($numon >= 5) {
					print "Mo¿esz maksymalnie wystawiæ 5 ofert na raz!";
				} else {
					$sc = mysql_fetch_array(mysql_query("select * from core where id=$_POST[add_core]"));
					if ($sc['owner'] != $stat['id']) {
						print "Nie mo¿esz sprzedaæ cudzego chowañca!";
						require_once("footer.php");
						exit;
					}
					mysql_query("insert into core_market (seller, cost, name, type, power, defense) values($stat[id],$_POST[cost],'$sc[name]','$sc[type]',$sc[power],$sc[defense])");
					mysql_query("delete from core where id=$_POST[add_core]");
					print "Doda³e¶ swojego <b>$sc[name] Chowañca</b> do sklepu za <b>$_POST[cost]</b> sztuk z³ota.";
				}
			}
		}
	}
}

if ($_GET['view'] == 'explore') {
	if (!isset($_GET['next'])) {
		print "Witaj w centrum poszukiwañ Chowañców. Proszê, wybierz region, z którego szukasz chowañca. Jest wiele regionów, ale musisz posiadaæ odpowiedni± ilo¶æ mithrilu aby móc wej¶æ w jeden z nich. Ka¿de poszukianie chowañca kosztuje 0.1 energii. Chowañce przyci±ga mithril z wielu powodów...";
		print "<form method=post action=core.php?view=explore&next=yes>";
		print "<select name=explore><option value=Forest>Las (0 mith)</option>";
		print "<option value=Ocean>Ocean (50 mith)</option>";
		print "<option value=Mountains>Góry (100 mith)</option>";
		print "<option value=Plains>£±ki (150 mith)</option>";
		print "<option value=Desert>Pustynia (200 mith)</option>";
		print "<option value=Magic>W innym wymiarze (250 mith)</option></select><br>";
		print "Szukaj <input type=text name=repeat size=4> razy<br>";
		print "<input type=submit value=Szukaj></form>";
	} else {
		if ($_GET['next'] == 'yes') {
		        if (!ereg("^[1-9][0-9]*$", $_POST['repeat'])) {
                                print "Zapomnij o tym";
                                require_once("footer.php");
                                exit;
                        }
                        $rep = ($_POST['repeat'] * 0.1);
			if ($gracz['energy'] < $rep) {
				print "Nie masz wystarczaj±co du¿o energii aby szukaæ. <a href=core.php?view=explore>Wróæ</a>";
				require_once("footer.php");
				exit;
			}
			if ($gracz['hp'] == 0) {
				print "Nie mo¿esz wyruszyæ na poszukiwanie poniewa¿ jeste¶ martwy! <a href=core.php?view=explore>Wróæ</a>";
				require_once("footer.php");
				exit;
			}
			if ($_POST['explore'] == 'Forest') { $req = 0; }
			elseif ($_POST['explore'] == 'Ocean') { $req = 50; }
			elseif ($_POST['explore'] == 'Mountains') { $req = 100; }
			elseif ($_POST['explore'] == 'Plains') { $req = 150; }
			elseif ($_POST['explore'] == 'Desert') { $req = 200; }
			elseif ($_POST['explore'] == 'Magic') { $req = 250; }
			else { print "Nie ma takiego regionu!"; require_once("footer.php"); exit; }
			if ($gracz['platinum'] < $req) {
				print "Nie masz tyle mithrilu. <a href=core.php?view=explore>Wróæ</a>";
				require_once("footer.php");
				exit;
			}

			if ($_POST['explore'] == 'Forest') { $type = 'Plant'; $common[1] = 1; $common[2] = 2; $common[3] = 3; $uncommon = 4; $rare1 = 5; $obszar = 'Las';}
			if ($_POST['explore'] == 'Ocean') { $type = 'Aqua'; $common[1] = 6; $common[2] = 7; $common[3] = 8; $uncommon = 9; $rare1 = 10; $obszar = 'Ocean';}
			if ($_POST['explore'] == 'Mountains') { $type = 'Material'; $common[1] = 11; $common[2] = 12; $common[3] = 13; $uncommon = 14; $rare1 = 15; $obszar = 'Góry';}
			if ($_POST['explore'] == 'Plains') { $type = 'Element'; $common[1] = 16; $common[2] =17; $common[3] = 18; $uncommon =19; $rare1 = 20; $obszar = '£±ki';}
			if ($_POST['explore'] == 'Desert') { $type = 'Alien'; $common[1] = 21; $common[2] = 22; $common[3] = 23; $uncommon = 24; $rare1 = 25; $obszar = 'Pustynia';}
			if ($_POST['explore'] == 'Magic') { $type = 'Ancient'; $common[1] = 26; $common[2] = 27; $common[3] = 28; $uncommon = 29; $rare1 = 30; $obszar = 'Inny wymiar';}
			print "Chcesz szukaæ Chowañca w regionie: <b>$obszar</b>...<br>";

                        for ($i=0;$i<=$_POST['repeat'];$i++) {
                                $rare = rand(1,3);
                                if ($rare == 1) {
				        $odds = rand(1,50);
                           		$chance = rand(1,50);
                             		if ($chance == $odds) {
			         		$core = rand(1,3);
				         	$core = $common[$core];
              					$coreinfo = mysql_fetch_array(mysql_query("select * from cores where id=$core"));
	           				if ($coreinfo['type'] == 'Plant') {
		           				$typ = 'Le¶ny';
			           			$mith = 0;
				         	}
              					if ($coreinfo['type'] == 'Aqua') {
	           					$typ = 'Wodny';
		        				$mith = 50;
			        		}
				        	if ($coreinfo['type'] == 'Material') {
					        	$typ = 'Górski';
						        $mith = 100;
              					}
	           				if ($coreinfo['type'] == 'Element') {
		           				$typ = 'Polny';
			           			$mith = 150;
				         	}
              					if ($coreinfo['type'] == 'Alien') {
	           					$typ = 'Pustynny';
		        				$mith = 200;
			        		}
				        	if ($coreinfo['type'] == 'Ancient') {
					        	$typ = 'Magiczny';
						        $mith = 250;
              					}
					        print "Znalaz³e¶ <b>$coreinfo[name] Chowañca</b>! Jest on rodzaju <b>$typ</b>.";
             					if ($coreinfo['rarity'] == 1) { print "<br>Ten Chowaniec jest <b>czêsto spotykany</b>."; }
	          				if ($coreinfo['rarity'] == 2) { print "<br>Ten Chowaniec jest <b>rzadki</b>."; }
		          			if ($coreinfo['rarity'] == 3) { print "<br>Ten Chowaniec jest <b>bardzo rzadki</b>."; }
			        		$corenum = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$coreinfo[name]'"));
				        	if ($corenum <= 0) { print "<br>To jest twój pierwszy Chowaniec tego typu!<br>"; } else { print "<br>Masz ju¿ takiego Chowañca.<br>"; }
					        mysql_query("update players set platinum=platinum-$mith where id=$stat[id]");
             					mysql_query("insert into core (owner,name,type,ref_id,power,defense) values($stat[id],'$coreinfo[name]','$coreinfo[type]',$core,$coreinfo[power],$coreinfo[defense])") or die("Could not add Core.");
	          			}
		        	}
			        if ($rare == 2) {
				        $odds = rand(1,250);
            				$chance = rand(1,250);
	        			if ($chance == $odds) {
		         			$core = $uncommon;
			          		$coreinfo = mysql_fetch_array(mysql_query("select * from cores where id=$core"));
				        	if ($coreinfo['type'] == 'Plant') {
					        	$typ = 'Le¶ny';
						        $mith = 0;
              					}
	           				if ($coreinfo['type'] == 'Aqua') {
		       	         			$typ = 'Wodny';
		              	    			$mith = 50;
				          	}
               					if ($coreinfo['type'] == 'Material') {
	            					$typ = 'Górski';
		         				$mith = 100;
			         		}
				         	if ($coreinfo['type'] == 'Element') {
					        	$typ = 'Polny';
						        $mith = 150;
              					}
	           				if ($coreinfo['type'] == 'Alien') {
		           				$typ = 'Pustynny';
			           			$mith = 200;
				           	}
                				if ($coreinfo['type'] == 'Ancient') {
		        				$typ = 'Magiczny';
			        			$mith = 250;
				         	}
              					print "Znalaz³e¶ <b>$coreinfo[name] Chowañca</b>! Jest to Chowaniec typu <b>$typ</b>.";
	           				if ($coreinfo['rarity'] == 1) { print "<br>Ten Chowaniec jest <b>czêsto spotykany</b>."; }
		           			if ($coreinfo['rarity'] == 2) { print "<br>Ten Chowaniec jest <b>rzadki</b>."; }
			         		if ($coreinfo['rarity'] == 3) { print "<br>Ten Chowaniec jest <b>bardzo rzadki</b>."; }
				         	$corenum = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$coreinfo[name]'"));
              					if ($corenum <= 0) { print "<br>Jest to twój pierwszy chowaniec tego typu!<br>"; } else { print "<br>Masz ju¿ takiego chowañca.<br>"; }
	           				mysql_query("update players set platinum=platinum-$mith where id=$stat[id]");
		           			mysql_query("insert into core (owner,name,type,ref_id,power,defense) values($stat[id],'$coreinfo[name]','$coreinfo[type]',$core,$coreinfo[power],$coreinfo[defense])") or die("Could not add Core.");
			           	}
               			}
	          		if ($rare == 3) {
		        		$odds = rand(1,500);
			        	$chance = rand(1,500);
				        if ($chance == $odds) {
					        $core = $rare1;
             					$coreinfo = mysql_fetch_array(mysql_query("select * from cores where id=$core"));
	          				if ($coreinfo['type'] == 'Plant') {
		            				$typ = 'Le¶ny';
		                			$mith = 0;
				        	}
					        if ($coreinfo['type'] == 'Aqua') {
						        $typ = 'Wodny';
              						$mith = 50;
	            				}
		        			if ($coreinfo['type'] == 'Material') {
			         			$typ = 'Górski';
				          		$mith = 100;
                				}
		        			if ($coreinfo['type'] == 'Element') {
			         			$typ = 'Polny';
				          		$mith = 150;
                				}
		        			if ($coreinfo['type'] == 'Alien') {
			         			$typ = 'Pustynny';
				          		$mith = 200;
                				}
		        			if ($coreinfo['type'] == 'Ancient') {
			         			$typ = 'Magiczny';
				          		$mith = 250;
                				}
		        			print "Znalaz³e¶ <b>$coreinfo[name] Chowañca</b>! Jest on typu <b>$typ</b>.";
			         		if ($coreinfo['rarity'] == 1) { print "<br>Ten Chowaniec jest <b>czêsto spotykany</b>."; }
				         	if ($coreinfo['rarity'] == 2) { print "<br>Ten Chowaniec jest <b>rzadki</b>."; }
              					if ($coreinfo['rarity'] == 3) { print "<br>Ten Chowaniec jest <b>bardzo rzadki</b>."; }
	           				$corenum = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$coreinfo[name]'"));
		           			if ($corenum <= 0) { print "<br>To twój pierszy Chowaniec tego typu!<br>"; } else { print "<br>Masz ju¿ podobnego chowañca.<br>"; }
			         		mysql_query("update players set platinum=platinum-$mith where id=$stat[id]");
				         	mysql_query("insert into core (owner,name,type,ref_id,power,defense) values($stat[id],'$coreinfo[name]','$coreinfo[type]',$core,$coreinfo[power],$coreinfo[defense])") or die("Could not add Core.");
              				}
	          		}
	                        if ($gracz['platinum'] < $req) {
                         		print "Nie masz tyle mithrilu!";
                             		break;
                               	}
             		}
             		$repeat = ($i - 1);
             		$lostenergy = ($repeat * 0.1);
             		print "<br>Szuka³e¶ chowañców w $obszar $repeat razy<br>";
             		mysql_query("update players set energy=energy-$lostenergy where id=$stat[id]");
             		print "<br>Chcesz szukaæ ponownie?<br>";
             		print "<a href=core.php?view=explore>Tak</a><br>";
             		print "<a href=core.php>Nie</a><br>";
               }
	}
}

if ($_GET['view'] == 'help') {
	if (!$_GET['step']) {
		print "Witaj w opisie Polany Chowanców. Wszystko co potrzebujesz wiedzieæ, znajduje siê w³a¶nie tutaj.";
		print "<ul>";
		print "<li><a href=core.php?view=help&step=getting>Zdobywanie Chowañców</a>";
		print "<li><a href=core.php?view=help&step=info>Informacje o Chowañcach</a>";
		print "<li><a href=core.php?view=help&step=library>Biblioteka Chowañców</a>";
		print "<li><a href=core.php?view=help&step=training>Trenowanie Chowañców</a>";
		print "<li><a href=core.php?view=help&step=battling>Walka Chowañców</a>";
		print "</ul>";
	}
	if ($_GET['step'] == 'getting') {
		print "+ <b>Zdobywanie Chowañców</b><br><br>";
		print "Najprostszym sposobem jest ³apanie ich! Jest to bardzo proste. Wszystko co potrzebujesz to i¶æ do opcji Szukaj. Nastêpnie zobaczysz kilka opcji. Jest wiele regionów do wyboru, ale ka¿dy jest oznaczony (# mith). Musisz mieæ co najmniej tyle samo mithrilu ile jest podane jako #. Liczba ta oznacza równie¿ ile zap³acisz za znalezienie jedenego chowañca danego typu. Ka¿de poszukiwanie kosztuje 0,01 energii<br><br>Chowañce s± posegregowane wed³ug rzadko¶ci. Czêsto spotykane - szansa aby je z³apaæ jest oko³o 1/150. Rzadkie aby z³apaæ 1/750, Bardzo rzadkie oko³o 1/1500.";
	}
	if ($_GET['step'] == 'info') {
		print "+ <b>Informacje o Chowañcach</b><br><br>";
		print "Aby zobaczyc informacje o Chowañcu, musisz klikn±æ opcje Moje Chowañce. Nastêpnie kliknij na nazwie Chowañca. Bêdziesz mia³ mo¿liwo¶æ obejrzenia Chowañca, aktywacji go lub uwolnienia.";
	}
	if ($_GET['step'] == 'library') {
		print "+ <b>Biblioteka Chowañców</b><br><br>";
		print "Biblioteka Chowañców poka¿e ci informacje o wszystkich chowañcach jakie zebra³e¶. Mo¿esz zobaczyæ tylko te, które posiadasz.";
	}
	if ($_GET['step'] == 'training') {
		print "+ <b>Trenowanie Chowañców</b><br><br>";
		print "To miejsce posiada w³asny opis. Za ka¿de .2 punktu treningowego, twój Chowaniec zdobywa .1 w odpowiedniej statystyce.";
	}
	if ($_GET['step'] == 'battling') {
		print "+ <b>Walka Chowañców</b><br><br>";
		print "Walka Chowañców jest bardzo ³atw± drog± aby zdobyæ nieco mithrilu. Im wy¿sza Si³a oraz Obrona twojego Chowañca, tym wiêksza szansa na zwyciêstwo. Aby¶ móg³ toczyæ walkê, jeden z twoich Chowañców musi byæ Aktywny.";
	}
	if ($_GET['step']) {
		print "<br><br>... <a href=core.php?view=help>wróæ</a>.";
	}
}

if ($_GET['view']) {
	print "<br><br>... <a href=core.php>Polana Chowañców</a>.";
}
?>

<?php require_once("footer.php"); ?>
