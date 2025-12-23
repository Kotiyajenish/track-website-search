<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class TWS_Admin {

    public function __construct() {
        add_action( 'admin_menu', [$this, 'menu'] );
    }

    public function menu() {
        add_menu_page(
            'Track Website Search',
            'Track Website Search',
            'manage_options',
            'track-website-search',
            [$this, 'page'],
            'dashicons-search',
            25
        );
    }

    public function page() {
        global $wpdb;
        $table = $wpdb->prefix . 'visitor_logs';

        $results = $wpdb->get_results("
            SELECT visitor_id, ip_address,
                   COUNT(*) AS visit_count,
                   MIN(visited_at) AS first_visit,
                   MAX(visited_at) AS last_visit
            FROM $table
            GROUP BY visitor_id
            ORDER BY last_visit DESC
        ");
        ?>
        <div class="wrap">
            <h1>Website Visitor Tracking</h1>
            <table class="widefat striped">
                <thead>
                <tr>
                    <th>Visitor ID</th>
                    <th>IP Address</th>
                    <th>Total Visits</th>
                    <th>First Visit</th>
                    <th>Last Visit</th>
                </tr>
                </thead>
                <tbody>
                <?php if ( $results ) : foreach ( $results as $row ) : ?>
                    <tr>
                        <td><?php echo esc_html($row->visitor_id); ?></td>
                        <td><?php echo esc_html($row->ip_address); ?></td>
                        <td><?php echo esc_html($row->visit_count); ?></td>
                        <td><?php echo esc_html($row->first_visit); ?></td>
                        <td><?php echo esc_html($row->last_visit); ?></td>
                    </tr>
                <?php endforeach; else : ?>
                    <tr><td colspan="5">No visits yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}

new TWS_Admin();
