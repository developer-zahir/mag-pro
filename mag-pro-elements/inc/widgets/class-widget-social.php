<?php
/**
 * MagPro Social Follow Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Social extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-social';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Social Follow Us', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-share';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// Content Controls
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Social Profiles', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Widget Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Follow Us', 'mag-pro-elements' ),
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
				'condition' => array(
					'widget_title!' => '',
				),
			)
		);

		$this->add_control(
			'facebook_url',
			array(
				'label'   => esc_html__( 'Facebook URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://facebook.com/',
			)
		);

		$this->add_control(
			'twitter_url',
			array(
				'label'   => esc_html__( 'Twitter / X URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://twitter.com/',
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'   => esc_html__( 'YouTube URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://youtube.com/',
			)
		);

		$this->add_control(
			'instagram_url',
			array(
				'label'   => esc_html__( 'Instagram URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://instagram.com/',
			)
		);

		$this->add_control(
			'pinterest_url',
			array(
				'label'   => esc_html__( 'Pinterest URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'telegram_url',
			array(
				'label'   => esc_html__( 'Telegram URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->end_controls_section();

		// Style Tab: Section Title
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Widget Title', 'mag-pro-elements' ),
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

		$this->end_controls_section();

		// Style Tab: Buttons Style
		$this->start_controls_section(
			'section_style_buttons',
			array(
				'label' => esc_html__( 'Buttons & Layout', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => array(
					'1' => esc_html__( '1 Column', 'mag-pro-elements' ),
					'2' => esc_html__( '2 Columns', 'mag-pro-elements' ),
					'3' => esc_html__( '3 Columns', 'mag-pro-elements' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .magpro-social-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				),
			)
		);

		$this->add_responsive_control(
			'button_gap',
			array(
				'label'      => esc_html__( 'Grid Gap', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 4,
						'max' => 24,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-social-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-social-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Button Padding', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-social-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .magpro-social-btn',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$title_style = $settings['title_style'] ?? 'style-1';
		?>
		<div class="magpro-social-wrap" style="box-shadow: none;">
			<?php
			if ( ! empty( $settings['widget_title'] ) ) {
				\MagPro_Helpers::render_section_title(
					$settings['widget_title'],
					$title_style,
					false,
					'',
					'',
					'fas fa-share-alt'
				);
			}
			?>

			<div class="magpro-social-grid">
				<?php if ( ! empty( $settings['facebook_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['facebook_url'] ); ?>" class="magpro-social-btn magpro-social-facebook" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-facebook-f"></i> Facebook</span>
						<span><i class="fas fa-thumbs-up"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['twitter_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['twitter_url'] ); ?>" class="magpro-social-btn magpro-social-twitter" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-twitter"></i> Twitter</span>
						<span><i class="fas fa-plus"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['youtube_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['youtube_url'] ); ?>" class="magpro-social-btn magpro-social-youtube" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-youtube"></i> YouTube</span>
						<span><i class="fas fa-play"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['instagram_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['instagram_url'] ); ?>" class="magpro-social-btn magpro-social-instagram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-instagram"></i> Instagram</span>
						<span><i class="fas fa-camera"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['pinterest_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['pinterest_url'] ); ?>" class="magpro-social-btn magpro-social-pinterest" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-pinterest-p"></i> Pinterest</span>
						<span><i class="fas fa-pin"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['telegram_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['telegram_url'] ); ?>" class="magpro-social-btn magpro-social-telegram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-telegram-plane"></i> Telegram</span>
						<span><i class="fas fa-paper-plane"></i></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
