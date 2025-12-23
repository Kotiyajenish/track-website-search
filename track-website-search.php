<?php
/**
 * Plugin Name: Track Website Search
 * Plugin URI: https://wordpress.org/plugins/track-website-search/
 * Description: Tracks anonymous website visitor activity for analytics purposes.
 * Version: 1.0.1
 * Author: Jenish
 * Author URI: https://profiles.wordpress.org/jenish/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: track-website-search
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'TWS_VERSION', '1.0.0' );
define( 'TWS_PATH', plugin_dir_path( __FILE__ ) );
define( 'TWS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Activation hook
 */
require_once TWS_PATH . 'includes/class-database.php';
register_activation_hook( __FILE__, ['TWS_Database', 'create_table'] );

/**
 * Load plugin files
 */
require_once TWS_PATH . 'includes/class-tracker.php';
require_once TWS_PATH . 'includes/class-admin.php';
