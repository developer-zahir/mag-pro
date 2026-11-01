<?php
/**
 * The main template file for Mag Pro.
 * Re-engineered to match the classic MagPro magazine layout.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="container row-x1">
	<div class="content-wrapper">
		<main id="main-wrapper" class="blog-posts">

			<?php if ( have_posts() ) : ?>

				<?php if ( is_home() && ! is_front_page() ) : ?>
					<header class="page-header" style="margin-bottom: 20px;">
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php endif; ?>

				<?php
$archive_layout = get_theme_mod( 'magpro_archive_layout', 'list' );
$hover_effect   = get_theme_mod( 'magpro_archive_hover_effect', 0 ) ? 'has-hover-effect' : 'no-hover-effect';
$wrap_classes   = 'index-post-wrap layout-' . esc_attr( $archive_layout ) . ' ' . $hover_effect;
?>
				<div class="<?php echo esc_attr( $wrap_classes ); ?>">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'index-post' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'magpro-medium' ); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="entry-header">
								<?php
								$categories = get_the_category();
								if ( ! empty( $categories ) ) :
									?>
									<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="entry-category">
										<?php echo esc_html( $categories[0]->name ); ?>
									</a>
								<?php endif; ?>

								<h2 class="entry-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>

								<?php magpro_render_archive_post_meta(); ?>

								<p class="excerpt">
									<?php echo wp_trim_words( get_the_excerpt(), 24, '...' ); ?>
								</p>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>

				<?php magpro_render_archive_pagination(); ?>

			<?php else : ?>

				<div class="magpro-no-results" style="padding: 40px; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius); text-align: center;">
					<h2><?php esc_html_e( 'Nothing Found', 'mag-pro' ); ?></h2>
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mag-pro' ); ?></p>
					<div style="max-width: 400px; margin: 20px auto 0;">
						<?php get_search_form(); ?>
					</div>
				</div>

			<?php endif; ?>

		</main>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
