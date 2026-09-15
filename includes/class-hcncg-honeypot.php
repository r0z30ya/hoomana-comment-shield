<?php
/**
 * Comment-form fields used to identify unsophisticated automated submissions.
 *
 * @package Hoomana_Native_Comment_Guard
 */

defined( 'ABSPATH' ) || exit;

class HCNCG_Honeypot {
	const FIELD_PREFIX = 'hcncg_hp_';

	/** Registers fields for logged-out and logged-in commenters. */
	public function __construct() {
		add_filter( 'comment_form_default_fields', array( $this, 'remove_website_field' ) );
		add_action( 'comment_form_after_fields', array( $this, 'render_fields' ) );
		add_action( 'comment_form_logged_in_after', array( $this, 'render_fields' ) );
	}

	/** Removes the website field from WordPress's standard comment form. */
	public function remove_website_field( $fields ) {
		unset( $fields['url'] );
		return $fields;
	}

	/**
	 * Returns an opaque field name. The daily rotation avoids a permanently
	 * hard-coded selector. The submitted field name is signed so cached forms
	 * from an earlier rotation remain valid.
	 */
	public static function get_field_name() {
		return self::FIELD_PREFIX . substr( wp_hash( 'honeypot|' . gmdate( 'Y-m-d' ) ), 0, 12 );
	}

	/** Outputs the honeypot and a signed form-render timestamp. */
	public function render_fields() {
		$field_name = self::get_field_name();
		$timestamp  = time();
		$signature  = wp_hash( 'hcncg-comment|' . $field_name . '|' . $timestamp, 'auth' );
		?>
		<p class="hcncg-honeypot" aria-hidden="true">
			<label for="<?php echo esc_attr( $field_name ); ?>"><?php esc_html_e( 'Leave this field empty', 'hoomana-native-comment-guard' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $field_name ); ?>" name="<?php echo esc_attr( $field_name ); ?>" value="" tabindex="-1" autocomplete="off" />
		</p>
		<input type="hidden" name="hcncg_started" value="<?php echo esc_attr( (string) $timestamp ); ?>" />
		<input type="hidden" name="hcncg_honeypot_name" value="<?php echo esc_attr( $field_name ); ?>" />
		<input type="hidden" name="hcncg_signature" value="<?php echo esc_attr( $signature ); ?>" />
		<?php
	}
}
