<?php
/**
 * MagPro Shortcodes
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MagPro_Shortcodes {

	public static function init() {
		add_shortcode( 'magpro_hero', array( __CLASS__, 'render_hero' ) );
		add_shortcode( 'magpro_block1', array( __CLASS__, 'render_block1' ) );
		add_shortcode( 'magpro_block2', array( __CLASS__, 'render_block2' ) );
		add_shortcode( 'magpro_grid', array( __CLASS__, 'render_grid' ) );
		add_shortcode( 'magpro_list', array( __CLASS__, 'render_list' ) );
		add_shortcode( 'magpro_videos', array( __CLASS__, 'render_videos' ) );
		add_shortcode( 'magpro_ticker', array( __CLASS__, 'render_ticker' ) );
		add_shortcode( 'magpro_tabs', array( __CLASS__, 'render_tabs' ) );
		add_shortcode( 'magpro_social', array( __CLASS__, 'render_social' ) );
	}

	public static function render_hero( $atts ) {
		$atts = shortcode_atts(
			array(
				'layout'   => '5_posts',
				'category' => '',
				'count'    => 5,
				'orderby'  => 'date',
			),
			$atts
		);

		ob_start();
		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => intval( $atts['count'] ),
				'category'       => $atts['category'],
				'orderby'        => $atts['orderby'],
			)
		);

		$posts = $query->posts;
		if ( ! empty( $posts ) ) {
			?>
			<div class="magpro-hero-wrap">
				<?php if ( '5_posts' === $atts['layout'] && isset( $posts[0] ) ) : 
					$lead_id = $posts[0]->ID;
					$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
				?>
					<div class="magpro-hero-grid-5">
						<div class="magpro-hero-lead magpro-hero-card">
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
								<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
							</a>
							<div class="magpro-hero-overlay"></div>
							<div class="magpro-hero-content">
								<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
								<h2 class="magpro-post-title">
									<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
								</h2>
								<?php echo \MagPro_Helpers::get_post_meta( $lead_id, true, true ); ?>
							</div>
						</div>
						<div class="magpro-hero-subgrid">
							<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
								$p_id  = $posts[ $i ]->ID;
								$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
							?>
								<div class="magpro-hero-card">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
										<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
									</a>
									<div class="magpro-hero-overlay"></div>
									<div class="magpro-hero-content">
										<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
										<h3 class="magpro-post-title">
											<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
										</h3>
										<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, true ); ?>
									</div>
								</div>
							<?php endfor; ?>
						</div>
					</div>
				<?php else : ?>
					<div class="magpro-hero-grid-3">
						<?php foreach ( $posts as $p ) : 
							$p_id  = $p->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
						?>
							<div class="magpro-hero-card">
								<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
									<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
								</a>
								<div class="magpro-hero-overlay"></div>
								<div class="magpro-hero-content">
									<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
									<h3 class="magpro-post-title">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									</h3>
									<?php echo \MagPro_Helpers::get_post_meta( $p_id, true, true ); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	public static function render_grid( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'columns'  => '3',
				'category' => '',
				'count'    => 6,
				'orderby'  => 'date',
			),
			$atts
		);

		ob_start();
		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => intval( $atts['count'] ),
				'category'       => $atts['category'],
				'orderby'        => $atts['orderby'],
			)
		);

		if ( $query->have_posts() ) {
			?>
			<div class="magpro-grid-wrap">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h3 class="magpro-widget-title"><?php echo esc_html( $atts['title'] ); ?></h3>
				<?php endif; ?>

				<div class="magpro-grid-columns-<?php echo esc_attr( $atts['columns'] ); ?>">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$p_id  = get_the_ID();
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
						?>
						<article class="magpro-grid-card">
							<div class="magpro-grid-thumb">
								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								</a>
								<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
							</div>
							<div class="magpro-grid-content">
								<h4 class="magpro-post-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h4>
								<?php echo \MagPro_Helpers::get_post_meta( $p_id, true, true ); ?>
								<p class="magpro-grid-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $p_id, 14 ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="magpro-read-more">
									<?php esc_html_e( 'Read More', 'mag-pro-elements' ); ?> <i class="fas fa-arrow-right"></i>
								</a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	public static function render_block1( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'category' => '',
				'count'    => 5,
			),
			$atts
		);

		ob_start();
		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => intval( $atts['count'] ),
				'category'       => $atts['category'],
			)
		);

		$posts = $query->posts;
		if ( ! empty( $posts ) ) {
			?>
			<div class="magpro-block1-wrap">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h3 class="magpro-widget-title"><?php echo esc_html( $atts['title'] ); ?></h3>
				<?php endif; ?>

				<div class="magpro-block1-grid">
					<?php if ( isset( $posts[0] ) ) : 
						$lead_id = $posts[0]->ID;
						$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
					?>
						<div class="magpro-block1-lead">
							<div class="magpro-block1-lead-thumb">
								<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $lead_id ) ); ?>" loading="lazy" />
								</a>
								<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
							</div>
							<div class="magpro-block1-lead-content">
								<h4 class="magpro-post-title">
									<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
								</h4>
								<?php echo \MagPro_Helpers::get_post_meta( $lead_id, true, true ); ?>
								<p class="magpro-block1-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $lead_id, 18 ) ); ?></p>
							</div>
						</div>
					<?php endif; ?>

					<div class="magpro-block1-list">
						<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
							$p_id  = $posts[ $i ]->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
						?>
							<div class="magpro-compact-item">
								<div class="magpro-compact-thumb">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>">
										<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $p_id ) ); ?>" loading="lazy" />
									</a>
								</div>
								<div class="magpro-compact-content">
									<h5 class="magpro-post-title">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									</h5>
									<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, true ); ?>
								</div>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	public static function render_tabs( $atts ) {
		$atts = shortcode_atts( array( 'count' => 4 ), $atts );
		ob_start();
		$count = intval( $atts['count'] );
		$recent_query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'date' ) );
		$popular_query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'comment_count' ) );
		$random_query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'rand' ) );
		?>
		<div class="magpro-tabs-wrap">
			<div class="magpro-tabs-nav">
				<button type="button" class="magpro-tab-button active" data-tab="recent">
					<i class="far fa-clock"></i> <?php esc_html_e( 'Recent', 'mag-pro-elements' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="popular">
					<i class="fas fa-fire"></i> <?php esc_html_e( 'Popular', 'mag-pro-elements' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="comments">
					<i class="fas fa-random"></i> <?php esc_html_e( 'Trending', 'mag-pro-elements' ); ?>
				</button>
			</div>

			<div class="magpro-tabs-content">
				<div class="magpro-tab-panel magpro-tab-recent active">
					<?php self::render_compact_items( $recent_query ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-popular">
					<?php self::render_compact_items( $popular_query ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-comments">
					<?php self::render_compact_items( $random_query ); ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	private static function render_compact_items( $query ) {
		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}
		while ( $query->have_posts() ) :
			$query->the_post();
			$p_id  = get_the_ID();
			$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
			?>
			<div class="magpro-compact-item">
				<div class="magpro-compact-thumb">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
					</a>
				</div>
				<div class="magpro-compact-content">
					<h5 class="magpro-post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>
					<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, true, true ); ?>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}
}

MagPro_Shortcodes::init();

