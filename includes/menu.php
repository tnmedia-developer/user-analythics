<?php
if (!defined('ABSPATH')) {
    exit;
}

function user_analythics_add_menu()
{
    add_menu_page(
        'User Analythics',
        'User Analythics',
        'manage_options',
        'user-analythics',
        'user_analythics_dashboard',
        'dashicons-chart-pie',
        25
    );

    add_submenu_page(
        'user-analythics',
        'Detail User',
        'Detail',
        'manage_options',
        'user-analythics-detail',
        'user_analythics_detail_page'
    );

    add_submenu_page(
        'user-analythics',
        'Settings',
        'Settings',
        'manage_options',
        'user-analythics-settings',
        'user_analythics_settings_page'
    );
}
add_action('admin_menu', 'user_analythics_add_menu');
