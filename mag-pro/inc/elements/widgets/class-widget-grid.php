<?php
/**
 * MagPro Post Grid Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-grid';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Post Grid', 'mag-pro' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content Settings
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Grid Query & Columns', 'mag-pro' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Section Title', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured News', 'mag-pro' ),
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
				'placeholder'   => 'https://your-link.com',
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
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'2' => esc_html__( '2 Columns', 'mag-pro' ),
					'3' => esc_html__( '3 Columns', 'mag-pro' ),
					'4' => esc_html__( '4 Columns', 'mag-pro' ),
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
				'min'     => 1,
				'max'     => 24,
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
				),
			)
		);

		$this->end_controls_section();

		// Meta & Visibility Controls
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

		$this->add_control(
			'show_excerpt',
			array(
				'label'        => esc_html__( 'Show Excerpt', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_read_more',
			array(
				'label'        => esc_html__( 'Show Read More Link', 'mag-pro' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// Image Size & Hover Animation
		$this->start_controls_section(
			'section_image_settings',
			array(
				'label' => esc_html__( 'Image Size & Animation', 'mag-pro' ),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'   => esc_html__( 'Aspect Ratio', 'mag-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '16:9',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro' ),
					'1:1'    => esc_html__( '1:1 Square', 'mag-pro' ),
					'3:2'    => esc_html__( '3:2 Classic Magazine', 'mag-pro' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro' ),
				),
			)
		);

		$this->add_control(
			'custom_height',
			array(
				'label'     => esc_html__( 'Manual Height (px)', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 190,
				'min'       => 120,
				'max'       => 450,
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

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Image Border Radius', 'mag-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-grid-thumb, {{WRAPPER}} .magpro-grid-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		// Style Tab: Card
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Grid Card Container', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-grid-card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-grid-card' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-grid-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Content Padding', 'mag-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Titles & Meta
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Titles, Meta & Excerpt', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Title Hover Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title a:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .magpro-post-title',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta Text Color', 'mag-pro' ),
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

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Excerpt Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-grid-excerpt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .magpro-grid-excerpt',
			)
		);

		$this->end_controls_section();

		// Style Tab: Read More Button
		$this->start_controls_section(
			'section_style_read_more',
			array(
				'label' => esc_html__( 'Read More Link', 'mag-pro' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'read_more_color',
			array(
				'label'     => esc_html__( 'Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-read-more' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'read_more_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'mag-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-read-more:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'read_more_typography',
				'selector' => '{{WRAPPER}} .magpro-read-more',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$columns      = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
		$hover_class  = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] ?? 'none' );
		$aspect_style = \MagPro_Helpers::get_image_aspect_style( $settings['aspect_ratio'] ?? '16:9', $settings['custom_height'] ?? 190 );

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

		$title_style    = $settings['title_style'] ?? 'style-1';
		$show_view_all  = ( 'yes' === ( $settings['show_view_all'] ?? 'yes' ) );
		$view_all_text  = $settings['view_all_text'] ?? esc_html__( 'View All', 'mag-pro' );
		$view_all_url   = ! empty( $settings['view_all_url']['url'] ) ? $settings['view_all_url']['url'] : '';

		$show_badge     = 'yes' === ( $settings['show_badge'] ?? 'yes' );
		$show_author    = 'yes' === ( $settings['show_author'] ?? 'yes' );
		$show_date      = 'yes' === ( $settings['show_date'] ?? 'yes' );
		$show_views     = 'yes' === ( $settings['show_views'] ?? 'yes' );
		$show_comments  = 'yes' === ( $settings['show_comments'] ?? 'no' );
		$show_excerpt   = 'yes' === ( $settings['show_excerpt'] ?? 'yes' );
		$show_read_more = 'yes' === ( $settings['show_read_more'] ?? 'yes' );
		?>
		<div class="magpro-grid-wrap">
			<?php
			if ( ! empty( $settings['widget_title'] ) ) {
				\MagPro_Helpers::render_section_title(
					$settings['widget_title'],
					$title_style,
					$show_view_all,
					$view_all_text,
					$view_all_url,
					! empty( $settings['section_icon']['value'] ) ? $settings['section_icon'] : 'fas fa-th', $settings['category'] ?? 0, 'yes' === ( $settings['view_all_auto_link'] ?? 'yes' )
				);
			}
			?>

			<div class="magpro-grid-columns-<?php echo esc_attr( $columns ); ?>">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$p_id  = get_the_ID();
					$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
					?>
					<article class="magpro-grid-card <?php echo esc_attr( $hover_class ); ?>" style="box-shadow: none;">
						<div class="magpro-grid-thumb" style="<?php echo esc_attr( $aspect_style ); ?>">
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

							<?php if ( $show_read_more ) : ?>
								<a href="<?php the_permalink(); ?>" class="magpro-read-more">
									<?php esc_html_e( 'Read More', 'mag-pro' ); ?> <i class="fas fa-arrow-right"></i>
								</a>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		</div>
		<?php
		wp_reset_postdata();
	}
}
