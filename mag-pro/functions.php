<?php
/**
 * Mag Pro functions and definitions
 *
 * @package MagPro
 * @version 2.1.0
 * @author Developer Zahir (https://developerzahir.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define Constants
define( 'MAGPRO_THEME_VERSION', '2.1.0' );
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
	add_image_size( 'magpro-thumb', 300, 190, true );
	add_image_size( 'magpro-medium', 600, 380, true );

	// Register Navigation Menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Main Navigation Menu', 'mag-pro' ),
			'top'     => esc_html__( 'Topbar Navigation Menu', 'mag-pro' ),
			'footer'  => esc_html__( 'Footer Navigation Menu', 'mag-pro' ),
		)
	);

	// Switch default core markup to output valid HTML5
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
			'height'      => 60,
			'width'       => 220,
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
 * Content width
 */
function magpro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'magpro_content_width', 1140 );
}
add_action( 'after_setup_theme', 'magpro_content_width', 0 );

/**
 * Register widget areas.
 */
function magpro_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Main Sidebar', 'mag-pro' ),
			'id'            => 'magpro-main-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in the main magazine sidebar.', 'mag-pro' ),
			'before_widget' => '<section id="%1$s" class="widget magpro-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title magpro-widget-title"><span class="title-text">',
			'after_title'   => '</span></h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Ad (728x90)', 'mag-pro' ),
			'id'            => 'magpro-header-ad',
			'description'   => esc_html__( 'Header Leaderboard Ad (728x90 banner or widget) displayed next to the logo.', 'mag-pro' ),
			'before_widget' => '<div id="%1$s" class="widget-header-ad %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="screen-reader-text">',
			'after_title'   => '</span>',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer Column %d', 'mag-pro' ), $i ),
				'id'            => 'magpro-footer-' . $i,
				'description'   => sprintf( esc_html__( 'Widgets in this area will be shown in footer column %d.', 'mag-pro' ), $i ),
				'before_widget' => '<section id="%1$s" class="widget magpro-widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title magpro-widget-title"><span class="title-text">',
				'after_title'   => '</span></h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'magpro_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function magpro_scripts() {
	// Font Awesome 5 Free
	wp_enqueue_style(
		'magpro-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
		array(),
		'5.15.4'
	);

	// Google Fonts - Hind Siliguri
	wp_enqueue_style(
		'magpro-font-hind',
		'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Theme Base Stylesheet
	wp_enqueue_style( 'magpro-style', get_stylesheet_uri(), array(), MAGPRO_THEME_VERSION );

	// Mag Pro Complete Theme Stylesheet
	wp_enqueue_style( 'magpro-theme', MAGPRO_THEME_URI . '/assets/css/magpro-theme.css', array( 'magpro-fontawesome', 'magpro-font-hind' ), MAGPRO_THEME_VERSION );

	// Mag Pro Theme JavaScript
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
