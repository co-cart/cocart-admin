<?php
/**
 * Manages CoCart assets in the WordPress dashboard.
 *
 * @author  Sébastien Dumont
 * @package CoCart\Admin
 * @since   1.2.0 Introduced.
 * @version 4.0.0
 * @license GPL-2.0+
 */

namespace CoCart\Admin;

use CoCart\Help;

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
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Adds admin body classes.
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
	} // END __construct()

	/**
	 * Registers and enqueue Stylesheets.
	 *
	 * @access public
	 *
	 * @since 1.2.0 Introduced.
	 * @since 4.0.0 Added Javascript for the settings page.
	 */
	public function admin_enqueue_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';
		$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( in_array( $screen_id, Help::cocart_get_admin_screens() ) ) {
			wp_register_style( COCART_SLUG . '_admin', COCART_ADMIN_URL_PATH . '/assets/css/admin/cocart' . $suffix . '.css', array(), COCART_VERSION );
			wp_enqueue_style( COCART_SLUG . '_admin' );
			wp_style_add_data( COCART_SLUG . '_admin', 'rtl', 'replace' );
			if ( $suffix ) {
				wp_style_add_data( COCART_SLUG . '_admin', 'suffix', '.min' );
			}

			wp_register_script( COCART_SLUG . '-admin', COCART_ADMIN_URL_PATH . '/assets/js/admin/settings' . $suffix . '.js', array( 'jquery' ), COCART_VERSION );
			wp_enqueue_script( COCART_SLUG . '-admin' );
			wp_localize_script( COCART_SLUG . '-admin', 'cocart_params', array(
				'root'                     => esc_url_raw( rest_url() ),
				'saved_message'            => esc_html__( 'Settings saved successfully.', 'cart-rest-api-for-woocommerce' ),
				'i18n_nav_warning'         => __( 'The changes you made will be lost if you navigate away from this page.', 'cart-rest-api-for-woocommerce' ),
				'i18n_regenerate_token'    => __( 'Are you sure you want to regenerate your access token?', 'cart-rest-api-for-woocommerce' ),
				'ajax_url'                 => admin_url( 'admin-ajax.php' ),
				'generate_token_nonce'     => wp_create_nonce( 'regenerate_token' ),
				'i18n_generated_new_token' => __( 'New access token generated.', 'cart-rest-api-for-woocommerce' ),
				'i18n_no_generated_token'  => __( 'Access token failed to generate.', 'cart-rest-api-for-woocommerce' )
			) );
		}
	} // END admin_enqueue_scripts()

	/**
	 * Adds admin body class for CoCart page.
	 *
	 * @access public
	 *
	 * @since   1.2.0 Introduced.
	 * @version 3.0.7
	 *
	 * @param string $classes Classes already registered.
	 *
	 * @return string $classes All classes registered.
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
