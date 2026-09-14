<?php
/*
/**
 * Plugin Name:       Hoomana Comment Shield – Anti-Spam Without CAPTCHA
 * Plugin URI:        https://github.com/r0z30ya/hoomana-comment-shield
 * Description:       Block automated comment spam quietly. No CAPTCHA, no configuration, no cookies, and no external service.
 * Version:           0.1.3
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            Hooman
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hoomana-comment-shield
 * Domain Path:       /languages
 */
 *
 * @package Hoomana_Comment_Shield
 */

defined( 'ABSPATH' ) || exit;

define( 'HCS_VERSION', '0.1.3' );
define( 'HCS_FILE', __FILE__ );
define( 'HCS_DIR', plugin_dir_path( __FILE__ ) );

require_once HCS_DIR . 'includes/class-hcs-honeypot.php';
require_once HCS_DIR . 'includes/class-hcs-validator.php';
require_once HCS_DIR . 'includes/class-hcs-dashboard.php';

/** Loads translations supplied by WordPress.org or bundled with the plugin. */
function hcs_load_textdomain() {
	load_plugin_textdomain( 'hoomana-comment-shield', false, dirname( plugin_basename( HCS_FILE ) ) . '/languages' );
}
add_action( 'init', 'hcs_load_textdomain' );

/** Starts the plugin. */
function hcs_bootstrap() {
	new HCS_Honeypot();
	new HCS_Validator();

	if ( is_admin() ) {
		new HCS_Dashboard();
	}
}
add_action( 'plugins_loaded', 'hcs_bootstrap' );

/** Creates the small, non-autoloaded statistics option. */
function hcs_activate() {
	add_option( 'hcs_blocked_count', 0, '', false );
}
register_activation_hook( HCS_FILE, 'hcs_activate' );
