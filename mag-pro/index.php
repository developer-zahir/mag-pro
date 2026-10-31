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
									<span class="entry-author">
										<i class="far fa-user"></i>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
									</span>

									<span class="entry-time">
										<i class="far fa-clock"></i>
										<?php echo esc_html( get_the_date() ); ?>
									</span>

									<span class="entry-views">
										<i class="far fa-eye"></i>
										<?php echo esc_html( magpro_get_post_views() ); ?>
									</span>

									<?php if ( comments_open() || get_comments_number() ) : ?>
										<span class="entry-comments">
											<i class="far fa-comment-alt"></i>
											<?php comments_number( '0', '1', '%' ); ?>
										</span>
									<?php endif; ?>
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
