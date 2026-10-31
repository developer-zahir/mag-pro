<?php
/**
 * The template for displaying search results pages.
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

				<header class="page-header" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius); padding: 20px 24px; margin-bottom: 25px; border-left: 4px solid var(--main-color);">
					<h1 class="page-title" style="margin: 0; font-size: 22px; font-weight: 800; color: var(--title-color);">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: "%s"', 'mag-pro' ), '<span style="color:var(--main-color);">' . esc_html( get_search_query() ) . '</span>' );
						?>
					</h1>
				</header>

				<div class="index-post-wrap">
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

								<div class="entry-meta">
									<span class="entry-time">
										<i class="far fa-clock"></i>
										<?php echo esc_html( get_the_date() ); ?>
									</span>

									<span class="entry-views">
										<i class="far fa-eye"></i>
										<?php echo esc_html( magpro_get_post_views() ); ?>
									</span>
								</div>

								<p class="excerpt">
									<?php echo wp_trim_words( get_the_excerpt(), 24, '...' ); ?>
								</p>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>

				<div class="blog-pager">
					<?php
					the_posts_pagination(
						array(
							'prev_text' => '<i class="fas fa-chevron-left"></i>',
							'next_text' => '<i class="fas fa-chevron-right"></i>',
						)
					);
					?>
				</div>

			<?php else : ?>

				<div class="magpro-no-results" style="padding: 50px; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius); text-align: center;">
					<h2 style="font-size: 24px; font-weight: 800; margin-bottom: 12px; color: var(--title-color);"><?php esc_html_e( 'Nothing Found', 'mag-pro' ); ?></h2>
					<p style="color: var(--meta-color); font-size: 15px; margin-bottom: 24px;"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mag-pro' ); ?></p>
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
