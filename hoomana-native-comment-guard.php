<?php
/**
 * Plugin Name:       Hoomana Native Comment Guard
 * Plugin URI:        https://github.com/r0z30ya/hoomana-comment-shield
 * Description:       Block automated comment spam quietly. No CAPTCHA, no configuration, no cookies, and no external service.
 * Version:           0.1.5
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            Hooman
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hoomana-native-comment-guard
 *
 * @package Hoomana_Native_Comment_Guard
 */

defined( 'ABSPATH' ) || exit;

define( 'HCNCG_VERSION', '0.1.5' );
define( 'HCNCG_FILE', __FILE__ );
define( 'HCNCG_DIR', plugin_dir_path( __FILE__ ) );

require_once HCNCG_DIR . 'includes/class-hcncg-honeypot.php';
require_once HCNCG_DIR . 'includes/class-hcncg-validator.php';
require_once HCNCG_DIR . 'includes/class-hcncg-dashboard.php';

/** Enqueues the frontend honeypot styling. */
function hcncg_enqueue_styles() {
	wp_enqueue_style(
		'hcncg-honeypot',
		plugins_url( 'assets/css/hcncg-honeypot.css', HCNCG_FILE ),
		array(),
		HCNCG_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'hcncg_enqueue_styles' );

/** Starts the plugin. */
function hcncg_bootstrap() {
	new HCNCG_Honeypot();
	new HCNCG_Validator();

	if ( is_admin() ) {
		new HCNCG_Dashboard();
	}
}
add_action( 'plugins_loaded', 'hcncg_bootstrap' );

/** Creates the small, non-autoloaded statistics option. */
function hcncg_activate() {
	add_option( 'hcncg_blocked_count', 0, '', false );
}
register_activation_hook( HCNCG_FILE, 'hcncg_activate' );
