<?php
/**
 * Header News Ticker Component for Mag Pro Header Builder.
 * Supports Slide and Continuous Marquee styles.
 *
 * @package Mag Pro
 * @author  Developer Zahir
 * @link    https://developerzahir.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Astra_Header_News_Ticker_Component {

	public function __construct() {
		add_action( 'astra_header_news_ticker', array( $this, 'render' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	public function render() {
		$style      = astra_get_option( 'header-news-ticker-style', 'slide' );
		$label_text = astra_get_option( 'header-news-ticker-label', __( 'Breaking News', 'mag-pro' ) );
		$post_count = astra_get_option( 'header-news-ticker-count', 6 );

		$recent_posts = new WP_Query(
			array(
				'posts_per_page'      => intval( $post_count ),
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! $recent_posts->have_posts() ) {
			return;
		}

		$posts = $recent_posts->posts;
		?>
		<div class="magpro-ticker-wrap magpro-ticker-builder magpro-ticker-style-<?php echo esc_attr( $style ); ?>">
			<div class="magpro-ticker-container">
				<div class="magpro-ticker-label">
					<i class="fas fa-bolt"></i>
					<span><?php echo esc_html( $label_text ); ?></span>
				</div>

				<?php if ( 'marquee' === $style ) : ?>
					<!-- Marquee Continuous Scrolling Ticker -->
					<div class="magpro-ticker-marquee">
						<div class="magpro-ticker-marquee-track">
							<?php
							// Repeat twice for seamless infinite looping
							for ( $r = 0; $r < 2; $r++ ) :
								foreach ( $posts as $post_obj ) :
									$p_id  = $post_obj->ID;
									$views = function_exists( 'magpro_get_post_views' ) ? magpro_get_post_views( $p_id ) : '';
									?>
									<span class="magpro-marquee-item">
										<span class="magpro-ticker-bullet">&bull;</span>
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
										<?php if ( ! empty( $views ) ) : ?>
											<span class="magpro-ticker-views"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
										<?php endif; ?>
									</span>
									<?php
								endforeach;
							endfor;
							?>
						</div>
					</div>
				<?php else : ?>
					<!-- Slide / Fade Rotating Ticker -->
					<div class="magpro-ticker-content">
						<?php
						$count = 0;
						foreach ( $posts as $post_obj ) :
							$p_id   = $post_obj->ID;
							$active = ( 0 === $count ) ? 'active' : '';
							$views  = function_exists( 'magpro_get_post_views' ) ? magpro_get_post_views( $p_id ) : '';
							?>
							<div class="magpro-ticker-item <?php echo esc_attr( $active ); ?>">
								<span class="magpro-ticker-bullet">&bull;</span>
								<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
								<?php if ( ! empty( $views ) ) : ?>
									<span class="magpro-ticker-views"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
								<?php endif; ?>
							</div>
							<?php
							$count++;
						endforeach;
						?>
					</div>

					<div class="magpro-ticker-controls">
						<button type="button" class="magpro-ticker-btn magpro-ticker-prev" aria-label="<?php esc_attr_e( 'Previous news', 'mag-pro' ); ?>">
							<i class="fas fa-chevron-left"></i>
						</button>
						<button type="button" class="magpro-ticker-btn magpro-ticker-next" aria-label="<?php esc_attr_e( 'Next news', 'mag-pro' ); ?>">
							<i class="fas fa-chevron-right"></i>
						</button>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		wp_reset_postdata();
	}

	public function customize_register( $wp_customize ) {
		if ( class_exists( 'Astra_Builder_Customizer' ) ) {
			$wp_customize->add_section(
				'section-header-news-ticker',
				array(
					'title'    => esc_html__( 'News Ticker', 'mag-pro' ),
					'panel'    => 'panel-header-builder-group',
					'priority' => 85,
				)
			);
		}
	}
}

new Astra_Header_News_Ticker_Component();
