# Site Deployment Manager

A WordPress plugin that adds a deployment button to trigger static site rebuilds via webhook.

## Description

Site Deployment Manager adds a convenient deployment button to your WordPress admin panel that triggers a webhook to rebuild your static site. The plugin includes built-in logging functionality to track deployment history.

## Features

- One-click deployment trigger from WordPress admin
- Configurable webhook URL
- Deployment history logging
- Clean, modern UI with status indicators
- Secure nonce verification
- Rate limiting to prevent multiple simultaneous deployments

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher

## Installation

1. Upload the plugin files to `/wp-content/plugins/site-deployment-manager`
2. Activate the plugin through the 'Plugins' screen in WordPress  
3. Configure your webhook URL in the plugin settings

## Usage

1. Go to WordPress admin panel
2. Click on the "Deploy" menu item on the left tab.
3. Configure your webhook URL in Settings
4. Use the "Deploy Site" button to trigger builds
5. View deployment history in the logs table

## Screenshots

1. Deployment dashboard with one-click deploy button and logs showing history and status

![](/public_assets/dashboard.png)

2. Deployment settings to configure webhook URL

![](/public_assets/settings.png)

## License

This project is licensed under the GPL v2 or later - see the [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) file for details.

## Author

Kibet Ishmael ([GitHub](https://github.com/kmishmael))

## Version History

### 1.0.0
- Initial release