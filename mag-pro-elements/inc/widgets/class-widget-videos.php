<?php
/**
 * MagPro Video / Multimedia Block Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Videos extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-videos';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Video / Multimedia Block', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-video-playlist';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Video Block Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Section Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured Videos', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'category',
			array(
				'label'   => esc_html__( 'Category', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => \MagPro_Helpers::get_categories_list(),
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Number of Posts', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 8,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $settings['posts_per_page'],
				'category'       => $settings['category'],
			)
		);

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		$posts = $query->posts;
		?>
		<div class="magpro-videos-wrap">
			<?php if ( ! empty( $settings['widget_title'] ) ) : ?>
				<h3 class="magpro-widget-title"><i class="fas fa-play-circle" style="color: var(--mp-primary, #ff2232); margin-right: 6px;"></i> <?php echo esc_html( $settings['widget_title'] ); ?></h3>
			<?php endif; ?>

			<div class="magpro-videos-grid">
				<?php if ( isset( $posts[0] ) ) : 
					$lead_id = $posts[0]->ID;
					$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
				?>
					<div class="magpro-video-hero magpro-hero-card">
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
							<div class="magpro-video-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
						</a>
						<div class="magpro-hero-overlay"></div>
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-video-play-btn" aria-label="<?php esc_attr_e( 'Play Video', 'mag-pro-elements' ); ?>">
							<i class="fas fa-play"></i>
						</a>
						<div class="magpro-hero-content">
							<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
							<h3 class="magpro-post-title" style="color: #ffffff; font-size: 18px; margin-top: 8px;">
								<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
							</h3>
							<?php echo \MagPro_Helpers::get_post_meta( $lead_id, false, true ); ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="magpro-video-list">
					<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
						$p_id  = $posts[ $i ]->ID;
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
					?>
						<div class="magpro-video-item">
							<div class="magpro-video-item-thumb">
								<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $p_id ) ); ?>" loading="lazy" />
									<span class="magpro-video-mini-play"><i class="fas fa-play"></i></span>
								</a>
							</div>
							<div class="magpro-video-item-content">
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
}

