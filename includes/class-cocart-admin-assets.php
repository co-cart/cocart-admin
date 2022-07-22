<?php
/**
 * Manages CoCart assets in the WordPress dashboard.
 *
 * @author  Sébastien Dumont
 * @package CoCart\Admin
 * @since   1.2.0
 * @version 4.0.0
 * @license GPL-2.0+
 */

namespace CoCart\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Assets {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {
		// Registers and enqueue Stylesheets.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );

		// Adds admin body classes.
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
	} // END __construct()

	/**
	 * Registers and enqueue Stylesheets.
	 *
	 * @access  public
	 * @since   1.2.0
	 * @version 3.0.17
	 */
	public function admin_styles() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';
		$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( in_array( $screen_id, CoCart\Help::cocart_get_admin_screens() ) ) {
			wp_register_style( COCART_SLUG . '_admin', COCART_ADMIN_URL_PATH . '/assets/css/admin/cocart' . $suffix . '.css', array(), COCART_VERSION );
			wp_enqueue_style( COCART_SLUG . '_admin' );
			wp_style_add_data( COCART_SLUG . '_admin', 'rtl', 'replace' );
			if ( $suffix ) {
				wp_style_add_data( COCART_SLUG . '_admin', 'suffix', '.min' );
			}
		}
		if ( $suffix ) {
			wp_style_add_data( COCART_SLUG . '_admin', 'suffix', '.min' );
		}
	} // END admin_styles()

	/**
	 * Adds admin body class for CoCart page.
	 *
	 * @access  public
	 * @since   1.2.0
	 * @version 3.0.7
	 * @param   string $classes - Classes already registered.
	 * @return  string $classes - All classes registered.
	 */
	public function admin_body_class( $classes ) {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		// Add body class for CoCart page.
		if ( 'toplevel_page_cocart' === $screen_id || 'toplevel_page_cocart-network' === $screen_id ) {
			$classes = ' cocart ';
		}

		// Add special body class for plugin install page.
		if ( 'plugin-install' === $screen_id || 'plugin-install-network' === $screen_id ) {
			if ( isset( $_GET['tab'] ) && 'cocart' === $_GET['tab'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$classes = ' cocart-plugin-install ';
			}
		}

		return $classes;
	} // END admin_body_class()

} // END class

return new Assets();
