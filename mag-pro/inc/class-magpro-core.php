<?php
/**
 * Core functionality for Mag Pro theme.
 * Dark/Light Mode, Post Views, Fallback Header & Footer, Search Modal, Admin Dashboard.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MagPro_Core {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		// Output early theme script in <head> to prevent FOUC (flash of light theme)
		add_action( 'wp_head', array( $this, 'early_theme_script' ), 1 );

		// Post views tracker
		add_action( 'template_redirect', array( $this, 'track_post_views' ) );

		// Print Search Modal in wp_footer
		add_action( 'wp_footer', array( $this, 'render_search_modal' ) );

		// Admin menu
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
	}

	/**
	 * Output dark/light mode inline script at the very top of <head>.
	 */
	public function early_theme_script() {
		?>
		<script>
		(function() {
			try {
				var savedTheme = localStorage.getItem('magpro_theme');
				var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
				var theme = savedTheme ? savedTheme : (prefersDark ? 'dark' : 'light');
				document.documentElement.setAttribute('data-theme', theme);
			} catch(e) {}
		})();
		</script>
		<?php
	}

	/**
	 * Track single post views.
	 */
	public function track_post_views() {
		if ( ! is_singular( 'post' ) || is_user_logged_in() ) {
			return;
		}

		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return;
		}

		// Prevent multiple counts during the same session
		$viewed_cookie = isset( $_COOKIE['magpro_viewed_posts'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_COOKIE['magpro_viewed_posts'] ) ) ) : array();

		if ( ! in_array( (string) $post_id, $viewed_cookie, true ) ) {
			$views = get_post_meta( $post_id, '_magpro_post_views', true );
			$views = ( ! empty( $views ) ) ? intval( $views ) + 1 : 1;
			update_post_meta( $post_id, '_magpro_post_views', $views );

			$viewed_cookie[] = $post_id;
			setcookie( 'magpro_viewed_posts', implode( ',', $viewed_cookie ), time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
		}
	}

	/**
	 * Register Mag Pro admin menu and dashboard.
	 */
	public function register_admin_menu() {
		add_menu_page(
			__( 'Mag Pro Theme', 'mag-pro' ),
			__( 'Mag Pro', 'mag-pro' ),
			'edit_theme_options',
			'magpro-dashboard',
			array( $this, 'render_dashboard_page' ),
			'dashicons-superhero',
			59
		);

		add_submenu_page(
			'magpro-dashboard',
			__( 'Dashboard & Welcome', 'mag-pro' ),
			__( 'Dashboard', 'mag-pro' ),
			'edit_theme_options',
			'magpro-dashboard',
			array( $this, 'render_dashboard_page' )
		);
	}

	/**
	 * Render Mag Pro Dashboard Page in WP Admin.
	 */
	public function render_dashboard_page() {
		?>
		<div class="wrap magpro-dashboard-wrap" style="max-width: 1050px; margin-top: 25px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
			<div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); margin-bottom: 30px;">
				<div style="display:flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
					<div>
						<span style="background: #0066cc; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Version 2.0.0</span>
						<h1 style="color: #ffffff; font-size: 32px; font-weight: 800; margin: 12px 0 8px;">Mag Pro — Modern Blog & Magazine Theme</h1>
						<p style="color: #94a3b8; font-size: 15px; margin: 0; max-width: 600px;">Developed by <strong style="color: #38bdf8;">Developer Zahir</strong>. Built for high performance, drag-and-drop Elementor Header & Footer building, and built-in Dark/Light theme switching.</p>
					</div>
					<div>
						<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=magpro_hf' ) ); ?>" class="button button-primary" style="background:#0066cc; border-color:#0066cc; padding: 10px 22px; height: auto; font-size: 15px; font-weight: 600; border-radius: 6px;">+ Create Elementor Header / Footer</a>
					</div>
				</div>
			</div>

			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 30px;">
				<!-- Card 1: Header & Footer Builder -->
				<div style="background: #ffffff; padding: 28px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
					<div style="font-size: 28px; margin-bottom: 12px;">🎨</div>
					<h3 style="font-size: 18px; font-weight: 700; margin: 0 0 10px; color: #0f172a;">Elementor Header & Footer Builder</h3>
					<p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Create unique Headers, Footers, and sticky bars using Elementor drag-and-drop with target display conditions (Entire Site, Posts, Pages, Archives, Homepage).</p>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=magpro_hf' ) ); ?>" class="button" style="font-weight: 600;">Manage Templates &rarr;</a>
				</div>

				<!-- Card 2: Elementor Magazine Widgets -->
				<div style="background: #ffffff; padding: 28px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
					<div style="font-size: 28px; margin-bottom: 12px;">📰</div>
					<h3 style="font-size: 18px; font-weight: 700; margin: 0 0 10px; color: #0f172a;">Mag Pro Elements Widgets</h3>
					<p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Includes 12 powerful Elementor widgets: Post Grids, Featured Hero, Carousel/Slider, Magazine Tabs, News Ticker, Search Element, Dark Mode Switcher, and Social Follow.</p>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>" class="button" style="font-weight: 600;">Edit Pages with Elementor &rarr;</a>
				</div>

				<!-- Card 3: Dark & Light Mode -->
				<div style="background: #ffffff; padding: 28px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
					<div style="font-size: 28px; margin-bottom: 12px;">🌓</div>
					<h3 style="font-size: 18px; font-weight: 700; margin: 0 0 10px; color: #0f172a;">Instant Dark & Light Mode</h3>
					<p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Zero-flash theme switcher with cookie/localStorage state and system OS detection. Add it into your header via Elementor widget or use the default topbar switch.</p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button" style="font-weight: 600;">View Live Site &rarr;</a>
				</div>
			</div>

			<div style="background: #ffffff; padding: 24px 30px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
				<div>
					<p style="margin: 0; font-size: 14px; color: #64748b;">
						Author: <strong style="color: #0f172a;">Developer Zahir</strong> | Website: <a href="https://developerzahir.com/" target="_blank" style="color: #0066cc; text-decoration: none; font-weight: 600;">developerzahir.com</a>
					</p>
				</div>
				<div>
					<span style="font-size: 13px; color: #94a3b8;">Mag Pro Version 2.0.0 — Pure & Lightweight</span>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Full-Screen Search Modal in wp_footer.
	 */
	public function render_search_modal() {
		?>
		<div id="magpro-search-fullscreen" class="magpro-search-fullscreen" aria-hidden="true" role="dialog">
			<div class="magpro-search-modal-backdrop"></div>
			<div class="magpro-search-modal-container">
				<button type="button" class="magpro-search-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
				</button>
				<div class="magpro-search-modal-content">
					<span class="magpro-search-modal-label"><?php esc_html_e( 'SEARCH THE MAGAZINE', 'mag-pro' ); ?></span>
					<form role="search" method="get" class="magpro-modal-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="magpro-modal-search-input-wrap">
							<input type="search" class="magpro-modal-search-field" placeholder="<?php esc_attr_e( 'Type keywords and press Enter...', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
							<button type="submit" class="magpro-modal-search-submit" aria-label="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>">
								<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
							</button>
						</div>
					</form>
					<p class="magpro-search-modal-hint"><?php esc_html_e( 'Press ESC to close or click outside the box.', 'mag-pro' ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
}

MagPro_Core::instance();

/**
 * Helper to get post views count.
 */
function magpro_get_post_views( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$views = get_post_meta( $post_id, '_magpro_post_views', true );
	$count = ! empty( $views ) ? intval( $views ) : 0;

	if ( $count >= 1000000 ) {
		return round( $count / 1000000, 1 ) . 'M';
	} elseif ( $count >= 1000 ) {
		return round( $count / 1000, 1 ) . 'k';
	}

	return number_format_i18n( $count );
}

/**
 * Render Fallback Header if no Elementor header template is active.
 */
function magpro_render_fallback_header() {
	?>
	<header id="masthead" class="magpro-default-header site-header">
		<!-- Top Bar -->
		<div class="magpro-topbar">
			<div class="magpro-container magpro-topbar-inner">
				<div class="magpro-topbar-left">
					<span class="magpro-topbar-date">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: -2px; margin-right: 4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
						<?php echo esc_html( date_i18n( get_option( 'date_format' ) ) ); ?>
					</span>
					<?php if ( has_nav_menu( 'top' ) ) : ?>
						<nav class="magpro-topbar-nav" aria-label="<?php esc_attr_e( 'Top Navigation', 'mag-pro' ); ?>">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'top',
									'menu_class'     => 'magpro-top-menu',
									'depth'          => 1,
									'container'      => false,
								)
							);
							?>
						</nav>
					<?php endif; ?>
				</div>

				<div class="magpro-topbar-right">
					<!-- Dark / Light Mode Switcher Button -->
					<button type="button" class="magpro-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark and light theme', 'mag-pro' ); ?>" data-magpro-toggle="theme">
						<span class="magpro-icon-sun" title="<?php esc_attr_e( 'Light Mode', 'mag-pro' ); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
						</span>
						<span class="magpro-icon-moon" title="<?php esc_attr_e( 'Dark Mode', 'mag-pro' ); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
						</span>
					</button>
				</div>
			</div>
		</div>

		<!-- Main Nav Header -->
		<div class="magpro-main-header">
			<div class="magpro-container magpro-main-header-inner">
				<div class="magpro-site-branding">
					<?php if ( has_custom_logo() ) : ?>
						<div class="magpro-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<h1 class="magpro-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
						$description = get_bloginfo( 'description', 'display' );
						if ( $description ) :
							?>
							<p class="magpro-site-description"><?php echo esc_html( $description ); ?></p>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<nav id="site-navigation" class="magpro-primary-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'mag-pro' ); ?>">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_class'     => 'magpro-main-menu',
								'container'      => false,
							)
						);
					} else {
						echo '<ul class="magpro-main-menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'mag-pro' ) . '</a></li></ul>';
					}
					?>
				</nav>

				<div class="magpro-header-actions">
					<!-- Fullscreen Search Trigger -->
					<button type="button" class="magpro-search-trigger magpro-header-btn" data-search-style="fullscreen" aria-label="<?php esc_attr_e( 'Open Search', 'mag-pro' ); ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
					</button>

					<!-- Mobile Drawer Toggle -->
					<button type="button" class="magpro-mobile-toggle magpro-header-btn" aria-label="<?php esc_attr_e( 'Toggle Menu', 'mag-pro' ); ?>">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
					</button>
				</div>
			</div>
		</div>

		<!-- Mobile Navigation Drawer -->
		<div class="magpro-mobile-drawer">
			<div class="magpro-mobile-drawer-header">
				<span class="magpro-mobile-title"><?php bloginfo( 'name' ); ?></span>
				<button type="button" class="magpro-mobile-close" aria-label="<?php esc_attr_e( 'Close Menu', 'mag-pro' ); ?>">&times;</button>
			</div>
			<div class="magpro-mobile-search-box">
				<?php get_search_form(); ?>
			</div>
			<div class="magpro-mobile-nav-container">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'magpro-mobile-menu-list',
							'container'      => false,
						)
					);
				}
				?>
			</div>
		</div>
		<div class="magpro-mobile-overlay"></div>
	</header>
	<?php
}

/**
 * Render Fallback Footer if no Elementor footer template is active.
 */
function magpro_render_fallback_footer() {
	?>
	<footer id="colophon" class="magpro-default-footer site-footer">
		<?php if ( is_active_sidebar( 'magpro-footer-1' ) || is_active_sidebar( 'magpro-footer-2' ) || is_active_sidebar( 'magpro-footer-3' ) || is_active_sidebar( 'magpro-footer-4' ) ) : ?>
			<div class="magpro-footer-widgets-area">
				<div class="magpro-container">
					<div class="magpro-footer-grid">
						<div class="magpro-footer-col"><?php dynamic_sidebar( 'magpro-footer-1' ); ?></div>
						<div class="magpro-footer-col"><?php dynamic_sidebar( 'magpro-footer-2' ); ?></div>
						<div class="magpro-footer-col"><?php dynamic_sidebar( 'magpro-footer-3' ); ?></div>
						<div class="magpro-footer-col"><?php dynamic_sidebar( 'magpro-footer-4' ); ?></div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="magpro-bottom-bar">
			<div class="magpro-container magpro-bottom-bar-inner">
				<div class="magpro-copyright">
					<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>. <?php esc_html_e( 'All rights reserved.', 'mag-pro' ); ?></p>
				</div>
				<div class="magpro-credits">
					<p><?php esc_html_e( 'Developed by', 'mag-pro' ); ?> <a href="https://developerzahir.com/" target="_blank" rel="noopener noreferrer"><strong>Developer Zahir</strong></a></p>
				</div>
			</div>
		</div>
	</footer>
	<?php
}
