<?php
/**
 * Activate theme.
 *
 * @package xts
 */

namespace XTS;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Activate theme.
 */
class Activation {
	private $_api     = null;
	private $_notices = null;

	function __construct() {
		$this->_api     = Registry::getInstance()->api;
		$this->_notices = Registry::getInstance()->notices;

		$this->process_form();
	}

	/**
	 * License page template.
	 *
	 * @return void
	 */
	public function form() {
		?>
		<div class="xts-box xts-license xts-theme-style">
			<div class="xts-box-header">
				<h3><?php esc_html_e( 'Theme license', 'woodmart' ); ?></h3>
				<p><?php esc_html_e( 'Activate your purchase code for this domain to turn on auto updates function.', 'woodmart' ); ?></p>
			</div>
			<div class="xts-box-content">
				<div class="xts-row">
					<div class="xts-col-12 xts-col-xl-5 xts-license-img">
						<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/license.svg' ); ?>" alt="license banner">
					</div>
					<div class="xts-col-12 xts-col-xl-7 xts-license-content">
						<?php $this->_notices->show_msgs(); ?>
						<?php if ( woodmart_is_license_activated() ) : ?>
							<div class="xts-activated-message">
								<p>
									Thank you for activation. Now you are able to get automatic updates for our theme via 
									<a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>">Appearance -> Themes</a> or via 
									<a href="<?php echo esc_url( admin_url( 'update-core.php?force-check=1' ) ); ?>">Dashboard -> Updates</a>. 
									You can click this button to deactivate your license code from this domain if you are going to transfer your website to some other domain or server.
								</p>
								<form action="" class="xts-form xts-activation-form" method="post">
									<?php wp_nonce_field( 'xts-license-deactivation' ); ?>
									<input type="hidden" name="purchase-code-deactivate" value="1"/>
									<div class="xts-license-btn xts-deactivate-btn xts-i-close">
										<input class="xts-btn xts-color-warning" type="submit" value="<?php esc_attr_e( 'Deactivate theme', 'woodmart' ); ?>" />
									</div>
								</form>
							</div>
						<?php else : ?>
							<form action="" class="xts-form xts-activation-form" method="post">
								<?php wp_nonce_field( 'xts-license-activation' ); ?>
								<label for="purchase-code"><?php esc_html_e( 'Purchase code', 'woodmart' ); ?> (<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Where can I get my purchase code?</a>)</label>
								<div class="xts-activation-form-inner">
									<input type="text" name="purchase-code" placeholder="Example: 1e71cs5f-13d9-41e8-a140-2cff01d96afb" id="purchase-code" required>
									<span>
										<?php echo woodmart_is_license_activated() ? esc_html__( 'Activated', 'woodmart' ) : esc_html__( 'Not activated', 'woodmart' ); ?>
									</span>
								</div>
								<div class="xts-dev-domain-agree">
									<label for="xts-dev-domain-label">
										<input id="xts-dev-domain-label" type="checkbox" name="xts-dev-domain" value="1" <?php checked( isset( $_REQUEST['xts-dev-domain'] ), '1' ); ?> />
										<?php esc_html_e( 'Development domain', 'woodmart' ); ?>
									</label>
								</div>
								<div class="xts-activation-form-agree">
									<label for="agree_stored" class="agree-label">
										<input type="checkbox" name="agree_stored" id="agree_stored" required>
										<?php esc_html_e( 'I agree that my purchase code and user data will be stored.', 'woodmart' ); ?>
									</label>
								</div>
								<div class="xts-license-btn xts-activate-btn xts-i-key">
									<input class="xts-btn xts-color-primary" name="woodmart-purchase-code" type="submit" value="<?php esc_attr_e( 'Activate theme', 'woodmart' ); ?>" />
								</div>
							</form>
						<?php endif; ?>
						<p class="xts-note">
							<?php
							echo wp_kses(
								'<span>Note:</span> you are allowed to use our theme only on one domain if you purchased a regular license. But we give you the ability to activate our theme on two domains: for the development website and your production website.',
								woodmart_get_allowed_html()
							);
							?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Process theme activation or deactivation.
	 *
	 * @return void
	 */
	public function process_form() {
		if ( isset( $_POST['purchase-code-deactivate'] ) ) {
			check_admin_referer( 'xts-license-deactivation' );
			$this->deactivate();
			$this->_notices->add_success( 'Theme license is successfully deactivated.' );
			return;
		}

		// Initialize variables
		$code = isset( $_POST['purchase-code'] ) ? sanitize_text_field( $_POST['purchase-code'] ) : '';
		$data = [
			'token' => $code,
		];
		$dev = isset( $_POST['xts-dev-domain'] ) ? 1 : 0;

		if ( empty( $code ) || empty( $data['token'] ) ) {
			$this->_notices->add_error( 'Purchase code is required to activate the theme.' );
			return;
		}

		$this->activate( $code, $data['token'], $dev );

		$this->_notices->add_success( 'The license is verified and the theme is activated successfully. Auto updates function is enabled.' );
	}

	/**
	 * Activate theme.
	 *
	 * @param string $purchase Purchase code.
	 * @param string $token Token.
	 * @param int    $dev Development domain flag.
	 *
	 * @return void
	 */
	public function activate( $purchase = '', $token = '', $dev = 0 ) {
		if ( empty( $purchase ) || empty( $token ) ) {
			$this->_notices->add_error( 'Activation failed due to missing data.' );
			return;
		}

		update_option( 'woodmart_token', $token );
		update_option( 'woodmart_is_activated', true );
		update_option( 'woodmart_purchase_code', $purchase );
		update_option( 'woodmart_dev_domain', $dev );
	}

	/**
	 * Deactivate theme.
	 *
	 * @return void
	 */
	public function deactivate() {
		$this->_api->call( 'deactivate/' . get_option( 'woodmart_token' ) );

		delete_option( 'woodmart_token' );
		delete_option( 'woodmart_is_activated' );
		delete_option( 'woodmart_purchase_code' );
		delete_option( 'woodmart-update-time' );
		delete_option( 'woodmart-update-info' );
		delete_option( 'woodmart_dev_domain' );
	}
}
