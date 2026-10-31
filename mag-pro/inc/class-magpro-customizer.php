<?php
/**
 * WordPress Customizer settings for Mag Pro theme.
 * Colors, Header Toggles, Dark/Light Logos, Ads, and Social Links.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MagPro_Customizer {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_action( 'wp_head', array( $this, 'output_dynamic_css' ), 99 );
	}

	/**
	 * Register Customizer panels, sections, and controls.
	 */
	public function register_settings( $wp_customize ) {

		// Panel: Mag Pro Settings
		$wp_customize->add_panel(
			'magpro_theme_panel',
			array(
				'title'       => __( 'Mag Pro Theme Settings', 'mag-pro' ),
				'priority'    => 25,
				'description' => __( 'Customize your Mag Pro header, colors, ads, and social profiles.', 'mag-pro' ),
			)
		);

		// =====================================================================
		// Section 1: Header Settings
		// =====================================================================
		$wp_customize->add_section(
			'magpro_header_section',
			array(
				'title'    => __( 'Header Options', 'mag-pro' ),
				'panel'    => 'magpro_theme_panel',
				'priority' => 10,
			)
		);

		// Topbar Enable/Disable
		$wp_customize->add_setting(
			'magpro_enable_topbar',
			array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			)
		);
		$wp_customize->add_control(
			'magpro_enable_topbar',
			array(
				'label'       => __( 'Enable Topbar (Top Header)', 'mag-pro' ),
				'description' => __( 'Show or hide the 32px topbar containing top menu and social icons.', 'mag-pro' ),
				'section'     => 'magpro_header_section',
				'type'        => 'checkbox',
			)
		);

		// Middle Header (Logo & Ad) Enable/Disable
		$wp_customize->add_setting(
			'magpro_enable_middle_header',
			array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			)
		);
		$wp_customize->add_control(
			'magpro_enable_middle_header',
			array(
				'label'       => __( 'Enable Middle Header (Logo & Ad Row)', 'mag-pro' ),
				'description' => __( 'Show or hide the header row containing site logo and 728x90 advertisement.', 'mag-pro' ),
				'section'     => 'magpro_header_section',
				'type'        => 'checkbox',
			)
		);

		// Logo Width Control
		$wp_customize->add_setting(
			'magpro_logo_width',
			array(
				'default'           => 220,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'magpro_logo_width',
			array(
				'label'       => __( 'Logo Max Width (px)', 'mag-pro' ),
				'description' => __( 'Control logo display width on desktop screens (50px - 500px).', 'mag-pro' ),
				'section'     => 'magpro_header_section',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 50,
					'max'  => 500,
					'step' => 5,
				),
			)
		);

		// Dark Mode Logo
		$wp_customize->add_setting(
			'magpro_dark_logo',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'magpro_dark_logo',
				array(
					'label'       => __( 'Dark Mode Logo', 'mag-pro' ),
					'description' => __( 'Upload a separate light-colored logo for Dark Mode. If left empty, default logo is used.', 'mag-pro' ),
					'section'     => 'magpro_header_section',
				)
			)
		);

		// Header Ad Code / Banner HTML
		$wp_customize->add_setting(
			'magpro_header_ad_code',
			array(
				'default'           => '',
				'sanitize_callback' => array( $this, 'sanitize_html' ),
			)
		);
		$wp_customize->add_control(
			'magpro_header_ad_code',
			array(
				'label'       => __( 'Header Ad Content (728x90 HTML or Banner)', 'mag-pro' ),
				'description' => __( 'Paste your AdSense / HTML code here. If empty, the Header Ad widget area will be displayed instead.', 'mag-pro' ),
				'section'     => 'magpro_header_section',
				'type'        => 'textarea',
			)
		);

		// =====================================================================
		// Section 2: Color Palette
		// =====================================================================
		$wp_customize->add_section(
			'magpro_colors_section',
			array(
				'title'    => __( 'Colors & Styling', 'mag-pro' ),
				'panel'    => 'magpro_theme_panel',
				'priority' => 20,
			)
		);

		// Primary Brand Color
		$wp_customize->add_setting(
			'magpro_primary_color',
			array(
				'default'           => '#ff2232',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'magpro_primary_color',
				array(
					'label'       => __( 'Primary Theme Color', 'mag-pro' ),
					'description' => __( 'Used for badges, highlights, links, and accent ribbons (Default: #ff2232).', 'mag-pro' ),
					'section'     => 'magpro_colors_section',
				)
			)
		);

		// Menu Bar Background
		$wp_customize->add_setting(
			'magpro_menu_bg',
			array(
				'default'           => '#ff2232',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'magpro_menu_bg',
				array(
					'label'   => __( 'Main Navigation Bar Background', 'mag-pro' ),
					'section' => 'magpro_colors_section',
				)
			)
		);

		// Topbar Background
		$wp_customize->add_setting(
			'magpro_topbar_bg',
			array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'magpro_topbar_bg',
				array(
					'label'   => __( 'Topbar Background (Light Mode)', 'mag-pro' ),
					'section' => 'magpro_colors_section',
				)
			)
		);

		// Header Background
		$wp_customize->add_setting(
			'magpro_header_bg',
			array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'magpro_header_bg',
				array(
					'label'   => __( 'Header Background (Light Mode)', 'mag-pro' ),
					'section' => 'magpro_colors_section',
				)
			)
		);

		// Dark Mode Body Background
		$wp_customize->add_setting(
			'magpro_dark_body_bg',
			array(
				'default'           => '#15181f',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'magpro_dark_body_bg',
				array(
					'label'   => __( 'Dark Mode Body Background', 'mag-pro' ),
					'section' => 'magpro_colors_section',
				)
			)
		);

		// Dark Mode Menu Background
		$wp_customize->add_setting(
			'magpro_dark_menu_bg',
			array(
				'default'           => '#171921',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'magpro_dark_menu_bg',
				array(
					'label'   => __( 'Dark Mode Menu Bar Background', 'mag-pro' ),
					'section' => 'magpro_colors_section',
				)
			)
		);

		// =====================================================================
		// Section 3: Social Profiles
		// =====================================================================
		$wp_customize->add_section(
			'magpro_social_section',
			array(
				'title'       => __( 'Social Links', 'mag-pro' ),
				'panel'       => 'magpro_theme_panel',
				'priority'    => 30,
				'description' => __( 'Configure social profile URLs for topbar and header icons. Leave empty to hide.', 'mag-pro' ),
			)
		);

		$social_networks = array(
			'facebook'  => __( 'Facebook URL', 'mag-pro' ),
			'twitter'   => __( 'Twitter / X URL', 'mag-pro' ),
			'youtube'   => __( 'YouTube URL', 'mag-pro' ),
			'instagram' => __( 'Instagram URL', 'mag-pro' ),
			'pinterest' => __( 'Pinterest URL', 'mag-pro' ),
			'linkedin'  => __( 'LinkedIn URL', 'mag-pro' ),
			'telegram'  => __( 'Telegram URL', 'mag-pro' ),
			'whatsapp'  => __( 'WhatsApp Link / Number', 'mag-pro' ),
		);

		foreach ( $social_networks as $key => $label ) {
			$wp_customize->add_setting(
				'magpro_social_' . $key,
				array(
					'default'           => in_array( $key, array( 'facebook', 'twitter', 'youtube', 'instagram', 'pinterest' ), true ) ? '#' : '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				'magpro_social_' . $key,
				array(
					'label'   => $label,
					'section' => 'magpro_social_section',
					'type'    => 'url',
				)
			);
		}
	}

	/**
	 * Output dynamic inline CSS based on customizer choices.
	 */
	public function output_dynamic_css() {
		$primary_color  = get_theme_mod( 'magpro_primary_color', '#ff2232' );
		$menu_bg        = get_theme_mod( 'magpro_menu_bg', '#ff2232' );
		$topbar_bg      = get_theme_mod( 'magpro_topbar_bg', '#ffffff' );
		$header_bg      = get_theme_mod( 'magpro_header_bg', '#ffffff' );
		$dark_body_bg   = get_theme_mod( 'magpro_dark_body_bg', '#15181f' );
		$dark_menu_bg   = get_theme_mod( 'magpro_dark_menu_bg', '#171921' );
		$logo_width     = get_theme_mod( 'magpro_logo_width', 220 );

		?>
		<style id="magpro-customizer-css">
			:root {
				--main-color: <?php echo esc_attr( $primary_color ); ?>;
				--main-color-hover: <?php echo esc_attr( $primary_color ); ?>;
				--title-hover-color: <?php echo esc_attr( $primary_color ); ?>;
				--link-color: <?php echo esc_attr( $primary_color ); ?>;
				--tag-bg: <?php echo esc_attr( $primary_color ); ?>;
				--menu-bg: <?php echo esc_attr( $menu_bg ); ?>;
				--topbar-bg: <?php echo esc_attr( $topbar_bg ); ?>;
				--header-bg: <?php echo esc_attr( $header_bg ); ?>;
			}
			html[data-theme="dark"] {
				--body-bg: <?php echo esc_attr( $dark_body_bg ); ?>;
				--menu-bg: <?php echo esc_attr( $dark_menu_bg ); ?>;
				--link-color: <?php echo esc_attr( $primary_color ); ?>;
			}
			.logo-img img,
			.header-logo-wrap img,
			.custom-logo-link img {
				max-width: <?php echo intval( $logo_width ); ?>px;
				width: 100%;
				height: auto;
			}
			/* Home icon and Search button with primary color */
			.home-icon-link {
				background-color: var(--main-color) !important;
				color: #ffffff !important;
			}
			.home-icon-link:hover {
				opacity: 0.9;
			}
			.search-toggle {
				background-color: var(--main-color) !important;
				color: #ffffff !important;
			}
			.search-toggle:hover {
				opacity: 0.9;
			}
			/* Dark / Light logo toggle */
			.magpro-logo-dark {
				display: none;
			}
			.magpro-logo-light {
				display: block;
			}
			html[data-theme="dark"] .magpro-logo-light {
				display: none !important;
			}
			html[data-theme="dark"] .magpro-logo-dark {
				display: block !important;
			}
		</style>
		<?php
	}

	public function sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? 1 : 0 );
	}

	public function sanitize_html( $input ) {
		return wp_kses_post( $input );
	}
}

MagPro_Customizer::instance();
