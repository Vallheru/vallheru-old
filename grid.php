<?php 
/***************************************************************************
 *                               grid.php
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

$title = "Labirynt"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['action'])) {
     $_GET['action'] = '';
}
if ($_GET['action'] != 'explore') {
	print "Idziesz sobie star� drog� gdzie po bokach stoj� stare kamieniczki ca�e z kamienia ju� prawie zniszczonego. Nagle w dali zauwa�asz stary, pot�ny labirynt jest on wykonany z marmuru a jego mury licz� oko�o pi�� metr�w wysoko�ci. Wej�cie jest zablokowane kamieniami, chocia� nikt tam nie wchodzi� od setek lat! Nagle podchodzi do ciebie stary m�drzec i m�wi <i>Patrzysz na stary labirynt m�odzie�cze. Nikt tam nie wchodzi� od wielu lat. Wielu m�nych wojownik�w wchodzi�o tam zabi� potwora. W ko�cu go zg�adzili, lecz gdy chcieli wychodzi� zostali zasypani g�azami. Szczury na pewno poroznosi�y ich skarby, b�dziesz m�g� znale�� tam interesuj�ce rzeczy a teraz �egnaj</i>. Podchodzisz do wej�cia i robisz sobie przej�cie. Pod gruzami le�y wielu martwych rycerzy.<br>";
	print "Czy mimo tego chcesz tam wej��? <a href=grid.php?action=explore>Tak.</a>";
} else {
	if ($gracz['energy'] < .3) {
		print "Nie masz wystarczaj�co energii aby zwiedza� labirynt.";
	} else {
		if ($gracz['hp'] == 0) {
			print "Nie mo�esz zwiedza� labiryntu poniewa� jeste� martwy!";
			require_once("footer.php");
			exit;
		}
		$chance = rand(1,8);
		mysql_query("update players set energy=energy-.3 where id=$stat[id]");
		if ($chance == 1) {
			print "Idziesz przez d�u�szy czas rozgl�daj�c si� w ko�o lecz nic tu nie ma.";
		}
		if ($chance == 2) {
			print "Nic nie znajdujesz.";
		}
		if ($chance == 3) {
			$crgain = rand(1,100);
			print "Znalaz�e� mieszek! Znajduje si� w nim <b>$crgain</b> sztuk z�ota.";
			mysql_query("update players set credits=credits+$crgain where id=$stat[id]");
		}
		if ($chance == 4) {
			print "Idziesz i idziesz, lecz nic nie znajdujesz.";
		}
		if ($chance == 5) {
			print "Co to jest?";
		}
		if ($chance == 6) {
			$plgain = rand(1,3);
			print "Znalaz�e� mithril! Zdoby�e� <b>$plgain</b> sztuk mithrilu.";
			mysql_query("update players set platinum=platinum+$plgain where id=$stat[id]");
		}
		if ($chance == 7) {
			$roll = rand(1,20);
			if ($roll == 15) {
				print "Widzisz �r�d�o! Idziesz do niego i wypijasz ca�� wod�. Zyskujesz <b>.3</b> maksymalnej energii!";
				mysql_query("update players set max_energy=max_energy+.3 where id=$stat[id]");
			} else {
				print "Zobaczy�e� �r�d�o! Podbiegasz i odzyskujesz <b>1</b> punkt energi!";
				mysql_query("update players set energy=energy+1 where id=$stat[id]");
			}
		}
		if ($chance == 8) {
			print "Nie ma tutaj nic warto�ciowego.";
		}
		$energyleft = ($gracz['energy'] - .3);
		print "<br><br>... <a href=grid.php?action=explore>zwiedzaj</a> dalej. (zosta�o ci $energyleft punkt�w energii.)";
	}
}

require_once("footer.php");
?>
