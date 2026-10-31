<?php
/**
 * Header Dark Mode Switcher Component for Mag Pro Header Builder.
 *
 * @package Mag Pro
 * @author  Developer Zahir
 * @link    https://developerzahir.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Astra_Header_Dark_Mode_Component {

	public function __construct() {
		add_action( 'astra_header_dark_mode', array( $this, 'render' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	public function render() {
		?>
		<div class="magpro-header-dark-mode-wrap">
			<button type="button" class="magpro-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle Dark/Light Theme', 'mag-pro' ); ?>" title="<?php esc_attr_e( 'Toggle Dark/Light Theme', 'mag-pro' ); ?>">
				<i class="fas fa-moon icon-moon"></i>
				<i class="fas fa-sun icon-sun"></i>
			</button>
		</div>
		<?php
	}

	public function customize_register( $wp_customize ) {
		// Register Customizer Section for Dark Mode in Header Builder
		if ( class_exists( 'Astra_Builder_Customizer' ) ) {
			$wp_customize->add_section(
				'section-header-dark-mode',
				array(
					'title'    => esc_html__( 'Dark Mode Switcher', 'mag-pro' ),
					'panel'    => 'panel-header-builder-group',
					'priority' => 80,
				)
			);
		}
	}
}

new Astra_Header_Dark_Mode_Component();
