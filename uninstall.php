<?php
// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete the plugin's database table
global $wpdb;
$table_name = $wpdb->prefix . 'deployment_logs';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

// Delete plugin options
delete_option('site_deploy_webhook_url');