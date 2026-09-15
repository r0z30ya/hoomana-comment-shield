<?php
/**
 * Small optional dashboard statistic.
 *
 * @package Hoomana_Native_Comment_Guard
 */

defined( 'ABSPATH' ) || exit;

class HCNCG_Dashboard {
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'register_widget' ) );
	}

	public function register_widget() {
		wp_add_dashboard_widget( 'hcncg_stats_widget', __( 'Native Comment Guard', 'hoomana-native-comment-guard' ), array( $this, 'render_widget' ) );
	}

	public function render_widget() {
		$count = (int) get_option( 'hcncg_blocked_count', 0 );
		/* translators: %s: number of blocked spam comments. */
		$message = sprintf( _n( '%s spam comment blocked', '%s spam comments blocked', $count, 'hoomana-native-comment-guard' ), number_format_i18n( $count ) );
		echo '<p><strong>' . esc_html( $message ) . '</strong></p>';
		echo '<p>' . esc_html__( 'No CAPTCHA, external service, or configuration required.', 'hoomana-native-comment-guard' ) . '</p>';
	}
}
