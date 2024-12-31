<?php 
/***************************************************************************
 *                               monuments.php
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

$title = "Pos±gi";
require_once("header.php");
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
?>

<center>
<table>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwy¿szy poziom</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Poziom</td></tr>
	<?php
	$tsel = mysql_query("select id, user, level from players order by level desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[level]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwy¿sze kowalstwo</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Kowalstwo</td></tr>
	<?php
	$tsel = mysql_query("select id, user, ability from players order by ability desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[ability]</td></tr>";
	}
	?>
	</table>
</td></tr>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej sztuk z³ota</b></u> (przy sobie)</td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Sztuk z³ota</td></tr>
	<?php
	$tsel = mysql_query("select id, user, credits from players order by credits desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[credits]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej sztuk z³ota</b></u> (w banku)</td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>W banku</td></tr>
	<?php
	$tsel = mysql_query("select id, user, bank from players order by bank desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[bank]</td></tr>";
	}
	?>
	</table>
</td></tr>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej sztuk mithrilu</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Sztuk Mithrilu</td></tr>
	<?php
	$tsel = mysql_query("select id, user, platinum from players order by platinum desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[platinum]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej maksymalnej energii</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Energii</td></tr>
	<?php
	$tsel = mysql_query("select id, user, max_energy from players order by max_energy desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[max_energy]</td></tr>";
	}
	?>
	</table>
</td></tr>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej zwyciêstw</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Zwyciêstw</td></tr>
	<?php
	$tsel = mysql_query("select id, user, wins from players order by wins desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[wins]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej pora¿ek</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Pora¿ek</td></tr>
	<?php
	$tsel = mysql_query("select id, user, losses from players order by losses desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[losses]</td></tr>";
	}
	?>
	</table>
</td></tr>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej Si³y</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Si³a</td></tr>
	<?php
	$tsel = mysql_query("select id, user, strength from players order by strength desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[strength]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej Zrêczno¶ci</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Zrêczno¶æ</td></tr>
	<?php
	$tsel = mysql_query("select id, user, agility from players order by agility desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[agility]</td></tr>";
	}
	?>
	</table>
</td></tr>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej Inteligencji</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Inteligencja</td></tr>
	<?php
	$tsel = mysql_query("select id, user, inteli from players order by inteli desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[inteli]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej Wytrzyma³o¶ci</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Wytrzyma³o¶æ</td></tr>
	<?php
	$tsel = mysql_query("select id, user, wytrz from players order by wytrz desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[wytrz]</td></tr>";
	}
	?>
	</table>
</td></tr>
<tr><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwiêcej Szybko¶ci</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Szybko¶æ</td></tr>
	<?php
	$tsel = mysql_query("select id, user, szyb from players order by szyb desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[szyb]</td></tr>";
	}
	?>
	</table>
</td><td width=200>
	<table class=td width=100% cellpadding=0 cellspacing=0>
	<tr><td style="border-bottom: solid gray 1px;" align=center colspan=2><b><u>Najwy¿sza Alchemia</b></u></td></tr>
	<tr><td width=100 align=center><b><u>Imiê (ID)</td><td width=100 align=center><b><u>Alchemia</td></tr>
	<?php
	$tsel = mysql_query("select id, user, alchemia from players order by alchemia desc limit 5");
	while ($top = mysql_fetch_array($tsel)) {
		print "<tr><td>$top[user] ($top[id])</td><td>$top[alchemia]</td></tr>";
	}
	?>
	</table>
</td></tr>
</table>

<?php require_once("footer.php"); ?>
