<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="magpro-container" style="padding-top: 60px; padding-bottom: 80px;">
	<main id="primary" class="site-main">
		<section class="error-404 not-found" style="background: var(--magpro-card-bg); border: 1px solid var(--magpro-border); border-radius: var(--magpro-radius); padding: 60px 20px; text-align: center; max-width: 650px; margin: 0 auto;">
			<header class="page-header">
				<span style="font-size: 80px; font-weight: 900; line-height: 1; color: var(--magpro-primary); display: block; margin-bottom: 15px;">404</span>
				<h1 class="page-title" style="font-size: 28px; font-weight: 800; margin: 0 0 12px; color: var(--magpro-text);"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mag-pro' ); ?></h1>
			</header>

			<div class="page-content" style="margin-top: 15px;">
				<p style="color: var(--magpro-text-muted); font-size: 16px; margin-bottom: 25px;"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try searching for what you need?', 'mag-pro' ); ?></p>
				<div style="max-width: 440px; margin: 0 auto 30px;">
					<?php get_search_form(); ?>
				</div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; background: var(--magpro-primary); color: #fff; padding: 10px 24px; border-radius: var(--magpro-radius); font-weight: 600; text-decoration: none;">
					&larr; <?php esc_html_e( 'Back to Homepage', 'mag-pro' ); ?>
				</a>
			</div>
		</section>
	</main>
</div>

<?php
get_footer();
