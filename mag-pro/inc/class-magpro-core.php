<?php
/**
 * Core functionality for Mag Pro theme.
 * Dark/Light Mode, Post Views, Fallback Header & Footer, Admin Dashboard.
 * Modeled directly after the classic MagPro template.
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
		<div class="wrap magpro-dashboard-wrap" style="max-width: 1050px; margin-top: 25px; font-family: 'Hind Siliguri', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
			<div style="background: linear-gradient(135deg, #171921 0%, #212530 100%); color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15); margin-bottom: 30px; border-bottom: 4px solid #ff2232;">
				<div style="display:flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
					<div>
						<span style="background: #ff2232; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Version 2.2.0</span>
						<h1 style="color: #ffffff; font-size: 32px; font-weight: 800; margin: 12px 0 8px;">Mag Pro — Classic Magazine & Blog Theme</h1>
						<p style="color: #a9b4ba; font-size: 15px; margin: 0; max-width: 600px;">Re-engineered with love by <strong style="color: #ff2232;">Developer Zahir</strong>. Modeled faithfully after the original MagPro design with modern Elementor Header & Footer capabilities.</p>
					</div>
					<div>
						<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=magpro_hf' ) ); ?>" class="button button-primary" style="background:#ff2232; border-color:#ff2232; padding: 10px 22px; height: auto; font-size: 15px; font-weight: 600; border-radius: 4px;">+ Create Elementor Header / Footer</a>
					</div>
				</div>
			</div>

			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 30px;">
				<div style="background: #ffffff; padding: 28px; border-radius: 6px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
					<div style="font-size: 28px; margin-bottom: 12px;">🎨</div>
					<h3 style="font-size: 18px; font-weight: 700; margin: 0 0 10px; color: #171921;">Elementor Header & Footer Builder</h3>
					<p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">The default header and footer match MagPro perfectly out of the box! If you want a custom design, create an Elementor template and set its display rule.</p>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=magpro_hf' ) ); ?>" class="button" style="font-weight: 600;">Manage Templates &rarr;</a>
				</div>

				<div style="background: #ffffff; padding: 28px; border-radius: 6px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
					<div style="font-size: 28px; margin-bottom: 12px;">📰</div>
					<h3 style="font-size: 18px; font-weight: 700; margin: 0 0 10px; color: #171921;">Mag Pro Elements Widgets</h3>
					<p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Use the 12 bundled Elementor widgets (Featured Hero, Block 1, Block 2, Magazine Tabs, Video Grid, Ticker, Dark Switcher, Search, etc.) to build rich magazine layouts.</p>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>" class="button" style="font-weight: 600;">Edit Pages &rarr;</a>
				</div>

				<div style="background: #ffffff; padding: 28px; border-radius: 6px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
					<div style="font-size: 28px; margin-bottom: 12px;">🌓</div>
					<h3 style="font-size: 18px; font-weight: 700; margin: 0 0 10px; color: #171921;">Instant MagPro Dark Mode</h3>
					<p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Built into the navigation bar and mobile menu with exact MagPro dark colors (#15181f background, #171921 menu, #212530 cards).</p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button" style="font-weight: 600;">View Live Site &rarr;</a>
				</div>
			</div>

			<div style="background: #ffffff; padding: 24px 30px; border-radius: 6px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
				<div>
					<p style="margin: 0; font-size: 14px; color: #64748b;">
						Author: <strong style="color: #171921;">Developer Zahir</strong> | Website: <a href="https://developerzahir.com/" target="_blank" style="color: #ff2232; text-decoration: none; font-weight: 600;">developerzahir.com</a>
					</p>
				</div>
				<div>
					<span style="font-size: 13px; color: #94a3b8;">Mag Pro Version 2.1.0 — Pure & Lightweight</span>
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
 * Render Fallback Header matching MagPro .xml template.
 */
function magpro_render_fallback_header() {
	$show_topbar        = get_theme_mod( 'magpro_enable_topbar', 1 );
	$show_middle_header = get_theme_mod( 'magpro_enable_middle_header', 1 );

	// Social links from customizer
	$social_networks = array(
		'facebook'  => array( 'icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => get_theme_mod( 'magpro_social_facebook', '#' ) ),
		'twitter'   => array( 'icon' => 'fab fa-twitter', 'name' => 'Twitter', 'url' => get_theme_mod( 'magpro_social_twitter', '#' ) ),
		'youtube'   => array( 'icon' => 'fab fa-youtube', 'name' => 'YouTube', 'url' => get_theme_mod( 'magpro_social_youtube', '#' ) ),
		'instagram' => array( 'icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => get_theme_mod( 'magpro_social_instagram', '#' ) ),
		'pinterest' => array( 'icon' => 'fab fa-pinterest-p', 'name' => 'Pinterest', 'url' => get_theme_mod( 'magpro_social_pinterest', '#' ) ),
		'linkedin'  => array( 'icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn', 'url' => get_theme_mod( 'magpro_social_linkedin', '' ) ),
		'telegram'  => array( 'icon' => 'fab fa-telegram-plane', 'name' => 'Telegram', 'url' => get_theme_mod( 'magpro_social_telegram', '' ) ),
		'whatsapp'  => array( 'icon' => 'fab fa-whatsapp', 'name' => 'WhatsApp', 'url' => get_theme_mod( 'magpro_social_whatsapp', '' ) ),
	);
	?>
	<header id="magpro-pro-header-wrapper" class="magpro-header-wrapper">
		<!-- 1. Topbar Wrap (Height: 32px) -->
		<?php if ( $show_topbar ) : ?>
			<nav class="topbar-wrap">
				<div class="container row-x1">
					<div class="main-navbar-menu">
						<?php if ( has_nav_menu( 'top' ) ) : ?>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'top',
									'menu_class'     => 'top-menu-list',
									'depth'          => 1,
									'container'      => false,
								)
							);
							?>
						<?php else : ?>
							<ul class="top-menu-list">
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'mag-pro' ); ?></a></li>
								<li><a href="#"><?php esc_html_e( 'About Us', 'mag-pro' ); ?></a></li>
								<li><a href="#"><?php esc_html_e( 'Contact Us', 'mag-pro' ); ?></a></li>
							</ul>
						<?php endif; ?>
					</div>

					<div class="main-navbar-social">
						<ul class="social">
							<?php
							foreach ( $social_networks as $network => $data ) :
								if ( ! empty( $data['url'] ) ) :
									?>
									<li class="<?php echo esc_attr( $network ); ?>">
										<a class="<?php echo esc_attr( $network ); ?>" href="<?php echo esc_url( $data['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $data['name'] ); ?>">
											<i class="<?php echo esc_attr( $data['icon'] ); ?>"></i>
										</a>
									</li>
									<?php
								endif;
							endforeach;
							?>
						</ul>
					</div>
				</div>
			</nav>
		<?php endif; ?>

		<!-- 2. Header Content (Logo + 728x90 Header Ad) -->
		<?php if ( $show_middle_header ) : ?>
			<div class="header-content">
				<div class="container row-x1">
					<div class="header-logo-wrap">
						<div class="logo-content">
							<?php
							$light_logo_id = get_theme_mod( 'custom_logo' );
							$dark_logo_url = get_theme_mod( 'magpro_dark_logo' );

							if ( $light_logo_id && $dark_logo_url ) :
								$light_logo_url = wp_get_attachment_image_url( $light_logo_id, 'full' );
								?>
								<div class="logo-img">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
										<img src="<?php echo esc_url( $light_logo_url ); ?>" class="magpro-logo-light" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
										<img src="<?php echo esc_url( $dark_logo_url ); ?>" class="magpro-logo-dark" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
									</a>
								</div>
							<?php elseif ( has_custom_logo() ) : ?>
								<div class="logo-img"><?php the_custom_logo(); ?></div>
							<?php else : ?>
								<h1 class="blog-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
								</h1>
							<?php endif; ?>

							<!-- Mobile Action Toggles -->
							<div class="toggle-content">
								<a class="mobile-darkmode-toggle" href="javascript:;" title="<?php esc_attr_e( 'Toggle Dark Mode', 'mag-pro' ); ?>"></a>
								<a class="mobile-menu-toggle" href="javascript:;" title="<?php esc_attr_e( 'Toggle Menu', 'mag-pro' ); ?>"><i class="fas fa-bars"></i></a>
							</div>
						</div>
					</div>

					<div class="header-ads-wrap">
						<?php
						$custom_ad = get_theme_mod( 'magpro_header_ad_code' );
						if ( ! empty( $custom_ad ) ) :
							?>
							<div class="header-ads">
								<?php echo do_shortcode( $custom_ad ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						<?php elseif ( is_active_sidebar( 'magpro-header-ad' ) ) : ?>
							<div class="header-ads">
								<?php dynamic_sidebar( 'magpro-header-ad' ); ?>
							</div>
						<?php else : ?>
							<div class="header-ads">
								<div class="header-ad-placeholder">
									<span><?php esc_html_e( 'Responsive Advertisement 728x90', 'mag-pro' ); ?></span>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- 3. Main Navigation Bar (Red 50px bar with Home icon, Search, Dark mode) -->
		<nav class="main-menu-wrap">
			<div class="main-menu">
				<div class="main-menu-frame">
					<div class="container row-x1">
						<div class="main-menu-items">
							<!-- Home Icon Link -->
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home-icon-link" aria-label="<?php esc_attr_e( 'Home', 'mag-pro' ); ?>">
								<i class="fas fa-home"></i>
							</a>

							<!-- Primary Navigation Menu -->
							<div id="magpro-pro-main-menu" class="magpro-pro-main-menu">
								<?php
								if ( has_nav_menu( 'primary' ) ) {
									wp_nav_menu(
										array(
											'theme_location' => 'primary',
											'menu_class'     => 'main-nav-list',
											'container'      => false,
										)
									);
								} else {
									echo '<ul class="main-nav-list"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'mag-pro' ) . '</a></li><li><a href="#">' . esc_html__( 'Features', 'mag-pro' ) . '</a></li><li><a href="#">' . esc_html__( 'Documentation', 'mag-pro' ) . '</a></li></ul>';
								}
								?>
							</div>

							<!-- Dark Mode Switcher (50x50 icon) -->
							<a class="darkmode-toggle" href="javascript:;" title="<?php esc_attr_e( 'Dark Mode', 'mag-pro' ); ?>" aria-label="<?php esc_attr_e( 'Toggle dark/light mode', 'mag-pro' ); ?>"></a>

							<!-- Search Toggle (50x50 icon) -->
							<a class="search-toggle" href="javascript:;" title="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'mag-pro' ); ?>"></a>

							<!-- Slide-out Nav Search Form -->
							<div id="nav-search">
								<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
									<input autocomplete="off" class="search-input" placeholder="<?php esc_attr_e( 'Search...', 'mag-pro' ); ?>" name="s" value="<?php echo get_search_query(); ?>" />
									<button class="search-action" type="submit" value="" aria-label="<?php esc_attr_e( 'Submit Search', 'mag-pro' ); ?>">
										<i class="fas fa-search"></i>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>

		<!-- Mobile Navigation Drawer -->
		<div class="magpro-mobile-drawer">
			<div class="magpro-mobile-drawer-header">
				<span class="magpro-mobile-title"><?php bloginfo( 'name' ); ?></span>
				<a href="javascript:;" class="magpro-mobile-close" aria-label="<?php esc_attr_e( 'Close Menu', 'mag-pro' ); ?>">&times;</a>
			</div>
			<div class="magpro-mobile-search-box">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-search-form">
					<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search...', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" />
					<button type="submit"><i class="fas fa-search"></i></button>
				</form>
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
 * Render Fallback Footer matching MagPro template.
 */
function magpro_render_fallback_footer() {
	?>
	<footer id="footer-wrapper" class="magpro-default-footer">
		<?php if ( is_active_sidebar( 'magpro-footer-1' ) || is_active_sidebar( 'magpro-footer-2' ) || is_active_sidebar( 'magpro-footer-3' ) ) : ?>
			<div class="footer-widgets-wrap">
				<div class="container row-x1">
					<div class="footer-grid">
						<div class="footer-col"><?php dynamic_sidebar( 'magpro-footer-1' ); ?></div>
						<div class="footer-col"><?php dynamic_sidebar( 'magpro-footer-2' ); ?></div>
						<div class="footer-col"><?php dynamic_sidebar( 'magpro-footer-3' ); ?></div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="footer-copyright-wrap">
			<div class="container row-x1 footer-bottom-inner">
				<div class="footer-copyright">
					<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>. <?php esc_html_e( 'All rights reserved.', 'mag-pro' ); ?></p>
				</div>
				<div class="footer-credits">
					<p><?php esc_html_e( 'Developed by', 'mag-pro' ); ?> <a href="https://developerzahir.com/" target="_blank" rel="noopener noreferrer"><strong>Developer Zahir</strong></a></p>
				</div>
			</div>
		</div>
	</footer>
	<?php
}
