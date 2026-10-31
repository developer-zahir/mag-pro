<?php
/**
 * Mag Pro Core Integration
 *
 * Enqueues assets, sets up Dark/Light mode, Hind Siliguri font,
 * breaking news ticker, and theme compatibility.
 *
 * @package Mag Pro
 * @author  Developer Zahir
 * @link    https://developerzahir.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output early anti-FOUC script directly in <head>
 */
function magpro_early_theme_script() {
	?>
	<script>
	(function() {
		try {
			var saved = localStorage.getItem('magpro_theme');
			var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
			if (saved === 'dark' || (!saved && prefersDark)) {
				document.documentElement.setAttribute('data-theme', 'dark');
			} else {
				document.documentElement.setAttribute('data-theme', 'light');
			}
		} catch (e) {}
	})();
	</script>
	<?php
}
add_action( 'astra_head_top', 'magpro_early_theme_script', 1 );
add_action( 'wp_head', 'magpro_early_theme_script', 1 );

/**
 * Enqueue Mag Pro styles and scripts
 */
function magpro_enqueue_scripts() {
	// 1. Google Font Hind Siliguri
	wp_enqueue_style(
		'magpro-font-hind',
		'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// 2. Font Awesome 5 Free
	wp_enqueue_style(
		'magpro-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
		array(),
		'5.15.4'
	);

	// 3. Mag Pro Custom CSS
	wp_enqueue_style(
		'magpro-theme-style',
		get_template_directory_uri() . '/assets/css/magpro-theme.css',
		array(),
		'1.0.0'
	);

	// 4. Mag Pro JS
	wp_enqueue_script(
		'magpro-theme-script',
		get_template_directory_uri() . '/assets/js/magpro-theme.js',
		array(),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'magpro_enqueue_scripts', 15 );

/**
 * Add custom body classes
 */
function magpro_body_classes( $classes ) {
	$classes[] = 'magpro-theme';
	return $classes;
}
add_filter( 'body_class', 'magpro_body_classes' );

/**
 * Filter Astra Header Search HTML to provide Mag Pro Search Trigger
 */
function magpro_filter_header_search( $search_html, $option = '', $device = '' ) {
	$search_style = astra_get_option( 'magpro-search-style', 'full-screen' );
	ob_start();
	?>
	<div class="magpro-header-search-wrap" data-search-style="<?php echo esc_attr( $search_style ); ?>">
		<button type="button" class="magpro-search-trigger" data-target-style="<?php echo esc_attr( $search_style ); ?>" aria-label="<?php esc_attr_e( 'Open Search', 'mag-pro' ); ?>" title="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>">
			<i class="fas fa-search"></i>
		</button>
	</div>
	<?php
	return ob_get_clean();
}
add_filter( 'astra_get_search', 'magpro_filter_header_search', 20, 3 );

/**
 * Render Search Elements (Style 1: Full Screen Modal, Style 2: Slide Down, Style 3: Header Replace)
 */
function magpro_render_search_elements() {
	?>
	<!-- Style 1: Full-Screen Modal Search (Center-Center) -->
	<div class="magpro-search-modal" id="magpro-search-modal" aria-hidden="true" role="dialog" aria-modal="true">
		<div class="magpro-search-modal-backdrop"></div>
		<button type="button" class="magpro-search-modal-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro' ); ?>">&times;</button>
		<div class="magpro-search-modal-inner">
			<form role="search" method="get" class="magpro-search-modal-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="magpro-search-modal-input"><?php esc_html_e( 'Search for:', 'mag-pro' ); ?></label>
				<div class="magpro-search-input-wrap">
					<i class="fas fa-search magpro-search-modal-icon"></i>
					<input type="search" id="magpro-search-modal-input" class="magpro-search-modal-input" placeholder="<?php esc_attr_e( 'Type to search and hit enter...', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
					<button type="submit" class="magpro-search-modal-submit" aria-label="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>">
						<i class="fas fa-arrow-right"></i>
					</button>
				</div>
				<div class="magpro-search-modal-hint"><?php esc_html_e( 'Press ESC to close or click anywhere outside', 'mag-pro' ); ?></div>
			</form>
		</div>
	</div>

	<!-- Style 2: Slide Down Search Bar -->
	<div class="magpro-search-slide-down" id="magpro-search-slide-down" aria-hidden="true">
		<div class="magpro-search-slide-down-container">
			<form role="search" method="get" class="magpro-search-slide-down-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<i class="fas fa-search magpro-search-slide-icon"></i>
				<input type="search" class="magpro-search-slide-down-input" placeholder="<?php esc_attr_e( 'Search news, topics, articles...', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
				<button type="submit" class="magpro-search-slide-down-submit" aria-label="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>"><?php esc_html_e( 'Search', 'mag-pro' ); ?></button>
				<button type="button" class="magpro-search-slide-down-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro' ); ?>">&times;</button>
			</form>
		</div>
	</div>

	<!-- Style 3: Header Row Replace Search Bar -->
	<div class="magpro-search-replace-bar" id="magpro-search-replace-bar" aria-hidden="true">
		<div class="magpro-search-replace-inner">
			<form role="search" method="get" class="magpro-search-replace-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<i class="fas fa-search magpro-search-replace-icon"></i>
				<input type="search" class="magpro-search-replace-input" placeholder="<?php esc_attr_e( 'Type keywords and hit enter to search...', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
				<button type="submit" class="magpro-search-replace-submit" aria-label="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>">
					<i class="fas fa-arrow-right"></i>
				</button>
				<button type="button" class="magpro-search-replace-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro' ); ?>">&times;</button>
			</form>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'magpro_render_search_elements', 95 );

/**
 * Post Views Counter & Formatter
 */
function magpro_get_post_views( $post_id ) {
	$views = get_post_meta( $post_id, '_magpro_post_views', true );
	if ( empty( $views ) ) {
		$views = 0;
	}
	$views = intval( $views );

	if ( $views >= 1000000 ) {
		return round( $views / 1000000, 1 ) . 'M';
	} elseif ( $views >= 1000 ) {
		return round( $views / 1000, 1 ) . 'K';
	}
	return number_format_i18n( $views );
}

function magpro_increment_post_views() {
	if ( ! is_single() ) {
		return;
	}
	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}
	if ( current_user_can( 'manage_options' ) ) {
		return;
	}
	$views = get_post_meta( $post_id, '_magpro_post_views', true );
	$views = ! empty( $views ) ? intval( $views ) + 1 : 1;
	update_post_meta( $post_id, '_magpro_post_views', $views );
}
add_action( 'wp_head', 'magpro_increment_post_views' );


