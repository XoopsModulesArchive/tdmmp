CREATE TABLE `tdmmp_folder` (
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  `pid` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(50) NOT NULL default '',
  `uid` mediumint(8) default NULL,
  `ver` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM;

CREATE TABLE `tdmmp_contact` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(10) unsigned NOT NULL default '0',
  `contact` mediumint(10) unsigned NOT NULL default '0',
  `name` varchar(60) NOT NULL default '',
  `uname` varchar(25) NOT NULL default '',
  `regdate` int(10) unsigned NOT NULL default '0',
  KEY `userid` (`id`)
) ENGINE=MyISAM;