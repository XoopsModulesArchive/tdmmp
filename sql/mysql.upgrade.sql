ALTER TABLE `priv_msgs`
  
  ADD `msg_folder` tinyint(10) unsigned     NOT NULL default '3',
  
  ADD INDEX `prune` (`msg_time`, `read_msg`, `msg_folder`);