<?php
if (!defined('ABSPATH')) {
    exit;
}

function user_analythics_get_allowed_authors()
{
    $authors = get_option('user_analythics_allowed_authors', '');
    return !empty($authors) ? explode(',', $authors) : [];
}

function user_analythics_has_access()
{
    $user = wp_get_current_user();
    $allowed_authors = user_analythics_get_allowed_authors();
    $allow_admins = get_option('user_analythics_allow_admins', 'yes');

    if ($allow_admins === 'yes' && in_array('administrator', $user->roles)) {
        return true;
    }

    return in_array($user->ID, $allowed_authors);
}
