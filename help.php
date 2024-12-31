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
	print "W czym potrzebujesz pomocy? Wiem, �e jest niedoko�czona, ale jaki� pocz�tek ju� jest.<ul>
	<li><a href=historia.php>Historia �wiata</a>
	<li><a href=help.php?help=overview>Og�lne informacje</a>
	<li><a href=help.php?help=equipment>Ekwipunek</a>
	<li><a href=help.php?help=eventlog>Dziennik</a>
	<li><a href=help.php?help=indocron>Altara</a>
	<li><a href=help.php?help=battle>Walka</a>
	<li><a href=help.php?help=money>Pieni�dze</a>
	<li><a href=help.php?help=energy>Energia</a>
	<li><a href=help.php?help=faq>FAQ</a></ul>";
}

if ($_GET['help'] == 'overview') {
	print "W og�lnych informacjach znajdziesz status oraz charakterystyk� swojej postaci oraz twoje dane, podzielone na dwie cz�ci. Pierwsza cz�� obejmuje twoje charakterystyki w grze. Na samym pocz�tku pokazana jest ilo�� <b>Astralnych Punkt�w</b> - za te punkty je�eli chcesz, mo�esz podnie�� sobie jedn� z 4 cech (<b>Zdrowie, Energi�, Si��</b> lub <b>Zr�czno��</b>). <b>AP</b> zdobywasz zawsze przechodz�c na nast�pny poziom. Poni�ej znajduj� si� warto�ci twojej <b>Zr�czno�ci</b> oraz <b>Si�y</b>. Nast�pnie s� <b>Wyniki</b>. Jest to statystyka wszystkich bitew z graczami jakie stoczy�e� w grze. Zapisane s� w postaci 3 cyfr np 0/0/0. Pierwsza warto�� oznacza wygrane bitwy, druga przegrane a trzecia, bitwy ��cznie. W polu <b>Ostatnio zabity</b> jest wpisane imi� gracza jakiego ostatnio zabi�e�. W polu <b>Ostatnio zabity przez</b> wpisane jest imi� gracza, kt�ry ostatnio zabi� twoj� posta�. Obok znajduje si� sekcja <i>Informacje</i>. S� to og�lne informacje na tw�j temat. <b>Ranga</b> oznacza czy jeste� Adminem, Cz�onkiem Zespo�u (Staff) czy te� U�ytkownikiem (Member). <b>Wiek</b> to wiek twojej postaci w dniach. <b>Klan</b> informuje czy nale�ysz do jakiego� klanu, czy te� nie.";
} elseif ($_GET['help'] == 'eventlog') {
	print "W Dzienniku s� zapisane wszystkie wa�niejsze wydarzenia jakie spotka�y twoj� posta� podczas gry. S� tutaj napisane wyniki walk z innymi graczami, kupno przez kogo� wystawionego przez ciebie przedmiotu na rynku, itp. Zdarza si�, �e co� si� wydarza w momencie, kiedy nie jeste� w grze. Dlatego w�a�nie bardzo przydatny jest wtedy dziennik. Liczba w nawiasie obok dziennika oznacza ilo�� nowych wa�nych zdarze� jakie ciebie spotka�y od czasu kiedy ostatnio gra�e�.";
} elseif ($_GET['help'] == 'equipment') {
	print "W Ekwipunku mo�esz zobaczy� bro� oraz zbroje jakie posiadasz. W sekcji <b>Obecnie u�ywane przedmioty</b> napisane jest, jakiej u�ywasz broni oraz zbroi. Liczby w nawiasach oznaczaj� premi� jak� daje przedmiot do jakiej� umiej�tno�ci (np <i>br�zowy sztylet (+1)</i> oznacza, �e sztylet ten dodaje +1 do zadawanych obra�e�). Sekcje <b>Zapasowa bro�</b> oraz <b>Zapasowa zbroja</b> s� do siebie bardzo podobne i pokazuj� jakie przedmioty posiadasz przy sobie, ale ich nie u�ywasz w danej chwili. Nie u�ywane przedmioty mo�esz sprzeda� (oczywi�cie po ni�szej cenie ni� kupi�e�) lub wyekwipowa� si� w nie.";
} elseif ($_GET['help'] == 'indocron') {
	print "Altara jest stolic� �wiata Vallheru. Znajdziesz tutaj wiele interesuj�cych miejsc. Miasto jest podzielone na kilka dzielnic, w ka�dej z nich znajduj� si� r�ne interesuj�ce lokacje.<ul><li><a href=helpwojenne.php>Wojenne Pola</a></li>
	<li><a href=helpzachodni.php>Zachodnia strona</a></li>
	<li><a href=helppraca.php>Praca</a></li>
	<li><a href=helpspol.php>Spo�eczno��</a></li>
	<li><a href=helpmieszkana.php>Dzielnica mieszkalna</a></li>
	<li><a href=helppoludniowa.php>Dzielnica po�udniowa</a></li>
	<li><a href=helppodgrodzie.php>Podgrodzie</a></li>
	<li><a href=helpzamek.php>Zamek</a></li></ul>Kliknij na nazw� dzielnicy, aby zobaczy� co si� w niej znajduje.";
} elseif ($_GET['help'] == 'battle') {
	print "Walka jest g��wnym punktem gry. Im wi�cej posiadasz Zr�czno�ci, tym cz�ciej trafisz przeciwnika. Im wi�cej posiadasz Si�y, tym wi�cej obra�e� zadajesz. Opr�cz tego w grze dost�pne s� r�wnie� bronie i zbroje. Im silniejsza jest twoja bro� (pokazywana z +) tym wi�cej jest dodawane do zadawanych obra�e�. Im silniejsza jest twoja zbroja (ponownie, pokazywana z +) tym mniej obra�e� otrzymujesz podczas ataku przeciwnika. Na przyk�ad, przeciwnik ma 13 si�y a ty masz zbroj� +10. Otrzymujesz tylko 3 obra�enia. Ten, kto straci jako pierwszy wszystkie Punkty �ycia przegrywa walk�, natomiast jego przeciwnik zyskuje PD oraz sztuki z�ota za walk�. Je�eli PD przekrocz� odpowiedni� warto��, zwyci�zca zdobywa poziom.";
} elseif ($_GET['help'] == 'money') {
	print "Pieni�dze w grze, dziel� si� na dwa typy: sztuki z�ota oraz sztuki mithrilu. Sztuki z�ota s� podstawow� jednostk� monetarn� w grze i s� najcz�ciej u�ywane. Sztuki mithrilu s� znacznie rzadsze i mog� by� znalezione tylko w trzech miejscach w grze (w <b>Labiryncie</b>, mo�na je r�wnie� kupi� w <b>Sklepie z Mithrilem</b> oraz na <b>Rynku</b> od innych graczy). Mithril na razie mo�e by� u�ywany tylko do zakupu kopalni oraz do zakupu darmowego leczenia przez klan.";
} elseif ($_GET['help'] == 'energy') {
	print "Energia jest decyduj�cym wsp�czynnikiem, co mo�esz robi� w ci�gu dnia. Je�eli osi�gnie zerow� warto��, musisz poczeka� do resetu, wtedy zostanie odnowiona. Reset zdarza si� o 12 godzinie i par� razy dziennie o r�nych porach.";
} elseif ($_GET['help'] == 'faq') {
	print "Tutaj znajdziesz odpowiedzi, na najcz�ciej zadawane pytania. Je�eli chcia�by� si� czego� dowiedzie� o grze, po prostu skontaktuj si� ze mn� <a href=mailto:amandil@poczta.fm>mailem</a>, wysy�aj�c poczt� w grze, zadaj�c swoje pytanie na <b>Forum</b> lub podczas rozmowy w <b>Karczmie</b>. Najciekawsze i najcz�ciej powtarzaj�ce si� pytania zostan� tutaj umieszczone wraz z odpowiedzami.<br><br><ul><li> Jak odzyskiwa� energi�?<br>Energi� odzyskujesz podczas resetu gry. Resety zdarzaj� si� o godzinach 12 (nowy dzie� na Vallheru) oraz o 16,18,20,22 czasu gry.</li></ul>";
}

if ($_GET['help']) {
	print "<br><br>(<a href=help.php>Powr�t</a>)";
}

require_once("footer.php");
?>
