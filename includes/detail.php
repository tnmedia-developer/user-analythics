<?php
if (!defined('ABSPATH')) {
    exit;
}

function user_analythics_detail_page()
{
    if (!isset($_GET['user_id'])) {
        echo '<h2>Data tidak ditemukan</h2>';
        return;
    }

    $user_id = intval($_GET['user_id']);
    $user_info = get_userdata($user_id);
    global $wpdb;

    $user_posts = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT ID, post_title, post_date FROM $wpdb->posts WHERE post_author = %d AND post_status = 'publish' ORDER BY post_date DESC",
            $user_id
        )
    );

    include plugin_dir_path(__FILE__) . '../templates/detail.php';
}
