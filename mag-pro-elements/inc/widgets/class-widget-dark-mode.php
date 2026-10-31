<?php
/**
 * Elementor Widget: Dark Mode Switcher
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class MagPro_Widget_Dark_Mode extends Widget_Base {

	public function get_name() {
		return 'magpro_dark_mode';
	}

	public function get_title() {
		return esc_html__( 'MagPro Dark Mode Switcher', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-adjust';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	public function get_keywords() {
		return array( 'dark', 'light', 'mode', 'theme', 'switcher', 'toggle', 'header' );
	}

	protected function register_controls() {
		// Content Section
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Switcher Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'switcher_style',
			array(
				'label'   => esc_html__( 'Style', 'mag-pro-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => array(
					'circle' => esc_html__( 'Circle Icon Button', 'mag-pro-elements' ),
					'pill'   => esc_html__( 'Pill Toggle Switch', 'mag-pro-elements' ),
					'button' => esc_html__( 'Button with Text', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'light_text',
			array(
				'label'       => esc_html__( 'Light Label', 'mag-pro-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Light', 'mag-pro-elements' ),
				'condition'   => array(
					'switcher_style' => 'button',
				),
			)
		);

		$this->add_control(
			'dark_text',
			array(
				'label'       => esc_html__( 'Dark Label', 'mag-pro-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Dark', 'mag-pro-elements' ),
				'condition'   => array(
					'switcher_style' => 'button',
				),
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'mag-pro-elements' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'mag-pro-elements' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'mag-pro-elements' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'mag-pro-elements' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .magpro-dm-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style & Colors', 'mag-pro-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'btn_size',
			array(
				'label'      => esc_html__( 'Size (px)', 'mag-pro-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 24,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 38,
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-theme-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .magpro-dm-pill'      => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'mag-pro-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-theme-toggle svg, {{WRAPPER}} .magpro-dm-btn svg' => 'stroke: {{VALUE}}; color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'mag-pro-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-theme-toggle, {{WRAPPER}} .magpro-dm-btn, {{WRAPPER}} .magpro-dm-pill' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'btn_border',
				'label'    => esc_html__( 'Border', 'mag-pro-elements' ),
				'selector' => '{{WRAPPER}} .magpro-theme-toggle, {{WRAPPER}} .magpro-dm-btn, {{WRAPPER}} .magpro-dm-pill',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'btn_shadow',
				'selector' => '{{WRAPPER}} .magpro-theme-toggle, {{WRAPPER}} .magpro-dm-btn, {{WRAPPER}} .magpro-dm-pill',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$style    = ! empty( $settings['switcher_style'] ) ? $settings['switcher_style'] : 'circle';
		?>
		<div class="magpro-dm-wrapper">
			<?php if ( 'button' === $style ) : ?>
				<button type="button" class="magpro-dm-btn magpro-theme-toggle" data-magpro-toggle="theme" style="width:auto; height:auto; padding: 8px 16px; border-radius: 6px; display:inline-flex; align-items:center; gap:8px;">
					<span class="magpro-icon-sun">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
						<span style="font-weight:600;"><?php echo esc_html( $settings['light_text'] ); ?></span>
					</span>
					<span class="magpro-icon-moon">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
						<span style="font-weight:600;"><?php echo esc_html( $settings['dark_text'] ); ?></span>
					</span>
				</button>
			<?php elseif ( 'pill' === $style ) : ?>
				<div class="magpro-dm-pill magpro-theme-toggle" data-magpro-toggle="theme" role="button" tabindex="0" style="width: 64px; height: 32px; border-radius: 30px; display:inline-flex; align-items:center; justify-content:space-between; padding: 0 8px; cursor:pointer; position:relative;">
					<span style="display:inline-flex;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle></svg></span>
					<span style="display:inline-flex;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg></span>
				</div>
			<?php else : ?>
				<button type="button" class="magpro-theme-toggle" data-magpro-toggle="theme" aria-label="<?php esc_attr_e( 'Toggle dark and light theme', 'mag-pro-elements' ); ?>">
					<span class="magpro-icon-sun">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
					</span>
					<span class="magpro-icon-moon">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
					</span>
				</button>
			<?php endif; ?>
		</div>
		<?php
	}
}

