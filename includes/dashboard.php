<?php
if (!defined('ABSPATH')) {
    exit;
}

function user_analythics_dashboard()
{
    if (!user_analythics_has_access()) {
        wp_die(__('Anda tidak memiliki izin untuk mengakses halaman ini.'));
    }

    $user_count = count_users();
    $total_users = $user_count['total_users'];
    $total_comments = wp_count_comments()->approved;

    // Ambil rentang waktu dari input
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : date('Y-m-d', strtotime('-30 days'));
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : date('Y-m-d');

    global $wpdb;

    // Query jumlah postingan dalam rentang waktu
    $total_posts = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND post_date BETWEEN %s AND %s",
            $start_date . ' 00:00:00',
            $end_date . ' 23:59:59'
        )
    );

    // Query jumlah postingan per pengguna dalam rentang waktu
    $user_posts = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT p.post_author, COUNT(p.ID) as post_count, u.display_name AS username FROM $wpdb->posts p
            JOIN $wpdb->users u ON p.post_author = u.ID
            WHERE p.post_status = 'publish' AND p.post_type = 'post' 
            AND p.post_date BETWEEN %s AND %s
            GROUP BY p.post_author ORDER BY post_count DESC",
            $start_date . ' 00:00:00',
            $end_date . ' 23:59:59'
        )
    );

    include plugin_dir_path(__FILE__) . '../templates/dashboard.php';
}
