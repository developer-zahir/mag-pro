<?php
/**
 * The template for displaying archive pages.
 * Replicated same to same as MagPro XML.
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

			<!-- MagPro Archive Breadcrumbs -->
			<nav id="breadcrumb">
				<a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i> <?php esc_html_e( 'Home', 'mag-pro' ); ?></a>
				<em class="delimiter"></em>
				<?php if ( is_category() ) : ?>
					<span class="current"><?php single_cat_title(); ?></span>
				<?php elseif ( is_tag() ) : ?>
					<span class="current">#<?php single_tag_title(); ?></span>
				<?php elseif ( is_author() ) : ?>
					<span class="current"><?php the_author(); ?></span>
				<?php else : ?>
					<span class="current"><?php echo wp_strip_all_tags( get_the_archive_title() ); ?></span>
				<?php endif; ?>
			</nav>

			<!-- MagPro .queryMessage (same to same as MagPro XML) -->
			<div class="queryMessage">
				<span class="query-info">
					<?php esc_html_e( 'Showing posts for:', 'mag-pro' ); ?>
					<span class="search-label">
						<?php
						if ( is_category() ) {
							single_cat_title();
						} elseif ( is_tag() ) {
							single_tag_title( '#' );
						} elseif ( is_author() ) {
							the_author();
						} else {
							echo wp_strip_all_tags( get_the_archive_title() );
						}
						?>
					</span>
				</span>
			</div>

			<?php if ( have_posts() ) : ?>

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

				<div class="queryEmpty">
					<p><?php esc_html_e( 'No posts found in this archive.', 'mag-pro' ); ?></p>
				</div>

			<?php endif; ?>

		</main>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
