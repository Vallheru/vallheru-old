	</td></tr>
	</table>
	</td><td width="150" valign=top>
		<table cellpadding=0 cellspacing=0 class=td width="100%">
		<tr><td bgcolor=black align=center>
			<b>Statystyki gry</b>
		</td></tr>
		<tr><td>
			<?php
			$query = mysql_query("select lpv, rank, id, user from players");
			$nump = mysql_num_rows($query);
			$ctime = time();
			$numo = 0;
			print "<ul>";
			print "<li>Lista graczy w grze:<br>";
			while ($pl = mysql_fetch_array($query)) {
				$span = ($ctime - $pl['lpv']);
				if ($span <= 180) {
                                    if ($pl['rank'] == 'Admin') {
			                print "<img src=\"images/admin.gif\" ALT=\"Admin!\"><A href=\"view.php?view=".$pl['id']."\">".$pl['user']."</a> (".$pl['id'].")<br>";
   		                    } else {
			                print "<A href=\"view.php?view=".$pl['id']."\">".$pl['user']."</a> (".$pl['id'].")<br>";
		                    }
				    $numo = ($numo + 1);
                                }
                        }
                        print "</li>";
			print "<li><b>".$nump."</b> zarejestrowanych graczy.</li>";
			print "<li><b>".$numo."</b> graczy w grze.</li>";
                        print "</ul>";
			?>
		</td></tr>
		</table>
</TD></TR>
</TABLE>
</center>
<!--          (C) 2004 Bartek "Thindil" Jasicki                                        -->
<!--           gra powsta³a na podstawie kodu Gammers Fusion wersja 2.5                -->
</body>
</html>
