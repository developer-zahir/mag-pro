<?php
/**
 * Admin notices for required plugins
 *
 * @package Mag Pro
 * @author  Developer Zahir
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display admin notice if Mag Pro Elements plugin is not active
 */
function magpro_required_plugin_admin_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	// Check if Mag Pro Elements is loaded
	if ( defined( 'MAGPRO_ELEMENTS_VERSION' ) ) {
		return;
	}

	$install_url = admin_url( 'themes.php?page=tgmpa-install-plugins' );
	?>
	<div class="notice notice-warning is-dismissible" style="border-left-color: #ff2232; padding: 12px 15px;">
		<h3 style="margin: 0 0 8px; color: #171921;">
			<span class="dashicons dashicons-admin-plugins" style="color: #ff2232; vertical-align: middle; margin-right: 5px;"></span>
			<?php esc_html_e( 'Mag Pro Theme: Required Plugin Missing', 'mag-pro' ); ?>
		</h3>
		<p style="margin: 0 0 10px; font-size: 14px;">
			<?php esc_html_e( 'The Mag Pro theme requires the companion plugin "Mag Pro Elements" to enable all magazine hero widgets, post grids, breaking news, video blocks, and Elementor builder widgets.', 'mag-pro' ); ?>
		</p>
		<p style="margin: 0;">
			<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary" style="background: #ff2232; border-color: #e51f2d; text-shadow: none;">
				<?php esc_html_e( 'Install & Activate Mag Pro Elements', 'mag-pro' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'magpro_required_plugin_admin_notice' );

