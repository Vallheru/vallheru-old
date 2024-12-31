		<table cellpadding=0 cellspacing=0 class=td width="100%">
		<tr><td bgcolor=black align=center>
			<b>Statystyki</b>
		</td></tr>
		<tr><td>
			<?php
			print "<center><b><u>$gracz[user]</u></b> ($stat[id])</center><br>";
			print "<b>Poziom:</b> $gracz[level]<br>";
			$expn = ($gracz['level'] * 200);
			$pct = (($gracz['exp']/$expn) * 100);
			$pct = round($pct,"0");
			print "<b>PD:</b> $gracz[exp]/$expn ($pct%)<br>";
			print "<b>Zdrowie:</b> $gracz[hp]/$gracz[max_hp]<br>";
			print "<b>Punkty Magii:</b> $gracz[pm]<br>";
			print "<b>Energia:</b> $gracz[energy]/$gracz[max_energy]<br><br>";
			print "<b>Z³oto:</b> $gracz[credits]<br>";
			print "<b>W banku:</b> $gracz[bank]<br>";
			print "<b>Mithril:</b> $gracz[platinum]<br>";
			$ref = mysql_num_rows(mysql_query("select id from players where refs=$stat[id]"));
			print "<b>Vallary:</b> $ref<br>";
			?>
		</td></tr>
		</table><br>
		<table cellpadding=0 cellspacing=0 class=td width="100%">
		<tr><td bgcolor=black align=center>
			<b>Nawigacja</b>
		</td></tr>
		<tr>
          <td>
			- <a href="stats.php">Statystyki</a><br>
			- <a href="zloto.php">Bogactwa</a><br>
			- <a href="equip.php">Ekwipunek</a><br>
			- <a href="czary.php">Ksiêga Czarów</a><br>
			<?php
			$numlog = mysql_num_rows(mysql_query("select * from log where unread='F' and owner=$stat[id]"));
			print "- <a href=\"log.php\">Dziennik</a> [$numlog]<br>";
			?>
			- <a href="notatnik.php">Notatnik</a><br><br>
			- <a href="city.php">Altara</a><br>
			- <a href="battle.php">Arena Walk</a><br>
			<?php
			if ($gracz['hp'] > 0) {
				$healneed = ($gracz['max_hp'] - $gracz['hp']);
			} else {
				$healneed = ($gracz['max_hp'] * $gracz['level']);
			}
			print "- <a href=\"hospital.php\">Szpital</a> [$healneed sz]<br>";
			?>
			<?php
			if ($gracz['tribe']) {
				print "- <a href=\"tribes.php?view=my\">Mój klan</a><br>";
			}
			$nieprzeczytane = mysql_num_rows(mysql_query("select * from mail where owner=$stat[id] and zapis='N'"));

			?>
			- <a href="mail.php">Poczta [<?=$nieprzeczytane?>]</a><br>
			- <a href="bank.php">Bank</a><br><br>
			- <a href="forums.php?view=categories">Forum</a><br>
			<?php
			if ($gracz['tribe'] > 0) {
				print "- <a href=\"tforums.php?view=topics\">Forum klanu</a><br>";
			}
			?>
			<?php
			$psel = mysql_query("select lpv from players where page='Chat'");
			$ctime = time();
			$numoc = 0;
			while ($pl = mysql_fetch_array($psel)) {
				$span = ($ctime - $pl['lpv']);
				if ($span <= 180) {
					$numoc = ($numoc + 1);
				}
			}
			$numoc = ($numoc + 0);
			print "- <a href=\"chat.php\">Karczma</a> [$numoc]<br><br>";
			?>
			- <a href="account.php">Opcje konta</a><br>
			<?php
			print "- <a href=\"logout.php?did=$stat[id]\">Wylogowanie</a><br>";
			?>
			- <a href="help.php">Pomoc</a><br>
			<?php
			if ($gracz['rank'] == 'Admin') {
				print "<br>- <a href=\"admin.php\">Admin</a>";
			}
			if ($gracz['rank'] == 'Staff') {
				print "<br>- <a href=\"staff.php\">Ksi±¿ê</a>";
			}
			if ($gracz['rank'] == 'Sêdzia') {
				print "<br>- <a href=\"sedzia.php\">Sêdzia</a>";
			}
			?>
		</td></tr>
		</table>
