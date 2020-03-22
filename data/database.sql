/*
* @Author: alexandru.serban
* @Date:   2016-09-12 17:35:25
* @Last Modified by:   alexandru.serban
* @Last Modified time: 2016-09-12 17:38:23
*/


--
-- Structura de tabel pentru tabelul `url_playlist`
--

CREATE TABLE IF NOT EXISTS `url_playlist` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Hash` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'job unique identifier',
  `Action` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `Method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Data` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `Minutes` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT 'null means *',
  `Hours` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT 'null means *',
  `Days` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT 'null means *',
  `Months` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT 'null means *',
  `DoW` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT 'null means *',
  `Comment` text COLLATE utf8_unicode_ci,
  `Added` datetime DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `Hash` (`Hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

