<?php 
/***************************************************************************
 *                               helpspol.php
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
	print "W dziale <b>Spo�eczno��</b> znajdziesz r�ne iformacje na temat spo�eczno�ci w grze. Opr�cz tego, tutaj znajduj� si� miejsca, gdzie mo�esz porozmawia� z innymi graczmi oraz klany graczy. Je�eli chcesz si� dowiedzie� wi�cej na jaki� temat, po prostu kliknij na interesuj�c� ciebie rzecz.<ul>
	<li><a href=helpspol.php?help=plotki>Plotki</a>
	<li><a href=helpspol.php?help=forum>Forum</a>
	<li><a href=helpspol.php?help=karczma>Karczma</a>
	<li><a href=helpspol.php?help=poczta>Poczta</a>
	<li><a href=helpspol.php?help=klany>Klany</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powr�t</a>)";
}

if ($_GET['help'] == 'plotki') {
	print "Miejskie Plotki, to miejsce gdzie znajdziesz r�ne informacje z �ycia spo�eczno�ci Vallheru, takie jak promocje graczy na wy�sze rangi, og�oszenia o konkursach, kary dla oszust�w oraz tym podobne informacje.";
} elseif ($_GET['help'] == 'forum') {
	print "Na Forum mo�esz wymiena� si� pogl�dami z innymi cz�onkami spo�eczno�ci. Na stronie jest pokazane s� tematy ich autorzy oraz ilo�� odpowiedzi. Je�eli chcesz zacz�� now� dyskusj�, napisz nazw� tematu oraz swoj� wypowied�. Je�eli ineteresuje ciebie jaki� temat po prostu kliknij na niego. B�dziesz m�g� wtedy przeczyta� wszystkie wypowiedzi innych jakie zamieszczone s� w tym temacie. Na ko�cu znajduje si� formularz w kt�rym mo�esz napisa� odpowied� na dany temat. Odno�nik do Forum znajduje si� r�wnie� w menu <i>Nawigacja</i>";
} elseif ($_GET['help'] == 'karczma') {
	print "Karczma to po prostu czat, na kt�rym mo�esz porozmawia� z innymi graczami. Co jaki� czas to co znajduje si� w czacie jest usuwane. Mo�esz tutaj rozmawia� na dowolne tematy (opcja szepnij na razie nie jest aktywna). Je�eli chcesz odpowiedzie� komu�, po prostu wpisz swoj� wiadomo�� w polu u g�ry ekranu i naci�nij Enter lub klawisz Wy�lij. Obok pola znajduje si� opcja od�wie�ania czata (<b>od�wie�</b>). Na dole ekranu mo�esz zobaczy�, kto jest na czacie, ile jest wypowiedzi na nim oraz liczb� graczy na czacie. Opcje na dole ekranu s� chwilowo nie aktywne. Sam czat posiada opcj� automatycznego od�wie�ania. Odno�nik do Karczmy znajduje si� r�wnie� w menu <i>Nawigacja</i>, tutaj obok odno�nika znajduje si� r�wnie� informacja, ilu obecnie jest graczy na czacie (je�eli jeste� na czacie, to liczone s� wszystkie osoby opr�cz ciebie)";
} elseif ($_GET['help'] == 'poczta') {
	print "Poczta jest to twoja wewn�trzna skrzynka pocztowa w grze. Mo�esz tutaj wysy�a� informacje do innych graczy. Opcja <b>Skrzynka</b> zaprowadzi ci� do twojej skrzynki pocztowej. Tutaj zobaczysz wszystkie listy jakie posiadasz. W tabeli jest podane od kogo jest dany list, numer nadawcy w grze, temat listu oraz opcja <b>czytaj</b> - czyli po prostu przeczytanie danego listu. Podczas czytania listu, masz r�wnie� mo�liwo�� odpowiedzenia na niego, przy pomocy opcji <b>Odpisz</b>. Na dole znajduj� si� dodatkowe opcje: <b>Wyczy�� skrzynk�</b> - usuwa wszystkie listy jakie posiadasz w skrzynce, <b>Napisz</b> napisz list do kogo� (ta opcja znajduje si� r�wnie� na g��wnym ekranie skrzynki). Aby napisa� do kogo� list (b�d� odpowiedzie� na czyj� list). Musisz wype�ni� odpowiednie pola: <i>Do (ID Numer)</i> tutaj musisz wpisa� numer (nie imi�, tylko numer) osoby, do kt�rej chcesz wys�a� list. <i>Temat:</i> - po prostu temat wiadomo�ci. W polu <i>Tre��</i> wpisz po prostu tre�� listu. Aby wys�a� list, kliknij przycisk Wy�lij. Za ka�dym razem, kiedy dostaniesz jaki� list od kogo�, zostaniesz o tym powiadomiony w <b>Dzienniku</b>.";
} elseif ($_GET['help'] == 'klany') {
	print "Znajduje si� wszystko na temat klan�w b�d�cych w grze. S� dost�pne trzy opcje. 1.Opcja <b>M�j Klan</b> jest dost�pna tylko dla cz�onk�w dowolnego klanu. Na g��wnym ekranie mo�esz zobaczy� nazw� swojego klanu, liczb� cz�onk�w, przyw�dc�, drugiego przyw�dc� (zast�pnc� przyw�dcy klanu), ile sztuk z�ota posiada klan oraz ile mithrilu posiada klan. Na dole znajduje si� menu z opcjami: <b>G��wna</b> - jest to strona z informacjami na temat klanu. <b>Dotuj</b> tutaj mo�esz da� sztuki z�ota lub mithril dla klanu. Aby dotowa� klan, po prostu wpisz ile oraz wybierz co chcesz da� klanowi (sztuki z�ota lub mithril) a nast�pnie kliknij przycisk Dotuj. Twoje pieni�dze zostan� przekazane na konto klanu. Mo�esz da� tylko tyle sztuk z�ota ile w danym momencie posiadasz przy sobie. Opcja <b>Cz�onkowie</b> pozwala ci zobaczy�, kto nale�y do klanu. Wy�wietla imi� oraz numer (ID) cz�onka oraz pozycj� w klanie (Przyw�dca, Drugi Przyw�dca). Klikaj�c na imi�, mo�esz dowiedzie� si� czego� wi�cej na temat danego cz�onka klanu. Opcja <b>Opu�� klan</b> pozwala ci odej�� z klanu. Je�eli odejdziesz z klanu, nie b�dziesz mia� dost�pu do specjalnych opcji klanu. Je�eli odejdzie Drugi Przyw�dca, stanowisko to, zwolni si�, natomiast, je�eli odejdzie Przyw�dca, ca�y klan zostanie zlikwidowany a wszystkie pieni�dze klanu przepadn�. Opcja <b>Opcje Przyw�dcy</b> jest dost�pna tylko dla Przyw�dcy oraz Drugiego Przyw�dcy klanu. Tutaj mo�na <b>Edytowa� wiadomo��</b> - mo�esz wys�a� list albo do wszystich graczy (opcja <b>Publiczna Wiadomo��</b>, albo tylko do cz�onk�w klanu (<b>Prywatna Wiadomo��</b>. Wysy�anie Wiadomo�ci wygl�da tak samo jak wysy�anie zwyk�ego listu. Kolejn� opcj� jest <b>Wyrzu� Cz�onka</b> - tutaj mo�esz usun�� kogo� z klanu - po prostu wpisz jego ID (numer, nie imi�). Nie mo�na w ten spos�b usun�� Przyw�dcy klanu. Opcja <b>Zaci�gnij Po�yczk�</b> pozwala da� jakiemu� cz�onkowi klanu cz�� sztuk z�ota lub mithrilu ze skarbca klanu. Je�eli chcesz komu� udzieli� po�yczki, po prostu wpisz jego ID (numer, nie imi�), ilo�� oraz rodzaj pieni�dzy (sztuki mithrilu lub z�ota) a nast�pnie wci�nij klawisz <i>Po�ycz</i>. Kolejn� opcj� jest <b>Zmiana has�a do klanu</b> - zmieniasz tutaj has�o dost�pu do klanu. Has�o jest wa�ne dla nowych cz�onk�w (musz� je zna�, aby m�c do��czy� do klanu. Aby zmieni� has�o, najpierw wpisz stare has�o, a nast�pnie nowe oraz wci�nij przycisk <i>Zmie�</i>. Opcja <b>Ustawi� Drugiego Przyw�dc�</b> pozwala Przyw�dcy klanu ustawi�, kto ma by� jego zast�pc�. Aby to zrobi�, po prostu wpisz ID (numer, nie imi�) cz�onka klanu oraz kliknij przycisk <i>Ustaw</i>. Drugi Przyw�dca b�dzie mia� prawie takie same uprawnienia jak Przyw�dca klanu. Opcja <b>Dodatki klanu</b> pozwala zakupi� klanowi darmowe leczenie w szpitalu - ka�dy cz�onek klanu, b�dzie leczy� si� za darmo w szpitalu. Opcja ta kosztuje 100 sztuk mithrilu.<br>2.Kolejn� opcj� na g�ownym ekranie jest opcja <b>Stw�rz nowy klan</b> - aby stworzy� nowy klan, musisz posiada� przy sobie 25000 sztuk z�ota. Je�eli je posiada�, to wpisz w odpowiednie pola, nazw� klanu oraz has�o do klanu (jest niezb�dne dla nowych cz�onk�w), a nast�pnie kliknij przycisk <i>Za��</i>. Od tego momentu istnieje tw�j klan, a ty jeste� jego Przyw�dc�.<br>3.Opcj� dost�pn� dla wszystkich jest opcja <b>Zobacz list� klan�w</b>. Tutaj mo�esz zobaczy� list� wszystkich klan�w jakie s� w grze. Na li�cie jest nazwa klanu oraz ID (numer) przyw�dcy. Klikaj�c na nazw� klanu mo�esz zobaczy� dodatkowe informacje oraz do��czy� do klanu. Aby do��czy� do klanu, kliknij przycisk <i>Do��cz</i> a nast�pnie wpisa� has�o do klanu (has�o mo�esz otrzyma� od Przyw�dcy klanu lub Drugiego przyw�dcy). Potem ju� tylko wci�nij przycisk <i>Do��cz</i> i od tej pory jeste� cz�onkie danego klanu.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpspol.php>Powr�t</a>)";
}

require_once("footer.php");
?>
