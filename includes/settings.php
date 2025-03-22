<?php
if (!defined('ABSPATH')) {
    exit;
}

function user_analythics_settings_page()
{
    if (isset($_POST['user_analythics_save_settings'])) {
        update_option('user_analythics_allowed_authors', sanitize_text_field($_POST['allowed_authors']));
        update_option('user_analythics_allow_admins', isset($_POST['allow_admins']) ? 'yes' : 'no');
        echo '<div class="updated"><p>Pengaturan berhasil disimpan.</p></div>';
    }

    include plugin_dir_path(__FILE__) . '../templates/settings.php';
}
