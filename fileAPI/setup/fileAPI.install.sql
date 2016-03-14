
CREATE TABLE IF NOT EXISTS `cot_fileAPI` (
  `fa_id` int(11) NOT NULL auto_increment,
  `fa_userid` int(11) NOT NULL default '0',
  `fa_date` int(11) NOT NULL default '0',
  `fa_file` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `fa_extension` varchar(8) collate utf8_unicode_ci NOT NULL default '',
  `fa_area` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `fa_cat` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `fa_indf` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `fa_prefix` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `fa_mime` varchar(25) collate utf8_unicode_ci NOT NULL default '',
  `fa_folderid` int(11) NOT NULL default '0',
  `fa_desc` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `fa_size` int(11) unsigned NOT NULL default '0',
  `fa_count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fa_id`),
  KEY `fa_userid` (`fa_userid`),
  KEY `fa_area` (`fa_area`),
  KEY `fa_cat` (`fa_cat`),
  KEY `fa_indf` (`fa_indf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

