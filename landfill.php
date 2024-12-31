<?php 
/***************************************************************************
 *                               landfill.php
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

$title = "Oczyszczanie miasta"; require_once("header.php"); ?>

<?php
if ($stat['miejsce'] != 'Altara') {
	print "Zapomnij o tym";
	require_once("footer.php");
	exit;
}
if ($gracz['hp'] == 0) {
	print "Nie mo¿esz sprz±taæ miasta, poniewa¿ jeste¶ martwy!";
	require_once("footer.php");
	exit;
}
if (!isset($_GET['action'])) {
	$gain = ($gracz['level'] * 25);
	print "Pragniesz zarobiæ nieco sztuk z³ota? W porz±dku. Za ka¿dy worek ¶mieci jakie uprz±tniesz, dam ci <b>$gain</b> sztuk z³ota.<br><br>[<A href=landfill.php?action=work>OK</a>.]";
} else {
	if ($gracz['energy'] < 1) {
		print "Nie masz energii aby pracowaæ.";
		require_once("footer.php");
		exit;
	}
	$gain = ($gracz['level'] * 25);
	mysql_query("update players set energy=energy-1 where id=$stat[id]");
	mysql_query("update players set credits=credits+$gain where id=$stat[id]");
	print "Podczas pracy zu¿y³e¶ <b>1</b> punkt energii i zarobi³e¶ <b>$gain</b> sztuk z³ota.";
	print "<br>[<a href=landfill.php?action=work>Pracuj dalej</a>]";
}

require_once("footer.php");
?>
