<?php
/**
 * Admin View: PHP Requirement Notice.
 *
 * @author  Sébastien Dumont
 * @package CoCart\Admin\Views
 * @since   2.6.0
 * @version 4.0.0
 * @license GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="notice notice-error">
	<p><?php echo esc_html( CoCart\Help::get_environment_message() ); ?></p>
</div>
