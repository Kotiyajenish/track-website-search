<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Track_Website_Search
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Delete custom table
$table_name = $wpdb->prefix . 'visitor_logs';
$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

// Delete plugin options (if added later)
// delete_option( 'tws_settings' );
