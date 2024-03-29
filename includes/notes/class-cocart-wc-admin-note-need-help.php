<?php
/**
 * CoCart - WooCommerce Admin: Need Help?
 *
 * Adds a note to ask the client if they need help with CoCart.
 *
 * @author  Sébastien Dumont
 * @package CoCart\Admin\WooCommerce Admin\Notes
 * @since   2.3.0
 * @version 4.0.0
 * @license GPL-2.0+
 */

namespace CoCart\Admin;

use CoCart\Help;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CoCart_WC_Admin_Need_Help_Note extends WCAdminNotes {

	/**
	 * Name of the note for use in the database.
	 */
	const NOTE_NAME = 'cocart-wc-admin-need-help';

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {
		self::add_note( self::NOTE_NAME, 8 * DAY_IN_SECONDS );
	}

	/**
	 * Add note.
	 *
	 * @access public
	 *
	 * @static
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
	 * @since 4.0.0 Updated to use namespaces.
	 *
	 * @return array
	 */
	public static function get_note_args() {
		$status = \Automattic\WooCommerce\Admin\Notes\Note::E_WC_ADMIN_NOTE_UNACTIONED;

		$campaign_args = Help::cocart_campaign(
			array(
				'utm_campaign' => 'wc-admin',
				'utm_content'  => 'wc-inbox',
			)
		);

		$args = array(
			'title'   => __( 'Need help with CoCart?', 'cart-rest-api-for-woocommerce' ),
			'content' => __( 'You can ask a question on the support forum or discuss with other CoCart developers in the Slack community.', 'cart-rest-api-for-woocommerce' ),
			'name'    => self::NOTE_NAME,
			'actions' => array(
				array(
					'name'    => 'cocart-learn-more-support',
					'label'   => __( 'Learn more', 'cart-rest-api-for-woocommerce' ),
					'url'     => Help::build_shortlink( add_query_arg( $campaign_args, esc_url( COCART_STORE_URL . 'support/' ) ) ),
					'status'  => $status,
					'primary' => true,
				),
			),
		);

		return $args;
	} // END get_note_args()

} // END class

return new CoCart_WC_Admin_Need_Help_Note();
