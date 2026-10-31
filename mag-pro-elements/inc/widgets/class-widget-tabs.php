<?php
/**
 * MagPro Tabbed Posts Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Tabs extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-tabs';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Tabbed Posts', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content Controls
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Tab Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'       => esc_html__( 'Section Title (Optional)', 'mag-pro-elements' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Trending Posts', 'mag-pro-elements' ),
				'placeholder' => esc_html__( 'Enter block title', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'title_style',
			array(
				'label'     => esc_html__( 'Section Title Style', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'style-1',
				'options'   => array(
					'style-1' => esc_html__( 'Style 1: Modern Left Accent Bar', 'mag-pro-elements' ),
					'style-2' => esc_html__( 'Style 2: Solid Badge Header', 'mag-pro-elements' ),
					'style-3' => esc_html__( 'Style 3: Underline Dual-Color Bar', 'mag-pro-elements' ),
				),
				'condition' => array(
					'widget_title!' => '',
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
				'condition'    => array(
					'widget_title!' => '',
				),
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
					'widget_title!' => '',
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
					'widget_title!' => '',
				),
			)
		);

		$this->add_control(
			'posts_count',
			array(
				'label'   => esc_html__( 'Posts Per Tab', 'mag-pro-elements' ),
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

		// Image Size & Hover Animation
		$this->start_controls_section(
			'section_image_settings',
			array(
				'label' => esc_html__( 'Image Size & Animation', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'thumb_width',
			array(
				'label'      => esc_html__( 'Thumbnail Width (px)', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 60,
						'max' => 140,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 85,
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-compact-thumb' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'thumb_height',
			array(
				'label'      => esc_html__( 'Thumbnail Height (px)', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 140,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 70,
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-compact-thumb img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
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

		// Style Tab: Section Header
		$this->start_controls_section(
			'section_style_header',
			array(
				'label'     => esc_html__( 'Section Header', 'mag-pro-elements' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'widget_title!' => '',
				),
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

		// Style Tab: Tab Navigation Buttons
		$this->start_controls_section(
			'section_style_nav',
			array(
				'label' => esc_html__( 'Tabs Navigation', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tab_btn_bg',
			array(
				'label'     => esc_html__( 'Button Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-tab-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_btn_active_bg',
			array(
				'label'     => esc_html__( 'Active Button Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-tab-button.active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_btn_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-tab-button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_btn_active_color',
			array(
				'label'     => esc_html__( 'Active Button Text Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-tab-button.active' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_btn_typography',
				'selector' => '{{WRAPPER}} .magpro-tab-button',
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
			'title_color',
			array(
				'label'     => esc_html__( 'Post Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Post Title Hover Color', 'mag-pro-elements' ),
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

	private function render_post_list( $query, $settings ) {
		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		$show_author   = ( 'yes' === ( $settings['show_author'] ?? 'no' ) );
		$show_date     = ( 'yes' === ( $settings['show_date'] ?? 'yes' ) );
		$show_views    = ( 'yes' === ( $settings['show_views'] ?? 'yes' ) );
		$show_comments = ( 'yes' === ( $settings['show_comments'] ?? 'no' ) );
		$anim_class    = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] ?? 'zoom-in' );

		while ( $query->have_posts() ) :
			$query->the_post();
			$p_id  = get_the_ID();
			$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
			?>
			<div class="magpro-compact-item" style="box-shadow: none;">
				<div class="magpro-compact-thumb <?php echo esc_attr( $anim_class ); ?>">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
					</a>
				</div>
				<div class="magpro-compact-content">
					<h5 class="magpro-post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>
					<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['posts_count'] ) ? intval( $settings['posts_count'] ) : 4;

		$title_style   = $settings['title_style'] ?? 'style-1';
		$show_view_all = ( 'yes' === ( $settings['show_view_all'] ?? 'yes' ) );
		$view_all_text = $settings['view_all_text'] ?? esc_html__( 'View All', 'mag-pro-elements' );
		$view_all_url  = ! empty( $settings['view_all_url']['url'] ) ? $settings['view_all_url']['url'] : '';

		// 1. Recent Posts Query
		$recent_query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'orderby'        => 'date',
			)
		);

		// 2. Popular Posts Query (comment count)
		$popular_query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'orderby'        => 'comment_count',
			)
		);

		// 3. Random/Trending Posts Query
		$random_query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'orderby'        => 'rand',
			)
		);
		?>
		<div class="magpro-tabs-widget-wrap">
			<?php
			if ( ! empty( $settings['widget_title'] ) ) {
				\MagPro_Helpers::render_section_title(
					$settings['widget_title'],
					$title_style,
					$show_view_all,
					$view_all_text,
					$view_all_url,
					'far fa-clock'
				);
			}
			?>

			<div class="magpro-tabs-wrap" style="box-shadow: none;">
				<div class="magpro-tabs-nav">
					<button type="button" class="magpro-tab-button active" data-tab="recent">
						<i class="far fa-clock"></i> <?php esc_html_e( 'Recent', 'mag-pro-elements' ); ?>
					</button>
					<button type="button" class="magpro-tab-button" data-tab="popular">
						<i class="fas fa-fire"></i> <?php esc_html_e( 'Popular', 'mag-pro-elements' ); ?>
					</button>
					<button type="button" class="magpro-tab-button" data-tab="comments">
						<i class="fas fa-random"></i> <?php esc_html_e( 'Trending', 'mag-pro-elements' ); ?>
					</button>
				</div>

				<div class="magpro-tabs-content">
					<div class="magpro-tab-panel magpro-tab-recent active">
						<?php $this->render_post_list( $recent_query, $settings ); ?>
					</div>
					<div class="magpro-tab-panel magpro-tab-popular">
						<?php $this->render_post_list( $popular_query, $settings ); ?>
					</div>
					<div class="magpro-tab-panel magpro-tab-comments">
						<?php $this->render_post_list( $random_query, $settings ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
