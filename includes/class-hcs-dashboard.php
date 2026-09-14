<?php
/**
 * Small optional dashboard statistic.
 *
 * @package Hoomana_Comment_Shield
 */

defined( 'ABSPATH' ) || exit;

class HCS_Dashboard {
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'register_widget' ) );
	}

	public function register_widget() {
		wp_add_dashboard_widget( 'hcs_stats_widget', __( 'Comment Shield', 'hoomana-comment-shield' ), array( $this, 'render_widget' ) );
	}

	public function render_widget() {
		$count = (int) get_option( 'hcs_blocked_count', 0 );
		/* translators: %s: number of blocked spam comments. */
		$message = sprintf( _n( '%s spam comment blocked', '%s spam comments blocked', $count, 'hoomana-comment-shield' ), number_format_i18n( $count ) );
		echo '<p><strong>' . esc_html( $message ) . '</strong></p>';
		echo '<p>' . esc_html__( 'No CAPTCHA, external service, or configuration required.', 'hoomana-comment-shield' ) . '</p>';
	}
}
