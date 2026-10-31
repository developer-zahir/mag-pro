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

		$this->add_control(
			'left_show_view_all',
			array(
				'label'        => esc_html__( 'Show "View All" Button', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'left_view_all_url',
			array(
				'label'         => esc_html__( '"View All" URL', 'mag-pro-elements' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => 'https://your-link.com',
				'condition'     => array(
					'left_show_view_all' => 'yes',
				),
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

		$this->add_control(
			'right_show_view_all',
			array(
				'label'        => esc_html__( 'Show "View All" Button', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'right_view_all_url',
			array(
				'label'         => esc_html__( '"View All" URL', 'mag-pro-elements' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => 'https://your-link.com',
				'condition'     => array(
					'right_show_view_all' => 'yes',
				),
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
			'title_style',
			array(
				'label'   => esc_html__( 'Section Title Style', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => array(
					'style-1' => esc_html__( 'Style 1: Modern Left Accent Bar', 'mag-pro-elements' ),
					'style-2' => esc_html__( 'Style 2: Solid Badge Header', 'mag-pro-elements' ),
					'style-3' => esc_html__( 'Style 3: Underline Dual-Color Bar', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'posts_per_col',
			array(
				'label'   => esc_html__( 'Posts Per Column', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 6,
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
			'show_author',
			array(
				'label'        => esc_html__( 'Show Author', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
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
			'show_comments',
			array(
				'label'        => esc_html__( 'Show Comments Count', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// Big Image (Lead) Settings
		$this->start_controls_section(
			'section_big_image_settings',
			array(
				'label' => esc_html__( 'Big Image Controls (Lead Post)', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'big_aspect_ratio',
			array(
				'label'   => esc_html__( 'Aspect Ratio', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '16:9',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro-elements' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro-elements' ),
					'1:1'    => esc_html__( '1:1 Square', 'mag-pro-elements' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'big_custom_height',
			array(
				'label'     => esc_html__( 'Manual Height (px)', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 200,
				'min'       => 130,
				'max'       => 450,
				'condition' => array(
					'big_aspect_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'big_hover_animation',
			array(
				'label'   => esc_html__( 'Hover Animation', 'mag-pro-elements' ),
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

		$this->add_control(
			'big_image_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-block2-lead-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Small Image (Sub List) Settings
		$this->start_controls_section(
			'section_small_image_settings',
			array(
				'label' => esc_html__( 'Small Image Controls (Sub List)', 'mag-pro-elements' ),
			)
		);

		$this->add_responsive_control(
			'small_image_width',
			array(
				'label'      => esc_html__( 'Thumbnail Width (px)', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 50, 'max' => 140 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 80 ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-compact-thumb' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'small_image_height',
			array(
				'label'      => esc_html__( 'Thumbnail Height (px)', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 45, 'max' => 130 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 65 ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-compact-thumb img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				),
			)
		);

		$this->add_control(
			'small_hover_animation',
			array(
				'label'   => esc_html__( 'Hover Animation', 'mag-pro-elements' ),
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

		// Style Tab: Section Headers
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Section Headers', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-widget-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'header_title_typography',
				'selector' => '{{WRAPPER}} .magpro-widget-title',
			)
		);

		$this->add_control(
			'header_accent_color',
			array(
				'label'     => esc_html__( 'Accent / Bar Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-header-style-1 .magpro-widget-title' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .magpro-header-style-2 .magpro-widget-title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .magpro-header-style-2'                      => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .magpro-header-style-3 .magpro-widget-title' => 'border-bottom-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'view_all_color',
			array(
				'label'     => esc_html__( 'View All Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'view_all_hover_color',
			array(
				'label'     => esc_html__( 'View All Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Titles & Meta
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Titles & Meta', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lead_title_color',
			array(
				'label'     => esc_html__( 'Lead Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-block2-lead-card .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lead_title_typography',
				'selector' => '{{WRAPPER}} .magpro-block2-lead-card .magpro-post-title',
			)
		);

		$this->add_control(
			'sub_title_color',
			array(
				'label'     => esc_html__( 'Sub Item Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-compact-content .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'sub_title_hover_color',
			array(
				'label'     => esc_html__( 'Sub Item Title Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-compact-content .magpro-post-title a:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .magpro-compact-content .magpro-post-title',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta, {{WRAPPER}} .magpro-post-meta a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'meta_icon_color',
			array(
				'label'     => esc_html__( 'Meta Icon Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta i' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();
	}

	private function render_column( $title, $category, $count, $settings, $view_all_url ) {
		$show_view_all = ! empty( $view_all_url['url'] );
		$view_url      = $view_all_url['url'] ?? '';
		$title_style   = $settings['title_style'] ?? 'style-1';

		if ( ! empty( $title ) ) {
			\MagPro_Helpers::render_section_title(
				$title,
				$title_style,
				$show_view_all,
				esc_html__( 'View All', 'mag-pro-elements' ),
				$view_url,
				'far fa-newspaper'
			);
		}

		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'category'       => $category,
			)
		);

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		$posts         = $query->posts;
		$show_badge    = ( 'yes' === ( $settings['show_badge'] ?? 'yes' ) );
		$show_author   = ( 'yes' === ( $settings['show_author'] ?? 'no' ) );
		$show_date     = ( 'yes' === ( $settings['show_date'] ?? 'yes' ) );
		$show_views    = ( 'yes' === ( $settings['show_views'] ?? 'yes' ) );
		$show_comments = ( 'yes' === ( $settings['show_comments'] ?? 'no' ) );

		$big_aspect_ratio  = $settings['big_aspect_ratio'] ?? '16:9';
		$big_custom_height = ! empty( $settings['big_custom_height'] ) ? intval( $settings['big_custom_height'] ) : 200;
		$big_aspect_style  = \MagPro_Helpers::get_image_aspect_style( $big_aspect_ratio, $big_custom_height );
		$big_anim_class    = \MagPro_Helpers::get_hover_animation_class( $settings['big_hover_animation'] ?? 'zoom-in' );
		$small_anim_class  = \MagPro_Helpers::get_hover_animation_class( $settings['small_hover_animation'] ?? 'zoom-in' );

		if ( isset( $posts[0] ) ) {
			$lead_id = $posts[0]->ID;
			$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'medium_large' );
			?>
			<div class="magpro-block2-lead-card magpro-hero-card <?php echo esc_attr( $big_anim_class ); ?>" style="<?php echo esc_attr( $big_aspect_style ); ?> box-shadow: none; margin-bottom: 15px;">
				<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
					<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
				</a>
				<div class="magpro-hero-overlay"></div>
				<div class="magpro-hero-content">
					<?php if ( $show_badge ) : ?>
						<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
					<?php endif; ?>
					<h4 class="magpro-post-title" style="color: #ffffff; font-size: 15px; margin: 6px 0;">
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
					</h4>
					<?php echo \MagPro_Helpers::get_post_meta( $lead_id, $show_author, $show_date, $show_views, $show_comments ); ?>
				</div>
			</div>
			<?php
		}

		echo '<div class="magpro-block2-sublist" style="display: flex; flex-direction: column; gap: 12px;">';
		for ( $i = 1; $i < count( $posts ); $i++ ) {
			$p_id  = $posts[ $i ]->ID;
			$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
			?>
			<div class="magpro-compact-item" style="box-shadow: none;">
				<div class="magpro-compact-thumb <?php echo esc_attr( $small_anim_class ); ?>">
					<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $p_id ) ); ?>" loading="lazy" />
					</a>
				</div>
				<div class="magpro-compact-content">
					<h5 class="magpro-post-title" style="font-size: 13px; margin: 0 0 5px 0;">
						<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
					</h5>
					<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, $show_date, $show_views, $show_comments ); ?>
				</div>
			</div>
			<?php
		}
		echo '</div>';
		wp_reset_postdata();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['posts_per_col'] ) ? intval( $settings['posts_per_col'] ) : 4;
		?>
		<div class="magpro-block2-wrap">
			<div class="magpro-block2-grid">
				<div class="magpro-block2-col-left">
					<?php $this->render_column( $settings['left_title'], $settings['left_category'], $count, $settings, $settings['left_view_all_url'] ?? array() ); ?>
				</div>
				<div class="magpro-block2-col-right">
					<?php $this->render_column( $settings['right_title'], $settings['right_category'], $count, $settings, $settings['right_view_all_url'] ?? array() ); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
