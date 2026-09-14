<?php
/** Uninstall cleanup for Hoomana Comment Shield. */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'hcs_blocked_count' );
