<?php

// Prevent direct access
defined('ABSPATH') || exit;

class Site_Deploy_Manager {
    
    private static $instance = null;

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'deploy_manager_menu'));
        add_action('admin_enqueue_scripts', array($this, 'deploy_manager_scripts'));
        add_action('wp_ajax_trigger_deployment', array($this, 'handle_deployment'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_settings_page'));
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        register_activation_hook(__FILE__, array($this, 'deploy_manager_install'));
    }

    public function add_settings_page() {
        add_submenu_page(
            'deploy-manager',
            'Deploy Settings',
            'Settings',
            'manage_options',
            'deploy-manager-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting('deploy_manager_settings', 'site_deploy_webhook_url');
        
        add_settings_section(
            'deploy_manager_main',
            'Deployment Settings',
            null,
            'deploy-manager-settings'
        );

        add_settings_field(
            'site_deploy_webhook_url',
            'Webhook URL',
            array($this, 'webhook_url_callback'),
            'deploy-manager-settings',
            'deploy_manager_main'
        );
    }

    public function webhook_url_callback() {
        $webhook_url = get_option('site_deploy_webhook_url');
        echo '<input type="url" name="site_deploy_webhook_url" value="' . esc_attr($webhook_url) . '" class="regular-text">';
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Deploy Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('deploy_manager_settings');
                do_settings_sections('deploy-manager-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Add admin menu item
     */
    public function deploy_manager_menu() {
        add_menu_page(
            'Deploy Site',
            'Deploy',
            'manage_options',
            'deploy-manager',
            array($this, 'deploy_manager_page'),
            'dashicons-upload',
            100
        );
    }

    /**
     * Create database table on activation
     */
    public function deploy_manager_install() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'deployment_logs';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            deploy_time datetime DEFAULT CURRENT_TIMESTAMP,
            status varchar(20) NOT NULL,
            response_message text,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Enqueue scripts and styles
     */
    public function deploy_manager_scripts($hook) {
        if($hook != 'toplevel_page_deploy-manager') return;
        
        wp_enqueue_script('deploy-manager-js', 
            SITE_DEPLOY_PLUGIN_URL . 'assets/js/deploy-manager.js', 
            array(), 
            SITE_DEPLOY_VERSION, 
            true
        );
        
        wp_localize_script('deploy-manager-js', 'deployManagerData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('deploy-manager-nonce')
        ));
        
        wp_enqueue_style('deploy-manager-css', 
            SITE_DEPLOY_PLUGIN_URL . 'assets/css/deploy-manager.css',
            array(),
            SITE_DEPLOY_VERSION
        );
    }

    /**
     * Handle the deployment AJAX request
     */
    public function handle_deployment() {
        check_ajax_referer('deploy-manager-nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
        }
        
        $webhook_url = get_option('site_deploy_webhook_url', '');
        
        if (empty($webhook_url)) {
            wp_send_json_error('Webhook URL not configured');
        }
        
        $response = wp_remote_post($webhook_url, array(
            'method' => 'POST',
            'timeout' => 45,
            'headers' => array('Content-Type' => 'application/json'),
            'body' => json_encode(array('trigger' => 'manual'))
        ));
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'deployment_logs';
        
        if (is_wp_error($response)) {
            $wpdb->insert($table_name, array(
                'status' => 'failed',
                'response_message' => $response->get_error_message()
            ));
            wp_send_json_error($response->get_error_message());
        } else {
            $wpdb->insert($table_name, array(
                'status' => 'success',
                'response_message' => wp_remote_retrieve_body($response)
            ));
            wp_send_json_success('Deployment triggered successfully');
        }
    }

    /**
     * Render the admin page
     */
    public function deploy_manager_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'deployment_logs';
        $logs = $wpdb->get_results("SELECT * FROM $table_name ORDER BY deploy_time DESC LIMIT 10");
        
        include SITE_DEPLOY_PLUGIN_DIR . 'admin/views/deploy-page.php';
    }

    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}