<?php
/** Uninstall cleanup for Hoomana Native Comment Guard. */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'hcncg_blocked_count' );
