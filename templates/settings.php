<?php
if (!defined('ABSPATH')) {
    exit;
}

$allowed_authors = get_option('user_analythics_allowed_authors', '');
$allow_admins = get_option('user_analythics_allow_admins', 'yes');

// Konversi ID ke username untuk ditampilkan di form
$stored_ids = !empty($allowed_authors) ? explode(',', $allowed_authors) : [];
$stored_usernames = [];

foreach ($stored_ids as $id) {
    $user = get_user_by('ID', $id);
    if ($user) {
        $stored_usernames[] = $user->user_login;
    }
}
?>
<div class="wrap">
    <h1>Pengaturan User Analythics</h1>
    <form method="post">
        <table class="form-table">
            <tr>
                <th><label for="allowed_authors">Username Penulis yang Diizinkan</label></th>
                <td>
                    <input type="text" name="allowed_authors" value="<?php echo esc_attr(implode(', ', $stored_usernames)); ?>" class="regular-text">
                    <p class="description">Pisahkan dengan koma jika lebih dari satu.</p>
                </td>
            </tr>
            <tr>
                <th><label for="allow_admins">Izinkan Admin</label></th>
                <td><input type="checkbox" name="allow_admins" value="yes" <?php checked($allow_admins, 'yes'); ?>></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="user_analythics_save_settings" class="button-primary" value="Simpan Pengaturan">
        </p>
    </form>
</div>