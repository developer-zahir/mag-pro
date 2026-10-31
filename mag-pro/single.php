<?php
/**
 * The template for displaying all single posts.
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

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'magpro-single-post' ); ?>>
					<header class="magpro-single-header">
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) :
							?>
							<div class="magpro-single-categories" style="margin-bottom: 12px;">
								<?php foreach ( $categories as $category ) : ?>
									<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="magpro-cat-badge">
										<?php echo esc_html( $category->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<h1 class="magpro-single-title"><?php the_title(); ?></h1>

						<div class="magpro-post-meta">
							<span class="magpro-meta-item magpro-meta-author">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 26, '', '', array( 'style' => 'border-radius:50%; vertical-align:middle; margin-right:6px;' ) ); ?>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
							</span>

							<span class="magpro-meta-item magpro-meta-date">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
								<?php echo esc_html( get_the_date() ); ?>
							</span>

							<span class="magpro-meta-item magpro-meta-views">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
								<?php echo esc_html( magpro_get_post_views() ); ?> <?php esc_html_e( 'Views', 'mag-pro' ); ?>
							</span>

							<?php if ( comments_open() || get_comments_number() ) : ?>
								<span class="magpro-meta-item magpro-meta-comments">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
									<?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?>
								</span>
							<?php endif; ?>
						</div>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="magpro-single-thumb">
							<?php the_post_thumbnail( 'full' ); ?>
						</div>
					<?php endif; ?>

					<div class="magpro-single-content entry-content">
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
					$tags = get_the_tags();
					if ( ! empty( $tags ) ) :
						?>
						<div class="magpro-post-tags">
							<strong><?php esc_html_e( 'Tags:', 'mag-pro' ); ?></strong>
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="magpro-tag-link">#<?php echo esc_html( $tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- Author Box -->
					<div class="magpro-author-box">
						<div class="magpro-author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?>
						</div>
						<div class="magpro-author-info">
							<h4 class="magpro-author-name"><?php echo esc_html( get_the_author() ); ?></h4>
							<p class="magpro-author-bio"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
						</div>
					</div>

					<!-- Post Navigation -->
					<div class="magpro-post-navigation" style="display:flex; justify-content:space-between; margin-top:30px; padding:20px 0; border-top:1px solid var(--magpro-border); border-bottom:1px solid var(--magpro-border);">
						<div class="magpro-nav-prev"><?php previous_post_link( '&larr; %link', '%title' ); ?></div>
						<div class="magpro-nav-next"><?php next_post_link( '%link &rarr;', '%title' ); ?></div>
					</div>

					<!-- Comments -->
					<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				</article>

			<?php endwhile; ?>

		</main>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
