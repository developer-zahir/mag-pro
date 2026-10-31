<?php
/**
 * MagPro News Ticker Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Ticker extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-news-ticker';
	}

	public function get_title() {
		return esc_html__( 'MagPro - News Ticker', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-alert';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content Controls
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Ticker Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'ticker_style',
			array(
				'label'   => esc_html__( 'Ticker Animation Style', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'marquee',
				'options' => array(
					'marquee' => esc_html__( 'Continuous Marquee Ribbon', 'mag-pro-elements' ),
					'slide'   => esc_html__( 'Slide / Fade Rotator', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'label_text',
			array(
				'label'   => esc_html__( 'Label Text', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Trending News', 'mag-pro-elements' ),
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
				'default' => 8,
				'min'     => 1,
				'max'     => 20,
			)
		);

		$this->add_control(
			'marquee_speed',
			array(
				'label'       => esc_html__( 'Marquee Loop Duration (Seconds)', 'mag-pro-elements' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 25,
				'min'         => 10,
				'max'         => 90,
				'description' => esc_html__( 'Lower numbers scroll faster, higher numbers scroll smoother/slower.', 'mag-pro-elements' ),
				'condition'   => array(
					'ticker_style' => 'marquee',
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
			'show_views',
			array(
				'label'        => esc_html__( 'Show Post View Count', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_badge',
			array(
				'label'        => esc_html__( 'Show Category Badge', 'mag-pro-elements' ),
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
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// Style Tab: Ticker Box
		$this->start_controls_section(
			'section_style_ticker_box',
			array(
				'label' => esc_html__( 'Ticker Container', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'box_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-wrap' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'box_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-wrap' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'box_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-ticker-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-ticker-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Label Badge
		$this->start_controls_section(
			'section_style_label',
			array(
				'label' => esc_html__( 'Label Badge', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_bg',
			array(
				'label'     => esc_html__( 'Label Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-label' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label Text Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .magpro-ticker-label',
			)
		);

		$this->add_control(
			'label_radius',
			array(
				'label'      => esc_html__( 'Label Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-ticker-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: News Titles & Views
		$this->start_controls_section(
			'section_style_news_titles',
			array(
				'label' => esc_html__( 'News Titles & Views', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'News Title Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-item a, {{WRAPPER}} .magpro-ticker-marquee-item a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'News Title Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-item a:hover, {{WRAPPER}} .magpro-ticker-marquee-item a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .magpro-ticker-item a, {{WRAPPER}} .magpro-ticker-marquee-item a',
			)
		);

		$this->add_control(
			'views_color',
			array(
				'label'     => esc_html__( 'Views Count Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-views' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'views_icon_color',
			array(
				'label'     => esc_html__( 'Views Icon Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-views i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Tab: Rotator Controls (only if slide)
		$this->start_controls_section(
			'section_style_rotator_btns',
			array(
				'label'     => esc_html__( 'Prev/Next Buttons', 'mag-pro-elements' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'ticker_style' => 'slide',
				),
			)
		);

		$this->add_control(
			'btn_color',
			array(
				'label'     => esc_html__( 'Button Icon Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_bg',
			array(
				'label'     => esc_html__( 'Button Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_hover_bg',
			array(
				'label'     => esc_html__( 'Button Hover Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-ticker-btn:hover' => 'background-color: {{VALUE}};',
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

		$style         = $settings['ticker_style'] ?? 'marquee';
		$show_views    = ( 'yes' === ( $settings['show_views'] ?? 'yes' ) );
		$show_badge    = ( 'yes' === ( $settings['show_badge'] ?? 'no' ) );
		$show_date     = ( 'yes' === ( $settings['show_date'] ?? 'no' ) );
		$marquee_speed = ! empty( $settings['marquee_speed'] ) ? intval( $settings['marquee_speed'] ) : 25;
		$posts         = $query->posts;
		?>
		<div class="magpro-ticker-wrap magpro-ticker-<?php echo esc_attr( $style ); ?>-wrap" style="border-radius: 4px; margin-bottom: 25px;">
			<div class="magpro-ticker-container" style="max-width: 100%; padding: 0 12px;">
				<div class="magpro-ticker-label">
					<i class="fas fa-fire"></i>
					<span><?php echo esc_html( $settings['label_text'] ); ?></span>
				</div>

				<?php if ( 'marquee' === $style ) : ?>
					<div class="magpro-ticker-marquee">
						<div class="magpro-ticker-marquee-track" style="animation-duration: <?php echo esc_attr( $marquee_speed ); ?>s;">
							<?php
							// Output twice for seamless infinite continuous scroll loop
							for ( $loop = 0; $loop < 2; $loop++ ) :
								foreach ( $posts as $p ) :
									$p_id  = $p->ID;
									$views = \MagPro_Helpers::get_post_views( $p_id );
									$date  = get_the_time( get_option( 'date_format' ), $p_id );
								?>
									<span class="magpro-ticker-marquee-item">
										<?php if ( $show_badge ) : ?>
											<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
										<?php endif; ?>
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
										<?php if ( $show_views ) : ?>
											<span class="magpro-ticker-views"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
										<?php endif; ?>
										<?php if ( $show_date ) : ?>
											<span class="magpro-ticker-date"><i class="far fa-clock"></i> <?php echo esc_html( $date ); ?></span>
										<?php endif; ?>
										<span class="magpro-ticker-bullet">&bull;</span>
									</span>
								<?php
								endforeach;
							endfor;
							?>
						</div>
					</div>
				<?php else : ?>
					<div class="magpro-ticker-content">
						<?php
						$count = 0;
						foreach ( $posts as $p ) :
							$p_id   = $p->ID;
							$views  = \MagPro_Helpers::get_post_views( $p_id );
							$date   = get_the_time( get_option( 'date_format' ), $p_id );
							$active = ( 0 === $count ) ? 'active' : '';
							?>
							<div class="magpro-ticker-item <?php echo esc_attr( $active ); ?>">
								<?php if ( $show_badge ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
								<?php endif; ?>
								<span class="magpro-ticker-bullet">&bull;</span>
								<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
								<?php if ( $show_views ) : ?>
									<span class="magpro-ticker-views" style="margin-left: 8px; font-size: 11px; opacity: 0.85;"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
								<?php endif; ?>
								<?php if ( $show_date ) : ?>
									<span class="magpro-ticker-date" style="margin-left: 6px; font-size: 11px; opacity: 0.8;"><i class="far fa-clock"></i> <?php echo esc_html( $date ); ?></span>
								<?php endif; ?>
							</div>
							<?php
							$count++;
						endforeach;
						?>
					</div>

					<div class="magpro-ticker-controls">
						<button type="button" class="magpro-ticker-btn magpro-ticker-prev" aria-label="<?php esc_attr_e( 'Previous news', 'mag-pro-elements' ); ?>">
							<i class="fas fa-chevron-left"></i>
						</button>
						<button type="button" class="magpro-ticker-btn magpro-ticker-next" aria-label="<?php esc_attr_e( 'Next news', 'mag-pro-elements' ); ?>">
							<i class="fas fa-chevron-right"></i>
						</button>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		wp_reset_postdata();
	}
}
