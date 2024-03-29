<?php
/**
 * CoCart - WooCommerce Admin: Thanks for Installing
 *
 * Adds a note for the client thanking them for installing the plugin.
 *
 * @author  Sébastien Dumont
 * @package CoCart\Admin\WooCommerce Admin\Notes
 * @since   2.3.0
 * @version 4.0.0
 * @license GPL-2.0+
 */

namespace CoCart\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CoCart_WC_Admin_Thanks_Install_Note extends WCAdminNotes {

	/**
	 * Name of the note for use in the database.
	 */
	const NOTE_NAME = 'cocart-wc-admin-thanks-install';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {
		self::add_note( self::NOTE_NAME );
	}

	/**
	 * Add note.
	 *
	 * @access public
	 *
	 * @static
	 *
	 * @since 2.3.0 Introduced.
	 * @since 3.2.0 Dropped support for WooCommerce less than version 4.8
	 *
	 * @param string $note_name Note name.
	 * @param string $seconds   How many seconds since CoCart was installed before the notice is shown.
	 * @param string $source    Source of the note.
	 */
	public static function add_note( $note_name = '', $seconds = '', $source = 'cocart' ) {
		parent::add_note( $note_name, $seconds, $source );

		$args = self::get_note_args();

		// If no arguments return then we cant create a note.
		if ( is_array( $args ) && empty( $args ) ) {
			return;
		}

		$data_store = \Automattic\WooCommerce\Admin\Notes\Notes::load_data_store();

		// We already have this note? Then don't create it again.
		$note_ids = $data_store->get_notes_with_name( self::NOTE_NAME );
		if ( ! empty( $note_ids ) ) {
			return;
		}

		// Otherwise, create new note.
		self::create_new_note( $args );
	} // END add_note()

	/**
	 * Get note arguments.
	 *
	 * @access public
	 *
	 * @static
	 *
	 * @since 2.3.0 Introduced.
	 * @since 3.2.0 Dropped support for WooCommerce less than version 4.8
	 * @version 4.0.0
	 *
	 * @return array
	 */
	public static function get_note_args() {
		$status = \Automattic\WooCommerce\Admin\Notes\Note::E_WC_ADMIN_NOTE_UNACTIONED;

		$args = array(
			'title'   => sprintf(
				/* translators: %s: CoCart */
				esc_attr__( 'Thank you for installing %s!', 'cart-rest-api-for-woocommerce' ),
				'CoCart'
			),
			'content' => wp_kses_post(
				sprintf(
					/* translators: %s: CoCart */
					__( 'Now that you have %s installed your ready to start developing your headless store. We recommend that you have <code>WP_DEBUG</code> enabled to help you while testing. In the API reference you will find the API routes available with examples in a few languages.', 'cart-rest-api-for-woocommerce' ),
					'CoCart'
				)
			),
			'name'    => self::NOTE_NAME,
			'actions' => array(
				array(
					'name'    => 'cocart-view-api-reference',
					'label'   => __( 'View API Reference', 'cart-rest-api-for-woocommerce' ),
					'url'     => esc_url( COCART_DOCUMENTATION_URL ),
					'status'  => $status,
					'primary' => true,
				),
			),
		);

		return $args;
	} // END get_note_args()

} // END class

return new CoCart_WC_Admin_Thanks_Install_Note();
