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

<div class="magpro-container">
	<div class="magpro-main-layout">
		<main id="primary" class="site-main magpro-content-area">

			<?php if ( have_posts() ) : ?>

				<header class="page-header" style="background: var(--magpro-card-bg); border: 1px solid var(--magpro-border); border-radius: var(--magpro-radius); padding: 24px; margin-bottom: 30px;">
					<h1 class="page-title" style="margin: 0; font-size: 24px; font-weight: 800; color: var(--magpro-text);">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: "%s"', 'mag-pro' ), '<span style="color:var(--magpro-primary);">' . esc_html( get_search_query() ) . '</span>' );
						?>
					</h1>
				</header>

				<div class="magpro-posts-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'magpro-post-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="magpro-post-thumbnail-wrap">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'large', array( 'class' => 'magpro-post-thumb-img' ) ); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="magpro-post-content">
								<?php
								$categories = get_the_category();
								if ( ! empty( $categories ) ) :
									?>
									<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="magpro-cat-badge">
										<?php echo esc_html( $categories[0]->name ); ?>
									</a>
								<?php endif; ?>

								<h2 class="magpro-post-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>

								<div class="magpro-post-meta">
									<span class="magpro-meta-item magpro-meta-date">
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
										<?php echo esc_html( get_the_date() ); ?>
									</span>

									<span class="magpro-meta-item magpro-meta-views">
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
										<?php echo esc_html( magpro_get_post_views() ); ?>
									</span>
								</div>

								<div class="magpro-post-excerpt">
									<?php the_excerpt(); ?>
								</div>

								<a href="<?php the_permalink(); ?>" class="magpro-read-more-btn">
									<?php esc_html_e( 'Read More', 'mag-pro' ); ?> &rarr;
								</a>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'prev_text' => '&larr; ' . esc_html__( 'Previous', 'mag-pro' ),
						'next_text' => esc_html__( 'Next', 'mag-pro' ) . ' &rarr;',
					)
				);
				?>

			<?php else : ?>

				<div class="magpro-no-results" style="padding: 50px; background: var(--magpro-card-bg); border: 1px solid var(--magpro-border); border-radius: var(--magpro-radius); text-align: center;">
					<h2 style="font-size: 26px; font-weight: 800; margin-bottom: 12px; color: var(--magpro-text);"><?php esc_html_e( 'Nothing Found', 'mag-pro' ); ?></h2>
					<p style="color: var(--magpro-text-muted); font-size: 15px; margin-bottom: 24px;"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mag-pro' ); ?></p>
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
