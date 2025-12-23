<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class TWS_Database {
    public static function create_table() {
        global $wpdb;
        $table = $wpdb->prefix . 'visitor_logs';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            visitor_id VARCHAR(64) NOT NULL,
            ip_address VARCHAR(50) NOT NULL,
            user_id BIGINT UNSIGNED DEFAULT NULL,
            page_url TEXT NOT NULL,
            user_agent TEXT DEFAULT NULL,
            visited_at DATETIME NOT NULL,
            PRIMARY KEY (id),
            KEY visitor_id (visitor_id),
            KEY ip_address (ip_address),
            KEY user_id (user_id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
