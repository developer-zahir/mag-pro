<?php
/**
 * MagPro Post Block 1 Widget (Lead + List)
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Block_1 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-block-1';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Block 1 (Lead + List)', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Block Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'       => esc_html__( 'Section Title', 'mag-pro-elements' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Latest Articles', 'mag-pro-elements' ),
				'placeholder' => esc_html__( 'Enter block title', 'mag-pro-elements' ),
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
				'default' => 5,
				'min'     => 2,
				'max'     => 10,
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'          => esc_html__( 'Date', 'mag-pro-elements' ),
					'comment_count' => esc_html__( 'Popularity (Comments)', 'mag-pro-elements' ),
					'rand'          => esc_html__( 'Random', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'show_excerpt',
			array(
				'label'        => esc_html__( 'Show Excerpt on Lead Post', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
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
				'orderby'        => $settings['orderby'],
			)
		);

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		$posts = $query->posts;
		?>
		<div class="magpro-block1-wrap">
			<?php if ( ! empty( $settings['widget_title'] ) ) : ?>
				<h3 class="magpro-widget-title"><?php echo esc_html( $settings['widget_title'] ); ?></h3>
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
							<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
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
}

