-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Aug 2017 um 11:57
-- Server Version: 5.5.55-0+deb8u1
-- PHP-Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `test`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_articles`
--

CREATE TABLE IF NOT EXISTS `shop_articles` (
`id` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `shop_articles`
--

INSERT INTO `shop_articles` (`id`, `title`, `text`, `timestamp`) VALUES
(1, 'Titel', 'Inhalt', '123456789');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_btc_transactions`
--

CREATE TABLE IF NOT EXISTS `shop_btc_transactions` (
`id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `address` text,
  `txid` text,
  `confirmed` enum('1','0') DEFAULT '0',
  `timestamp` varchar(255) DEFAULT '123456789',
  `received` enum('1','0') DEFAULT '0',
  `amount` varchar(255) DEFAULT '0.0'
) ENGINE=InnoDB AUTO_INCREMENT=1708 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_categories`
--

CREATE TABLE IF NOT EXISTS `shop_categories` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_coupons`
--

CREATE TABLE IF NOT EXISTS `shop_coupons` (
`id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `type` enum('balance') NOT NULL DEFAULT 'balance',
  `max_usable` int(11) NOT NULL DEFAULT '1',
  `used` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_coupons_logs`
--

CREATE TABLE IF NOT EXISTS `shop_coupons_logs` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `couponid` int(11) NOT NULL DEFAULT '0',
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789'
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_deposits`
--

CREATE TABLE IF NOT EXISTS `shop_deposits` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_faqs`
--

CREATE TABLE IF NOT EXISTS `shop_faqs` (
`id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `shop_faqs`
--

INSERT INTO `shop_faqs` (`id`, `question`, `answer`) VALUES
(1, 'beispiel', 'beispiel');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_histories`
--

CREATE TABLE IF NOT EXISTS `shop_histories` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB AUTO_INCREMENT=3243 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_notes`
--

CREATE TABLE IF NOT EXISTS `shop_notes` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `note` text,
  `readed` enum('1','0') NOT NULL DEFAULT '0',
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_permissions`
--

CREATE TABLE IF NOT EXISTS `shop_permissions` (
`id` int(11) NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `shop_permissions`
--

INSERT INTO `shop_permissions` (`id`, `permission`) VALUES
(1, 'ALL_PERMISSIONS'),
(2, 'ACCESS_BY_MAINTENANCE'),
(3, 'ACCESS_ADMIN_PANEL'),
(4, 'ACCESS_CATALOG'),
(5, 'ACCESS_BTC_SERVER'),
(6, 'ACCESS_JABBER_NEWSLETTER'),
(7, 'ACCESS_SETTINGS'),
(8, 'ACCESS_USER_LOGIN'),
(9, 'ACCESS_EDIT_USER');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_plugins`
--

CREATE TABLE IF NOT EXISTS `shop_plugins` (
`id` int(11) NOT NULL,
  `package` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `contributors` text,
  `requiredPlugins` text,
  `enabled` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `shop_plugins`
--

INSERT INTO `shop_plugins` (`id`, `package`, `name`, `version`, `author`, `contributors`, `requiredPlugins`, `enabled`) VALUES
(1, 'gwork.gwork.shop', 'Szene-Shop Frontend', '1.0.0', 'geograph', NULL, NULL, '1'),
(2, 'gwork.gwork.acp', 'Szene-Shop Backend', '1.0.0', 'geograph', NULL, 'gwork.gwork.shop', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_plugins_event_listeners`
--

CREATE TABLE IF NOT EXISTS `shop_plugins_event_listeners` (
`id` int(11) NOT NULL,
  `pluginId` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `eventClass` text NOT NULL,
  `listenerClass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_plugins_template_listeners`
--

CREATE TABLE IF NOT EXISTS `shop_plugins_template_listeners` (
`id` int(11) NOT NULL,
  `pluginId` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `templateName` varchar(255) NOT NULL,
  `listenerClass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_products`
--

CREATE TABLE IF NOT EXISTS `shop_products` (
`id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` text,
  `unlimited` enum('true','false') NOT NULL DEFAULT 'false',
  `short_description` text,
  `price` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `unlimited_content` text,
  `info_tag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_products_items`
--

CREATE TABLE IF NOT EXISTS `shop_products_items` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_settings`
--

CREATE TABLE IF NOT EXISTS `shop_settings` (
  `row` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `shop_settings`
--

INSERT INTO `shop_settings` (`row`, `value`) VALUES
('SiteName', '4dler'),
('Language', 'DE'),
('Template', 'Default'),
('Style', 'default'),
('Maintenance', '0'),
('CountryAutoDetect', '0'),
('LanguagesPath', 'Application/Languages'),
('Currency', 'EUR'),
('InfoBoxTitle', ''),
('InfoBoxText', ''),
('RecaptchaSiteKey', 'xxxxxxxxx'),
('RecaptchaPrivateKey', 'xxxxxxxxx'),
('StartYear', '2017'),
('HomepageNews', '1'),
('BitcoinHost', 'xxxxxxxxx'),
('BitcoinPort', '133769'),
('BitcoinUsername', 'xxxxxxxx'),
('BitcoinPassword', 'xxxxxxxx'),
('RecaptchaEnabled', '0'),
('JabberHost', 'jabber.de'),
('JabberPort', '5222'),
('JabberUsername', 'gganewsletter'),
('JabberPassword', 'xxxxxxxx'),
('JabberID', 'diestehtobenrechts'),
('JabberIDNoReply', 'HierKommtAnWennTicketAufgemachtWird');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_tickets`
--

CREATE TABLE IF NOT EXISTS `shop_tickets` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789',
  `status` enum('completed','closed','open') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_tickets_answers`
--

CREATE TABLE IF NOT EXISTS `shop_tickets_answers` (
`id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_tutorials`
--

CREATE TABLE IF NOT EXISTS `shop_tutorials` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_users`
--

CREATE TABLE IF NOT EXISTS `shop_users` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT '0',
  `language` varchar(255) NOT NULL,
  `can_redeem_coupons` enum('0','1') NOT NULL DEFAULT '1',
  `account_created` varchar(255) NOT NULL DEFAULT '123456789',
  `can_read_tutorials` enum('0','1') NOT NULL DEFAULT '0',
  `jabber` varchar(255) NOT NULL,
  `newsletter` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=596 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_users_bans`
--

CREATE TABLE IF NOT EXISTS `shop_users_bans` (
`id` int(11) NOT NULL,
  `banType` enum('id','ip') NOT NULL DEFAULT 'id',
  `value` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `expire` varchar(255) NOT NULL DEFAULT '123456789',
  `addedBy` int(11) NOT NULL DEFAULT '0',
  `timestamp` varchar(255) NOT NULL DEFAULT '123456789'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_users_permissions`
--

CREATE TABLE IF NOT EXISTS `shop_users_permissions` (
`id` int(11) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Daten für Tabelle `shop_users_permissions`
--

INSERT INTO `shop_users_permissions` (`id`, `permission`, `userid`) VALUES
(1, 1, 1),
(2, 1, 9);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `shop_articles`
--
ALTER TABLE `shop_articles`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_btc_transactions`
--
ALTER TABLE `shop_btc_transactions`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_categories`
--
ALTER TABLE `shop_categories`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_coupons`
--
ALTER TABLE `shop_coupons`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_coupons_logs`
--
ALTER TABLE `shop_coupons_logs`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_deposits`
--
ALTER TABLE `shop_deposits`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_faqs`
--
ALTER TABLE `shop_faqs`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_histories`
--
ALTER TABLE `shop_histories`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_notes`
--
ALTER TABLE `shop_notes`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shop_permissions`
--
ALTER TABLE `shop_permissions`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_plugins`
--
ALTER TABLE `shop_plugins`
 ADD PRIMARY KEY (`id`,`package`) USING BTREE;

--
-- Indizes für die Tabelle `shop_plugins_event_listeners`
--
ALTER TABLE `shop_plugins_event_listeners`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_plugins_template_listeners`
--
ALTER TABLE `shop_plugins_template_listeners`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_products`
--
ALTER TABLE `shop_products`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_products_items`
--
ALTER TABLE `shop_products_items`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_tickets`
--
ALTER TABLE `shop_tickets`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_tickets_answers`
--
ALTER TABLE `shop_tickets_answers`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_tutorials`
--
ALTER TABLE `shop_tutorials`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_users`
--
ALTER TABLE `shop_users`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `shop_users_bans`
--
ALTER TABLE `shop_users_bans`
 ADD PRIMARY KEY (`id`) USING BTREE, ADD KEY `value` (`value`) USING BTREE, ADD KEY `bantype` (`banType`) USING BTREE;

--
-- Indizes für die Tabelle `shop_users_permissions`
--
ALTER TABLE `shop_users_permissions`
 ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `shop_articles`
--
ALTER TABLE `shop_articles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_btc_transactions`
--
ALTER TABLE `shop_btc_transactions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_categories`
--
ALTER TABLE `shop_categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_coupons`
--
ALTER TABLE `shop_coupons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_coupons_logs`
--
ALTER TABLE `shop_coupons_logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_deposits`
--
ALTER TABLE `shop_deposits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `shop_faqs`
--
ALTER TABLE `shop_faqs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_histories`
--
ALTER TABLE `shop_histories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_notes`
--
ALTER TABLE `shop_notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `shop_permissions`
--
ALTER TABLE `shop_permissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `shop_plugins`
--
ALTER TABLE `shop_plugins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `shop_plugins_event_listeners`
--
ALTER TABLE `shop_plugins_event_listeners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `shop_plugins_template_listeners`
--
ALTER TABLE `shop_plugins_template_listeners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `shop_products`
--
ALTER TABLE `shop_products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_products_items`
--
ALTER TABLE `shop_products_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_tickets`
--
ALTER TABLE `shop_tickets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_tickets_answers`
--
ALTER TABLE `shop_tickets_answers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_tutorials`
--
ALTER TABLE `shop_tutorials`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_users`
--
ALTER TABLE `shop_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `shop_users_bans`
--
ALTER TABLE `shop_users_bans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `shop_users_permissions`
--
ALTER TABLE `shop_users_permissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
