<?php

global $wpdb;
$table = new Clp_Link();
$tableName = $table->getTableName();
$computeLinksDbVersion = '1.0.0';

if ( $wpdb->get_var( "SHOW TABLES LIKE '{$tableName}'" ) != $tableName ) {

	$sql = sprintf("CREATE TABLE %s (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
		  `user_id` int(10) unsigned NOT NULL,
		  `url` varchar(400) COLLATE utf8_persian_ci NOT NULL,
		  `md5_url` varchar(32) COLLATE utf8_persian_ci NOT NULL,
		  `size` int(50) unsigned DEFAULT 0,
		  `type` varchar(10) COLLATE utf8_persian_ci DEFAULT 'NULL',
		  `host` varchar(40) COLLATE utf8_persian_ci NOT NULL,
		  `title` varchar(100) COLLATE utf8_persian_ci DEFAULT 'NULL',
		  `post_id` int(20) unsigned DEFAULT NULL,
		  `count` mediumint(9) DEFAULT 0,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `url_postId` (`md5_url`,`post_id`),
		  KEY `md5_url` (`md5_url`),
		  KEY `post_id` (`post_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;", $tableName);

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	add_option( 'my_db_version', $computeLinksDbVersion );
}
