<?php
/**
 * Admin View: Getting Started.
 *
 * @author  Sébastien Dumont
 * @package CoCart\Admin\Views
 * @since   1.2.0
 * @version 4.0.0
 * @license GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$campaign_args    = CoCart\Help::cocart_campaign(
	array(
		'utm_content' => 'getting-started',
	)
);
$store_url        = CoCart\Help::build_shortlink( add_query_arg( $campaign_args, COCART_STORE_URL ) );
$addons_url       = admin_url( 'plugin-install.php?tab=cocart' );
$pro_url          = CoCart\Help::build_shortlink( add_query_arg( $campaign_args, COCART_STORE_URL . 'pro/' ) );
$dev_hub_url      = CoCart\Help::build_shortlink( add_query_arg( $campaign_args, esc_url( 'https://cocart.dev/' ) ) );
?>
<div class="wrap cocart getting-started">

	<div class="container">
		<div class="content">
			<div class="logo">
				<a href="<?php echo esc_url( $store_url ); ?>" target="_blank">
					<img src="<?php echo esc_url( COCART_ADMIN_URL_PATH . '/assets/images/brand/header-logo.png' ); ?>" alt="CoCart Logo" />
				</a>
			</div>

			<h1>
				<?php
				printf(
					/* translators: 1: CoCart */
					esc_html__( 'Welcome to %s.', 'cart-rest-api-for-woocommerce' ),
					'CoCart'
				);
				?>
			</h1>

			<p>
				<?php
				printf(
					/* translators: 1: CoCart, 2: WooCommerce */
					esc_html__( 'Thank you for choosing %1$s - the #1 customizable WordPress REST API for %2$s that lets you build headless ecommerce using your favorite technologies.', 'cart-rest-api-for-woocommerce' ),
					'CoCart',
					'WooCommerce'
				);
				?>
			</p>

			<p>
				<?php
				printf(
					/* translators: 1: CoCart, 2: WooCommerce */
					esc_html__( '%1$s provides support for managing the user session, alternative options for doing this task do exist; however, their usage can be limited to applications of the same origin as the WordPress installation. This is due to %2$s using cookies to store user session tokens.', 'cart-rest-api-for-woocommerce' ),
					'CoCart',
					'WooCommerce'
				);
				?>
			</p>

			<p>
				<?php
				printf(
					/* translators: %s: CoCart */
					esc_html__( '%s provides the utilities to change this behavior during any cart request and passes the required information to HTTP Header so it can be cached client-side. The use of an HTTP Authorization header is optional allowing users to shop as a guest.', 'cart-rest-api-for-woocommerce' ),
					'CoCart'
				);
				?>
			</p>

			<p>
				<?php
				echo wp_kses_post(
					sprintf(
						/* translators: %s: CoCart */
						__( 'Now that you have %s installed your ready to start developing your headless store. We recommend that you have <code>WP_DEBUG</code> enabled to help you while testing.', 'cart-rest-api-for-woocommerce' ),
						'CoCart'
					)
				);
				?>
			</p>

			<p><?php esc_html_e( 'In the API reference you will find the API routes available with examples in a few languages.', 'cart-rest-api-for-woocommerce' ); ?></p>

			<p>
				<?php
				echo wp_kses_post(
					sprintf(
						/* translators: 1: Developers Hub link, 2: CoCart */
						__( 'At the <a href="%s" target="_blank">developers hub</a> you can find all the resources you need to be productive with %2$s and keep track of everything that is happening with the plugin including development decisions and scoping of future versions.', 'cart-rest-api-for-woocommerce' ),
						$dev_hub_url,
						'CoCart'
					)
				);
				?>
			</p>

			<p>
				<?php
				esc_html_e( 'It also provides answers to most common questions should you find that you need help and is the best place to look first before contacting support.', 'cart-rest-api-for-woocommerce' );
				?>
			</p>

			<p>
				<?php
				printf(
					/* translators: 1: CoCart, 2: WooCommerce */
					esc_html__( 'If you do need support or simply want to talk to other developers about taking your %2$s store headless, come join the %s community.', 'cart-rest-api-for-woocommerce' ),
					'CoCart',
					'WooCommerce'
				);
				?>
			</p>

			<p><?php esc_html_e( 'Thank you and enjoy!', 'cart-rest-api-for-woocommerce' ); ?></p>

			<p><?php esc_html_e( 'regards,', 'cart-rest-api-for-woocommerce' ); ?></p>

			<div class="founder-row">
				<div class="founder-image">
					<img src="<?php echo 'https://www.gravatar.com/avatar/' . md5( strtolower( trim( 'mailme@sebastiendumont.com' ) ) ) . '?d=mp&s=60'; ?>" width="60px" height="60px" alt="Photo of Founder" />
				</div>

				<div class="founder-details">
					<p>Sébastien Dumont<br><?php echo sprintf( __( 'Founder of %s', 'cart-rest-api-for-woocommerce' ), 'CoCart' ); ?></p>
				</div>
			</div>

			<p style="text-align: center;">
				<?php printf( '<a class="button button-primary button-large" href="%1$s" target="_blank">%2$s</a>', esc_url( COCART_DOCUMENTATION_URL ), esc_html__( 'View API Reference', 'cart-rest-api-for-woocommerce' ) ); ?> 
				<?php printf( '<a class="button button-secondary button-large" href="%1$s" target="_blank">%2$s</a>', esc_url( CoCart\Help::build_shortlink( add_query_arg( $campaign_args, esc_url( COCART_STORE_URL . 'community/' ) ) ) ), esc_html__( 'Join Community', 'cart-rest-api-for-woocommerce' ) ); ?>
			</p>

			<?php if ( CoCart\Help::is_cocart_ps_active() ) { ?>
			<hr>

			<p><?php printf( esc_html__( 'Want to find compatible plugins or extensions for CoCart. Checkout our plugin suggestions that can help enhance your development and your customers shopping experience.', 'cart-rest-api-for-woocommerce' ), 'CoCart' ); ?></p>

			<p style="text-align: center;">
				<?php printf( '<a class="button button-secondary button-medium" href="%1$s">%2$s</a>', esc_url( $addons_url ), esc_html__( 'View Plugin Suggestions', 'cart-rest-api-for-woocommerce' ) ); ?>
			</p>
			<?php } ?>
		</div>
	</div>

</div>
