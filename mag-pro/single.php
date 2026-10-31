<?php
/**
 * The template for displaying all single posts.
 * Modeled after the classic MagPro .item-post design.
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
		<main id="main-wrapper" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();
				$post_id    = get_the_ID();
				$categories = get_the_category();
				$cat_id     = ! empty( $categories ) ? $categories[0]->term_id : 0;
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'item-post' ); ?>>

					<!-- 1. MagPro Post Breadcrumbs -->
					<nav id="breadcrumb">
						<a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i> <?php esc_html_e( 'Home', 'mag-pro' ); ?></a>
						<em class="delimiter"></em>
						<?php if ( ! empty( $categories ) ) : ?>
							<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a>
							<em class="delimiter"></em>
						<?php endif; ?>
						<span class="current"><?php the_title(); ?></span>
					</nav>

					<!-- 2. Post Header -->
					<header class="blog-entry-header">
						<?php if ( ! empty( $categories ) ) : ?>
							<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="entry-category">
								<?php echo esc_html( $categories[0]->name ); ?>
							</a>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>

						<div class="entry-meta">
							<span class="entry-author">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 22, '', '', array( 'style' => 'border-radius:50%; vertical-align:middle; margin-right:5px;' ) ); ?>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
							</span>

							<span class="entry-time">
								<i class="far fa-clock"></i>
								<?php echo esc_html( get_the_date() ); ?>
							</span>

							<span class="entry-views">
								<i class="far fa-eye"></i>
								<?php echo esc_html( magpro_get_post_views() ); ?> <?php esc_html_e( 'Views', 'mag-pro' ); ?>
							</span>

							<?php if ( comments_open() || get_comments_number() ) : ?>
								<span class="entry-comments">
									<i class="far fa-comment-alt"></i>
									<?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?>
								</span>
							<?php endif; ?>
						</div>
					</header>

					<!-- 3. Featured Image -->
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-thumb">
							<?php the_post_thumbnail( 'full' ); ?>
						</div>
					<?php endif; ?>

					<!-- 4. Post Content -->
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

					<!-- 5. Post Tags -->
					<?php
					$tags = get_the_tags();
					if ( ! empty( $tags ) ) :
						?>
						<div class="post-tags">
							<strong style="margin-right: 6px; font-size: 13px; color: var(--title-color);"><i class="fas fa-tags"></i> <?php esc_html_e( 'Tags:', 'mag-pro' ); ?></strong>
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag-link">#<?php echo esc_html( $tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- 6. MagPro Social Share Box -->
					<?php
					$share_url   = rawurlencode( get_permalink() );
					$share_title = rawurlencode( get_the_title() );
					?>
					<div class="post-share">
						<span class="share-title"><?php esc_html_e( 'Share This Article:', 'mag-pro' ); ?></span>
						<div class="share-links">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn share-facebook">
								<i class="fab fa-facebook-f"></i> Facebook
							</a>
							<a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&amp;url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn share-twitter">
								<i class="fab fa-twitter"></i> Twitter
							</a>
							<a href="https://pinterest.com/pin/create/button/?url=<?php echo $share_url; ?>&amp;description=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-btn share-pinterest">
								<i class="fab fa-pinterest-p"></i> Pinterest
							</a>
							<a href="https://api.whatsapp.com/send?text=<?php echo $share_title; ?>%20<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn share-whatsapp">
								<i class="fab fa-whatsapp"></i> WhatsApp
							</a>
							<a href="https://t.me/share/url?url=<?php echo $share_url; ?>&amp;text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-btn share-telegram">
								<i class="fab fa-telegram-plane"></i> Telegram
							</a>
							<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn share-linkedin">
								<i class="fab fa-linkedin-in"></i> LinkedIn
							</a>
						</div>
					</div>

					<!-- 7. About Author Box -->
					<div class="about-author">
						<div class="avatar-container">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
						</div>
						<div class="author-info">
							<h4 class="author-name"><?php echo esc_html( get_the_author() ); ?></h4>
							<p class="author-bio">
								<?php
								$bio = get_the_author_meta( 'description' );
								echo ! empty( $bio ) ? esc_html( $bio ) : esc_html__( 'Content creator and journalist covering breaking news, business, and tech.', 'mag-pro' );
								?>
							</p>
						</div>
					</div>

					<!-- 8. Post Navigation (Prev/Next) -->
					<div class="post-nav">
						<div class="nav-prev">
							<?php previous_post_link( '<i class="fas fa-chevron-left"></i> %link', '%title' ); ?>
						</div>
						<div class="nav-next">
							<?php next_post_link( '%link <i class="fas fa-chevron-right"></i>', '%title' ); ?>
						</div>
					</div>

					<!-- 9. Related Posts (3 columns) -->
					<?php
					if ( $cat_id ) {
						$related_query = new WP_Query(
							array(
								'cat'                 => $cat_id,
								'post__not_in'        => array( $post_id ),
								'posts_per_page'      => 3,
								'ignore_sticky_posts' => 1,
							)
						);

						if ( $related_query->have_posts() ) :
							?>
							<div class="related-posts-wrap">
								<h3 class="related-title"><?php esc_html_e( 'Related Articles', 'mag-pro' ); ?></h3>
								<div class="related-posts-grid">
									<?php
									while ( $related_query->have_posts() ) :
										$related_query->the_post();
										?>
										<div class="related-post-card">
											<?php if ( has_post_thumbnail() ) : ?>
												<div class="related-post-thumb">
													<a href="<?php the_permalink(); ?>">
														<?php the_post_thumbnail( 'magpro-thumb' ); ?>
													</a>
												</div>
											<?php endif; ?>
											<div class="related-post-content">
												<h4 class="related-post-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h4>
												<span class="entry-time" style="font-size: 11px; color: var(--meta-color);">
													<i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
												</span>
											</div>
										</div>
										<?php
									endwhile;
									wp_reset_postdata();
									?>
								</div>
							</div>
							<?php
						endif;
					}
					?>

					<!-- 10. Comments -->
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
