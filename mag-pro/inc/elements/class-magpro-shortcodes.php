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
		add_shortcode( 'magpro_slider', array( __CLASS__, 'render_slider' ) );
	}

	public static function render_hero( $atts ) {
		$atts = shortcode_atts(
			array(
				'layout'   => '5_posts',
				'category' => '',
				'count'    => 5,
				'orderby'  => 'date',
				'views'    => 'yes',
				'author'   => 'yes',
				'date'     => 'yes',
				'comments' => 'no',
				'badge'    => 'yes',
				'hover'    => 'zoom-in',
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

		$posts         = $query->posts;
		$show_views    = ( 'yes' === $atts['views'] );
		$show_author   = ( 'yes' === $atts['author'] );
		$show_date     = ( 'yes' === $atts['date'] );
		$show_comments = ( 'yes' === $atts['comments'] );
		$show_badge    = ( 'yes' === $atts['badge'] );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );

		if ( ! empty( $posts ) ) {
			?>
			<div class="magpro-hero-wrap">
				<?php if ( '5_posts' === $atts['layout'] && isset( $posts[0] ) ) : 
					$lead_id = $posts[0]->ID;
					$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
				?>
					<div class="magpro-hero-grid-5">
						<div class="magpro-hero-lead magpro-hero-card <?php echo esc_attr( $anim_class ); ?>">
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
								<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
							</a>
							<div class="magpro-hero-overlay"></div>
							<div class="magpro-hero-content">
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
								<?php endif; ?>
								<h2 class="magpro-post-title">
									<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
								</h2>
								<?php echo \MagPro_Helpers::get_post_meta( $lead_id, $show_author, $show_date, $show_views, $show_comments ); ?>
							</div>
						</div>
						<div class="magpro-hero-subgrid">
							<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
								$p_id  = $posts[ $i ]->ID;
								$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
							?>
								<div class="magpro-hero-card <?php echo esc_attr( $anim_class ); ?>">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
										<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
									</a>
									<div class="magpro-hero-overlay"></div>
									<div class="magpro-hero-content">
										<?php if ( $show_badge ) : ?>
											<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
										<?php endif; ?>
										<h3 class="magpro-post-title">
											<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
										</h3>
										<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, $show_date, $show_views, $show_comments ); ?>
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
							<div class="magpro-hero-card <?php echo esc_attr( $anim_class ); ?>">
								<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
									<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
								</a>
								<div class="magpro-hero-overlay"></div>
								<div class="magpro-hero-content">
									<?php if ( $show_badge ) : ?>
										<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
									<?php endif; ?>
									<h3 class="magpro-post-title">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									</h3>
									<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
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
				'views'    => 'yes',
				'author'   => 'yes',
				'date'     => 'yes',
				'comments' => 'no',
				'badge'    => 'yes',
				'excerpt'  => 'yes',
				'aspect'   => '16:9',
				'height'   => 190,
				'hover'    => 'zoom-in',
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

		$show_views    = ( 'yes' === $atts['views'] );
		$show_author   = ( 'yes' === $atts['author'] );
		$show_date     = ( 'yes' === $atts['date'] );
		$show_comments = ( 'yes' === $atts['comments'] );
		$show_badge    = ( 'yes' === $atts['badge'] );
		$show_excerpt  = ( 'yes' === $atts['excerpt'] );
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $atts['aspect'], intval( $atts['height'] ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );

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
							<div class="magpro-grid-thumb <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?>">
								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								</a>
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
								<?php endif; ?>
							</div>
							<div class="magpro-grid-content">
								<h4 class="magpro-post-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h4>
								<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
								<?php if ( $show_excerpt ) : ?>
									<p class="magpro-grid-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $p_id, 14 ) ); ?></p>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="magpro-read-more">
									<?php esc_html_e( 'Read More', 'mag-pro' ); ?> <i class="fas fa-arrow-right"></i>
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

	public static function render_list( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'category' => '',
				'count'    => 5,
				'orderby'  => 'date',
				'views'    => 'yes',
				'author'   => 'yes',
				'date'     => 'yes',
				'comments' => 'no',
				'badge'    => 'yes',
				'excerpt'  => 'yes',
				'aspect'   => '16:9',
				'height'   => 160,
				'hover'    => 'zoom-in',
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

		$show_views    = ( 'yes' === $atts['views'] );
		$show_author   = ( 'yes' === $atts['author'] );
		$show_date     = ( 'yes' === $atts['date'] );
		$show_comments = ( 'yes' === $atts['comments'] );
		$show_badge    = ( 'yes' === $atts['badge'] );
		$show_excerpt  = ( 'yes' === $atts['excerpt'] );
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $atts['aspect'], intval( $atts['height'] ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );

		if ( $query->have_posts() ) {
			?>
			<div class="magpro-list-wrap">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h3 class="magpro-widget-title"><?php echo esc_html( $atts['title'] ); ?></h3>
				<?php endif; ?>

				<div class="magpro-list-items">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$p_id  = get_the_ID();
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
						?>
						<article class="magpro-list-item">
							<div class="magpro-list-thumb <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?>">
								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								</a>
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
								<?php endif; ?>
							</div>
							<div class="magpro-list-content">
								<h4 class="magpro-post-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h4>
								<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
								<?php if ( $show_excerpt ) : ?>
									<p class="magpro-list-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $p_id, 18 ) ); ?></p>
								<?php endif; ?>
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
				'views'    => 'yes',
				'author'   => 'yes',
				'date'     => 'yes',
				'comments' => 'no',
				'badge'    => 'yes',
				'excerpt'  => 'yes',
				'aspect'   => '16:9',
				'height'   => 230,
				'hover'    => 'zoom-in',
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

		$show_views    = ( 'yes' === $atts['views'] );
		$show_author   = ( 'yes' === $atts['author'] );
		$show_date     = ( 'yes' === $atts['date'] );
		$show_comments = ( 'yes' === $atts['comments'] );
		$show_badge    = ( 'yes' === $atts['badge'] );
		$show_excerpt  = ( 'yes' === $atts['excerpt'] );
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $atts['aspect'], intval( $atts['height'] ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );
		$posts         = $query->posts;

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
							<div class="magpro-block1-lead-thumb <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?>">
								<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $lead_id ) ); ?>" loading="lazy" />
								</a>
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
								<?php endif; ?>
							</div>
							<div class="magpro-block1-lead-content">
								<h4 class="magpro-post-title">
									<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
								</h4>
								<?php echo \MagPro_Helpers::get_post_meta( $lead_id, $show_author, $show_date, $show_views, $show_comments ); ?>
								<?php if ( $show_excerpt ) : ?>
									<p class="magpro-block1-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $lead_id, 18 ) ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="magpro-block1-list">
						<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
							$p_id  = $posts[ $i ]->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
						?>
							<div class="magpro-compact-item">
								<div class="magpro-compact-thumb <?php echo esc_attr( $anim_class ); ?>">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>">
										<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $p_id ) ); ?>" loading="lazy" />
									</a>
								</div>
								<div class="magpro-compact-content">
									<h5 class="magpro-post-title">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									</h5>
									<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, $show_date, $show_views, $show_comments ); ?>
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

	public static function render_block2( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'category' => '',
				'count'    => 4,
				'views'    => 'yes',
				'author'   => 'no',
				'date'     => 'yes',
				'comments' => 'no',
				'badge'    => 'yes',
				'aspect'   => '16:9',
				'height'   => 200,
				'hover'    => 'zoom-in',
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

		$show_views    = ( 'yes' === $atts['views'] );
		$show_author   = ( 'yes' === $atts['author'] );
		$show_date     = ( 'yes' === $atts['date'] );
		$show_comments = ( 'yes' === $atts['comments'] );
		$show_badge    = ( 'yes' === $atts['badge'] );
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $atts['aspect'], intval( $atts['height'] ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );
		$posts         = $query->posts;

		if ( ! empty( $posts ) ) {
			?>
			<div class="magpro-block2-wrap">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h3 class="magpro-widget-title"><?php echo esc_html( $atts['title'] ); ?></h3>
				<?php endif; ?>

				<div class="magpro-block2-grid">
					<?php foreach ( $posts as $p ) : 
						$p_id  = $p->ID;
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
					?>
						<div class="magpro-block2-card magpro-hero-card <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?>">
							<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
								<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
							</a>
							<div class="magpro-hero-overlay"></div>
							<div class="magpro-hero-content">
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
								<?php endif; ?>
								<h4 class="magpro-post-title" style="color: #ffffff; font-size: 15px;">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
								</h4>
								<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	public static function render_videos( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'    => 'Featured Videos',
				'category' => '',
				'count'    => 4,
				'views'    => 'yes',
				'author'   => 'no',
				'date'     => 'yes',
				'comments' => 'no',
				'badge'    => 'yes',
				'aspect'   => '16:9',
				'height'   => 360,
				'hover'    => 'zoom-in',
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

		$posts         = $query->posts;
		$show_views    = ( 'yes' === $atts['views'] );
		$show_author   = ( 'yes' === $atts['author'] );
		$show_date     = ( 'yes' === $atts['date'] );
		$show_comments = ( 'yes' === $atts['comments'] );
		$show_badge    = ( 'yes' === $atts['badge'] );
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $atts['aspect'], intval( $atts['height'] ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );

		if ( ! empty( $posts ) ) {
			?>
			<div class="magpro-videos-wrap">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h3 class="magpro-widget-title"><i class="fas fa-play-circle" style="color: var(--mp-primary, #ff2232); margin-right: 6px;"></i> <?php echo esc_html( $atts['title'] ); ?></h3>
				<?php endif; ?>

				<div class="magpro-videos-grid">
					<?php if ( isset( $posts[0] ) ) : 
						$lead_id = $posts[0]->ID;
						$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
					?>
						<div class="magpro-video-hero magpro-hero-card <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?>">
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
								<div class="magpro-video-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
							</a>
							<div class="magpro-hero-overlay"></div>
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-video-play-btn" aria-label="Play">
								<i class="fas fa-play"></i>
							</a>
							<div class="magpro-hero-content">
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
								<?php endif; ?>
								<h3 class="magpro-post-title" style="color: #ffffff; font-size: 18px; margin-top: 8px;">
									<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
								</h3>
								<?php echo \MagPro_Helpers::get_post_meta( $lead_id, $show_author, $show_date, $show_views, $show_comments ); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="magpro-video-list">
						<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
							$p_id  = $posts[ $i ]->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
						?>
							<div class="magpro-video-item">
								<div class="magpro-video-item-thumb <?php echo esc_attr( $anim_class ); ?>">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>">
										<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $p_id ) ); ?>" loading="lazy" />
										<span class="magpro-video-mini-play"><i class="fas fa-play"></i></span>
									</a>
								</div>
								<div class="magpro-video-item-content">
									<h5 class="magpro-post-title">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									</h5>
									<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
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

	public static function render_ticker( $atts ) {
		$atts = shortcode_atts(
			array(
				'label'    => 'Trending News',
				'category' => '',
				'count'    => 8,
				'style'    => 'marquee',
				'speed'    => 25,
				'views'    => 'yes',
				'badge'    => 'no',
				'date'     => 'no',
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

		$posts      = $query->posts;
		$show_views = ( 'yes' === $atts['views'] );
		$show_badge = ( 'yes' === $atts['badge'] );
		$show_date  = ( 'yes' === $atts['date'] );
		$speed      = intval( $atts['speed'] );

		if ( ! empty( $posts ) ) {
			?>
			<div class="magpro-ticker-wrap magpro-ticker-<?php echo esc_attr( $atts['style'] ); ?>-wrap" style="border-radius: 4px; margin-bottom: 25px;">
				<div class="magpro-ticker-container" style="max-width: 100%; padding: 0 12px;">
					<div class="magpro-ticker-label">
						<i class="fas fa-fire"></i>
						<span><?php echo esc_html( $atts['label'] ); ?></span>
					</div>

					<?php if ( 'marquee' === $atts['style'] ) : ?>
						<div class="magpro-ticker-marquee">
							<div class="magpro-ticker-marquee-track" style="animation-duration: <?php echo esc_attr( $speed ); ?>s;">
								<?php
								for ( $loop = 0; $loop < 2; $loop++ ) :
									foreach ( $posts as $p ) :
										$p_id  = $p->ID;
										$views = \MagPro_Helpers::get_post_views( $p_id );
										$date  = get_the_time( get_option( 'date_format' ), $p_id );
									?>
										<span class="magpro-ticker-marquee-item">
											<?php if ( $show_badge ) : ?>
												<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
											<?php endif; ?>
											<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
											<?php if ( $show_views ) : ?>
												<span class="magpro-ticker-views"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
											<?php endif; ?>
											<?php if ( $show_date ) : ?>
												<span class="magpro-ticker-date"><i class="far fa-clock"></i> <?php echo esc_html( $date ); ?></span>
											<?php endif; ?>
											<span class="magpro-ticker-bullet">&bull;</span>
										</span>
									<?php
									endforeach;
								endfor;
								?>
							</div>
						</div>
					<?php else : ?>
						<div class="magpro-ticker-content">
							<?php
							$count = 0;
							foreach ( $posts as $p ) :
								$p_id   = $p->ID;
								$views  = \MagPro_Helpers::get_post_views( $p_id );
								$date   = get_the_time( get_option( 'date_format' ), $p_id );
								$active = ( 0 === $count ) ? 'active' : '';
								?>
								<div class="magpro-ticker-item <?php echo esc_attr( $active ); ?>">
									<?php if ( $show_badge ) : ?>
										<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
									<?php endif; ?>
									<span class="magpro-ticker-bullet">&bull;</span>
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									<?php if ( $show_views ) : ?>
										<span class="magpro-ticker-views" style="margin-left: 8px; font-size: 11px; opacity: 0.85;"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
									<?php endif; ?>
									<?php if ( $show_date ) : ?>
										<span class="magpro-ticker-date" style="margin-left: 6px; font-size: 11px; opacity: 0.8;"><i class="far fa-clock"></i> <?php echo esc_html( $date ); ?></span>
									<?php endif; ?>
								</div>
								<?php
								$count++;
							endforeach;
							?>
						</div>

						<div class="magpro-ticker-controls">
							<button type="button" class="magpro-ticker-btn magpro-ticker-prev" aria-label="Previous">
								<i class="fas fa-chevron-left"></i>
							</button>
							<button type="button" class="magpro-ticker-btn magpro-ticker-next" aria-label="Next">
								<i class="fas fa-chevron-right"></i>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	public static function render_tabs( $atts ) {
		$atts = shortcode_atts(
			array(
				'count'    => 4,
				'views'    => 'yes',
				'author'   => 'no',
				'date'     => 'yes',
				'comments' => 'no',
				'hover'    => 'zoom-in',
			),
			$atts
		);

		ob_start();
		$count         = intval( $atts['count'] );
		$recent_query  = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'date' ) );
		$popular_query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'comment_count' ) );
		$random_query  = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'rand' ) );
		?>
		<div class="magpro-tabs-wrap">
			<div class="magpro-tabs-nav">
				<button type="button" class="magpro-tab-button active" data-tab="recent">
					<i class="far fa-clock"></i> <?php esc_html_e( 'Recent', 'mag-pro' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="popular">
					<i class="fas fa-fire"></i> <?php esc_html_e( 'Popular', 'mag-pro' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="comments">
					<i class="fas fa-random"></i> <?php esc_html_e( 'Trending', 'mag-pro' ); ?>
				</button>
			</div>

			<div class="magpro-tabs-content">
				<div class="magpro-tab-panel magpro-tab-recent active">
					<?php self::render_compact_items( $recent_query, $atts ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-popular">
					<?php self::render_compact_items( $popular_query, $atts ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-comments">
					<?php self::render_compact_items( $random_query, $atts ); ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	public static function render_social( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'     => 'Follow Us',
				'facebook'  => 'https://facebook.com/',
				'twitter'   => 'https://twitter.com/',
				'youtube'   => 'https://youtube.com/',
				'instagram' => 'https://instagram.com/',
				'pinterest' => '',
				'telegram'  => '',
			),
			$atts
		);

		ob_start();
		?>
		<div class="magpro-social-wrap">
			<?php if ( ! empty( $atts['title'] ) ) : ?>
				<h3 class="magpro-widget-title"><?php echo esc_html( $atts['title'] ); ?></h3>
			<?php endif; ?>

			<div class="magpro-social-grid">
				<?php if ( ! empty( $atts['facebook'] ) ) : ?>
					<a href="<?php echo esc_url( $atts['facebook'] ); ?>" class="magpro-social-btn magpro-social-facebook" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-facebook-f"></i> Facebook</span>
						<span><i class="fas fa-thumbs-up"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $atts['twitter'] ) ) : ?>
					<a href="<?php echo esc_url( $atts['twitter'] ); ?>" class="magpro-social-btn magpro-social-twitter" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-twitter"></i> Twitter</span>
						<span><i class="fas fa-plus"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $atts['youtube'] ) ) : ?>
					<a href="<?php echo esc_url( $atts['youtube'] ); ?>" class="magpro-social-btn magpro-social-youtube" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-youtube"></i> YouTube</span>
						<span><i class="fas fa-play"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $atts['instagram'] ) ) : ?>
					<a href="<?php echo esc_url( $atts['instagram'] ); ?>" class="magpro-social-btn magpro-social-instagram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-instagram"></i> Instagram</span>
						<span><i class="fas fa-camera"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $atts['pinterest'] ) ) : ?>
					<a href="<?php echo esc_url( $atts['pinterest'] ); ?>" class="magpro-social-btn magpro-social-pinterest" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-pinterest-p"></i> Pinterest</span>
						<span><i class="fas fa-pin"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $atts['telegram'] ) ) : ?>
					<a href="<?php echo esc_url( $atts['telegram'] ); ?>" class="magpro-social-btn magpro-social-telegram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-telegram-plane"></i> Telegram</span>
						<span><i class="fas fa-paper-plane"></i></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	private static function render_compact_items( $query, $atts = array() ) {
		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro' ) . '</p>';
			return;
		}

		$show_views    = ( 'yes' === ( $atts['views'] ?? 'yes' ) );
		$show_author   = ( 'yes' === ( $atts['author'] ?? 'no' ) );
		$show_date     = ( 'yes' === ( $atts['date'] ?? 'yes' ) );
		$show_comments = ( 'yes' === ( $atts['comments'] ?? 'no' ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] ?? 'zoom-in' );

		while ( $query->have_posts() ) :
			$query->the_post();
			$p_id  = get_the_ID();
			$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
			?>
			<div class="magpro-compact-item">
				<div class="magpro-compact-thumb <?php echo esc_attr( $anim_class ); ?>">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
					</a>
				</div>
				<div class="magpro-compact-content">
					<h5 class="magpro-post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>
					<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}
	public static function render_slider( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'       => '',
				'title_style' => 'style-1',
				'view_all'    => 'yes',
				'view_url'    => '',
				'category'    => '',
				'count'       => 6,
				'desktop'     => 3,
				'tablet'      => 2,
				'mobile'      => 1,
				'autoplay'    => 'true',
				'speed'       => 4000,
				'height'      => 240,
				'aspect'      => '16:9',
				'views'       => 'yes',
				'author'      => 'yes',
				'date'        => 'yes',
				'badge'       => 'yes',
				'comments'    => 'no',
				'hover'       => 'zoom-in',
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

		if ( $query->have_posts() ) {
			$posts         = $query->posts;
			$show_badge    = ( 'yes' === $atts['badge'] );
			$show_author   = ( 'yes' === $atts['author'] );
			$show_date     = ( 'yes' === $atts['date'] );
			$show_views    = ( 'yes' === $atts['views'] );
			$show_comments = ( 'yes' === $atts['comments'] );
			$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $atts['aspect'], intval( $atts['height'] ) );
			$anim_class    = \MagPro_Helpers::get_hover_animation_class( $atts['hover'] );
			?>
			<div class="magpro-slider-widget-wrap">
				<?php
				if ( ! empty( $atts['title'] ) ) {
					\MagPro_Helpers::render_section_title(
						$atts['title'],
						$atts['title_style'],
						( 'yes' === $atts['view_all'] ),
						esc_html__( 'View All', 'mag-pro' ),
						$atts['view_url'],
						'fas fa-sliders-h'
					);
				}
				?>
				<div class="magpro-slider-wrap"
					data-autoplay="<?php echo esc_attr( $atts['autoplay'] ); ?>"
					data-speed="<?php echo esc_attr( $atts['speed'] ); ?>"
					data-desktop="<?php echo esc_attr( $atts['desktop'] ); ?>"
					data-tablet="<?php echo esc_attr( $atts['tablet'] ); ?>"
					data-mobile="<?php echo esc_attr( $atts['mobile'] ); ?>"
					style="box-shadow: none;">
					<div class="magpro-slider-viewport">
						<div class="magpro-slider-track">
							<?php foreach ( $posts as $p ) : 
								$p_id  = $p->ID;
								$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
							?>
								<div class="magpro-slide-item">
									<div class="magpro-slide-card <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?> box-shadow: none;">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-slide-img-link">
											<div class="magpro-slide-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
										</a>
										<div class="magpro-slide-overlay"></div>
										<div class="magpro-slide-content">
											<?php if ( $show_badge ) : ?>
												<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
											<?php endif; ?>
											<h4 class="magpro-post-title" style="color: #ffffff; font-size: 15px; margin: 6px 0;">
												<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
											</h4>
											<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<button type="button" class="magpro-slider-btn magpro-slider-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
					<button type="button" class="magpro-slider-btn magpro-slider-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
					<div class="magpro-slider-dots"></div>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}
		return ob_get_clean();
	}
}

MagPro_Shortcodes::init();
