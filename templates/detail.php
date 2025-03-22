<?php
if (!defined('ABSPATH')) {
    exit;
}

// Ambil parameter user_id, start_date, dan end_date
$user_id = intval($_GET['user_id']);
$start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : date('Y-m-d');

$user = get_userdata($user_id);
if (!$user) {
    echo '<h2>Pengguna tidak ditemukan.</h2>';
    return;
}
?>

<div class="wrap">
    <h1>Detail Postingan: <?php echo esc_html($user->display_name); ?></h1>

    <!-- Form Filter Tanggal -->
    <form method="GET" style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; flex-wrap: wrap; align-items: center; gap: 10px;">
        <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>">
        <input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

        <label for="start_date">Mulai:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo esc_attr($start_date); ?>" style="padding: 5px;">

        <label for="end_date">Sampai:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo esc_attr($end_date); ?>" style="padding: 5px;">

        <button type="submit" style="background: #0073aa; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
            Filter
        </button>
    </form>


</div>

<?php
// Query untuk mengambil postingan pengguna berdasarkan rentang waktu
global $wpdb;
$user_posts = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT ID, post_title, post_date 
        FROM $wpdb->posts 
        WHERE post_author = %d 
        AND post_status = 'publish' 
        AND post_type = 'post' 
        AND post_date BETWEEN %s AND %s 
        ORDER BY post_date DESC",
        $user_id,
        $start_date . ' 00:00:00',
        $end_date . ' 23:59:59'
    )
);
?>

<div class="wrap">
    <ul>
        <li>Email: <?php echo esc_html($user->user_email); ?></li>
        <li>Peran: <?php echo implode(', ', $user->roles); ?></li>
        <li>Jumlah Postingan: <?php echo count($user_posts); ?></li>
    </ul>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <th style="border-bottom: 1px solid #ddd; padding: 10px; text-align: left;">No</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px; text-align: left;">Judul</th>
            <th style="border-bottom: 1px solid #ddd; padding: 10px; text-align: left;">Tanggal</th>
        </tr>
        <?php
        $no = 1;
        foreach ($user_posts as $post) { ?>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?php echo $no++; ?></td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                    <a href="<?php echo get_permalink($post->ID); ?>" target="_blank">
                        <?php echo esc_html($post->post_title); ?>
                    </a>
                </td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?php echo esc_html($post->post_date); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>