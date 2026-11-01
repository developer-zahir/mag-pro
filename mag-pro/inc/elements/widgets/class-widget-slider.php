<?php
/**
 * MagPro Post Slider / Carousel Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-slider';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Post Slider / Carousel', 'mag-pro' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content: Query & General
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Slider & Query Settings', 'mag-pro' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Section Title', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Trending Slider', 'mag-pro' ),
			)
		);

		$this->add_control(
			'title_style',
			array(
				'label'   => esc_html__( 'Section Title Style', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => array(
					'style-1' => esc_html__( 'Style 1: Modern Left Accent Bar', 'mag-pro' ),
					'style-2' => esc_html__( 'Style 2: Solid Badge Header', 'mag-pro' ),
					'style-3' => esc_html__( 'Style 3: Underline Dual-Color Bar', 'mag-pro' ),
					'style-4' => esc_html__( 'Style 4: Refined Bordered Box', 'mag-pro' ),
					'style-5' => esc_html__( 'Style 5: Sleek Line Divider', 'mag-pro' ),
					'style-6' => esc_html__( 'Style 6: Gradient Accent Bar', 'mag-pro' ),
				),
			)
		);

		$this->add_control(
			'section_icon',
			array(
				'label'   => esc_html__( 'Section Icon', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(),
			)
		);


		$this->add_control(
			'show_view_all',
			array(
				'label'        => esc_html__( 'Show "View All" Button', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'view_all_auto_link',
			array(
				'label'        => esc_html__( 'Auto-Link to Category', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'mag-pro' ),
				'label_off'    => esc_html__( 'No', 'mag-pro' ),
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition'    => array(
					'show_view_all' => 'yes',
				),
			)
		);


		$this->add_control(
			'view_all_text',
			array(
				'label'     => esc_html__( '"View All" Text', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'View All', 'mag-pro' ),
				'condition' => array(
					'show_view_all' => 'yes',
				),
			)
		);

		$this->add_control(
			'view_all_url',
			array(
				'label'         => esc_html__( '"View All" Link', 'mag-pro' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'mag-pro' ),
				'show_external' => true,
				'default'       => array(
					'url'         => '#',
					'is_external' => false,
				),
				'condition'     => array(
					'show_view_all' => 'yes',
				),
			)
		);

		$this->add_control(
			'category',
			array(
				'label'   => esc_html__( 'Category', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => \MagPro_Helpers::get_categories_list(),
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Number of Posts', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 2,
				'max'     => 15,
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'          => esc_html__( 'Date (Recent)', 'mag-pro' ),
					'comment_count' => esc_html__( 'Most Popular (Comments)', 'mag-pro' ),
					'rand'          => esc_html__( 'Random', 'mag-pro' ),
				),
			)
		);

		$this->end_controls_section();

		// Content: Slider Settings
		$this->start_controls_section(
			'section_slider_options',
			array(
				'label' => esc_html__( 'Carousel Controls', 'mag-pro' ),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'          => esc_html__( 'Slides to Show', 'mag-pro' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'1' => esc_html__( '1 Slide (Full Width)', 'mag-pro' ),
					'2' => esc_html__( '2 Slides', 'mag-pro' ),
					'3' => esc_html__( '3 Slides', 'mag-pro' ),
					'4' => esc_html__( '4 Slides', 'mag-pro' ),
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4000,
				'min'       => 1500,
				'max'       => 10000,
				'step'      => 500,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_arrows',
			array(
				'label'        => esc_html__( 'Navigation Arrows', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_dots',
			array(
				'label'        => esc_html__( 'Navigation Dots', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// Content: Meta & Visibility
		$this->start_controls_section(
			'section_meta_visibility',
			array(
				'label' => esc_html__( 'Meta & Visibility Options', 'mag-pro' ),
			)
		);

		$this->add_control(
			'show_badge',
			array(
				'label'        => esc_html__( 'Show Category Badge', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_author',
			array(
				'label'        => esc_html__( 'Show Author', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_date',
			array(
				'label'        => esc_html__( 'Show Date', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_views',
			array(
				'label'        => esc_html__( 'Show Post View Count', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_comments',
			array(
				'label'        => esc_html__( 'Show Comments Count', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// Content: Image Size & Animation
		$this->start_controls_section(
			'section_image_settings',
			array(
				'label' => esc_html__( 'Image Size & Animation', 'mag-pro' ),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'   => esc_html__( 'Slide Aspect Ratio', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '16:9',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro' ),
					'21:9'   => esc_html__( '21:9 Hero Ultrawide', 'mag-pro' ),
					'1:1'    => esc_html__( '1:1 Square', 'mag-pro' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro' ),
				),
			)
		);

		$this->add_control(
			'custom_height',
			array(
				'label'     => esc_html__( 'Manual Height (px)', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 280,
				'min'       => 160,
				'max'       => 600,
				'condition' => array(
					'aspect_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'hover_animation',
			array(
				'label'   => esc_html__( 'Image Hover Animation', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array(
					'zoom-in'   => esc_html__( 'Zoom In (Scale Up)', 'mag-pro' ),
					'zoom-out'  => esc_html__( 'Zoom Out', 'mag-pro' ),
					'slide-up'  => esc_html__( 'Slide Up', 'mag-pro' ),
					'grayscale' => esc_html__( 'Grayscale to Color', 'mag-pro' ),
					'blur'      => esc_html__( 'Blur to Sharp', 'mag-pro' ),
					'none'      => esc_html__( 'None', 'mag-pro' ),
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Section Header
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Section Header', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'mag-pro' ),
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
				'label'     => esc_html__( 'Accent / Bar Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-header-style-1 .magpro-widget-title' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .magpro-header-style-2 .magpro-widget-title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .magpro-header-style-2'                      => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .magpro-header-style-3 .magpro-widget-title' => 'border-bottom-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'mag-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 40,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-section-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .magpro-section-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'section_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-section-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .magpro-section-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_icon_gap',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'mag-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-section-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);


		$this->add_control(
			'view_all_heading',
			array(
				'label'     => esc_html__( 'View All Button', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'view_all_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'view_all_hover_color',
			array(
				'label'     => esc_html__( 'Button Hover Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'view_all_bg',
			array(
				'label'     => esc_html__( 'Button Background', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'view_all_hover_bg',
			array(
				'label'     => esc_html__( 'Button Hover Background', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Slide Cards
		$this->start_controls_section(
			'section_style_slides',
			array(
				'label' => esc_html__( 'Slide Cards', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-slide-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Gradient Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slide-overlay' => 'background: linear-gradient(180deg, transparent 40%, {{VALUE}} 100%);',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Post Titles & Meta
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Titles & Meta', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Post Title Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slide-card .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Post Title Hover Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slide-card .magpro-post-title a:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .magpro-slide-card .magpro-post-title',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slide-card .magpro-post-meta, {{WRAPPER}} .magpro-slide-card .magpro-post-meta a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'meta_icon_color',
			array(
				'label'     => esc_html__( 'Meta Icon Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slide-card .magpro-post-meta i' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Arrows & Dots
		$this->start_controls_section(
			'section_style_navigation',
			array(
				'label' => esc_html__( 'Arrows & Dots', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => esc_html__( 'Arrow Icon Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slider-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_bg',
			array(
				'label'     => esc_html__( 'Arrow Background', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slider-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_bg',
			array(
				'label'     => esc_html__( 'Arrow Hover Background', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slider-btn:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_color',
			array(
				'label'     => esc_html__( 'Dot Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slider-dot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_active_color',
			array(
				'label'     => esc_html__( 'Active Dot Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-slider-dot.active' => 'background-color: {{VALUE}};',
				),
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
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro' ) . '</p>';
			return;
		}

		$posts         = $query->posts;
		$title_style   = $settings['title_style'] ?? 'style-1';
		$show_view_all = ( 'yes' === ( $settings['show_view_all'] ?? 'yes' ) );
		$view_all_text = $settings['view_all_text'] ?? esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = ! empty( $settings['view_all_url']['url'] ) ? $settings['view_all_url']['url'] : '';

		$show_badge    = ( 'yes' === ( $settings['show_badge'] ?? 'yes' ) );
		$show_author   = ( 'yes' === ( $settings['show_author'] ?? 'yes' ) );
		$show_date     = ( 'yes' === ( $settings['show_date'] ?? 'yes' ) );
		$show_views    = ( 'yes' === ( $settings['show_views'] ?? 'yes' ) );
		$show_comments = ( 'yes' === ( $settings['show_comments'] ?? 'no' ) );

		$aspect_ratio  = $settings['aspect_ratio'] ?? '16:9';
		$custom_height = ! empty( $settings['custom_height'] ) ? intval( $settings['custom_height'] ) : 280;
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $aspect_ratio, $custom_height );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] ?? 'none' );

		$slides_desktop = ! empty( $settings['slides_to_show'] ) ? intval( $settings['slides_to_show'] ) : 3;
		$slides_tablet  = ! empty( $settings['slides_to_show_tablet'] ) ? intval( $settings['slides_to_show_tablet'] ) : 2;
		$slides_mobile  = ! empty( $settings['slides_to_show_mobile'] ) ? intval( $settings['slides_to_show_mobile'] ) : 1;

		$autoplay       = ( 'yes' === ( $settings['autoplay'] ?? 'yes' ) ) ? 'true' : 'false';
		$autoplay_speed = ! empty( $settings['autoplay_speed'] ) ? intval( $settings['autoplay_speed'] ) : 4000;
		$show_arrows    = ( 'yes' === ( $settings['show_arrows'] ?? 'yes' ) );
		$show_dots      = ( 'yes' === ( $settings['show_dots'] ?? 'yes' ) );
		?>
		<div class="magpro-slider-widget-wrap">
			<?php
			if ( ! empty( $settings['widget_title'] ) ) {
				\MagPro_Helpers::render_section_title(
					$settings['widget_title'],
					$title_style,
					$show_view_all,
					$view_all_text,
					$view_all_url,
					! empty( $settings['section_icon']['value'] ) ? $settings['section_icon'] : 'fas fa-sliders-h', $settings['category'] ?? 0, 'yes' === ( $settings['view_all_auto_link'] ?? 'yes' )
				);
			}
			?>

			<div class="magpro-slider-wrap"
				data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				data-speed="<?php echo esc_attr( $autoplay_speed ); ?>"
				data-desktop="<?php echo esc_attr( $slides_desktop ); ?>"
				data-tablet="<?php echo esc_attr( $slides_tablet ); ?>"
				data-mobile="<?php echo esc_attr( $slides_mobile ); ?>">

				<div class="magpro-slider-viewport">
					<div class="magpro-slider-track">
						<?php foreach ( $posts as $p ) : 
							$p_id  = $p->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
						?>
							<div class="magpro-slide-item">
								<div class="magpro-slide-card <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?>">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-slide-img-link">
										<div class="magpro-slide-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
									</a>
									<div class="magpro-slide-overlay"></div>
									<div class="magpro-slide-content">
										<?php if ( $show_badge ) : ?>
											<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
										<?php endif; ?>
										<h4 class="magpro-post-title" style="color: #ffffff; font-size: 16px; margin: 8px 0;">
											<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
										</h4>
										<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( $show_arrows ) : ?>
					<button type="button" class="magpro-slider-btn magpro-slider-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'mag-pro' ); ?>">
						<i class="fas fa-chevron-left"></i>
					</button>
					<button type="button" class="magpro-slider-btn magpro-slider-next" aria-label="<?php esc_attr_e( 'Next slide', 'mag-pro' ); ?>">
						<i class="fas fa-chevron-right"></i>
					</button>
				<?php endif; ?>

				<?php if ( $show_dots ) : ?>
					<div class="magpro-slider-dots"></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		wp_reset_postdata();
	}
}

