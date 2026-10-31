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
 * Render Floating Dark/Light Mode Toggle
 */
function magpro_render_floating_toggle() {
	if ( ! apply_filters( 'magpro_show_floating_toggle', true ) ) {
		return;
	}
	?>
	<button type="button" class="magpro-floating-toggle" aria-label="<?php esc_attr_e( 'Toggle Dark/Light Mode', 'mag-pro' ); ?>" title="<?php esc_attr_e( 'Toggle Dark/Light Mode', 'mag-pro' ); ?>">
		<i class="fas fa-moon icon-moon"></i>
		<i class="fas fa-sun icon-sun"></i>
	</button>
	<?php
}
add_action( 'wp_footer', 'magpro_render_floating_toggle', 99 );

