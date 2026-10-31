<?php
/**
 * MagPro Post Block 2 Widget (2-Column Split by Category)
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Block_2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-block-2';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Block 2 (2-Column Split)', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-columns';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Left Column Settings
		$this->start_controls_section(
			'section_left_column',
			array(
				'label' => esc_html__( 'Left Column', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'left_title',
			array(
				'label'   => esc_html__( 'Left Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Technology', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'left_category',
			array(
				'label'   => esc_html__( 'Left Category', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => \MagPro_Helpers::get_categories_list(),
			)
		);

		$this->end_controls_section();

		// Right Column Settings
		$this->start_controls_section(
			'section_right_column',
			array(
				'label' => esc_html__( 'Right Column', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'right_title',
			array(
				'label'   => esc_html__( 'Right Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Gadgets', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'right_category',
			array(
				'label'   => esc_html__( 'Right Category', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => \MagPro_Helpers::get_categories_list(),
			)
		);

		$this->end_controls_section();

		// General Settings
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General Options', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'posts_per_col',
			array(
				'label'   => esc_html__( 'Posts Per Column', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 8,
			)
		);

		$this->end_controls_section();
	}

	private function render_column( $title, $category, $count ) {
		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'category'       => $category,
			)
		);

		$posts = $query->posts;
		?>
		<div class="magpro-block2-col">
			<?php if ( ! empty( $title ) ) : ?>
				<h3 class="magpro-widget-title"><?php echo esc_html( $title ); ?></h3>
			<?php endif; ?>

			<?php if ( empty( $posts ) ) : ?>
				<p><?php esc_html_e( 'No posts found in this category.', 'mag-pro-elements' ); ?></p>
			<?php else : ?>
				<?php 
				$lead_id = $posts[0]->ID;
				$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'medium_large' );
				?>
				<div class="magpro-block1-lead" style="margin-bottom: 15px;">
					<div class="magpro-block1-lead-thumb" style="height: 180px;">
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $lead_id ) ); ?>" loading="lazy" />
						</a>
						<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
					</div>
					<div class="magpro-block1-lead-content" style="padding: 14px;">
						<h4 class="magpro-post-title" style="font-size: 16px;">
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
						</h4>
						<?php echo \MagPro_Helpers::get_post_meta( $lead_id, false, true ); ?>
					</div>
				</div>

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
			<?php endif; ?>
		</div>
		<?php
		wp_reset_postdata();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['posts_per_col'] ) ? intval( $settings['posts_per_col'] ) : 4;
		?>
		<div class="magpro-block2-wrap">
			<div class="magpro-block2-grid">
				<?php $this->render_column( $settings['left_title'], $settings['left_category'], $count ); ?>
				<?php $this->render_column( $settings['right_title'], $settings['right_category'], $count ); ?>
			</div>
		</div>
		<?php
	}
}

