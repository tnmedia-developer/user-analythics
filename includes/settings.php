<?php
if (!defined('ABSPATH')) {
    exit;
}

function user_analythics_settings_page()
{
    $warning_messages = []; // Array untuk menyimpan pesan peringatan

    if (isset($_POST['user_analythics_save_settings'])) {
        if (!empty($_POST['allowed_authors'])) {
            $usernames = explode(',', sanitize_text_field($_POST['allowed_authors']));
            $user_ids = [];
            $invalid_usernames = []; // Array untuk menyimpan username yang tidak ditemukan

            foreach ($usernames as $username) {
                $username = trim($username);
                $user = get_user_by('login', $username); // Ambil user berdasarkan username

                if ($user) {
                    $user_ids[] = $user->ID;
                } else {
                    $invalid_usernames[] = $username; // Simpan username yang tidak ditemukan
                }
            }

            update_option('user_analythics_allowed_authors', implode(',', $user_ids));

            // Jika ada username yang tidak ditemukan, tambahkan ke peringatan
            if (!empty($invalid_usernames)) {
                $warning_messages[] = 'Username berikut tidak ditemukan: <strong>' . implode(', ', $invalid_usernames) . '</strong>. Pastikan mereka sudah terdaftar di sistem.';
            }
        } else {
            update_option('user_analythics_allowed_authors', '');
        }

        update_option('user_analythics_allow_admins', isset($_POST['allow_admins']) ? 'yes' : 'no');

        echo '<div class="updated"><p>Pengaturan berhasil disimpan.</p></div>';
    }

    // Tampilkan peringatan jika ada username yang tidak valid
    if (!empty($warning_messages)) {
        echo '<div class="notice notice-warning"><p>' . implode('<br>', $warning_messages) . '</p></div>';
    }

    include plugin_dir_path(__FILE__) . '../templates/settings.php';
}
