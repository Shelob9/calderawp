<?php
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
function _getenv($var, $default = '')
{
	return !empty(getenv($var)) ? getenv($var) : $default;
}

define('DB_NAME', _getenv('DB_NAME', 'wordpress'));
define('DB_USER', _getenv('DB_USER', 'wordpress'));
define('DB_PASSWORD', _getenv('DB_PASSWORD', 'wordpress'));
define('DB_HOST', _getenv('DB_HOST', 'database'));
define('DB_CHARSET', 'utf8');
define('DISABLE_WP_CRON', 'true');
define('DB_COLLATE', '');

define('WP_DEBUG', _getenv('WP_DEBUG', true ));
define('WP_DEBUG_LOG', _getenv('WP_DEBUG_LOG', true ));
define('WP_DEBUG_DISPLAY', _getenv('WP_DEBUG_DISPLAY', true ));

define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content' );
define( 'WP_CONTENT_URL', 'https://localhost:32776/wp-content' );

define( 'WPMU_PLUGIN_DIR', dirname(__FILE__) . '/mu-plugins' );
define( 'WPMU_PLUGIN_URL', 'https://calderawp.lndo.site/mu-plugins' );


define('AUTH_KEY', _getenv('AUTH_KEY', 'wordpress'));
define('SECURE_AUTH_KEY', _getenv('SECURE_AUTH_KEY', 'wordpress'));
define('LOGGED_IN_KEY', _getenv('LOGGED_IN_KEY', 'wordpress'));
define('NONCE_KEY', _getenv('NONCE_KEY', 'wordpress'));
define('AUTH_SALT', _getenv('AUTH_SALT', 'wordpress'));
define('SECURE_AUTH_SALT', _getenv('SECURE_AUTH_SALT', 'wordpress'));
define('LOGGED_IN_SALT', _getenv('LOGGED_IN_SALT', 'wordpress'));
define('NONCE_SALT', _getenv('NONCE_SALT', 'wordpress'));
$table_prefix = 'wp_';

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/wordpress');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
