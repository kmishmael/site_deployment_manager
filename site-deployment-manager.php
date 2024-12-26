<?php
/**
 * Plugin Name: Site Deployment Manager
 * Plugin URI: https://yourwebsite.com/site-deployment-manager
 * Description: Adds a deployment button that triggers a webhook and logs deployments
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: site-deployment-manager
 * Domain Path: /languages
 *
 * @package Site_Deployment_Manager
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('SITE_DEPLOY_VERSION', '1.0.0');
define('SITE_DEPLOY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SITE_DEPLOY_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the main plugin class
require_once SITE_DEPLOY_PLUGIN_DIR . 'includes/class-deploy-manager.php';

// Initialize the plugin
function run_site_deployment_manager() {
    $plugin = new Site_Deploy_Manager();
    $plugin->init();
}
run_site_deployment_manager();