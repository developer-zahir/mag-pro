<?php
/**
 * The template for displaying search results pages.
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

			<!-- MagPro Search Breadcrumbs -->
			<nav id="breadcrumb">
				<a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i> <?php esc_html_e( 'Home', 'mag-pro' ); ?></a>
				<em class="delimiter"></em>
				<span class="current"><?php esc_html_e( 'Search', 'mag-pro' ); ?></span>
			</nav>

			<!-- MagPro .queryMessage for Search -->
			<div class="queryMessage">
				<span class="query-info">
					<?php esc_html_e( 'Showing posts matching the search for:', 'mag-pro' ); ?>
					<span class="search-query"><?php echo get_search_query(); ?></span>
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

				<div class="queryEmpty" style="padding: 40px 0; text-align: center;">
					<h3 style="font-size: 20px; font-weight: 700; color: var(--title-color); margin-bottom: 12px;"><?php esc_html_e( 'No matching posts found', 'mag-pro' ); ?></h3>
					<p style="color: var(--meta-color); font-size: 14px; margin-bottom: 24px;"><?php esc_html_e( 'Try different keywords or browse our categories.', 'mag-pro' ); ?></p>
					<div style="max-width: 440px; margin: 0 auto;">
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
