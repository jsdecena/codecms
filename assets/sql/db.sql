DROP TABLE IF EXISTS `cc_users`;

CREATE TABLE `cc_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `role` varchar(255) NOT NULL DEFAULT 'subscriber',
  `first_name` varchar(255) DEFAULT '',
  `last_name` varchar(255) DEFAULT '',
  `about` text,
  `creation_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cc_users` WRITE;
/*!40000 ALTER TABLE `cc_users` DISABLE KEYS */;

INSERT INTO `cc_users` (`id`, `username`, `email`, `password`, `role`, `first_name`, `last_name`, `about`, `creation_date`, `last_login`)
VALUES
  (1,'admin','admin@admin.com','601f1889667efaebb33b8c12572835da3f027f78','admin','Master','User','','2012-12-12 01:25:06',NULL);

/*!40000 ALTER TABLE `cc_users` ENABLE KEYS */;
UNLOCK TABLES;

CREATE TABLE `cc_user_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;