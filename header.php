<?php 
/***************************************************************************
 *                               header.php
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

require_once("config.php"); ?>
<?php

if (empty($_SESSION['email']) || empty($_SESSION['pass'])) {
	print "Sesja zakoñczona.";
	exit;
}

$stat = mysql_fetch_array(mysql_query("select id, lpv, page, data, email, miejsce from players where email='".$_SESSION['email']."' and pass=MD5('".$_SESSION['pass']."')"));echo(mysql_error());
$gracz = mysql_fetch_array(mysql_query("select user, level, exp, hp, max_hp, energy, max_energy, credits, bank, platinum, tribe, rank, pm from players where id=".$stat['id']));

if (empty ($stat['id'])) {
	print "Z³y login.";
	exit;
}


$ctime = time();
$data = date("y-m-d");
mysql_query("update players set lpv=$ctime where id=$stat[id]");
$ip = $_SERVER['REMOTE_ADDR'];
$title = strip_tags($title);
mysql_query("update players set ip='".$ip."' where id=".$stat['id']);
mysql_query("update players set page='".$title."' where id=".$stat['id']);
mysql_query("update players set data='".$data."' where id=".$stat['id']);
if ($stat['email'] == 'mietek_rulez@o2.pl' || $stat['email'] == 'tnkywe@gazeta.pl' || $stat['email'] == 'neorulez@o2.pl' || $stat['email'] == 'tnkywe2@gazeta.pl') {
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title>Vallheru :: <?=$title?></title>
<link rel="stylesheet" href="style.css">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-2">
</head>

<body onload="window.status='Vallheru'">

<center>

<table width="700" class=td cellpadding=0 cellspacing=0>
<tr><td COLSPAN=3 valign=top align=center bgcolor=black>
	<b>Czas w Grze:</b> <?=date("H:i:s")?> <b>Vallheru</b>
</td></tr>
<tr><td valign=top>
<?php
if ($stat['miejsce'] == 'Altara') {
	require_once("menu.php");
}
if ($stat['miejsce'] == 'Góry') {
	require_once("menug.php");
}
?>
</td><td width=400 valign=top>
	<table cellpadding=0 cellspacing=0 class=td width="100%">
	<tr><td style="border-bottom: solid black 1px;" bgcolor=black align=center>
			<?php print "<b>$title</b>" ?>
	</td></tr>
	<tr><td>
