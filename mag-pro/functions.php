<?php
/**
 * Mag Pro functions and definitions
 *
 * @package MagPro
 * @version 2.0.0
 * @author Developer Zahir (https://developerzahir.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define Constants
define( 'MAGPRO_THEME_VERSION', '2.0.0' );
define( 'MAGPRO_THEME_DIR', get_template_directory() );
define( 'MAGPRO_THEME_URI', get_template_directory_uri() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function magpro_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'mag-pro', MAGPRO_THEME_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 675, true );

	// Register Navigation Menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Navigation', 'mag-pro' ),
			'top'     => esc_html__( 'Top Bar Navigation', 'mag-pro' ),
			'footer'  => esc_html__( 'Footer Navigation', 'mag-pro' ),
		)
	);

	// Switch default core markup for search form, comment form, etc. to output valid HTML5
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Custom Logo Support
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Gutenberg / Block Editor Support
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'magpro_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function magpro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'magpro_content_width', 1200 );
}
add_action( 'after_setup_theme', 'magpro_content_width', 0 );

/**
 * Register widget area.
 */
function magpro_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Main Sidebar', 'mag-pro' ),
			'id'            => 'magpro-main-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'mag-pro' ),
			'before_widget' => '<section id="%1$s" class="widget magpro-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title magpro-widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer Column %d', 'mag-pro' ), $i ),
				'id'            => 'magpro-footer-' . $i,
				'description'   => sprintf( esc_html__( 'Widgets in this area will be shown in footer column %d.', 'mag-pro' ), $i ),
				'before_widget' => '<section id="%1$s" class="widget magpro-widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title magpro-widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'magpro_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function magpro_scripts() {
	// Theme Main Stylesheet
	wp_enqueue_style( 'magpro-style', get_stylesheet_uri(), array(), MAGPRO_THEME_VERSION );

	// Mag Pro Component & Layout Styles
	wp_enqueue_style( 'magpro-theme', MAGPRO_THEME_URI . '/assets/css/magpro-theme.css', array(), MAGPRO_THEME_VERSION );

	// Mag Pro Theme JavaScript (Dark mode toggle, mobile nav, search modals)
	wp_enqueue_script( 'magpro-theme-js', MAGPRO_THEME_URI . '/assets/js/magpro-theme.js', array(), MAGPRO_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'magpro_scripts' );

// Include Core Functionality
require_once MAGPRO_THEME_DIR . '/inc/class-magpro-core.php';

// Include Header & Footer Builder
require_once MAGPRO_THEME_DIR . '/inc/class-magpro-header-footer.php';

// Include TGM Plugin Activation
if ( file_exists( MAGPRO_THEME_DIR . '/inc/plugins/tgm-config.php' ) ) {
	require_once MAGPRO_THEME_DIR . '/inc/plugins/tgm-config.php';
}
