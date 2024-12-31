# phpMyAdmin SQL Dump
# version 2.5.6-rc1
# http://www.phpmyadmin.net
#
# Host: localhost
# Czas wygenerowania: 24 Maj 2004, 09:41
# Wersja serwera: 3.23.58
# Wersja PHP: 4.2.3
# 
# Baza danych : `cordy_vallheru`
# 

# --------------------------------------------------------

#
# Struktura tabeli dla  `aktywacja`
#

USE vallheru;

CREATE TABLE `aktywacja` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(15) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `aktyw` int(11) NOT NULL default '0',
  `refs` int(11) NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  `data` date NOT NULL default '2000-01-01',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  FULLTEXT KEY `user_2` (`user`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `alchemik`
#

CREATE TABLE `alchemik` (
  `id` int(11) NOT NULL auto_increment,
  `nazwa` varchar(60) NOT NULL default '',
  `gracz` int(11) NOT NULL default '0',
  `illani` int(11) NOT NULL default '0',
  `illanias` int(11) NOT NULL default '0',
  `nutari` int(11) NOT NULL default '0',
  `cena` int(11) NOT NULL default '0',
  `poziom` int(11) NOT NULL default '0',
  `status` char(1) NOT NULL default 'S',
  PRIMARY KEY  (`id`),
  KEY `gracz` (`gracz`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `categories`
#

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `desc` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `chat`
#

CREATE TABLE `chat` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(100) NOT NULL default '',
  `chat` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_2` (`id`),
  FULLTEXT KEY `chat` (`chat`),
  FULLTEXT KEY `user` (`user`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `chat_config`
#

CREATE TABLE `chat_config` (
  `id` int(11) NOT NULL auto_increment,
  `cisza` char(2) NOT NULL default 'Y',
  `gracz` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id_2` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `core`
#

CREATE TABLE `core` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `ref_id` int(11) NOT NULL default '0',
  `power` double(11,3) NOT NULL default '0.000',
  `defense` double(11,3) NOT NULL default '0.000',
  `status` varchar(5) NOT NULL default 'Alive',
  `active` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `core_market`
#

CREATE TABLE `core_market` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `cost` int(11) NOT NULL default '0',
  `seller` int(11) NOT NULL default '0',
  `type` varchar(20) NOT NULL default '',
  `power` int(11) NOT NULL default '0',
  `defense` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `cores`
#

CREATE TABLE `cores` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `power` double(11,4) NOT NULL default '1.0000',
  `defense` double(11,4) NOT NULL default '1.0000',
  `rarity` int(1) NOT NULL default '1',
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `czary`
#

CREATE TABLE `czary` (
  `id` int(11) NOT NULL auto_increment,
  `nazwa` varchar(20) NOT NULL default '',
  `gracz` int(11) NOT NULL default '0',
  `cena` int(11) NOT NULL default '0',
  `poziom` int(11) NOT NULL default '1',
  `typ` char(1) NOT NULL default 'B',
  `obr` double(11,1) NOT NULL default '1.0',
  `status` char(1) NOT NULL default 'S',
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `equipment`
#

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL default '0',
  `name` varchar(60) NOT NULL default '',
  `power` int(11) NOT NULL default '0',
  `status` char(1) NOT NULL default 'U',
  `type` char(1) NOT NULL default 'W',
  `cost` int(11) NOT NULL default '0',
  `minlev` int(2) NOT NULL default '1',
  `zr` int(11) NOT NULL default '0',
  `wt` int(11) NOT NULL default '0',
  `szyb` int(11) NOT NULL default '0',
  `maxwt` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `owner` (`owner`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `herbs`
#

CREATE TABLE `herbs` (
  `id` int(11) NOT NULL auto_increment,
  `gracz` int(11) NOT NULL default '0',
  `illani` int(11) NOT NULL default '0',
  `illanias` int(11) NOT NULL default '0',
  `nutari` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gracz`),
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `hmarket`
#

CREATE TABLE `hmarket` (
  `id` int(11) NOT NULL auto_increment,
  `seller` int(11) NOT NULL default '0',
  `ilosc` int(11) NOT NULL default '0',
  `cost` int(11) NOT NULL default '0',
  `nazwa` varchar(30) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `kopalnie`
#

CREATE TABLE `kopalnie` (
  `id` int(11) NOT NULL auto_increment,
  `gracz` int(11) NOT NULL default '0',
  `ops` int(11) NOT NULL default '5',
  `kbronz` int(11) NOT NULL default '0',
  `kzel` int(11) NOT NULL default '0',
  `kweg` int(11) NOT NULL default '0',
  `bronz` int(11) NOT NULL default '0',
  `zelazo` int(11) NOT NULL default '0',
  `wegiel` int(11) NOT NULL default '0',
  `adam` int(11) NOT NULL default '0',
  `meteo` int(11) NOT NULL default '0',
  `krysztal` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gracz`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `kowal`
#

CREATE TABLE `kowal` (
  `id` int(11) NOT NULL auto_increment,
  `nazwa` varchar(60) NOT NULL default '',
  `gracz` int(11) NOT NULL default '0',
  `cena` int(11) NOT NULL default '0',
  `bronz` int(11) NOT NULL default '0',
  `zelazo` int(11) NOT NULL default '0',
  `wegiel` int(11) NOT NULL default '0',
  `poziom` int(11) NOT NULL default '0',
  `status` char(1) NOT NULL default 'S',
  `mithril` int(11) NOT NULL default '0',
  `adamant` int(11) NOT NULL default '0',
  `meteor` int(11) NOT NULL default '0',
  `krysztal` int(11) NOT NULL default '0',
  `type` char(1) NOT NULL default '',
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `kowal_praca`
#

CREATE TABLE `kowal_praca` (
  `id` int(11) NOT NULL auto_increment,
  `gracz` int(11) NOT NULL default '0',
  `nazwa` varchar(60) NOT NULL default '',
  `c_energia` int(4) NOT NULL default '0',
  `u_energia` int(4) NOT NULL default '0',
  PRIMARY KEY  (`gracz`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `log`
#

CREATE TABLE `log` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL default '0',
  `log` text NOT NULL,
  `unread` char(1) NOT NULL default 'F',
  `czas` datetime NOT NULL default '2000-01-01 00:00:00',
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `mail`
#

CREATE TABLE `mail` (
  `id` int(11) NOT NULL auto_increment,
  `sender` varchar(15) NOT NULL default '',
  `senderid` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `subject` varchar(50) NOT NULL default '',
  `body` text NOT NULL,
  `unread` char(1) NOT NULL default 'F',
  `zapis` char(1) NOT NULL default 'N',
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `market`
#

CREATE TABLE `market` (
  `platcost` int(11) NOT NULL default '0'
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `mikstury`
#

CREATE TABLE `mikstury` (
  `id` int(11) NOT NULL auto_increment,
  `gracz` int(11) NOT NULL default '0',
  `nazwa` varchar(60) NOT NULL default '',
  `typ` char(1) NOT NULL default '',
  `efekt` varchar(30) NOT NULL default '',
  `status` char(1) NOT NULL default 'S',
  `cena` int(11) NOT NULL default '0',
  `moc` int(3) NOT NULL default '100',
  PRIMARY KEY  (`id`),
  KEY `id_2` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `monsters`
#

CREATE TABLE `monsters` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `level` int(11) NOT NULL default '0',
  `hp` int(11) NOT NULL default '0',
  `agility` double(11,2) NOT NULL default '0.00',
  `strength` double(11,2) NOT NULL default '0.00',
  `credits1` int(11) NOT NULL default '0',
  `credits2` int(11) NOT NULL default '0',
  `exp1` int(11) NOT NULL default '0',
  `exp2` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `news`
#

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `starter` text NOT NULL,
  `title` text NOT NULL,
  `news` text NOT NULL,
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `notatnik`
#

CREATE TABLE `notatnik` (
  `id` int(11) NOT NULL auto_increment,
  `gracz` int(11) NOT NULL default '0',
  `tekst` text NOT NULL,
  `czas` datetime NOT NULL default '2000-01-01 00:00:00',
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `opisy`
#

CREATE TABLE `opisy` (
  `id` int(11) NOT NULL auto_increment,
  `nazwa` varchar(30) NOT NULL default '',
  `opis` text NOT NULL,
  PRIMARY KEY  (`nazwa`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `outposts`
#

CREATE TABLE `outposts` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL default '0',
  `size` int(11) NOT NULL default '1',
  `mines` int(11) NOT NULL default '0',
  `turns` int(11) NOT NULL default '5',
  `tokens` int(11) NOT NULL default '1000',
  `troops` int(11) NOT NULL default '3',
  `barricades` int(11) NOT NULL default '3',
  `news` text NOT NULL,
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `players`
#

CREATE TABLE `players` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(15) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `rank` varchar(10) NOT NULL default 'Member',
  `level` int(11) NOT NULL default '1',
  `exp` int(11) NOT NULL default '0',
  `credits` int(11) NOT NULL default '1000',
  `energy` double(11,2) NOT NULL default '5.00',
  `max_energy` double(11,2) NOT NULL default '5.00',
  `strength` double(11,3) NOT NULL default '3.000',
  `agility` double(11,3) NOT NULL default '3.000',
  `ap` int(11) NOT NULL default '5',
  `wins` int(11) NOT NULL default '0',
  `losses` int(11) NOT NULL default '0',
  `lastkilled` varchar(15) NOT NULL default '...',
  `lastkilledby` varchar(15) NOT NULL default '...',
  `platinum` int(11) NOT NULL default '0',
  `age` int(11) NOT NULL default '1',
  `logins` int(11) NOT NULL default '0',
  `hp` int(11) NOT NULL default '15',
  `max_hp` int(11) NOT NULL default '15',
  `bank` int(11) NOT NULL default '0',
  `lpv` bigint(20) NOT NULL default '0',
  `page` varchar(100) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  `ability` double(11,2) NOT NULL default '0.01',
  `tribe` int(11) NOT NULL default '0',
  `profile` text NOT NULL,
  `refs` int(11) NOT NULL default '0',
  `corepass` char(1) NOT NULL default 'N',
  `mtools` int(11) NOT NULL default '1',
  `trains` int(11) NOT NULL default '5',
  `rasa` varchar(10) NOT NULL default '',
  `klasa` varchar(11) NOT NULL default '',
  `inteli` double(11,3) NOT NULL default '3.000',
  `pw` int(11) NOT NULL default '0',
  `atak` double(11,2) NOT NULL default '0.01',
  `unik` double(11,2) NOT NULL default '0.01',
  `magia` double(11,2) NOT NULL default '0.01',
  `immu` char(1) NOT NULL default 'N',
  `data` date NOT NULL default '2000-01-01',
  `pm` int(11) NOT NULL default '3',
  `miejsce` varchar(15) NOT NULL default 'Altara',
  `szyb` double(11,3) NOT NULL default '3.000',
  `wytrz` double(11,3) NOT NULL default '3.000',
  `alchemia` double(11,2) NOT NULL default '0.01',
  `gg` int(9) NOT NULL default '0',
  `avatar` varchar(36) NOT NULL default '',
  `wisdom` double(11,3) NOT NULL default '3.000',
  UNIQUE KEY `id` (`id`),
  KEY `user` (`user`),
  FULLTEXT KEY `user_2` (`user`),
  FULLTEXT KEY `ip` (`ip`),
  FULLTEXT KEY `profile` (`profile`)
);

INSERT INTO players (user, email, pass, rank, profile) VALUES('admin', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '');

# --------------------------------------------------------

#
# Struktura tabeli dla  `pmarket`
#

CREATE TABLE `pmarket` (
  `id` int(11) NOT NULL auto_increment,
  `seller` int(11) NOT NULL default '0',
  `ilosc` int(11) NOT NULL default '0',
  `cost` int(11) NOT NULL default '0',
  `nazwa` varchar(20) NOT NULL default 'mithril',
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `replies`
#

CREATE TABLE `replies` (
  `id` int(11) NOT NULL auto_increment,
  `starter` varchar(30) NOT NULL default '',
  `topic_id` text NOT NULL,
  `body` text NOT NULL,
  `gracz` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `topics`
#

CREATE TABLE `topics` (
  `id` int(11) NOT NULL auto_increment,
  `topic` text NOT NULL,
  `body` text NOT NULL,
  `starter` varchar(30) NOT NULL default '',
  `gracz` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribe_mag`
#

CREATE TABLE `tribe_mag` (
  `id` int(11) NOT NULL auto_increment,
  `klan` int(11) NOT NULL default '0',
  `nazwa` varchar(60) NOT NULL default '',
  `efekt` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `klan` (`klan`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribe_oczek`
#

CREATE TABLE `tribe_oczek` (
  `id` int(11) NOT NULL auto_increment,
  `gracz` int(11) NOT NULL default '0',
  `klan` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gracz`),
  KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribe_perm`
#

CREATE TABLE `tribe_perm` (
  `id` int(11) NOT NULL auto_increment,
  `tribe` int(11) NOT NULL default '0',
  `messages` int(11) NOT NULL default '0',
  `wait` int(11) NOT NULL default '0',
  `kick` int(11) NOT NULL default '0',
  `army` int(11) NOT NULL default '0',
  `attack` int(11) NOT NULL default '0',
  `loan` int(11) NOT NULL default '0',
  `armory` int(11) NOT NULL default '0',
  `warehouse` int(11) NOT NULL default '0',
  `bank` int(11) NOT NULL default '0',
  `herbs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tribe` (`tribe`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribe_replies`
#

CREATE TABLE `tribe_replies` (
  `id` int(11) NOT NULL auto_increment,
  `starter` varchar(30) NOT NULL default '',
  `topic_id` text NOT NULL,
  `body` text NOT NULL,
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribe_topics`
#

CREATE TABLE `tribe_topics` (
  `id` int(11) NOT NULL auto_increment,
  `topic` text NOT NULL,
  `body` text NOT NULL,
  `starter` varchar(30) NOT NULL default '',
  `tribe` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribe_zbroj`
#

CREATE TABLE `tribe_zbroj` (
  `id` int(11) NOT NULL auto_increment,
  `klan` int(11) NOT NULL default '0',
  `name` varchar(60) NOT NULL default '',
  `power` int(11) NOT NULL default '0',
  `wt` int(11) NOT NULL default '0',
  `maxwt` int(11) NOT NULL default '0',
  `zr` int(11) NOT NULL default '0',
  `szyb` int(11) NOT NULL default '0',
  `minlev` int(11) NOT NULL default '0',
  `type` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `klan` (`klan`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `tribes`
#

CREATE TABLE `tribes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `owner` int(11) NOT NULL default '0',
  `coowner` int(11) NOT NULL default '0',
  `credits` int(11) NOT NULL default '0',
  `platinum` int(11) NOT NULL default '0',
  `public_msg` text NOT NULL,
  `private_msg` text NOT NULL,
  `hospass` char(1) NOT NULL default 'N',
  `atak` char(1) NOT NULL default 'N',
  `wygr` int(11) NOT NULL default '0',
  `przeg` int(11) NOT NULL default '0',
  `zolnierze` int(11) NOT NULL default '0',
  `forty` int(11) NOT NULL default '0',
  `bronz` int(11) NOT NULL default '0',
  `zelazo` int(11) NOT NULL default '0',
  `wegiel` int(11) NOT NULL default '0',
  `adam` int(11) NOT NULL default '0',
  `meteo` int(11) NOT NULL default '0',
  `krysztal` int(11) NOT NULL default '0',
  `illani` int(11) NOT NULL default '0',
  `illanias` int(11) NOT NULL default '0',
  `nutari` int(11) NOT NULL default '0',
  `logo` varchar(36) NOT NULL default '',
  `www` varchar(60) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
);

# --------------------------------------------------------

#
# Struktura tabeli dla  `updates`
#

CREATE TABLE `updates` (
  `id` int(11) NOT NULL auto_increment,
  `starter` text NOT NULL,
  `title` text NOT NULL,
  `updates` text NOT NULL,
  UNIQUE KEY `id` (`id`)
);
