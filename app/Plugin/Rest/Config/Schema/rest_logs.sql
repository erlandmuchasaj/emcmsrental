-- DROP TABLE IF EXISTS `rest_logs`;
CREATE TABLE `rest_logs` (
  `id` bigint(20) UNSIGNED NOT NULL auto_increment,
  `class` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `username` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `controller` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `action` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `model_id` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ip` varchar(16) character set utf8 collate utf8_unicode_ci NOT NULL,
  `requested` datetime NOT NULL,
  `apikey` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL,
  `httpcode` smallint(3) UNSIGNED  NOT NULL,
  `error` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ratelimited` tinyint(1) UNSIGNED  NOT NULL,
  `data_in` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `meta` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `data_out` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `responded` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;