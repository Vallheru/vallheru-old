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
	print "W dziale <b>Spo³eczno¶æ</b> znajdziesz ró¿ne iformacje na temat spo³eczno¶ci w grze. Oprócz tego, tutaj znajduj± siê miejsca, gdzie mo¿esz porozmawiaæ z innymi graczmi oraz klany graczy. Je¿eli chcesz siê dowiedzieæ wiêcej na jaki¶ temat, po prostu kliknij na interesuj±c± ciebie rzecz.<ul>
	<li><a href=helpspol.php?help=plotki>Plotki</a>
	<li><a href=helpspol.php?help=forum>Forum</a>
	<li><a href=helpspol.php?help=karczma>Karczma</a>
	<li><a href=helpspol.php?help=poczta>Poczta</a>
	<li><a href=helpspol.php?help=klany>Klany</a></ul>
	<br><br>(<a href=help.php?help=indocron>Powrót</a>)";
}

if ($_GET['help'] == 'plotki') {
	print "Miejskie Plotki, to miejsce gdzie znajdziesz ró¿ne informacje z ¿ycia spo³eczno¶ci Vallheru, takie jak promocje graczy na wy¿sze rangi, og³oszenia o konkursach, kary dla oszustów oraz tym podobne informacje.";
} elseif ($_GET['help'] == 'forum') {
	print "Na Forum mo¿esz wymienaæ siê pogl±dami z innymi cz³onkami spo³eczno¶ci. Na stronie jest pokazane s± tematy ich autorzy oraz ilo¶æ odpowiedzi. Je¿eli chcesz zacz±æ now± dyskusjê, napisz nazwê tematu oraz swoj± wypowied¼. Je¿eli ineteresuje ciebie jaki¶ temat po prostu kliknij na niego. Bêdziesz móg³ wtedy przeczytaæ wszystkie wypowiedzi innych jakie zamieszczone s± w tym temacie. Na koñcu znajduje siê formularz w którym mo¿esz napisaæ odpowied¼ na dany temat. Odno¶nik do Forum znajduje siê równie¿ w menu <i>Nawigacja</i>";
} elseif ($_GET['help'] == 'karczma') {
	print "Karczma to po prostu czat, na którym mo¿esz porozmawiaæ z innymi graczami. Co jaki¶ czas to co znajduje siê w czacie jest usuwane. Mo¿esz tutaj rozmawiaæ na dowolne tematy (opcja szepnij na razie nie jest aktywna). Je¿eli chcesz odpowiedzieæ komu¶, po prostu wpisz swoj± wiadomo¶æ w polu u góry ekranu i naci¶nij Enter lub klawisz Wy¶lij. Obok pola znajduje siê opcja od¶wie¿ania czata (<b>od¶wie¿</b>). Na dole ekranu mo¿esz zobaczyæ, kto jest na czacie, ile jest wypowiedzi na nim oraz liczbê graczy na czacie. Opcje na dole ekranu s± chwilowo nie aktywne. Sam czat posiada opcjê automatycznego od¶wie¿ania. Odno¶nik do Karczmy znajduje siê równie¿ w menu <i>Nawigacja</i>, tutaj obok odno¶nika znajduje siê równie¿ informacja, ilu obecnie jest graczy na czacie (je¿eli jeste¶ na czacie, to liczone s± wszystkie osoby oprócz ciebie)";
} elseif ($_GET['help'] == 'poczta') {
	print "Poczta jest to twoja wewnêtrzna skrzynka pocztowa w grze. Mo¿esz tutaj wysy³aæ informacje do innych graczy. Opcja <b>Skrzynka</b> zaprowadzi ciê do twojej skrzynki pocztowej. Tutaj zobaczysz wszystkie listy jakie posiadasz. W tabeli jest podane od kogo jest dany list, numer nadawcy w grze, temat listu oraz opcja <b>czytaj</b> - czyli po prostu przeczytanie danego listu. Podczas czytania listu, masz równie¿ mo¿liwo¶æ odpowiedzenia na niego, przy pomocy opcji <b>Odpisz</b>. Na dole znajduj± siê dodatkowe opcje: <b>Wyczy¶æ skrzynkê</b> - usuwa wszystkie listy jakie posiadasz w skrzynce, <b>Napisz</b> napisz list do kogo¶ (ta opcja znajduje siê równie¿ na g³ównym ekranie skrzynki). Aby napisaæ do kogo¶ list (b±d¼ odpowiedzieæ na czyj¶ list). Musisz wype³niæ odpowiednie pola: <i>Do (ID Numer)</i> tutaj musisz wpisaæ numer (nie imiê, tylko numer) osoby, do której chcesz wys³aæ list. <i>Temat:</i> - po prostu temat wiadomo¶ci. W polu <i>Tre¶æ</i> wpisz po prostu tre¶æ listu. Aby wys³aæ list, kliknij przycisk Wy¶lij. Za ka¿dym razem, kiedy dostaniesz jaki¶ list od kogo¶, zostaniesz o tym powiadomiony w <b>Dzienniku</b>.";
} elseif ($_GET['help'] == 'klany') {
	print "Znajduje siê wszystko na temat klanów bêd±cych w grze. S± dostêpne trzy opcje. 1.Opcja <b>Mój Klan</b> jest dostêpna tylko dla cz³onków dowolnego klanu. Na g³ównym ekranie mo¿esz zobaczyæ nazwê swojego klanu, liczbê cz³onków, przywódcê, drugiego przywódcê (zastêpncê przywódcy klanu), ile sztuk z³ota posiada klan oraz ile mithrilu posiada klan. Na dole znajduje siê menu z opcjami: <b>G³ówna</b> - jest to strona z informacjami na temat klanu. <b>Dotuj</b> tutaj mo¿esz daæ sztuki z³ota lub mithril dla klanu. Aby dotowaæ klan, po prostu wpisz ile oraz wybierz co chcesz daæ klanowi (sztuki z³ota lub mithril) a nastêpnie kliknij przycisk Dotuj. Twoje pieni±dze zostan± przekazane na konto klanu. Mo¿esz daæ tylko tyle sztuk z³ota ile w danym momencie posiadasz przy sobie. Opcja <b>Cz³onkowie</b> pozwala ci zobaczyæ, kto nale¿y do klanu. Wy¶wietla imiê oraz numer (ID) cz³onka oraz pozycjê w klanie (Przywódca, Drugi Przywódca). Klikaj±c na imiê, mo¿esz dowiedzieæ siê czego¶ wiêcej na temat danego cz³onka klanu. Opcja <b>Opu¶æ klan</b> pozwala ci odej¶æ z klanu. Je¿eli odejdziesz z klanu, nie bêdziesz mia³ dostêpu do specjalnych opcji klanu. Je¿eli odejdzie Drugi Przywódca, stanowisko to, zwolni siê, natomiast, je¿eli odejdzie Przywódca, ca³y klan zostanie zlikwidowany a wszystkie pieni±dze klanu przepadn±. Opcja <b>Opcje Przywódcy</b> jest dostêpna tylko dla Przywódcy oraz Drugiego Przywódcy klanu. Tutaj mo¿na <b>Edytowaæ wiadomo¶æ</b> - mo¿esz wys³aæ list albo do wszystich graczy (opcja <b>Publiczna Wiadomo¶æ</b>, albo tylko do cz³onków klanu (<b>Prywatna Wiadomo¶æ</b>. Wysy³anie Wiadomo¶ci wygl±da tak samo jak wysy³anie zwyk³ego listu. Kolejn± opcj± jest <b>Wyrzuæ Cz³onka</b> - tutaj mo¿esz usun±æ kogo¶ z klanu - po prostu wpisz jego ID (numer, nie imiê). Nie mo¿na w ten sposób usun±æ Przywódcy klanu. Opcja <b>Zaci±gnij Po¿yczkê</b> pozwala daæ jakiemu¶ cz³onkowi klanu czê¶æ sztuk z³ota lub mithrilu ze skarbca klanu. Je¿eli chcesz komu¶ udzieliæ po¿yczki, po prostu wpisz jego ID (numer, nie imiê), ilo¶æ oraz rodzaj pieniêdzy (sztuki mithrilu lub z³ota) a nastêpnie wci¶nij klawisz <i>Po¿ycz</i>. Kolejn± opcj± jest <b>Zmiana has³a do klanu</b> - zmieniasz tutaj has³o dostêpu do klanu. Has³o jest wa¿ne dla nowych cz³onków (musz± je znaæ, aby móc do³±czyæ do klanu. Aby zmieniæ has³o, najpierw wpisz stare has³o, a nastêpnie nowe oraz wci¶nij przycisk <i>Zmieñ</i>. Opcja <b>Ustawiæ Drugiego Przywódcê</b> pozwala Przywódcy klanu ustawiæ, kto ma byæ jego zastêpc±. Aby to zrobiæ, po prostu wpisz ID (numer, nie imiê) cz³onka klanu oraz kliknij przycisk <i>Ustaw</i>. Drugi Przywódca bêdzie mia³ prawie takie same uprawnienia jak Przywódca klanu. Opcja <b>Dodatki klanu</b> pozwala zakupiæ klanowi darmowe leczenie w szpitalu - ka¿dy cz³onek klanu, bêdzie leczy³ siê za darmo w szpitalu. Opcja ta kosztuje 100 sztuk mithrilu.<br>2.Kolejn± opcj± na g³ownym ekranie jest opcja <b>Stwórz nowy klan</b> - aby stworzyæ nowy klan, musisz posiadaæ przy sobie 25000 sztuk z³ota. Je¿eli je posiadaæ, to wpisz w odpowiednie pola, nazwê klanu oraz has³o do klanu (jest niezbêdne dla nowych cz³onków), a nastêpnie kliknij przycisk <i>Za³ó¿</i>. Od tego momentu istnieje twój klan, a ty jeste¶ jego Przywódc±.<br>3.Opcj± dostêpn± dla wszystkich jest opcja <b>Zobacz listê klanów</b>. Tutaj mo¿esz zobaczyæ listê wszystkich klanów jakie s± w grze. Na li¶cie jest nazwa klanu oraz ID (numer) przywódcy. Klikaj±c na nazwê klanu mo¿esz zobaczyæ dodatkowe informacje oraz do³±czyæ do klanu. Aby do³±czyæ do klanu, kliknij przycisk <i>Do³±cz</i> a nastêpnie wpisaæ has³o do klanu (has³o mo¿esz otrzymaæ od Przywódcy klanu lub Drugiego przywódcy). Potem ju¿ tylko wci¶nij przycisk <i>Do³±cz</i> i od tej pory jeste¶ cz³onkie danego klanu.";
}
if ($_GET['help']) {
	print "<br><br>(<a href=helpspol.php>Powrót</a>)";
}

require_once("footer.php");
?>
