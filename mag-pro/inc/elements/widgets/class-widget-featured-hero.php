<?php
/**
 * MagPro Featured Hero Grid Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Featured_Hero extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-featured-hero';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Featured Hero Grid', 'mag-pro' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content Settings Section
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Hero Query & Layout', 'mag-pro' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Section Title (Optional)', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'title_style',
			array(
				'label'     => esc_html__( 'Section Title Style', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'style-1',
				'options'   => array(
					'style-1' => esc_html__( 'Style 1: Modern Left Accent Bar', 'mag-pro' ),
					'style-2' => esc_html__( 'Style 2: Solid Badge Header', 'mag-pro' ),
					'style-3' => esc_html__( 'Style 3: Underline Dual-Color Bar', 'mag-pro' ),
				),
				'condition' => array(
					'widget_title!' => '',
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
				'default'      => 'no',
				'return_value' => 'yes',
				'condition'    => array(
					'widget_title!' => '',
				),
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
					'widget_title!' => '',
				),
			)
		);

		$this->add_control(
			'view_all_url',
			array(
				'label'         => esc_html__( '"View All" Link', 'mag-pro' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => 'https://your-link.com',
				'show_external' => true,
				'condition'     => array(
					'show_view_all' => 'yes',
					'widget_title!' => '',
				),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Grid Layout', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '5_posts',
				'options' => array(
					'5_posts'   => esc_html__( 'MagPro 5-Post Grid (1 Big + 4 Small)', 'mag-pro' ),
					'3_columns' => esc_html__( '3 Columns Hero Cards', 'mag-pro' ),
					'4_columns' => esc_html__( '4 Columns Hero Cards', 'mag-pro' ),
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
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'          => esc_html__( 'Date', 'mag-pro' ),
					'comment_count' => esc_html__( 'Popularity (Comments)', 'mag-pro' ),
					'rand'          => esc_html__( 'Random', 'mag-pro' ),
					'title'         => esc_html__( 'Title', 'mag-pro' ),
				),
			)
		);

		$this->end_controls_section();

		// Post Meta Show / Hide Controls Section
		$this->start_controls_section(
			'section_meta_visibility',
			array(
				'label' => esc_html__( 'Post Meta Visibility', 'mag-pro' ),
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

		// Big Image (Lead) Controls
		$this->start_controls_section(
			'section_big_image_settings',
			array(
				'label' => esc_html__( 'Big Image Controls (Lead Post)', 'mag-pro' ),
			)
		);

		$this->add_control(
			'lead_aspect_ratio',
			array(
				'label'   => esc_html__( 'Lead Aspect Ratio', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro' ),
					'21:9'   => esc_html__( '21:9 Ultrawide', 'mag-pro' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro' ),
				),
			)
		);

		$this->add_control(
			'lead_custom_height',
			array(
				'label'     => esc_html__( 'Lead Height (px)', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 440,
				'min'       => 240,
				'max'       => 700,
				'condition' => array(
					'lead_aspect_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'lead_hover_animation',
			array(
				'label'   => esc_html__( 'Lead Hover Animation', 'mag-pro' ),
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

		// Small Image (Subgrid) Controls
		$this->start_controls_section(
			'section_small_image_settings',
			array(
				'label' => esc_html__( 'Small Image Controls (Subgrid Posts)', 'mag-pro' ),
			)
		);

		$this->add_control(
			'sub_aspect_ratio',
			array(
				'label'   => esc_html__( 'Subgrid Aspect Ratio', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro' ),
					'1:1'    => esc_html__( '1:1 Square', 'mag-pro' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro' ),
				),
			)
		);

		$this->add_control(
			'sub_custom_height',
			array(
				'label'     => esc_html__( 'Subgrid Height (px)', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 212,
				'min'       => 120,
				'max'       => 400,
				'condition' => array(
					'sub_aspect_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'sub_hover_animation',
			array(
				'label'   => esc_html__( 'Subgrid Hover Animation', 'mag-pro' ),
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
			'view_all_color',
			array(
				'label'     => esc_html__( 'View All Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'view_all_hover_color',
			array(
				'label'     => esc_html__( 'View All Hover Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-view-all:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Hero Cards
		$this->start_controls_section(
			'section_style_cards',
			array(
				'label' => esc_html__( 'Hero Cards', 'mag-pro' ),
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
					'{{WRAPPER}} .magpro-hero-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Gradient Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-hero-overlay' => 'background: linear-gradient(180deg, transparent 35%, {{VALUE}} 100%);',
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
			'lead_title_color',
			array(
				'label'     => esc_html__( 'Lead Title Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-hero-lead .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lead_title_typography',
				'selector' => '{{WRAPPER}} .magpro-hero-lead .magpro-post-title',
			)
		);

		$this->add_control(
			'sub_title_color',
			array(
				'label'     => esc_html__( 'Subgrid Title Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-hero-subgrid .magpro-post-title a, {{WRAPPER}} .magpro-hero-grid-3 .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .magpro-hero-subgrid .magpro-post-title, {{WRAPPER}} .magpro-hero-grid-3 .magpro-post-title',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta, {{WRAPPER}} .magpro-post-meta a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'meta_icon_color',
			array(
				'label'     => esc_html__( 'Meta Icon Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta i' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$count = ( '5_posts' === $settings['layout'] ) ? 5 : ( ( '4_columns' === $settings['layout'] ) ? 4 : 3 );

		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
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
		$show_view_all = ( 'yes' === ( $settings['show_view_all'] ?? 'no' ) );
		$view_all_text = $settings['view_all_text'] ?? esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = ! empty( $settings['view_all_url']['url'] ) ? $settings['view_all_url']['url'] : '';

		$show_badge    = ( 'yes' === ( $settings['show_badge'] ?? 'yes' ) );
		$show_author   = ( 'yes' === ( $settings['show_author'] ?? 'yes' ) );
		$show_date     = ( 'yes' === ( $settings['show_date'] ?? 'yes' ) );
		$show_views    = ( 'yes' === ( $settings['show_views'] ?? 'yes' ) );
		$show_comments = ( 'yes' === ( $settings['show_comments'] ?? 'no' ) );

		$lead_aspect   = $settings['lead_aspect_ratio'] ?? 'custom';
		$lead_height   = ! empty( $settings['lead_custom_height'] ) ? intval( $settings['lead_custom_height'] ) : 440;
		$lead_style    = \MagPro_Helpers::get_image_aspect_style( $lead_aspect, $lead_height );
		$lead_anim     = \MagPro_Helpers::get_hover_animation_class( $settings['lead_hover_animation'] ?? 'none' );

		$sub_aspect    = $settings['sub_aspect_ratio'] ?? 'custom';
		$sub_height    = ! empty( $settings['sub_custom_height'] ) ? intval( $settings['sub_custom_height'] ) : 212;
		$sub_style     = \MagPro_Helpers::get_image_aspect_style( $sub_aspect, $sub_height );
		$sub_anim      = \MagPro_Helpers::get_hover_animation_class( $settings['sub_hover_animation'] ?? 'none' );
		?>
		<div class="magpro-hero-wrap">
			<?php
			if ( ! empty( $settings['widget_title'] ) ) {
				\MagPro_Helpers::render_section_title(
					$settings['widget_title'],
					$title_style,
					$show_view_all,
					$view_all_text,
					$view_all_url,
					! empty( $settings['section_icon']['value'] ) ? $settings['section_icon'] : 'fas fa-star', $settings['category'] ?? 0, 'yes' === ( $settings['view_all_auto_link'] ?? 'yes' )
				);
			}
			?>

			<?php if ( '5_posts' === $settings['layout'] && isset( $posts[0] ) ) : 
				$lead_id = $posts[0]->ID;
				$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
			?>
				<div class="magpro-hero-grid-5">
					<div class="magpro-hero-lead magpro-hero-card <?php echo esc_attr( $lead_anim ); ?>" style="<?php echo esc_attr( $lead_style ); ?> box-shadow: none;">
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
							<div class="magpro-hero-card <?php echo esc_attr( $sub_anim ); ?>" style="<?php echo esc_attr( $sub_style ); ?> box-shadow: none;">
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
			<?php else : 
				$cols_class = ( '4_columns' === $settings['layout'] ) ? 'magpro-hero-grid-4' : 'magpro-hero-grid-3';
			?>
				<div class="<?php echo esc_attr( $cols_class ); ?>">
					<?php foreach ( $posts as $p ) : 
						$p_id  = $p->ID;
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
					?>
						<div class="magpro-hero-card <?php echo esc_attr( $sub_anim ); ?>" style="<?php echo esc_attr( $sub_style ); ?> box-shadow: none;">
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
}
