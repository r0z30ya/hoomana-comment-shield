<?php
/**
 * Server-side validation for native WordPress comment submissions.
 *
 * @package Hoomana_Comment_Shield
 */

defined( 'ABSPATH' ) || exit;

class HCS_Validator {
	const MINIMUM_FILL_SECONDS = 3;

	/** Registers early validation before WordPress creates the comment. */
	public function __construct() {
		add_filter( 'preprocess_comment', array( $this, 'validate' ), 1 );
	}

	/** Validates the native form, leaving API integrations untouched. */
	public function validate( $comment_data ) {
		if ( $this->should_skip() ) {
			return $comment_data;
		}

		$started        = isset( $_POST['hcs_started'] ) ? absint( wp_unslash( $_POST['hcs_started'] ) ) : 0;
		$signature      = isset( $_POST['hcs_signature'] ) && is_string( $_POST['hcs_signature'] ) ? sanitize_text_field( wp_unslash( $_POST['hcs_signature'] ) ) : '';
		$honeypot_field = isset( $_POST['hcs_honeypot_name'] ) && is_string( $_POST['hcs_honeypot_name'] ) ? sanitize_key( wp_unslash( $_POST['hcs_honeypot_name'] ) ) : '';
		$honeypot_value = isset( $_POST[ $honeypot_field ] ) && is_string( $_POST[ $honeypot_field ] ) ? trim( wp_unslash( $_POST[ $honeypot_field ] ) ) : null;
		$valid_name     = (bool) preg_match( '/^hcs_hp_[a-f0-9]{12}$/', $honeypot_field );

		if ( null !== $honeypot_value && '' !== $honeypot_value ) {
			$this->reject( __( 'Your comment could not be submitted.', 'hoomana-comment-shield' ), true );
		}

		$expected = ( $started && $honeypot_field ) ? wp_hash( 'hcs-comment|' . $honeypot_field . '|' . $started, 'auth' ) : '';
		if ( ! $started || ! $valid_name || null === $honeypot_value || ! hash_equals( $expected, $signature ) ) {
			$this->reject( __( 'Please reload the page and try again.', 'hoomana-comment-shield' ), false );
		}

		if ( time() - $started < self::MINIMUM_FILL_SECONDS ) {
			$this->reject( __( 'Your comment could not be submitted.', 'hoomana-comment-shield' ), true );
		}

		return $comment_data;
	}

	/** Gives API clients and explicitly opted-out integrations a safe bypass. */
	private function should_skip() {
		$skip = ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST );
		return (bool) apply_filters( 'hcs_skip_comment_validation', $skip );
	}

	/** Counts spam signals and returns a generic 403 response. */
	private function reject( $message, $count_as_spam ) {
		if ( $count_as_spam ) {
			global $wpdb;
			$updated = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->options} SET option_value = option_value + 1 WHERE option_name = %s", 'hcs_blocked_count' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
			if ( ! $updated ) {
				add_option( 'hcs_blocked_count', 1, '', false );
			}
			wp_cache_delete( 'hcs_blocked_count', 'options' );
		}

		wp_die(
			esc_html( $message ),
			esc_html__( 'Comment blocked', 'hoomana-comment-shield' ),
			array( 'response' => 403, 'back_link' => true )
		);
	}
}
