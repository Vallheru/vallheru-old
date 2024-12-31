<?php
/***************************************************************************
 *                               account.php
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
$title = "Opcje konta"; require_once("header.php"); ?>

Witaj w ustawieniach konta. Proszê, wybierz opcjê.
<ul>
<li><a href="account.php?view=name">Zmieñ imiê</a></li>
<li><a href="account.php?view=pass">Zmieñ has³o</a></li>
<li><a href="account.php?view=profile">Edytuj profil</a></li>
<li><a href="account.php?view=eci">Edytuj informacje kontaktowe</a></li>
<li><a href="account.php?view=avatar">Edytuj avatara</a></li>
</ul>

<?php
if (!isset($_GET['view'])) {
     $_GET['view'] = '';
}
if (!isset($_GET['step'])) {
     $_GET['step'] = '';
}
if ($_GET['view'] == "avatar") {
	$avatar = mysql_fetch_array(mysql_query("select avatar from players where id=$stat[id]"));
	$plik = 'avatars/'.$avatar['avatar'];
	if (is_file($plik)) {
		print "<center><img src=$plik heigth=100 width=100></center>";
	}
	print "Tutaj mo¿esz zmieniæ swojego avatara. <b>Uwaga!</b> Je¿eli ju¿ posiadasz avatara, stary zostanie skasowany. Maksymalny rozmiar avatara to 10 kB. Avatara mo¿esz za³adowaæ tylko z w³asnego komputera. Musi on mieæ rozszerzenie *.jpg, *.jpeg lub *.gif<br>";
	if (is_file($plik)) {
		print "<form action=\"account.php?view=avatar&step=usun\" method=\"post\">";
		print "<input type=hidden name=av value='$avatar[avatar]'>";
		print "<input type=submit value=Skasuj>";
		print "</form>";
	}
	print "<form enctype=\"multipart/form-data\" action=\"account.php?view=avatar&step=dodaj\" method=\"post\">";
	print "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240\">";
	print "Nazwa pliku graficznego: <input name=\"plik\" type=\"file\"><br>";
	print "<input type=submit value=\"Wy¶lij\"></form>";
	if ($_GET['step'] == 'usun') {
		$plik = 'avatars/'.$_POST['av'];
		if (is_file($plik)) {
			unlink($plik);
			mysql_query("update players set avatar='' where id=$stat[id]") or die ("nie mogê skasowaæ");
			print "Avatar usuniêty. <a href=account.php?view=avatar>Od¶wie¿</a><br>";
		} else {
			print "Nie ma takiego pliku!<br>";
			require_once("footer.php");
			exit;
		}
	}
	if ($_GET['step'] == 'dodaj') {
		$plik = $_FILES['plik']['tmp_name'];
		$nazwa = $_FILES['plik']['name'];
		$typ = $_FILES['plik']['type'];
		if ($typ != 'image/pjpeg' && $typ != 'image/jpeg' && $typ != 'image/gif') {
			print "Z³y typ pliku!";
			require_once("footer.php");
			exit;
		}
		if ($typ == 'image/pjpeg' && $typ != 'image/jpeg') {
			$liczba = rand(1,1000000);
			$newname = md5($liczba).'.jpg';
			$miejsce = 'avatars/'.$newname;
		}
		if ($typ == 'image/gif') {
			$liczba = rand(1,1000000);
			$newname = md5($liczba).'.gif';
			$miejsce = 'avatars/'.$newname;
		}
		if (is_uploaded_file($plik)) {
			if (!move_uploaded_file($plik,$miejsce)) {
				print "Nie skopiowano pliku!";
				require_once("footer.php");
				exit;
			}
		} else {
			print "Zapomij o tym";
			require_once("footer.php");
			exit;
		}
		mysql_query("update players set avatar='$newname' where id=$stat[id]") or die("nie mogê dodaæ!");
		print "Avatar za³adowany! <a href=account.php?view=avatar>Od¶wie¿</a><br>";
	}
}
if ($_GET['view'] == "name") {
	print "<form method=\"post\" action=\"account.php?view=name&step=name\">";
	print "Zmieñ moje imiê na <input type=\"text\" name=\"name\">. <input type=\"submit\" value=\"Zmieñ\">";
	print "</form>";
	if ($_GET['step'] == "name") {
		if (empty ($_POST['name'])) {
			print "Podaj imiê.";
		} else {
			$_POST['name'] = str_replace("'","",strip_tags($_POST['name']));
			if ($_POST['name'] == 'Admin' || $_POST['name'] == 'Staff') {
				print "Zapomnij o tym";
			} else {
				if (0 < mysql_num_rows(mysql_query("select id from players where user='".$_POST['name']."'"))) {
					print "To imiê jest ju¿ zajête.";
				} else {
					mysql_query("update players set user='".$_POST['name']."' where id=".$stat['id']);
					print "Zmieni³e¶ imiê na <b>".$_POST['name']."</b>.";
				}
			}
		}
	}
}
if ($_GET['view'] == "pass") {
	print 
	"Nie u¿ywaj HTML'a, ani pojedyñczego cudzys³owu. Nie próbuj go u¿ywaæ, bêdzie usuniêty.<BR>
	<form method=\"post\" action=\"account.php?view=pass&step=cp\">
	<table>
	<tr><td>Obecne has³o:</td><td><input type=\"text\" name=\"cp\"></td></tr> 
	<tr><td>Nowe has³o:</td><td><input type=\"text\" name=\"np\"></td></tr>
	<tr><td colspan=2 align=center><input type=\"submit\" value=\"Zmieñ\"></td></tr>
	</form>
	</table>";
	if ($_GET['step'] == "cp") {
		if (empty ($_POST['np'])) {
			print "Wype³nij wszystkie pola.";
			require_once("footer.php");
			exit;
			}
		if (empty ($_POST['cp'])) {
			print "Wype³nij wszystkie pola.";
			require_once("footer.php");
			exit;
			}
		$_POST['np'] = str_replace("'","",strip_tags($_POST['np']));
		$_POST['cp'] = str_replace("'","",strip_tags($_POST['cp']));
		mysql_query("UPDATE players SET pass = MD5('".$_POST['np']."') WHERE pass = MD5('".$_POST['cp']."') and id=$stat[id]");
		print "Zmieni³e¶ has³o z  ".$_POST['cp']." na ".$_POST['np'].".";	
		$_SESSION['pass']=$_POST['np'];
	}
}
if ($_GET['view'] == "profile") {
	print 
	"<form method=\"post\" action=\"account.php?view=profile&step=profile\">
	<table>
	<tr><td>Dodaj/Modyfikuj swój profil. Nie u¿ywaj html'a ani pojedyñczego cudzys³owu!</td></tr> 
	<tr><td>Nowy profil: <textarea name=\"profile\" id=\"profile\"></textarea></td></tr>
	<tr><td colspan=2 align=center><input type=\"submit\" value=\"Zapisz\"></td></tr>
	</form>
	</table>";
	if ($_GET['step'] == "profile") {
		if (empty ($_POST['profile'])) {
		print "Wype³nij wszystkie pola.";
		require_once("footer.php");
		exit;
		}
		$_POST['profile'] = str_replace("'","",strip_tags($_POST['profile']));
		mysql_query("UPDATE players SET profile = '".$_POST['profile']."' WHERE id = '".$stat['id']."'");
		print 
		"<table>
		<tr><td>Twój nowy profil:</td><td></td></tr>
		<tr><td>".$_POST['profile']."</td><tr>
		</table>";	
	}
}

if ($_GET['view'] == 'eci') {
	print
	"<form method=post action=account.php?view=eci&step=ce>
	<table>
	<tr><td>Obecny adres e-mail:</td><td><input type=\"text\" name=\"ce\"></td></tr>
	<tr><td>Nowy adres e-mail:</td><td><input type=\"text\" name=\"ne\"></td></tr>
	<tr><td colspan=2 align=\"center\"><input type=\"submit\" value=\"Zmieñ\"></td></tr>
	</form>
	</table>";
	$gg = mysql_fetch_array(mysql_query("select gg from players where id=$stat[id]"));
	if (empty($gg['gg'])) {
		$gg['gg']='';
	}
	print "<form method=post action=account.php?view=eci&step=gg>
		<table>
		<tr><td>Adres gadu-gadu:</td><td><input type=text name=gg value=$gg[gg]></td></tr>
		<tr><td colspan=2 align=center><input type=submit value=Zmieñ></td></tr>
		</form>
		</table>";
	if ($_GET['step'] == "gg") {
		if (empty($_POST['gg'])) {
			print "Podaj numer gg";
			require_once("footer.php");
			exit;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['gg'])) {
			print "Zapomnij o tym";
			require_once("footer.php");
			exit;
		}
		$dupe2 = mysql_num_rows(mysql_query("select id from players where gg='".$_POST['gg']."'"));
		if ($dupe2 > 0) {
			print "Kto¶ ju¿ posiada taki adres gadu-gadu.";
			require_once("footer.php");
			exit;
		}
		mysql_query("update players set gg=$_POST[gg] where id=$stat[id]") or die ("Nie mogê dodaæ");
		print "Zmieni³e¶ numer gadu-gadu na $_POST[gg]<br>";
	}
	if ($_GET['step'] == "ce") {
		{
		if (empty ($_POST["ne"])) {
		print "Wype³nij wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	if (empty ($_POST["ce"])) {
		print "Wype³nij wszystkie pola.";
		require_once("footer.php");
		exit;
	}
	$dupe2 = mysql_num_rows(mysql_query("select id from players where email='".$_POST['ne']."'"));
	if ($dupe2 > 0) {
		print "Kto¶ ju¿ posiada taki adres email.";
		require_once("footer.php");
		exit;
	}
		mysql_query("UPDATE players SET email = '".$_POST['ne']."' WHERE email = '".$_POST['ce']."' and id = '".$stat['id']."'") or print "Z³y mail";
		print "Zmieni³e¶ adres e-mail z ".$_POST['ce']." na ".$_POST['ne'].". Zamknij to okno przegl±darki i zaloguj siê ponownie.";
	}
}
}
?>

<?php require_once("footer.php"); ?>
