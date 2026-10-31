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
		// Content Controls
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
			'show_view_all',
			array(
				'label'        => esc_html__( 'Show "View All" Button', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'view_all_text',
			array(
				'label'     => esc_html__( '"View All" Text', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'View All', 'mag-pro-elements' ),
				'condition' => array(
					'show_view_all' => 'yes',
				),
			)
		);

		$this->add_control(
			'view_all_url',
			array(
				'label'         => esc_html__( '"View All" Link', 'mag-pro-elements' ),
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
				'max'     => 10,
			)
		);

		$this->end_controls_section();

		// Meta & Visibility Controls
		$this->start_controls_section(
			'section_meta_visibility',
			array(
				'label' => esc_html__( 'Meta & Visibility Options', 'mag-pro-elements' ),
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

		// Big Image (Hero Video) Settings
		$this->start_controls_section(
			'section_big_image_settings',
			array(
				'label' => esc_html__( 'Big Image Controls (Hero Video)', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'   => esc_html__( 'Hero Aspect Ratio', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '16:9',
				'options' => array(
					'16:9'   => esc_html__( '16:9 Widescreen', 'mag-pro-elements' ),
					'4:3'    => esc_html__( '4:3 Standard', 'mag-pro-elements' ),
					'21:9'   => esc_html__( '21:9 Ultrawide', 'mag-pro-elements' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'custom_height',
			array(
				'label'     => esc_html__( 'Hero Height (px)', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 360,
				'min'       => 200,
				'max'       => 650,
				'condition' => array(
					'aspect_ratio' => 'custom',
				),
			)
		);

		$this->add_control(
			'hover_animation',
			array(
				'label'   => esc_html__( 'Hero Hover Animation', 'mag-pro-elements' ),
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

		// Small Image (Playlist Items) Settings
		$this->start_controls_section(
			'section_small_image_settings',
			array(
				'label' => esc_html__( 'Small Image Controls (Playlist)', 'mag-pro-elements' ),
			)
		);

		$this->add_responsive_control(
			'small_image_width',
			array(
				'label'      => esc_html__( 'Thumbnail Width (px)', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 60, 'max' => 160 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 90 ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-video-item-thumb' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
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
					'px' => array( 'min' => 50, 'max' => 140 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 70 ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-video-item-thumb img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
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

		// Style Tab: Section Header
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Section Header', 'mag-pro-elements' ),
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

		// Style Tab: Cards & Container
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Container & Background', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'block_bg',
			array(
				'label'     => esc_html__( 'Block Background Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-videos-wrap' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-video-hero, {{WRAPPER}} .magpro-video-item-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Typography & Colors
		$this->start_controls_section(
			'section_style_typography',
			array(
				'label' => esc_html__( 'Titles & Meta', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'hero_title_color',
			array(
				'label'     => esc_html__( 'Hero Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-video-hero .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'hero_title_typography',
				'selector' => '{{WRAPPER}} .magpro-video-hero .magpro-post-title',
			)
		);

		$this->add_control(
			'list_title_color',
			array(
				'label'     => esc_html__( 'List Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-video-item .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'list_title_hover_color',
			array(
				'label'     => esc_html__( 'List Title Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-video-item .magpro-post-title a:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'list_title_typography',
				'selector' => '{{WRAPPER}} .magpro-video-item .magpro-post-title',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta Text Color', 'mag-pro-elements' ),
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

		// Style Tab: Play Button
		$this->start_controls_section(
			'section_style_play_btn',
			array(
				'label' => esc_html__( 'Play Button Style', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'play_btn_bg',
			array(
				'label'     => esc_html__( 'Hero Play Button Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-video-play-btn' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'play_btn_icon_color',
			array(
				'label'     => esc_html__( 'Hero Play Button Icon Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-video-play-btn i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'mini_play_btn_bg',
			array(
				'label'     => esc_html__( 'List Mini Play Button Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-video-mini-play' => 'background: {{VALUE}};',
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
			)
		);

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		$posts         = $query->posts;
		$title_style   = $settings['title_style'] ?? 'style-1';
		$show_view_all = ( 'yes' === ( $settings['show_view_all'] ?? 'yes' ) );
		$view_all_text = $settings['view_all_text'] ?? esc_html__( 'View All', 'mag-pro-elements' );
		$view_all_url  = ! empty( $settings['view_all_url']['url'] ) ? $settings['view_all_url']['url'] : '';

		$show_badge    = ( 'yes' === ( $settings['show_badge'] ?? 'yes' ) );
		$show_author   = ( 'yes' === ( $settings['show_author'] ?? 'no' ) );
		$show_date     = ( 'yes' === ( $settings['show_date'] ?? 'yes' ) );
		$show_views    = ( 'yes' === ( $settings['show_views'] ?? 'yes' ) );
		$show_comments = ( 'yes' === ( $settings['show_comments'] ?? 'no' ) );

		$aspect_ratio  = $settings['aspect_ratio'] ?? '16:9';
		$custom_height = ! empty( $settings['custom_height'] ) ? intval( $settings['custom_height'] ) : 360;
		$aspect_style  = \MagPro_Helpers::get_image_aspect_style( $aspect_ratio, $custom_height );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] ?? 'zoom-in' );
		$small_anim    = \MagPro_Helpers::get_hover_animation_class( $settings['small_hover_animation'] ?? 'zoom-in' );
		?>
		<div class="magpro-videos-wrap" style="box-shadow: none;">
			<?php
			if ( ! empty( $settings['widget_title'] ) ) {
				\MagPro_Helpers::render_section_title(
					$settings['widget_title'],
					$title_style,
					$show_view_all,
					$view_all_text,
					$view_all_url,
					'fas fa-play-circle'
				);
			}
			?>

			<div class="magpro-videos-grid">
				<?php if ( isset( $posts[0] ) ) : 
					$lead_id = $posts[0]->ID;
					$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
				?>
					<div class="magpro-video-hero magpro-hero-card <?php echo esc_attr( $anim_class ); ?>" style="<?php echo esc_attr( $aspect_style ); ?> box-shadow: none;">
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
							<div class="magpro-video-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
						</a>
						<div class="magpro-hero-overlay"></div>
						<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-video-play-btn" aria-label="<?php esc_attr_e( 'Play Video', 'mag-pro-elements' ); ?>">
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
						<div class="magpro-video-item" style="box-shadow: none;">
							<div class="magpro-video-item-thumb <?php echo esc_attr( $small_anim ); ?>">
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
}
