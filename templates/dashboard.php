<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1>User Analythics</h1>

    <!-- Form Filter -->
    <form method="GET" style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <input type="hidden" name="page" value="user-analythics">
        <label for="start_date">Mulai:</label>
        <input type="date" name="start_date" value="<?php echo esc_attr($start_date); ?>" style="padding: 5px;">
        <label for="end_date">Sampai:</label>
        <input type="date" name="end_date" value="<?php echo esc_attr($end_date); ?>" style="padding: 5px;">
        <button type="submit" style="background: #0073aa; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Filter</button>
    </form>

    <div style="display: flex; justify-content: space-between; gap: 20px; width: 100%;">
        <!-- Card Statistik -->
        <div style="background: #0073aa; color: #fff; padding: 20px; border-radius: 8px; flex: 1; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <h2 style="margin-bottom: 10px; color: #f8f9fa;">Total Pengguna</h2>
            <p style="font-size: 24px; font-weight: bold;"><?php echo esc_html($total_users); ?></p>
        </div>

        <div style="background: #28a745; color: #fff; padding: 20px; border-radius: 8px; flex: 1; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <h2 style="margin-bottom: 10px; color: #f8f9fa;">Total Postingan</h2>
            <p style="font-size: 24px; font-weight: bold;"><?php echo esc_html($total_posts); ?></p>
        </div>

        <div style="background: #dc3545; color: #fff; padding: 20px; border-radius: 8px; flex: 1; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <h2 style="margin-bottom: 10px; color: #f8f9fa;">Total Komentar</h2>
            <p style="font-size: 24px; font-weight: bold;"><?php echo esc_html($total_comments); ?></p>
        </div>
    </div>


    <div style="display: flex; gap: 20px;">
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; width: 300px;">
            <h2>Statistik Umum</h2>

            <div style="background: #fff; padding: 20px; border-radius: 8px; flex: 1; width: 300px;">
                <canvas id="userChart"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var ctx = document.getElementById('userChart').getContext('2d');
                        var userChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: [
                                    <?php foreach ($user_posts as $user) {
                                        $user_info = get_userdata($user->post_author);
                                        echo "'" . esc_html($user_info->display_name) . "',";
                                    } ?>
                                ],
                                datasets: [{
                                    data: [
                                        <?php foreach ($user_posts as $user) {
                                            echo esc_html($user->post_count) . ",";
                                        } ?>
                                    ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.7)',
                                        'rgba(54, 162, 235, 0.7)',
                                        'rgba(255, 206, 86, 0.7)',
                                        'rgba(75, 192, 192, 0.7)',
                                        'rgba(153, 102, 255, 0.7)',
                                        'rgba(255, 159, 64, 0.7)'
                                    ]
                                }]
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <div style="background: #fff; padding: 20px; border-radius: 8px; flex: 1;">
            <h2>Postingan Per Pengguna</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="border-bottom: 1px solid #ddd; padding: 10px; text-align: left;">Nama Pengguna</th>
                    <th style="border-bottom: 1px solid #ddd; padding: 10px; text-align: left;">Jumlah Postingan</th>
                    <th style="border-bottom: 1px solid #ddd; padding: 10px; text-align: left;">Aksi</th>
                </tr>
                <?php foreach ($user_posts as $user) {
                    $user_info = get_userdata($user->post_author);
                    $detail_url = admin_url('admin.php?page=user-analythics-detail&user_id=' . $user->post_author . '&start_date=' . urlencode($start_date) . '&end_date=' . urlencode($end_date));
                ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                            <?php echo esc_html($user_info->display_name); ?>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                            <?php echo esc_html($user->post_count); ?>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                            <a href="<?php echo esc_url($detail_url); ?>">Lihat Detail</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>