<?php
/***************************************************************************
 *                               aktywacja.php
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

require_once("head.php");
if ($_GET['kod']) {
	if (!ereg("^[1-9][0-9]*$", $_GET['kod'])) {
		print "Zapomnij o tym!";
		require_once("footer.php");
		exit;
	}
	$kd = mysql_query("select * from aktywacja where aktyw=".$_GET['kod']);
	while ($akt = mysql_fetch_array($kd)) {
		if ($_GET['kod'] == $akt['aktyw']) {
			mysql_query("insert into players (user, email, pass, refs) values('".$akt['user']."','".$akt['email']."','".$akt['pass']."',".$akt['refs'].")");
			mysql_query("delete from aktywacja where aktyw=".$_GET['kod']);
			print "Twoje konto jest ju¿ aktywne.Kliknij <a href=index.php>tutaj</a> aby siê zalogowaæ.";
		}
	}
}

require_once("foot.php");
?>
