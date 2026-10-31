<?php
/**
 * MagPro Post List Widget (Horizontal Cards)
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_List extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-list';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Post List', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content Settings
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'List Query & Title', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Section Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Recent Posts', 'mag-pro-elements' ),
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
				'min'     => 1,
				'max'     => 15,
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

		// Visibility & Meta Controls
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
				'default'      => 'yes',
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
						'min' => 100,
						'max' => 300,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 180,
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-list-thumb' => 'width: {{SIZE}}{{UNIT}};',
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
			'card_bg',
			array(
				'label'     => esc_html__( 'Card Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-list-card' => 'background-color: {{VALUE}};',
				),
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

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$hover_class = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] );

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

		$show_badge    = 'yes' === $settings['show_badge'];
		$show_author   = 'yes' === $settings['show_author'];
		$show_date     = 'yes' === $settings['show_date'];
		$show_views    = 'yes' === $settings['show_views'];
		$show_comments = 'yes' === $settings['show_comments'];
		$show_excerpt  = 'yes' === $settings['show_excerpt'];
		?>
		<div class="magpro-list-wrap">
			<?php if ( ! empty( $settings['widget_title'] ) ) : ?>
				<h3 class="magpro-widget-title"><?php echo esc_html( $settings['widget_title'] ); ?></h3>
			<?php endif; ?>

			<div class="magpro-list-items">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$p_id  = get_the_ID();
					$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium' );
					?>
					<article class="magpro-list-card <?php echo esc_attr( $hover_class ); ?>">
						<div class="magpro-list-thumb">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
							</a>
							<?php if ( $show_badge ) : ?>
								<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
							<?php endif; ?>
						</div>
						<div class="magpro-list-content">
							<h4 class="magpro-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>

							<?php if ( $show_excerpt ) : ?>
								<p class="magpro-list-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $p_id, 18 ) ); ?></p>
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
