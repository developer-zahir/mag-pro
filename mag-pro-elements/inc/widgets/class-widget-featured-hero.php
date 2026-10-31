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
		return esc_html__( 'MagPro - Featured Hero Grid', 'mag-pro-elements' );
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
				'label' => esc_html__( 'Hero Query & Layout', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Grid Layout', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '5_posts',
				'options' => array(
					'5_posts'   => esc_html__( 'MagPro 5-Post Grid (1 Big + 4 Small)', 'mag-pro-elements' ),
					'3_columns' => esc_html__( '3 Columns Hero Cards', 'mag-pro-elements' ),
					'4_columns' => esc_html__( '4 Columns Hero Cards', 'mag-pro-elements' ),
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
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'          => esc_html__( 'Date', 'mag-pro-elements' ),
					'comment_count' => esc_html__( 'Popularity (Comments)', 'mag-pro-elements' ),
					'rand'          => esc_html__( 'Random', 'mag-pro-elements' ),
					'title'         => esc_html__( 'Title', 'mag-pro-elements' ),
				),
			)
		);

		$this->end_controls_section();

		// Post Meta Show / Hide Controls Section
		$this->start_controls_section(
			'section_meta_visibility',
			array(
				'label' => esc_html__( 'Post Meta Visibility', 'mag-pro-elements' ),
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

		$this->end_controls_section();

		// Image Size & Hover Animation Section
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
					'21:9'   => esc_html__( '21:9 Cinema', 'mag-pro-elements' ),
					'custom' => esc_html__( 'Custom Manual Height', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'custom_height',
			array(
				'label'     => esc_html__( 'Manual Height (px)', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 380,
				'min'       => 150,
				'max'       => 800,
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

		// Style Tab: Titles
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
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title, {{WRAPPER}} .magpro-post-title a' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Title Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff2232',
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-title a:hover' => 'color: {{VALUE}} !important;',
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
				'default'   => 'rgba(255, 255, 255, 0.8)',
				'selectors' => array(
					'{{WRAPPER}} .magpro-post-meta, {{WRAPPER}} .magpro-meta-item, {{WRAPPER}} .magpro-meta-item a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'meta_icon_color',
			array(
				'label'     => esc_html__( 'Meta Icons Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff2232',
				'selectors' => array(
					'{{WRAPPER}} .magpro-meta-item i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Badges
		$this->start_controls_section(
			'section_style_badge',
			array(
				'label' => esc_html__( 'Category Badge Style', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'badge_bg_color',
			array(
				'label'     => esc_html__( 'Badge Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff2232',
				'selectors' => array(
					'{{WRAPPER}} .magpro-cat-badge' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_text_color',
			array(
				'label'     => esc_html__( 'Badge Text Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .magpro-cat-badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$layout       = ! empty( $settings['layout'] ) ? $settings['layout'] : '5_posts';
		$count        = ( '5_posts' === $layout ) ? 5 : ( ( '3_columns' === $layout ) ? 3 : 4 );
		$hover_class  = \MagPro_Helpers::get_hover_animation_class( $settings['hover_animation'] );
		$aspect_style = \MagPro_Helpers::get_image_aspect_style( $settings['aspect_ratio'], $settings['custom_height'] );

		$query_args = array(
			'posts_per_page' => $count,
			'category'       => $settings['category'],
			'orderby'        => $settings['orderby'],
		);

		$query = \MagPro_Helpers::get_posts( $query_args );

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		$posts         = $query->posts;
		$show_badge    = 'yes' === $settings['show_badge'];
		$show_author   = 'yes' === $settings['show_author'];
		$show_date     = 'yes' === $settings['show_date'];
		$show_views    = 'yes' === $settings['show_views'];
		$show_comments = 'yes' === $settings['show_comments'];
		?>
		<div class="magpro-hero-wrap" style="<?php echo esc_attr( $aspect_style ); ?>">
			<?php if ( '5_posts' === $layout ) : ?>
				<div class="magpro-hero-grid-5">
					<?php if ( isset( $posts[0] ) ) : 
						$lead_id = $posts[0]->ID;
						$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
					?>
						<div class="magpro-hero-lead magpro-hero-card <?php echo esc_attr( $hover_class ); ?>">
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
					<?php endif; ?>

					<div class="magpro-hero-subgrid">
						<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
							$p_id  = $posts[ $i ]->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
						?>
							<div class="magpro-hero-card <?php echo esc_attr( $hover_class ); ?>">
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
				$grid_class = ( '3_columns' === $layout ) ? 'magpro-hero-grid-3' : 'magpro-hero-grid-4';
			?>
				<div class="<?php echo esc_attr( $grid_class ); ?>">
					<?php foreach ( $posts as $p ) : 
						$p_id  = $p->ID;
						$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
					?>
						<div class="magpro-hero-card <?php echo esc_attr( $hover_class ); ?>">
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
