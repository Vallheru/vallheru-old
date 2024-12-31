<?php 
/***************************************************************************
 *                               ranking.php
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

$title = "Rankinng"; require_once("header.php"); ?>

<b><u>Najwy¿szy poziom</b></u><br>
<?php
$tsel = mysql_query("select * from players order by level desc limit 5");
while ($top = mysql_fetch_array($tsel)) {
	print "<b>$top[user]</b> jest na poziomie <b>$top[level]</b>.<br>";
}
print "<br>";
?>

<b><u>Najwiêcej sztuk z³ota</b></u><br>
<?php
$tsel = mysql_query("select * from players order by credits desc limit 5");
while ($top = mysql_fetch_array($tsel)) {
	print "<b>$top[user]</b> ma <b>$top[credits]</b> sztuk z³ota.<br>";
}
print "<br>";
?>

<b><u>Najwiêcej zwyciêstw</b></u><br>
<?php
$tsel = mysql_query("select * from players order by wins desc limit 5");
while ($top = mysql_fetch_array($tsel)) {
	print "<b>$top[user]</b> ma <b>$top[wins]</b> zwyciêstw.<br>";
}
print "<br>";
?>

<b><u>Najwiêcej Pora¿ek</b></u><br>
<?php
$tsel = mysql_query("select * from players order by losses desc limit 5");
while ($top = mysql_fetch_array($tsel)) {
	print "<b>$top[user]</b> ma <b>$top[losses]</b> pora¿ek.<br>";
}
print "<br>";
?>

<b><u>Najsilniejszy</b></u><br>
<?php
$tsel = mysql_query("select * from players order by strength desc limit 5");
while ($top = mysql_fetch_array($tsel)) {
	print "<b>$top[user]</b> ma <b>$top[strength]</b> Si³y.<br>";
}
print "<br>";
?>

<b><u>Najzwinniejszy</b></u><br>
<?php
$tsel = mysql_query("select * from players order by agility desc limit 5");
while ($top = mysql_fetch_array($tsel)) {
	print "<b>$top[user]</b> ma <b>$top[agility]</b> Zwinno¶ci.<br>";
}
print "<br>";
?>

<?php require_once("footer.php"); ?>
