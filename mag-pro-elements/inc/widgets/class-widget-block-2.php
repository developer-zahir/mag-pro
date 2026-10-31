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

		// General & Meta Settings
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General Options & Meta', 'mag-pro-elements' ),
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

		$this->add_control(
			'show_badge',
			array(
				'label'        => esc_html__( 'Show Category Badge', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_date',
			array(
				'label'        => esc_html__( 'Show Date', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_views',
			array(
				'label'        => esc_html__( 'Show Post View Count', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_author',
			array(
				'label'        => esc_html__( 'Show Author', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_comments',
			array(
				'label'        => esc_html__( 'Show Comments Count', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// Image Size & Hover Animation
		$this->start_controls_section(
			'section_image_settings',
			array(
				'label' => esc_html__( 'Image Size & Animation', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'   => esc_html__( 'Aspect Ratio', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '16:9',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro-elements' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro-elements' ),
					'1:1'    => esc_html__( '1:1 Square', 'mag-pro-elements' ),
					'3:2'    => esc_html__( '3:2 Classic Magazine', 'mag-pro-elements' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'custom_height',
			array(
				'label'     => esc_html__( 'Manual Height (px)', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 190,
				'min'       => 130,
				'max'       => 450,
				'condition' => array(
					'aspect_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'hover_animation',
			array(
				'label'   => esc_html__( 'Image Hover Animation', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'zoom-in',
				'options' => array(
					'zoom-in'   => esc_html__( 'Zoom In (Scale Up)', 'mag-pro-elements' ),
					'zoom-out'  => esc_html__( 'Zoom Out', 'mag-pro-elements' ),
					'slide-up'  => esc_html__( 'Slide Up', 'mag-pro-elements' ),
					'grayscale' => esc_html__( 'Grayscale to Color', 'mag-pro-elements' ),
					'blur'      => esc_html__( 'Blur to Sharp', 'mag-pro-elements' ),
					'none'      => esc_html__( 'None', 'mag-pro-elements' ),
				),
			)
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'section_style_tab',
			array(
				'label' => esc_html__( 'Style Options', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title, {{WRAPPER}} .magpro-post-title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Title Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta & Views Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta, {{WRAPPER}} .magpro-meta-item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function render_column( $title, $category, $count, $settings ) {
		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'category'       => $category,
			)
		);

		$posts         = $query->posts;
		$hover_class   = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] );
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $settings['aspect_ratio'], $settings['custom_height'] );
		$show_badge    = 'yes' === $settings['show_badge'];
		$show_author   = 'yes' === $settings['show_author'];
		$show_date     = 'yes' === $settings['show_date'];
		$show_views    = 'yes' === $settings['show_views'];
		$show_comments = 'yes' === $settings['show_comments'];
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
				<div class="magpro-block1-lead <?php echo esc_attr( $hover_class ); ?>" style="margin-bottom: 15px;">
					<div class="magpro-block1-lead-thumb" style="<?php echo esc_attr( $aspect_style ); ?>">
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $lead_id ) ); ?>" loading="lazy" />
						</a>
						<?php if ( $show_badge ) : ?>
							<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
						<?php endif; ?>
					</div>
					<div class="magpro-block1-lead-content" style="padding: 14px;">
						<h4 class="magpro-post-title" style="font-size: 16px;">
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
						</h4>
						<?php echo \MagPro_Helpers::get_post_meta( $lead_id, $show_author, $show_date, $show_views, $show_comments ); ?>
					</div>
				</div>

				<div class="magpro-block1-list">
					<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
						$p_id  = $posts[ $i ]->ID;
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
					?>
						<div class="magpro-compact-item <?php echo esc_attr( $hover_class ); ?>">
							<div class="magpro-compact-thumb">
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
				<?php $this->render_column( $settings['left_title'], $settings['left_category'], $count, $settings ); ?>
				<?php $this->render_column( $settings['right_title'], $settings['right_category'], $count, $settings ); ?>
			</div>
		</div>
		<?php
	}
}
