<?php
/**
 * The main template file for Mag Pro.
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

				<?php if ( is_home() && ! is_front_page() ) : ?>
					<header class="page-header" style="margin-bottom: 25px;">
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php endif; ?>

				<div class="magpro-posts-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'magpro-post-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="magpro-post-thumbnail-wrap">
									<a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
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
									<span class="magpro-meta-item magpro-meta-author">
										<?php echo get_avatar( get_the_author_meta( 'ID' ), 22, '', '', array( 'style' => 'border-radius:50%; vertical-align:middle; margin-right:4px;' ) ); ?>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
									</span>

									<span class="magpro-meta-item magpro-meta-date">
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
										<?php echo esc_html( get_the_date() ); ?>
									</span>

									<span class="magpro-meta-item magpro-meta-views">
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
										<?php echo esc_html( magpro_get_post_views() ); ?>
									</span>

									<?php if ( comments_open() || get_comments_number() ) : ?>
										<span class="magpro-meta-item magpro-meta-comments">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
											<?php comments_number( '0', '1', '%' ); ?>
										</span>
									<?php endif; ?>
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

				<div class="magpro-no-results" style="padding: 40px; background: var(--magpro-card-bg); border: 1px solid var(--magpro-border); border-radius: var(--magpro-radius); text-align: center;">
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
