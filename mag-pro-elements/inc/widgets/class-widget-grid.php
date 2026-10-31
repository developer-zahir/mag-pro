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
		return esc_html__( 'MagPro - Post Grid', 'mag-pro-elements' );
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
				'label' => esc_html__( 'Grid Query & Columns', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Section Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured News', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'2' => esc_html__( '2 Columns', 'mag-pro-elements' ),
					'3' => esc_html__( '3 Columns', 'mag-pro-elements' ),
					'4' => esc_html__( '4 Columns', 'mag-pro-elements' ),
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
				'default' => 6,
				'min'     => 1,
				'max'     => 24,
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
			'show_comments',
			array(
				'label'        => esc_html__( 'Show Comments Count', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_excerpt',
			array(
				'label'        => esc_html__( 'Show Excerpt', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_read_more',
			array(
				'label'        => esc_html__( 'Show Read More Link', 'mag-pro-elements' ),
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

		// Style Tab: Card
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card Style', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Card Background Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-grid-card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-grid-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Title
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title Style', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .magpro-post-title, {{WRAPPER}} .magpro-post-title a',
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

		$this->end_controls_section();

		// Style Tab: Meta
		$this->start_controls_section(
			'section_style_meta',
			array(
				'label' => esc_html__( 'Meta & Views Style', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Meta Text Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta, {{WRAPPER}} .magpro-meta-item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'meta_icon_color',
			array(
				'label'     => esc_html__( 'Meta Icon Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-meta-item i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$columns      = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
		$hover_class  = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] );
		$aspect_style = \MagPro_Helpers::get_image_aspect_style( $settings['aspect_ratio'], $settings['custom_height'] );

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

		$show_badge     = 'yes' === $settings['show_badge'];
		$show_author    = 'yes' === $settings['show_author'];
		$show_date      = 'yes' === $settings['show_date'];
		$show_views     = 'yes' === $settings['show_views'];
		$show_comments  = 'yes' === $settings['show_comments'];
		$show_excerpt   = 'yes' === $settings['show_excerpt'];
		$show_read_more = 'yes' === $settings['show_read_more'];
		?>
		<div class="magpro-grid-wrap">
			<?php if ( ! empty( $settings['widget_title'] ) ) : ?>
				<h3 class="magpro-widget-title"><?php echo esc_html( $settings['widget_title'] ); ?></h3>
			<?php endif; ?>

			<div class="magpro-grid-columns-<?php echo esc_attr( $columns ); ?>">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$p_id  = get_the_ID();
					$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
					?>
					<article class="magpro-grid-card <?php echo esc_attr( $hover_class ); ?>">
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
									<?php esc_html_e( 'Read More', 'mag-pro-elements' ); ?> <i class="fas fa-arrow-right"></i>
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
