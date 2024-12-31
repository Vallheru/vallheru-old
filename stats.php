<?php 
/***************************************************************************
 *                               stats.php
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

$title = "Statystyki";
	require_once("header.php");
$gr9 = mysql_fetch_array(mysql_query("select ap, rasa, klasa, agility, strength, inteli, pw, wins, losses, lastkilled, lastkilledby, age, logins, ability, atak, unik, magia, ip, szyb, wytrz, alchemia, gg, avatar, wisdom from players where id=$stat[id]"));
?>

Witaj w twoich statystykach. Mo¿esz tutaj zobaczyæ informacje na temat twojej postaci w grze.<br><br>
<?php
$plik = 'avatars/'.$gr9['avatar'];
if (is_file($plik)) {
	print "<center><img src=$plik height=100></center>";
}
?>
<table width=100%>
<tr><td width=50% valign=top>
	<center><b><u>Statystyki w grze</b></u></center><br>

	<?php
	if ($gr9['ap'] > 0) {
		print "<b>AP:</b> $gr9[ap] (<a href=ap.php>u¿yj</a>)<br>";
		} else {
		print "<b>AP:</b> $gr9[ap]<br>";
		}
	if ($gr9['rasa'] == '') {
		print "<b>Rasa:</b> (<a href=rasa.php>wybierz</a>)<br>";
		} else {
		print "<b>Rasa:</b> $gr9[rasa]<br>";
		}
	if ($gr9['klasa'] == '') {
		print "<b>Klasa:</b> (<a href=klasa.php>wybierz</a>)<br>";
		} else {
		print "<b>Klasa:</b> $gr9[klasa]<br>";
		}
	print "<b>Zrêczno¶æ:</b> $gr9[agility]<br>";
	print "<b>Si³a:</b> $gr9[strength]<br>";
	print "<b>Inteligencja:</b> $gr9[inteli]<br>";
	print "<b>Si³a Woli:</b> $gr9[wisdom]<br>";
	print "<b>Szybko¶æ:</b> $gr9[szyb]<br>";
	print "<b>Wytrzyma³o¶æ:</b> $gr9[wytrz]<br>";
	print "<b>Punkty Magii:</b> $gracz[pm]";
	if ($gracz['pm'] < $gr9['inteli']) {
		print " [<a href=rest.php>Odpocznij</a>]<br>";
	} else {
		print "<br>";
	}
	print "<b>Punkty Wiary:</b> $gr9[pw]<br><br>";

	$rt = ($gr9['wins'] + $gr9['losses']);
	print "<b>Wyniki:</b> $gr9[wins]/$gr9[losses]/$rt<br>";
	print "<b>Ostatnio zabity:</b> $gr9[lastkilled]<br>";
	print "<b>Ostatnio zabity przez:</b> $gr9[lastkilledby]";
	?>

</td><td width=50% valign=top>
	<center><b><u>Informacje</b></u></center><br>

	<?php
	if ($gracz['rank'] == 'Admin') {
		$ranga = 'W³adca Valheru';
	} elseif ($gracz[rank] == 'Staff') {
		$ranga = 'Ksi±¿ê Vallheru';
	} elseif ($gracz[rank] == 'Member') {
		$ranga = 'Mieszkaniec Valheru';
	} else {
		$ranga = $gracz[rank];
	}
	print "<b>Ranga:</b> $ranga<br>";
	print "<b>Lokacja:</b> $stat[miejsce]<br>";
	print "<b>Wiek:</b> $gr9[age]<br>";
	print "<b>Logowañ:</b> $gr9[logins]<br>";
	print "<b>IP:</b> $gr9[ip]<br>";
	print "<b>Email:</b> $stat[email]<br>";
	if (!empty($gr9['gg'])) {
		print "<b>Numer GG:</b> $gr9[gg]<br>";
	}
	$tribe = mysql_fetch_array(mysql_query("select name from tribes where id=$gracz[tribe]"));
	if ($tribe) {
		print "<b>Klan:</b> <a href=tribes.php?view=my>$tribe[name]</a><br>";
	} else {
		print "<b>Klan:</b> brak<br>";
	}
	?>

</td></tr><tr>
<td width=50% valign=top>
	<center><b><u>Umiejêtno¶ci</u></b></center><br>
		<?php
		print "<b>Kowalstwo:</b> $gr9[ability]<br>";
		print "<b>Alchemia:</b> $gr9[alchemia]<br>";
		print "<b>Walka broni±:</b> $gr9[atak]<br>";
		print "<b>Unik:</b> $gr9[unik]<br>";
		print "<b>Rzucanie czarów:</b> $gr9[magia]<br>";
		?>
</td></tr>
</table>
<?php require_once("footer.php"); ?>
