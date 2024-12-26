<?php
/**
 * Plugin Name: Site Deployment Manager
 * Description: Adds a deployment button that triggers a webhook and logs deployments
 * Version: 1.0.0
 * Author: Kibet Ishmael
 * Author URI: https://github.com/kmishmael
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

/**
* Handles activation hook.
*/
function deploy_manager_install_hook() {
   $plugin = Site_Deploy_Manager::get_instance();
   $plugin->deploy_manager_install();
}

/**
 * Initialize the plugin.
 */
function run_site_deployment_manager() {
    Site_Deploy_Manager::get_instance();
}

register_activation_hook(__FILE__, 'deploy_manager_install_hook');

run_site_deployment_manager();