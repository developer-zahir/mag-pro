<?php
/**
 * Plugin Name:       Mag Pro Elements
 * Plugin URI:        https://developerzahir.com/
 * Description:       Companion plugin for Mag Pro theme. Provides magazine post widgets, featured hero grids, video blocks, breaking news tickers, and tabbed posts with full Elementor support.
 * Version:           1.0.4
 * Author:            Developer Zahir
 * Author URI:        https://developerzahir.com/
 * Text Domain:       mag-pro-elements
 * Domain Path:       /languages
 * Requires at least: 5.6
 * Requires PHP:      7.4
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MAGPRO_ELEMENTS_VERSION', '1.0.4' );
define( 'MAGPRO_ELEMENTS_FILE', __FILE__ );
define( 'MAGPRO_ELEMENTS_DIR', plugin_dir_path( __FILE__ ) );
define( 'MAGPRO_ELEMENTS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Enqueue scripts and styles for Mag Pro Elements
 */
function magpro_elements_enqueue_assets() {
	// Font Awesome 5 Free
	if ( ! wp_style_is( 'magpro-fontawesome', 'enqueued' ) && ! wp_style_is( 'font-awesome', 'enqueued' ) ) {
		wp_enqueue_style(
			'magpro-fontawesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
			array(),
			'5.15.4'
		);
	}

	// Google Fonts - Hind Siliguri
	if ( ! wp_style_is( 'magpro-font-hind', 'enqueued' ) ) {
		wp_enqueue_style(
			'magpro-font-hind',
			'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap',
			array(),
			null
		);
	}

	// Plugin Stylesheet
	wp_enqueue_style(
		'magpro-elements-css',
		MAGPRO_ELEMENTS_URL . 'assets/css/magpro-elements.css',
		array(),
		MAGPRO_ELEMENTS_VERSION
	);

	// Plugin Scripts
	wp_enqueue_script(
		'magpro-elements-js',
		MAGPRO_ELEMENTS_URL . 'assets/js/magpro-elements.js',
		array( 'jquery' ),
		MAGPRO_ELEMENTS_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'magpro_elements_enqueue_assets' );

/**
 * Enqueue editor assets for Elementor
 */
function magpro_elements_editor_assets() {
	wp_enqueue_style(
		'magpro-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
		array(),
		'5.15.4'
	);
	wp_enqueue_style(
		'magpro-elements-editor-css',
		MAGPRO_ELEMENTS_URL . 'assets/css/magpro-elements.css',
		array(),
		MAGPRO_ELEMENTS_VERSION
	);
}
add_action( 'elementor/editor/after_enqueue_styles', 'magpro_elements_editor_assets' );

// Load Helpers
require_once MAGPRO_ELEMENTS_DIR . 'inc/class-magpro-helpers.php';

// Load Elementor Integration
require_once MAGPRO_ELEMENTS_DIR . 'inc/class-magpro-elementor-loader.php';

// Load Shortcodes
require_once MAGPRO_ELEMENTS_DIR . 'inc/class-magpro-shortcodes.php';

// Load Classic Widgets
require_once MAGPRO_ELEMENTS_DIR . 'inc/class-magpro-wp-widgets.php';

