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
 * Render Breaking News Ticker Bar above header
 */
function magpro_render_header_ticker() {
	// Allow disabling via filter
	if ( ! apply_filters( 'magpro_show_header_ticker', true ) ) {
		return;
	}

	$recent_posts = new WP_Query(
		array(
			'posts_per_page'      => 6,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		)
	);
	?>
	<div class="magpro-ticker-wrap">
		<div class="magpro-ticker-container">
			<div class="magpro-ticker-label">
				<i class="fas fa-bolt"></i>
				<span><?php esc_html_e( 'Breaking News', 'mag-pro' ); ?></span>
			</div>

			<div class="magpro-ticker-content">
				<?php
				if ( $recent_posts->have_posts() ) :
					$count = 0;
					while ( $recent_posts->have_posts() ) :
						$recent_posts->the_post();
						$active = ( 0 === $count ) ? 'active' : '';
						?>
						<div class="magpro-ticker-item <?php echo esc_attr( $active ); ?>">
							<span class="magpro-ticker-bullet">&bull;</span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
						<?php
						$count++;
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="magpro-ticker-item active">
						<span><?php esc_html_e( 'Welcome to Mag Pro — Built for modern publishers & bloggers.', 'mag-pro' ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<div class="magpro-ticker-controls">
				<button type="button" class="magpro-ticker-btn magpro-ticker-prev" aria-label="<?php esc_attr_e( 'Previous news', 'mag-pro' ); ?>">
					<i class="fas fa-chevron-left"></i>
				</button>
				<button type="button" class="magpro-ticker-btn magpro-ticker-next" aria-label="<?php esc_attr_e( 'Next news', 'mag-pro' ); ?>">
					<i class="fas fa-chevron-right"></i>
				</button>
			</div>

			<div class="magpro-ticker-date">
				<i class="far fa-calendar-alt"></i> <?php echo esc_html( date_i18n( get_option( 'date_format' ) ) ); ?>
			</div>

			<!-- Header Dark Mode Switcher -->
			<button type="button" class="magpro-theme-toggle" style="margin-left: 15px;" aria-label="<?php esc_attr_e( 'Toggle Dark/Light Mode', 'mag-pro' ); ?>" title="<?php esc_attr_e( 'Toggle Theme', 'mag-pro' ); ?>">
				<i class="fas fa-moon icon-moon"></i>
				<i class="fas fa-sun icon-sun"></i>
			</button>
		</div>
	</div>
	<?php
}
add_action( 'astra_header_before', 'magpro_render_header_ticker', 5 );

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
 * Render Search Elements (Full Screen Modal & Header Content Cover)
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

	<!-- Style 2: Replace Header Content Search Bar -->
	<div class="magpro-search-cover" id="magpro-search-cover" aria-hidden="true">
		<div class="magpro-search-cover-container">
			<form role="search" method="get" class="magpro-search-cover-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<i class="fas fa-search magpro-search-cover-icon"></i>
				<input type="search" class="magpro-search-cover-input" placeholder="<?php esc_attr_e( 'Search news, topics, articles...', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
				<button type="submit" class="magpro-search-cover-submit" aria-label="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>"><?php esc_html_e( 'Search', 'mag-pro' ); ?></button>
				<button type="button" class="magpro-search-cover-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro' ); ?>">&times;</button>
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


