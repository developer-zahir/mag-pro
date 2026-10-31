<?php
/**
 * The template for displaying all pages.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="magpro-page-wrapper">
	<?php
	while ( have_posts() ) :
		the_post();

		// If built with Elementor, render clean content directly
		if ( did_action( 'elementor/loaded' ) && \Elementor\Plugin::$instance->documents->get( get_the_ID() ) && \Elementor\Plugin::$instance->documents->get( get_the_ID() )->is_built_with_elementor() ) :
			the_content();
		else :
			?>
			<div class="magpro-container" style="padding-top: 40px; padding-bottom: 60px;">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'magpro-standard-page' ); ?> style="background: var(--magpro-card-bg); border: 1px solid var(--magpro-border); border-radius: var(--magpro-radius); padding: 40px;">
					<header class="entry-header" style="margin-bottom: 24px;">
						<h1 class="entry-title" style="font-size: 32px; font-weight: 800; margin: 0; color: var(--magpro-text);"><?php the_title(); ?></h1>
					</header>

					<div class="entry-content magpro-single-content">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mag-pro' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

					<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				</article>
			</div>
			<?php
		endif;
	endwhile;
	?>
</div>

<?php
get_footer();
