<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class TWS_Tracker {

    public function __construct() {
        add_action( 'init', [$this, 'set_visitor_id'], 0 );
        add_action( 'wp', [$this, 'capture_visit'] );
    }

    public function set_visitor_id() {

        if ( is_admin() || isset($_COOKIE['tws_visitor_id']) || headers_sent() ) {
            return;
        }

        $visitor_id = wp_generate_uuid4();

        setcookie(
            'tws_visitor_id',
            $visitor_id,
            time() + (30 * DAY_IN_SECONDS),
            '/'
        );

        $_COOKIE['tws_visitor_id'] = $visitor_id;
    }

    public function capture_visit() {

        if ( is_admin() || empty($_COOKIE['tws_visitor_id']) ) {
            return;
        }

        static $logged = false;
        if ( $logged ) return;
        $logged = true;

        global $wpdb;
        $table = $wpdb->prefix . 'visitor_logs';

        $wpdb->insert(
            $table,
            [
                'visitor_id' => sanitize_text_field($_COOKIE['tws_visitor_id']),
                'ip_address' => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
                'user_id'    => get_current_user_id() ?: null,
                'page_url'   => esc_url_raw($_SERVER['REQUEST_URI'] ?? ''),
                'user_agent' => sanitize_textarea_field($_SERVER['HTTP_USER_AGENT'] ?? ''),
                'visited_at' => current_time('mysql')
            ]
        );
    }
}

new TWS_Tracker();
