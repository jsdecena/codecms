# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.44)
# Database: codecms
# Generation Time: 2012-12-15 11:12:37 +0000
# ************************************************************

# Dump of table cc_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cc_users`;

CREATE TABLE `cc_users` (
  `users_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity` varchar(128) NOT NULL DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `role` varchar(255) NOT NULL DEFAULT 'subscriber',
  `first_name` varchar(255) DEFAULT '',
  `last_name` varchar(255) DEFAULT '',
  `about` text,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_logged_in` int(11) unsigned DEFAULT '0',
  `pw_recovery` varchar(255) DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cc_users` WRITE;
/*!40000 ALTER TABLE `cc_users` DISABLE KEYS */;

INSERT INTO `cc_users` (`users_id`, `identity`, `username`, `email`, `password`, `role`, `first_name`, `last_name`, `about`, `last_login`, `is_logged_in`, `pw_recovery`)
VALUES
  (1,'0','admin','admin@admin.com','88ea39439e74fa27c09a4fc0bc8ebe6d00978392','admin','John','Doe','about me!',NULL,1,'0');

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

DROP TABLE IF EXISTS `cc_posts`;

CREATE TABLE `cc_posts` (
  `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `author` varchar(128) NOT NULL DEFAULT 'user',
  `content` text DEFAULT NULL,
  `status` varchar(128) NOT NULL DEFAULT 'unpublished',
  `date_add` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `users_id` (`users_id`),
  KEY `post_parent` (`post_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

LOCK TABLES `cc_posts` WRITE;
/*!40000 ALTER TABLE `cc_posts` DISABLE KEYS */;

INSERT INTO `cc_posts` (`post_id`, `users_id`, `title`, `slug`, `author`, `content`, `status`, `date_add`, `modified`, `post_type`, `post_parent`)
VALUES
  (1, 1,'My First Blog Post','my-first-blog-post','John Doe','This is my first blog post!', 'published','2013-01-01 12:00:00','0000-00-00 00:00:00', 'post', 0),
  (2, 1,'About','about','John Doe','This is about us page', 'published','0000-00-00 00:00:00','0000-00-00 00:00:00', 'page', 0);

/*!40000 ALTER TABLE `cc_posts` ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table cc_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cc_settings`;

CREATE TABLE `cc_settings` (
  `settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settings_name` varchar(128) NOT NULL DEFAULT '',
  `settings_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`settings_id`),
  UNIQUE KEY `settings_id` (`settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cc_settings` WRITE;
/*!40000 ALTER TABLE `cc_settings` DISABLE KEYS */;

INSERT INTO `cc_settings` (`settings_id`, `settings_name`, `settings_value`)
VALUES
  (1,'post_page_chosen','blog'),
  (2,'post_per_page','10'),
  (3,'arrange_post_by','post_id'),
  (4,'order_post_by','desc');

/*!40000 ALTER TABLE `cc_settings` ENABLE KEYS */;
UNLOCK TABLES;