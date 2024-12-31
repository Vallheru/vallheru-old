<?php 
/***************************************************************************
 *                               market.php
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

$title = "Rynek"; require_once("header.php"); ?>
<?
print "Tutaj jest rynek z minera³ami. Masz parê opcji.<br>";
print "<ul>";	
print "<li><a href=pmarket.php?view=market&limit=0&lista=id>Zobacz oferty</a>";
print "<li><a href=pmarket.php?view=szukaj>Szukaj ofert</a></li>";	
print "<li><a href=pmarket.php?view=add>Dodaj ofertê</a>";	
print "<li><a href=pmarket.php?view=del>Skasuj wszystkie swoje oferty</a>";	
print "</ul>";
print "Tutaj jest rynek z przedmiotami. Masz parê opcji.<br>";
print "<ul>";	
print "<li><a href=imarket.php?view=market&limit=0&lista=id>Zobacz oferty</a>";
print "<li><a href=imarket.php?view=szukaj>Szukaj ofert</a></li>";
print "<li><a href=imarket.php?view=add>Dodaj ofertê</a>";	
print "<li><a href=imarket.php?view=del>Skasuj wszystkie swoje oferty</a>";	
print "</ul>";
print "Tutaj jest rynek z miksturami. Masz parê opcji.<br>";
print "<ul>";	
print "<li><a href=mmarket.php?view=market&limit=0&lista=id>Zobacz oferty</a>";
print "<li><a href=mmarket.php?view=szukaj>Szukaj ofert</a></li>";
print "<li><a href=mmarket.php?view=add>Dodaj ofertê</a>";	
print "<li><a href=mmarket.php?view=del>Skasuj wszystkie swoje oferty</a>";	
print "</ul>";
print "Tutaj jest rynek z zio³ami. Masz parê opcji.<br>";
print "<ul>";	
print "<li><a href=hmarket.php?view=market&limit=0&lista=id>Zobacz oferty</a>";
print "<li><a href=hmarket.php?view=szukaj>Szukaj ofert</a></li>";
print "<li><a href=hmarket.php?view=add>Dodaj ofertê</a>";	
print "<li><a href=hmarket.php?view=del>Skasuj wszystkie swoje oferty</a>";	
print "</ul><br><br>";
?>
<?php require_once("footer.php"); ?>
