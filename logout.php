<?php
/***************************************************************************
 *                               logout.php
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

require_once ("config.php");
require_once ("head1.php");
if (!ereg("^[1-9][0-9]*$", $_GET['did'])) {
	print "Zapomnij o tym!";
	require_once("foot.php");
	exit;
}
$stat = mysql_fetch_array(mysql_query("select id from players where email='".$_SESSION['email']."' and pass=MD5('".$_SESSION['pass']."')"));
if ($stat['id'] != $_GET['did']) {
	print "Zapomnij o tym!";
	require_once("foot.php");
	exit;
}
mysql_query("update players set lpv=lpv-180 where id=$_GET[did]");
session_unset();
session_destroy();
print "Jeste¶ wylogowany. Kliknij <a href=index.php>tutaj</a> aby wróciæ do strony g³ównej.";
require_once("foot.php");
?>
