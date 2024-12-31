<?php
/***************************************************************************
 *                               help.php
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

 $title = "Pomoc"; require_once("header.php"); ?>

<?php
if (!isset($_GET['help'])) {
     $_GET['help'] = '';
}
if (!$_GET['help']) {
	print "W czym potrzebujesz pomocy? Wiem, ¿e jest niedokoñczona, ale jaki¶ pocz±tek ju¿ jest.<ul>
	<li><a href=historia.php>Historia ¶wiata</a>
	<li><a href=help.php?help=overview>Ogólne informacje</a>
	<li><a href=help.php?help=equipment>Ekwipunek</a>
	<li><a href=help.php?help=eventlog>Dziennik</a>
	<li><a href=help.php?help=indocron>Altara</a>
	<li><a href=help.php?help=battle>Walka</a>
	<li><a href=help.php?help=money>Pieni±dze</a>
	<li><a href=help.php?help=energy>Energia</a>
	<li><a href=help.php?help=faq>FAQ</a></ul>";
}

if ($_GET['help'] == 'overview') {
	print "W ogólnych informacjach znajdziesz status oraz charakterystykê swojej postaci oraz twoje dane, podzielone na dwie czê¶ci. Pierwsza czê¶æ obejmuje twoje charakterystyki w grze. Na samym pocz±tku pokazana jest ilo¶æ <b>Astralnych Punktów</b> - za te punkty je¿eli chcesz, mo¿esz podnie¶æ sobie jedn± z 4 cech (<b>Zdrowie, Energiê, Si³ê</b> lub <b>Zrêczno¶æ</b>). <b>AP</b> zdobywasz zawsze przechodz±c na nastêpny poziom. Poni¿ej znajduj± siê warto¶ci twojej <b>Zrêczno¶ci</b> oraz <b>Si³y</b>. Nastêpnie s± <b>Wyniki</b>. Jest to statystyka wszystkich bitew z graczami jakie stoczy³e¶ w grze. Zapisane s± w postaci 3 cyfr np 0/0/0. Pierwsza warto¶æ oznacza wygrane bitwy, druga przegrane a trzecia, bitwy ³±cznie. W polu <b>Ostatnio zabity</b> jest wpisane imiê gracza jakiego ostatnio zabi³e¶. W polu <b>Ostatnio zabity przez</b> wpisane jest imiê gracza, który ostatnio zabi³ twoj± postaæ. Obok znajduje siê sekcja <i>Informacje</i>. S± to ogólne informacje na twój temat. <b>Ranga</b> oznacza czy jeste¶ Adminem, Cz³onkiem Zespo³u (Staff) czy te¿ U¿ytkownikiem (Member). <b>Wiek</b> to wiek twojej postaci w dniach. <b>Klan</b> informuje czy nale¿ysz do jakiego¶ klanu, czy te¿ nie.";
} elseif ($_GET['help'] == 'eventlog') {
	print "W Dzienniku s± zapisane wszystkie wa¿niejsze wydarzenia jakie spotka³y twoj± postaæ podczas gry. S± tutaj napisane wyniki walk z innymi graczami, kupno przez kogo¶ wystawionego przez ciebie przedmiotu na rynku, itp. Zdarza siê, ¿e co¶ siê wydarza w momencie, kiedy nie jeste¶ w grze. Dlatego w³a¶nie bardzo przydatny jest wtedy dziennik. Liczba w nawiasie obok dziennika oznacza ilo¶æ nowych wa¿nych zdarzeñ jakie ciebie spotka³y od czasu kiedy ostatnio gra³e¶.";
} elseif ($_GET['help'] == 'equipment') {
	print "W Ekwipunku mo¿esz zobaczyæ broñ oraz zbroje jakie posiadasz. W sekcji <b>Obecnie u¿ywane przedmioty</b> napisane jest, jakiej u¿ywasz broni oraz zbroi. Liczby w nawiasach oznaczaj± premiê jak± daje przedmiot do jakiej¶ umiejêtno¶ci (np <i>br±zowy sztylet (+1)</i> oznacza, ¿e sztylet ten dodaje +1 do zadawanych obra¿eñ). Sekcje <b>Zapasowa broñ</b> oraz <b>Zapasowa zbroja</b> s± do siebie bardzo podobne i pokazuj± jakie przedmioty posiadasz przy sobie, ale ich nie u¿ywasz w danej chwili. Nie u¿ywane przedmioty mo¿esz sprzedaæ (oczywi¶cie po ni¿szej cenie ni¿ kupi³e¶) lub wyekwipowaæ siê w nie.";
} elseif ($_GET['help'] == 'indocron') {
	print "Altara jest stolic± ¶wiata Vallheru. Znajdziesz tutaj wiele interesuj±cych miejsc. Miasto jest podzielone na kilka dzielnic, w ka¿dej z nich znajduj± siê ró¿ne interesuj±ce lokacje.<ul><li><a href=helpwojenne.php>Wojenne Pola</a></li>
	<li><a href=helpzachodni.php>Zachodnia strona</a></li>
	<li><a href=helppraca.php>Praca</a></li>
	<li><a href=helpspol.php>Spo³eczno¶æ</a></li>
	<li><a href=helpmieszkana.php>Dzielnica mieszkalna</a></li>
	<li><a href=helppoludniowa.php>Dzielnica po³udniowa</a></li>
	<li><a href=helppodgrodzie.php>Podgrodzie</a></li>
	<li><a href=helpzamek.php>Zamek</a></li></ul>Kliknij na nazwê dzielnicy, aby zobaczyæ co siê w niej znajduje.";
} elseif ($_GET['help'] == 'battle') {
	print "Walka jest g³ównym punktem gry. Im wiêcej posiadasz Zrêczno¶ci, tym czê¶ciej trafisz przeciwnika. Im wiêcej posiadasz Si³y, tym wiêcej obra¿eñ zadajesz. Oprócz tego w grze dostêpne s± równie¿ bronie i zbroje. Im silniejsza jest twoja broñ (pokazywana z +) tym wiêcej jest dodawane do zadawanych obra¿eñ. Im silniejsza jest twoja zbroja (ponownie, pokazywana z +) tym mniej obra¿eñ otrzymujesz podczas ataku przeciwnika. Na przyk³ad, przeciwnik ma 13 si³y a ty masz zbrojê +10. Otrzymujesz tylko 3 obra¿enia. Ten, kto straci jako pierwszy wszystkie Punkty ¯ycia przegrywa walkê, natomiast jego przeciwnik zyskuje PD oraz sztuki z³ota za walkê. Je¿eli PD przekrocz± odpowiedni± warto¶æ, zwyciêzca zdobywa poziom.";
} elseif ($_GET['help'] == 'money') {
	print "Pieni±dze w grze, dziel± siê na dwa typy: sztuki z³ota oraz sztuki mithrilu. Sztuki z³ota s± podstawow± jednostk± monetarn± w grze i s± najczê¶ciej u¿ywane. Sztuki mithrilu s± znacznie rzadsze i mog± byæ znalezione tylko w trzech miejscach w grze (w <b>Labiryncie</b>, mo¿na je równie¿ kupiæ w <b>Sklepie z Mithrilem</b> oraz na <b>Rynku</b> od innych graczy). Mithril na razie mo¿e byæ u¿ywany tylko do zakupu kopalni oraz do zakupu darmowego leczenia przez klan.";
} elseif ($_GET['help'] == 'energy') {
	print "Energia jest decyduj±cym wspó³czynnikiem, co mo¿esz robiæ w ci±gu dnia. Je¿eli osi±gnie zerow± warto¶æ, musisz poczekaæ do resetu, wtedy zostanie odnowiona. Reset zdarza siê o 12 godzinie i parê razy dziennie o ró¿nych porach.";
} elseif ($_GET['help'] == 'faq') {
	print "Tutaj znajdziesz odpowiedzi, na najczê¶ciej zadawane pytania. Je¿eli chcia³by¶ siê czego¶ dowiedzieæ o grze, po prostu skontaktuj siê ze mn± <a href=mailto:amandil@poczta.fm>mailem</a>, wysy³aj±c pocztê w grze, zadaj±c swoje pytanie na <b>Forum</b> lub podczas rozmowy w <b>Karczmie</b>. Najciekawsze i najczê¶ciej powtarzaj±ce siê pytania zostan± tutaj umieszczone wraz z odpowiedzami.<br><br><ul><li> Jak odzyskiwaæ energiê?<br>Energiê odzyskujesz podczas resetu gry. Resety zdarzaj± siê o godzinach 12 (nowy dzieñ na Vallheru) oraz o 16,18,20,22 czasu gry.</li></ul>";
}

if ($_GET['help']) {
	print "<br><br>(<a href=help.php>Powrót</a>)";
}

require_once("footer.php");
?>
