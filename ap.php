<?php
/***************************************************************************
 *                               ap.php
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

$title = "Dystrybucja AP"; require_once("header.php"); ?><?phpif (!isset($_GET['statp'])) {        $_GET['statp'] = '';}$gr1 = mysql_fetch_array(mysql_query("select rasa, klasa, ap from players where id=$stat[id]"));if (!$_GET['statp']) {	print "Tutaj mo¿esz uzyæ AP do zwiêkszenia swoich statystyk. Po prostu kliknij w odpowiedni link. Posiadasz <b>$gr1[ap]</b> AP.<br><br>";}if (!$_GET['statp'] && $gr1['rasa'] == 'Cz³owiek' && $gr1['ap'] > 0) {	print "- <a href=ap.php?statp=strength>+4 Si³a za 1 ap</a><br>	- <a href=ap.php?statp=agility>+4 Zrêczno¶æ za 1 ap</a><br>	- <a href=ap.php?statp=szyb>+4 Szybko¶æ za 1 ap</a><br>	- <a href=ap.php?statp=wytrz>+4 Wytrzyma³o¶æ za 1 ap</a><br>";}if (!$_GET['statp'] && $gr1['rasa'] == 'Elf' && $gr1['ap'] > 0) {	print "- <a href=ap.php?statp=strength>+3 Si³a za 1 ap</a><br>	- <a href=ap.php?statp=agility>+7 Zrêczno¶æ za 1 ap</a><br>	- <a href=ap.php?statp=szyb>+7 Szybko¶æ za 1 ap</a><br>	- <a href=ap.php?statp=wytrz>+3 Wytrzyma³o¶æ za 1 ap</a><br>";}if (!$_GET['statp'] && $gr1['rasa'] == 'Krasnolud' && $gr1['ap'] > 0) {	print "- <a href=ap.php?statp=strength>+8 Si³a za 1 ap</a><br>	- <a href=ap.php?statp=agility>+3 Zrêczno¶æ za 1 ap</a><br>	- <a href=ap.php?statp=szyb>+2 Szybko¶æ za 1 ap</a><br>	- <a href=ap.php?statp=wytrz>+7 Wytrzyma³o¶æ za 1 ap</a><br>";}if (!$_GET['statp'] && $gr1['klasa'] == 'Wojownik' && $gr1['ap'] > 0) {	print "- <a href=ap.php?statp=inteli>+4 Inteligencja za 1 ap</a><br>";	print "- <a href=ap.php?statp=wisdom>+4 Si³y Woli za 1 ap</a><br><br>";}if (!$_GET['statp'] && $gr1['klasa'] == 'Mag' && $gr1['ap'] > 0) {	print "- <a href=ap.php?statp=inteli>+6 Inteligencja za 1 ap</a><br>";	print "- <a href=ap.php?statp=wisdom>+6 Si³y Woli za 1 ap</a><br><br>";}if (!$_GET['statp'] && $gr1['klasa'] == 'Obywatel' && $gr1['ap'] > 0) {	print "- <a href=ap.php?statp=inteli>+5 Inteligencja za 1 ap</a><br>";	print "- <a href=ap.php?statp=wisdom>+5 Si³y Woli za 1 ap</a><br><br>";}if ($_GET['statp'] != 'szyb' && $_GET['statp'] != 'wytrz' && $_GET['statp'] != 'strength' && $_GET['statp'] != 'agility' && $_GET['statp'] != 'inteli' && $_GET['statp'] != 'wisdom' && $_GET['statp'] != '') {	print "Zapomnij o tym";	require_once("footer.php");	exit;}if ($gr1['rasa'] == 'Cz³owiek' && $_GET['statp']) {		$gain = 4;}if ($gr1['rasa'] == 'Elf' && $_GET['statp']) {	if ($_GET['statp'] == 'wytrz' || $_GET['statp'] == 'strength') {		$gain = 3;	} else {		$gain = 7;	}}if ($gr1['rasa'] == 'Krasnolud' && $_GET['statp']) {	if ($_GET['statp'] == 'strength') {		$gain = 8;	} elseif ($_GET['statp'] == 'wytrz') {		$gain = 7;	} elseif ($_GET['statp'] == 'agility') {		$gain = 3;	} elseif ($_GET['statp'] == 'szyb') {			$gain = 2;	}}if ($gr1['klasa'] == 'Wojownik' && $_GET['statp']) {        if ($_GET['statp'] == 'inteli' || $_GET['statp'] == 'wisdom') {        	$gain = 4;        }}if ($gr1['klasa'] == 'Mag' && $_GET['statp']) {        if ($_GET['statp'] == 'inteli' || $_GET['statp'] == 'wisdom') {        	$gain = 6;        }}if ($gr1['klasa'] == 'Obywatel' && $_GET['statp']) {        if ($_GET['statp'] == 'inteli' || $_GET['statp'] == 'wisdom') {        	$gain = 5;        }}if ($_GET['statp'] && $gr1['ap'] < 1) {	print "Nie masz tylu AP!";	require_once ("footer.php");	exit;}if ($_GET['statp'] && $gr1['ap'] > 0) {	if ($_GET['statp'] == 'strength') {		$cecha='Si³y';	}	if ($_GET['statp'] == 'agility') {		$cecha='Zrêczno¶ci';	}	if ($_GET['statp'] == 'szyb') {		$cecha='Szybko¶ci';	}	if ($_GET['statp'] == 'wytrz') {		$cecha='Wytrzyma³o¶ci';	}	if ($_GET['statp'] == 'inteli') {		$cecha = 'Inteligencji';	}	if ($_GET['statp'] == 'wisdom') {	        $cecha = 'Si³y Woli';	}	mysql_query("update players set $_GET[statp]=$_GET[statp]+$gain where id=$stat[id]");	mysql_query("update players set ap=ap-1 where id=$stat[id]");	print "Zdobywasz <b>$gain $cecha</b>. Kliknij <a href=ap.php>tutaj</a> aby to rozdysponowaæ wiêcej AP.";}?><?php require_once("footer.php"); ?>