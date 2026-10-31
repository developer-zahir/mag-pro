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

		// If built with Elementor, render full page content directly
		if ( did_action( 'elementor/loaded' ) && \Elementor\Plugin::$instance->documents->get( get_the_ID() ) && \Elementor\Plugin::$instance->documents->get( get_the_ID() )->is_built_with_elementor() ) :
			the_content();
		else :
			?>
			<div class="container row-x1" style="padding-top: 30px; padding-bottom: 50px;">
				<div class="content-wrapper" style="padding-top:0;">
					<main id="main-wrapper">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'item-post' ); ?>>
							<header class="blog-entry-header" style="margin-bottom: 20px;">
								<h1 class="entry-title" style="margin: 0; font-size: 28px; font-weight: 800; color: var(--title-color);"><?php the_title(); ?></h1>
							</header>

							<div class="entry-content">
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
					</main>
					<?php get_sidebar(); ?>
				</div>
			</div>
			<?php
		endif;
	endwhile;
	?>
</div>

<?php
get_footer();
