<?php 
/***************************************************************************
 *                               view.php
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

$title = "Zobacz"; require_once("header.php"); ?>

<?php
$gr12 = mysql_fetch_array(mysql_query("select immu from players where id=$stat[id]"));
if (!ereg("^[1-9][0-9]*$", $_GET['view'])) {
	print "Zapomnij o tym!";
	require_once("footer.php");
	exit;
}
$view = mysql_fetch_array(mysql_query("select id, user, rank, miejsce, immu, page, age, rasa, klasa, level, hp, max_hp, wins, losses, tribe, lastkilled, lastkilledby, profile, gg, avatar from players where id=$_GET[view]"));
if (empty ($view['id'])) {
	print "Nie ma gracza.";
	require_once("footer.php");
	exit;
}
print "<center><b><u>$view[user]</b></u> ($view[id])</center><br>";
$plik = 'avatars/'.$view['avatar'];
if (is_file($plik)) {
	print "<center><img src=$plik height=100></center>";
}
if (!empty($view['gg'])) {
	print "Numer Gadu-Gadu: <a href=gg:$view[gg]>$view[gg]</a><br>";
}
if ($view['rank'] == 'Admin') {
	$ranga = 'W³adca Vallheru';
} elseif ($view['rank'] == 'Staff') {
	$ranga = 'Ksi±¿ê Vallheru';
} elseif ($view['rank'] == 'Member') {
	$ranga = 'Mieszkaniec Vallheru';
} else {
	$ranga = $view['rank'];
}
print "Ranga: $ranga<br>";
print "Lokacja: $view[miejsce]<br>";
if ($view['immu'] == 'Y') {
	print "Posiada immunitet<br>";
}
print "Ostatnio widziany: $view[page]<br>";
print "Wiek: $view[age]<br>";
print "Rasa: $view[rasa]<br>";
print "Klasa: $view[klasa]<br>";
print "Poziom: $view[level]<br>";
if ($view['hp'] > 0) {
	print "Status: ¯ywy<br>";
} else {
	print "Status: <b>Martwy</b><br>";
}
$tribe = mysql_fetch_array(mysql_query("select name from tribes where id=$view[tribe]"));
if ($tribe) {
	print "Klan: <a href=tribes.php?view=view&id=$view[tribe]>$tribe[name]</a><br>";
} else {
	print "Klan: brak<br>";
}
print "Maksymalne P¯: $view[max_hp]<br><br>";
print "Wyniki: $view[wins]/$view[losses]<br>";
print "Ostatnio zabi³: $view[lastkilled]<br>";
print "Ostatnio zabity przez: $view[lastkilledby]<br>";
$ref = mysql_num_rows(mysql_query("select id from players where refs=$view[id]"));
print "Vallary: $ref<br>";
print "Profil:<br>$view[profile]<br><br>";
print "Opcje:<br>";
print "<ul>";
if ($stat['miejsce'] == $view['miejsce'] && $view['immu'] == 'N' && $gr12['immu'] == 'N' && $stat['id'] != $view['id']) {
	print "<li><a href=battle.php?battle=$view[id]>Atak</a></li>";
}
if ($stat['id'] != $view['id']) {
	print "<li><a href=mail.php?view=write&to=$view[id]>Napisz wiadomo¶æ</a></li>";
}
print "</ul>";
?>

<?php require_once("footer.php"); ?>
