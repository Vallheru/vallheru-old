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

 $title = "Polana Chowa�c�w"; require_once("header.php"); ?>

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
	print "Witaj na Polanie Chowa�c�w. Polana Chowa�c�w jest o miescje gdzie trzymane s� zwierz�ta wyst�puj�ce na Vallheru. Normalnie poluje si� na nie jako na zwierzyn� �own�, ale tutaj s� trzymane pod stra��. Je�eli kupisz Licencje na Chowa�ca, b�dziesz m�g� z�apa� i trenowa� w�asnego chowa�ca.";
	if ($gracz['credits'] < 500) {
		print "<br>Licencja kosztuje 500 sztuk z�ota - kt�rych akurat nie masz przy sobie. Prosz�, wr�� kiedy b�dziesz mia� odpowiedni� sum�.";
	} else {
		print "<br>Masz 500 sztuk z�ota - dlaczego nie kupisz licencji? To otworzy ci kolejne miejsce w grze.";
		print "<ul>";
		print "<li><a href=core.php?answer=yes>Jasne, kupuj�.</a></li>";
		print "<li><a href=core.php?answer=no>Niee...</a></li>";
		print "</ul>";
		if ($_GET['answer'] == 'yes') {
			if ($gracz['credits'] < 500) {
				print "Nie masz tyle sztuk z�ota.";
			} else {
				mysql_query("update players set credits=credits-500 where id=$stat[id]");
				mysql_query("update players set corepass='Y' where id=$stat[id]");
				print "�wietnie - masz ju� Licencj� na Chowa�ca. Kliknij <a href=core.php>tutaj</a> aby kontynuowa�.";
			}
		}
	}
	require_once("footer.php");
	exit;
}

if (empty ($_GET['view'])) {
	print "Witaj w Sektorze! Widz�, �e masz swoj� licencj�... w porz�dku, baw si� dobrze.
	<ul>
	<li><a href=core.php?view=mycores>Moje Chowa�ce</a>
	<li><a href=core.php?view=arena>Arena Chowa�c�w</a>
	<li><a href=core.php?view=train>Sala Treningowa Chowa�c�w</a>
	<li><a href=core.php?view=market>Sklep z Chowa�cami</a>
	<li><a href=core.php?view=explore>Szukaj</a>
	<li><a href=core.php?view=library>Biblioteka Chowa�c�w</a><br><br>
	<li><a href=core.php?view=help>Opis Polany Chowa�c�w</a>
	</ul>";
}

if ($_GET['view'] == 'mycores') {
	if (!isset($_GET['id'])) {
		print "Tutaj jest lista wszystkich Chowa�c�w jakie znalaz�e�.";
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
			$typ = 'Le�ny';
		}
		if ($coreinfo['type'] == 'Aqua') {
			$typ = 'Wodny';
		}
		if ($coreinfo['type'] == 'Material') {
			$typ = 'G�rski';
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
			$status = '�ywy';
		}
		if ($coreinfo['status'] == 'Dead') {
			$status = 'Martwy';
		}
		if (empty ($coreinfo['id'])) {
			print "Nie ma chowa�ca.";
		} else {
			if ($coreinfo['owner'] != $stat['id']) {
				print "To nie tw�j chowaniec!";
			} else {
				print "<center><br><table class=td width=300 cellpadding=0 cellspacing=0>";
				print "<tr><td align=center style=\"border-bottom: solid black 1px;\" colspan=2><b>Zobacz Chowa�ca</b></td></tr>";
				print "<tr><td width=150 valign=top>+ <b>Podstawowe Informacje</b>";
					print "<ul>";
					print "<li>ID: $coreinfo[id]";
					print "<li>Imi�: $coreinfo[name]";
					print "<li>Typ: $typ";
					print "</ul>";
				print "</td><td width=150 valign=top style=\"border-left: solid black 1px\">";
					print "+ <b>Fizyczne informacje</b>";
					print "<ul>";
					print "<li>Status: $status";
					print "<li>Si�a: $coreinfo[power]";
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
			print "Nie posiadasz tego chowa�ca.";
		} else {
			mysql_query("update core set active='N' where owner=$stat[id]");
			mysql_query("update core set active='T' where id=$active[id]");
			print "Aktywowa�e� swojego <b>$active[name] Chowa�ca</b> (<a href=core.php?view=mycores>od�wie�</a>).";
		}
	}
	if (isset($_GET['dezaktywuj'])) {
		$dez = mysql_fetch_array(mysql_query("select * from core where id=$_GET[dezaktywuj]"));
		if ($dez['owner'] != $stat['id']) {
			print "Nie posiadasz tego chowa�ca.";
		} else {
			mysql_query("update core set active='N' where id=$dez[id]");
			print "Dezaktywowa�e� swojego <b>$dez[name] Chowa�ca</b> (<a href=core.php?view=mycores>od�wie�</a>).";
			}
	}
	if (isset($_GET['release'])) {
		$rel = mysql_fetch_array(mysql_query("select * from core where id=$_GET[release]"));
		if ($rel['owner'] != $stat['id']) {
			print "Nie posiadasz tego chowa�ca.";
		} else {
			mysql_query("delete from core where id=$rel[id]");
			print "Uwolni�e� swojego <b>$rel[name] Chowa�ca</b> (<a href=core.php?view=mycores>od�wie�</a>).";
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
		print "Witaj w Bibliotece Chowa�c�w, $gracz[user]. Znajdziesz tutaj informacje o twoich <b>$yourc</b> chowa�cach po�r�d informacji o wszystkich <b>$tnumc</b> znajduj�cych si� w bibliotece.";
		print "<br><br>Mo�esz u�ywa� naszej biblioteki aby zobaczy� informacje tylko o tych chowa�cach, kt�re ju� widzia�e�.";
		print "<br><br>+ <b>Podstawowe Chowa�ce</b><br>";
		print "<ul>";
		$csel = mysql_query("select * from cores where type!='Hybrid' and type!='Secret'");
		while ($cr = mysql_fetch_array($csel)) {
			$yh = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$cr[name]'"));
			if ($cr['type'] == 'Plant') {
				$typ = 'Le�ny';
			}
			if ($cr['type'] == 'Aqua') {
				$typ = 'Wodny';
			}
			if ($cr['type'] == 'Material') {
				$typ = 'G�rski';
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
			print "+ <b>��czone chowa�ce</b>";
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
			print "+ <b>Specjalne chowa�ce</b>";
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
			$typ = 'Le�ny';
		}
		if ($coreinfo['type'] == 'Aqua') {
			$typ = 'Wodny';
		}
		if ($coreinfo['type'] == 'Material') {
			$typ = 'G�rski';
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
			print "<tr><td colspan=2 align=center style=\"border-bottom: solid black 1px;\"><b>Obejrzyj chowa�ca</td></tr>";
			print "<tr><td colspan=2 align=center><img src=images/pets/$coreinfo[id].jpg></td></tr>";
			print "<tr><td valign=top width=150>";
				print "+ <b>Podstawowe informacje</b>";
				print "<ul>";
				print "<li>Standardowy ID: $coreinfo[id]";
				print "<li>Nazwa: $coreinfo[name]";
				$caught = mysql_num_rows(mysql_query("select * from core where name='$coreinfo[name]'"));
				print "<li>Typ: $typ";
				print "<li>Rzadko��: $coreinfo[rarity]";
				print "<li>Zdobywalno��: $caught";
				print "</ul>";
			print "</td><td width=150 valign=top style=\"border-left: solid black 1px;\">";
				print " + <b>Opis</b><br><br>";
				print "<ul><li>$coreinfo[desc]</ul>";
			print "</td></tr>";
			print "</table></center>";
		} else {
			print "Nie zdoby�e� tego chowa�ca.";
		}
	}
}

if ($_GET['view'] == 'arena') {
	if (!$_GET['step'] && !isset($_GET['attack'])) {
		print "Witaj na Arenie Chowa�c�w. S� pewne r�nice w stosunku do walki na Arenie Walk - ka�dy Chowaniec zadaje jeden cios innemu. Ten, kt�ry zada najwi�cej obra�e� jest uznawany za zwyci�zc�.";
		print "<ul>";
		$chowaniec = mysql_fetch_array(mysql_query("select * from core where status='Alive' and active='T' and owner=$stat[id]"));
		if ($chowaniec['type'] == 'Plant') {
			print "<li><a href=core.php?view=arena&step=battles&typ=1>Arena le�na</a>.";
			print "<li>Arena morska";
			print "<li>Arena g�rska";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Aqua') {
			print "<li>Arena le�na";
			print "<li><a href=core.php?view=arena&step=battles&typ=2>Arena morska</a>.";
			print "<li>Arena g�rska";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Material') {
			print "<li>Arena le�na";
			print "<li>Arena morska";
			print "<li><a href=core.php?view=arena&step=battles&typ=3>Arena g�rska</a>.";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Element') {
			print "<li>Arena le�na";
			print "<li>Arena morska";
			print "<li>Arena g�rska";
			print "<li><a href=core.php?view=arena&step=battles&typ=4>Arena polna</a>.";
			print "<li>Arena pustynna";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Alien') {
			print "<li>Arena le�na";
			print "<li>Arena morska";
			print "<li>Arena g�rska";
			print "<li>Arena polna";
			print "<li><a href=core.php?view=arena&step=battles&typ=5>Arena pustynna</a>.";
			print "<li>Arena magiczna<br><br>";
		}
		if ($chowaniec['type'] == 'Ancient') {
			print "<li>Arena le�na";
			print "<li>Arena morska";
			print "<li>Arena g�rska";
			print "<li>Arena polna";
			print "<li>Arena pustynna";
			print "<li><a href=core.php?view=arena&step=battles&typ=6>Arena magiczna</a>.<br><br>";
		}
		print "<li><a href=core.php?view=arena&step=heal>Ulecz moje chowa�ce</a>.";
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
		print "<tr><td width=100><b><u>Chowaniec</td><td width=100><b><u>W�a�ciciel</td><td width=100><b><u>Opcje</td></tr>";
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
				print "Nie masz aktywnych chowa�c�w!";
			} else {
				if ($mycore['status'] == 'Dead') {
					print "Tw�j aktywny chowaniec jest martwy!";
				} else {
					print "+ <b>Walka Chowa�c�w</b><br>";
					$enemy = mysql_fetch_array(mysql_query("select * from core where id=$_GET[attack]"));
					if (empty ($enemy['id'])) {
						print "Nie ma takiego chowa�ca!";
						require_once("footer.php");
						exit;
					}
					$numy = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and id=$enemy[id]"));
					if ($numy > 0) {
						print "Nie mo�esz walczy� z w�asnym Chowa�cem!";
					} else {
						if ($enemy['status'] == 'Dead') {
							print "Ten chowaniec jest martwy.";
						} else {
							if  ($mycore['type'] != $enemy['type']) {
								print "Nie mo�esz walczy� chowa�cem $mycore[name] z chowa�cem $enemy[name] poniewa� s� r�nych typ�w";
								require_once("footer.php");
								exit;
							}
							if ($enemy['active'] != 'T') {
								print "Nie mo�esz walczy� z chowa�cem $enemy[name] poniewa� nie jest on aktywny!";
								require_once("footer.php");
								exit;
							}
							print "Tw�j Chowaniec $mycore[name] przeciwko ID $enemy[owner] $enemy[name] Chowa�cowi.<br><br>";
							$yattack = ($mycore['power'] - $enemy['defense']);
							if ($yattack <= 0) {
								$yattack = 0;
							}
							$eattack = ($enemy['power'] - $mycore['defense']);
							if ($eattack <= 0) {
								$eattack = 0;
							}
							print "Wrogi Chowaniec <b>$enemy[name]</b> atakuje za $eattack!<br>";
							print "Tw�j Chowaniec <b>$mycore[name]</b> atakuje za $yattack!<br><br>";
							if ($eattack == $yattack) {
								print "Bitwa nie  <b>rozstrzygni�ta</b>.";
							} else {
								if ($eattack > $yattack) {
									$victor = mysql_fetch_array(mysql_query("select user, id from players where id=$enemy[owner]"));
									$loser = mysql_fetch_array(mysql_query("select user, id from players where id=$stat[id]"));
								} else {
									$victor = mysql_fetch_array(mysql_query("select user, id from players where id=$stat[id]"));
									$loser = mysql_fetch_array(mysql_query("select user, id from players where id=$enemy[owner]"));
								}
								print "$victor[user] Chowaniec pokona� $loser[user] Chowa�ca.<br>";
								if ($victor['user'] == $gracz['user']) {
									print "Tw�j <b>Chowaniec $mycore[name]</b> pokona�  $loser[user] <b>$enemy[name] Chowa�ca</b>!<br><br>";
									mysql_query("update core set status='Dead' where id=$enemy[id]");
								} else {
									print "Tw�j <b>Chowaniec $mycore[name]</b> zosta� pokonany przez $victor[user] <b>$enemy[name] Chowa�ca</b>!<br><br>";
									mysql_query("update core set status='Dead' where id=$mycore[id]");
								}
								$crgain = rand(0,100);
								$plgain = rand(0,3);
								print "$victor[user] zdobywa <b>$crgain</b> sztuk z�ota za bitw� oraz <b>$plgain</b> mithrilu!";
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
		print "To b�dzie kosztowa� <b>$cost</b> sztuk z�ota, aby wyleczy� wszystkie twoich <b>$numdead</b> martwych Chowa�c�w.";
		print "<ul>";
		print "<li><a href=core.php?view=arena&step=heal&answer=yes>Wylecz je</a>.";
		print "<li><a href=core.php>Nie chc� leczy� ich teraz</a>.";
		print "</ul>";
		if ($_GET['answer'] == 'yes') {
			if ($gracz['credits'] < $cost) {
				print "Nie masz tyle sztuk z�ota.";
			} else {
				mysql_query("update core set status='Alive' where owner=$stat[id] and status='Dead'");
				mysql_query("update players set credits=credits-$cost where id=$stat[id]");
				print "Wszystkie twoje chowa�ce s� ponownie gotowe do walki.";
			}
		}
	}
}

if ($_GET['view'] == 'train') {
	print "Witaj w sali treningowej. Dostajesz 15 punkt�w treningu ka�dego dnia. Ka�dy punkt podwy�sza Chowa�cowi .125 w odpowiedniej statystyce. Obecnie masz <b>$gr3[trains]</b> wolnych punkt�w treningowych.";
	print "<form method=post action=core.php?view=train&step=train>";
	print "Trenuj mojego <select name=train_core>";
	$csel = mysql_query("select * from core where owner=$stat[id]");
	while ($myc = mysql_fetch_array($csel)) {
		print "<option value=$myc[id]>$myc[name]</option>";
	}
	print "</select> Chowa�ca <input type=text size=5 name=reps> razy w <select name=technique><option value=power>Sile</option><option value=defense>Obronie</option></select>. <input type=submit value=Trenuj>";
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
			print "Nie poda�e� ile razy.";
		} else {
			if ($_POST['technique'] != 'power' && $_POST['technique'] != 'defense') {
				print "Zapomnij o tym.";
				require_once("footer.php");
				exit;
			}
			if ($gracz['hp'] == 0) {
				print "Nie mo�esz trenowa� chowa�ca, poniewa� jeste� martwy!";
				require_once("footer.php");
				exit;
			}
			if ($_POST['reps'] > $gr3['trains']) {
				print "Nie masz wystarczaj�co du�o punkt�w treningowych.";
			} else {
				$gain = ($_POST['reps'] * .125);
				mysql_query("update core set $_POST[technique]=$_POST[technique]+$gain where id=$train_core") or print "stage 1 failed<br>";
				mysql_query("update players set trains=trains-$_POST[reps] where id=$stat[id]") or print "stage 2 failed<br>";
				if ($technique == 'power') {
					$cecha = 'Si�y';
				}
				if ($technique == 'defense') {
					$cecha = 'Obrony';
				}
				print "Trenowa�e� swojego Chowa�ca <b>$_POST[reps]</b> razy, zu�ywaj�c <b>$trains</b> punkt�w treningowych. Dostaje za to <b>$gain $cecha</b>.";
			}
		}
	}
}

if ($_GET['view'] == 'market') {
	if (empty ($_GET['step'])) {
		print "Witaj w sklepie z Chowa�cami. Tutaj mo�esz kupi� Chowa�ca od innych graczy. Co chcesz zrobi�?";
		print "<ul>";
		print "<li><A href=core.php?view=market&step=market>Zobacz oferty</a>";
		print "<li><A href=core.php?view=market&step=add>Dodaj ofert�</a>";
		print "</ul>";
	}
	if ($_GET['step'] == 'market') {
		print "Tutaj s� oferty sprzeda�y Chowa�c�w przez innych graczy.<br><br>";
		print "<table>";
		print "<tr><td width=100><b><u>Nazwa Chowa�ca</td><td width=100><b><u>ID Sprzedaj�cego</td><td width=100><b><u>Cena</td><td width=100><b><u>Opcje</td></tr>";
		$msel = mysql_query("select * from core_market order by id desc");
		while ($market = mysql_fetch_array($msel)) {
			if ($market['seller'] == $stat['id']) {
				print "<tr><td>$market[name]</td><td>M�j</td><td>$market[cost] sz</td><td><a href=core.php?view=market&step=market&remove=$market[id]>Usu�</a></td></tr>";
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
				print "Usun��e� ofert�. Tw�j Chowaniec <b>$rem[name]</b> wr�ci� do ciebie.";
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
				print "Nie mo�esz kupi� swojego Chowa�ca..";
			} else {
				if ($gracz['credits'] < $buy['cost']) {
					print "Nie sta� ci�.";
				} else {
					mysql_query("insert into core (owner,name,type,power,defense) values($stat[id],'$buy[name]','$buy[type]',$buy[power],$buy[defense])") or die("Could not get back.");
					mysql_query("update players set credits=credits-$buy[cost] where id=$stat[id]");
					mysql_query("update players set credits=credits+$buy[cost] where id=$buy[seller]");
					mysql_query("delete from core_market where id=$buy[id]");
					mysql_query("insert into log (owner,log) values($buy[seller],'$gracz[user] kupi� twojego $buy[name] Chowa�ca za $buy[cost] sztuk z�ota.')");
					print "Kupi�e� <b>Chowa�ca $buy[name]</b> za <b>$buy[cost]</b> sztuk z�ota.";
				}
			}
		}

	}
	if ($_GET['step'] == 'add') {
                if (!isset($_GET['action'])) {
                        $_GET['action'] = '';
                }
		print "Tutaj dodasz swoj� ofert� sprzeda�y chowa�ca.";
		print "<form method=post action=core.php?view=market&step=add&action=add>";
		print "Dodaj mojego <select name=add_core>";
		$csel = mysql_query("select * from core where owner=$stat[id]");
		while ($mc = mysql_fetch_array($csel)) {
			print "<option value=$mc[id]>$mc[name]</option>";
		}
		print "</select> Chowa�ca za <input type=text size=7 name=cost> sztuk z�ota. <input type=submit value=Sprzedaj>";
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
					print "Mo�esz maksymalnie wystawi� 5 ofert na raz!";
				} else {
					$sc = mysql_fetch_array(mysql_query("select * from core where id=$_POST[add_core]"));
					if ($sc['owner'] != $stat['id']) {
						print "Nie mo�esz sprzeda� cudzego chowa�ca!";
						require_once("footer.php");
						exit;
					}
					mysql_query("insert into core_market (seller, cost, name, type, power, defense) values($stat[id],$_POST[cost],'$sc[name]','$sc[type]',$sc[power],$sc[defense])");
					mysql_query("delete from core where id=$_POST[add_core]");
					print "Doda�e� swojego <b>$sc[name] Chowa�ca</b> do sklepu za <b>$_POST[cost]</b> sztuk z�ota.";
				}
			}
		}
	}
}

if ($_GET['view'] == 'explore') {
	if (!isset($_GET['next'])) {
		print "Witaj w centrum poszukiwa� Chowa�c�w. Prosz�, wybierz region, z kt�rego szukasz chowa�ca. Jest wiele region�w, ale musisz posiada� odpowiedni� ilo�� mithrilu aby m�c wej�� w jeden z nich. Ka�de poszukianie chowa�ca kosztuje 0.1 energii. Chowa�ce przyci�ga mithril z wielu powod�w...";
		print "<form method=post action=core.php?view=explore&next=yes>";
		print "<select name=explore><option value=Forest>Las (0 mith)</option>";
		print "<option value=Ocean>Ocean (50 mith)</option>";
		print "<option value=Mountains>G�ry (100 mith)</option>";
		print "<option value=Plains>��ki (150 mith)</option>";
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
				print "Nie masz wystarczaj�co du�o energii aby szuka�. <a href=core.php?view=explore>Wr��</a>";
				require_once("footer.php");
				exit;
			}
			if ($gracz['hp'] == 0) {
				print "Nie mo�esz wyruszy� na poszukiwanie poniewa� jeste� martwy! <a href=core.php?view=explore>Wr��</a>";
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
				print "Nie masz tyle mithrilu. <a href=core.php?view=explore>Wr��</a>";
				require_once("footer.php");
				exit;
			}

			if ($_POST['explore'] == 'Forest') { $type = 'Plant'; $common[1] = 1; $common[2] = 2; $common[3] = 3; $uncommon = 4; $rare1 = 5; $obszar = 'Las';}
			if ($_POST['explore'] == 'Ocean') { $type = 'Aqua'; $common[1] = 6; $common[2] = 7; $common[3] = 8; $uncommon = 9; $rare1 = 10; $obszar = 'Ocean';}
			if ($_POST['explore'] == 'Mountains') { $type = 'Material'; $common[1] = 11; $common[2] = 12; $common[3] = 13; $uncommon = 14; $rare1 = 15; $obszar = 'G�ry';}
			if ($_POST['explore'] == 'Plains') { $type = 'Element'; $common[1] = 16; $common[2] =17; $common[3] = 18; $uncommon =19; $rare1 = 20; $obszar = '��ki';}
			if ($_POST['explore'] == 'Desert') { $type = 'Alien'; $common[1] = 21; $common[2] = 22; $common[3] = 23; $uncommon = 24; $rare1 = 25; $obszar = 'Pustynia';}
			if ($_POST['explore'] == 'Magic') { $type = 'Ancient'; $common[1] = 26; $common[2] = 27; $common[3] = 28; $uncommon = 29; $rare1 = 30; $obszar = 'Inny wymiar';}
			print "Chcesz szuka� Chowa�ca w regionie: <b>$obszar</b>...<br>";

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
		           				$typ = 'Le�ny';
			           			$mith = 0;
				         	}
              					if ($coreinfo['type'] == 'Aqua') {
	           					$typ = 'Wodny';
		        				$mith = 50;
			        		}
				        	if ($coreinfo['type'] == 'Material') {
					        	$typ = 'G�rski';
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
					        print "Znalaz�e� <b>$coreinfo[name] Chowa�ca</b>! Jest on rodzaju <b>$typ</b>.";
             					if ($coreinfo['rarity'] == 1) { print "<br>Ten Chowaniec jest <b>cz�sto spotykany</b>."; }
	          				if ($coreinfo['rarity'] == 2) { print "<br>Ten Chowaniec jest <b>rzadki</b>."; }
		          			if ($coreinfo['rarity'] == 3) { print "<br>Ten Chowaniec jest <b>bardzo rzadki</b>."; }
			        		$corenum = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$coreinfo[name]'"));
				        	if ($corenum <= 0) { print "<br>To jest tw�j pierwszy Chowaniec tego typu!<br>"; } else { print "<br>Masz ju� takiego Chowa�ca.<br>"; }
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
					        	$typ = 'Le�ny';
						        $mith = 0;
              					}
	           				if ($coreinfo['type'] == 'Aqua') {
		       	         			$typ = 'Wodny';
		              	    			$mith = 50;
				          	}
               					if ($coreinfo['type'] == 'Material') {
	            					$typ = 'G�rski';
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
              					print "Znalaz�e� <b>$coreinfo[name] Chowa�ca</b>! Jest to Chowaniec typu <b>$typ</b>.";
	           				if ($coreinfo['rarity'] == 1) { print "<br>Ten Chowaniec jest <b>cz�sto spotykany</b>."; }
		           			if ($coreinfo['rarity'] == 2) { print "<br>Ten Chowaniec jest <b>rzadki</b>."; }
			         		if ($coreinfo['rarity'] == 3) { print "<br>Ten Chowaniec jest <b>bardzo rzadki</b>."; }
				         	$corenum = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$coreinfo[name]'"));
              					if ($corenum <= 0) { print "<br>Jest to tw�j pierwszy chowaniec tego typu!<br>"; } else { print "<br>Masz ju� takiego chowa�ca.<br>"; }
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
		            				$typ = 'Le�ny';
		                			$mith = 0;
				        	}
					        if ($coreinfo['type'] == 'Aqua') {
						        $typ = 'Wodny';
              						$mith = 50;
	            				}
		        			if ($coreinfo['type'] == 'Material') {
			         			$typ = 'G�rski';
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
		        			print "Znalaz�e� <b>$coreinfo[name] Chowa�ca</b>! Jest on typu <b>$typ</b>.";
			         		if ($coreinfo['rarity'] == 1) { print "<br>Ten Chowaniec jest <b>cz�sto spotykany</b>."; }
				         	if ($coreinfo['rarity'] == 2) { print "<br>Ten Chowaniec jest <b>rzadki</b>."; }
              					if ($coreinfo['rarity'] == 3) { print "<br>Ten Chowaniec jest <b>bardzo rzadki</b>."; }
	           				$corenum = mysql_num_rows(mysql_query("select * from core where owner=$stat[id] and name='$coreinfo[name]'"));
		           			if ($corenum <= 0) { print "<br>To tw�j pierszy Chowaniec tego typu!<br>"; } else { print "<br>Masz ju� podobnego chowa�ca.<br>"; }
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
             		print "<br>Szuka�e� chowa�c�w w $obszar $repeat razy<br>";
             		mysql_query("update players set energy=energy-$lostenergy where id=$stat[id]");
             		print "<br>Chcesz szuka� ponownie?<br>";
             		print "<a href=core.php?view=explore>Tak</a><br>";
             		print "<a href=core.php>Nie</a><br>";
               }
	}
}

if ($_GET['view'] == 'help') {
	if (!$_GET['step']) {
		print "Witaj w opisie Polany Chowanc�w. Wszystko co potrzebujesz wiedzie�, znajduje si� w�a�nie tutaj.";
		print "<ul>";
		print "<li><a href=core.php?view=help&step=getting>Zdobywanie Chowa�c�w</a>";
		print "<li><a href=core.php?view=help&step=info>Informacje o Chowa�cach</a>";
		print "<li><a href=core.php?view=help&step=library>Biblioteka Chowa�c�w</a>";
		print "<li><a href=core.php?view=help&step=training>Trenowanie Chowa�c�w</a>";
		print "<li><a href=core.php?view=help&step=battling>Walka Chowa�c�w</a>";
		print "</ul>";
	}
	if ($_GET['step'] == 'getting') {
		print "+ <b>Zdobywanie Chowa�c�w</b><br><br>";
		print "Najprostszym sposobem jest �apanie ich! Jest to bardzo proste. Wszystko co potrzebujesz to i�� do opcji Szukaj. Nast�pnie zobaczysz kilka opcji. Jest wiele region�w do wyboru, ale ka�dy jest oznaczony (# mith). Musisz mie� co najmniej tyle samo mithrilu ile jest podane jako #. Liczba ta oznacza r�wnie� ile zap�acisz za znalezienie jedenego chowa�ca danego typu. Ka�de poszukiwanie kosztuje 0,01 energii<br><br>Chowa�ce s� posegregowane wed�ug rzadko�ci. Cz�sto spotykane - szansa aby je z�apa� jest oko�o 1/150. Rzadkie aby z�apa� 1/750, Bardzo rzadkie oko�o 1/1500.";
	}
	if ($_GET['step'] == 'info') {
		print "+ <b>Informacje o Chowa�cach</b><br><br>";
		print "Aby zobaczyc informacje o Chowa�cu, musisz klikn�� opcje Moje Chowa�ce. Nast�pnie kliknij na nazwie Chowa�ca. B�dziesz mia� mo�liwo�� obejrzenia Chowa�ca, aktywacji go lub uwolnienia.";
	}
	if ($_GET['step'] == 'library') {
		print "+ <b>Biblioteka Chowa�c�w</b><br><br>";
		print "Biblioteka Chowa�c�w poka�e ci informacje o wszystkich chowa�cach jakie zebra�e�. Mo�esz zobaczy� tylko te, kt�re posiadasz.";
	}
	if ($_GET['step'] == 'training') {
		print "+ <b>Trenowanie Chowa�c�w</b><br><br>";
		print "To miejsce posiada w�asny opis. Za ka�de .2 punktu treningowego, tw�j Chowaniec zdobywa .1 w odpowiedniej statystyce.";
	}
	if ($_GET['step'] == 'battling') {
		print "+ <b>Walka Chowa�c�w</b><br><br>";
		print "Walka Chowa�c�w jest bardzo �atw� drog� aby zdoby� nieco mithrilu. Im wy�sza Si�a oraz Obrona twojego Chowa�ca, tym wi�ksza szansa na zwyci�stwo. Aby� m�g� toczy� walk�, jeden z twoich Chowa�c�w musi by� Aktywny.";
	}
	if ($_GET['step']) {
		print "<br><br>... <a href=core.php?view=help>wr��</a>.";
	}
}

if ($_GET['view']) {
	print "<br><br>... <a href=core.php>Polana Chowa�c�w</a>.";
}
?>

<?php require_once("footer.php"); ?>
