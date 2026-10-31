<?php
/**
 * MagPro Search Element Widget
 * 2 Styles: Full-screen Modal (Center Center) & Replace Header Content
 *
 * @package MagProElements
 * @author  Developer Zahir
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Search extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-search';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Header Search', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		// =====================================================================
		// Search Configuration
		// =====================================================================
		$this->start_controls_section(
			'section_search_content',
			array(
				'label' => esc_html__( 'Search Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'search_style',
			array(
				'label'   => esc_html__( 'Search Style', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'full-screen',
				'options' => array(
					'full-screen'  => esc_html__( 'Full Screen Modal (Center Center)', 'mag-pro-elements' ),
					'header-cover' => esc_html__( 'Replace Header Content', 'mag-pro-elements' ),
				),
			)
		);

		$this->add_control(
			'search_icon',
			array(
				'label'   => esc_html__( 'Search Trigger Icon', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'show_label',
			array(
				'label'        => esc_html__( 'Show Trigger Label', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'mag-pro-elements' ),
				'label_off'    => esc_html__( 'No', 'mag-pro-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'trigger_label',
			array(
				'label'     => esc_html__( 'Trigger Label Text', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Search', 'mag-pro-elements' ),
				'condition' => array(
					'show_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'placeholder',
			array(
				'label'   => esc_html__( 'Search Placeholder', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Type to search and hit enter...', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'hint_text',
			array(
				'label'     => esc_html__( 'Modal Hint Text', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Press ESC to close or click outside', 'mag-pro-elements' ),
				'condition' => array(
					'search_style' => 'full-screen',
				),
			)
		);

		$this->end_controls_section();

		// =====================================================================
		// Trigger Button Style
		// =====================================================================
		$this->start_controls_section(
			'section_trigger_style',
			array(
				'label' => esc_html__( 'Trigger Button', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 48,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-search-trigger i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .magpro-search-trigger svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_trigger_colors' );

		$this->start_controls_tab(
			'tab_trigger_normal',
			array(
				'label' => esc_html__( 'Normal', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'trigger_color',
			array(
				'label'     => esc_html__( 'Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-search-trigger' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'trigger_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-search-trigger' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_trigger_hover',
			array(
				'label' => esc_html__( 'Hover', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'trigger_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-search-trigger:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'trigger_hover_bg',
			array(
				'label'     => esc_html__( 'Hover Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .magpro-search-trigger:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'trigger_padding',
			array(
				'label'      => esc_html__( 'Padding', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-search-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'trigger_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mag-pro-elements' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .magpro-search-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// =====================================================================
		// Search Modal / Input Style
		// =====================================================================
		$this->start_controls_section(
			'section_modal_style',
			array(
				'label' => esc_html__( 'Modal / Field Style', 'mag-pro-elements' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay_bg',
			array(
				'label'     => esc_html__( 'Backdrop Background', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.magpro-search-modal-backdrop' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'label'    => esc_html__( 'Input Typography', 'mag-pro-elements' ),
				'selector' => '.magpro-search-modal-input, .magpro-search-cover-input',
			)
		);

		$this->add_control(
			'input_text_color',
			array(
				'label'     => esc_html__( 'Input Text Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.magpro-search-modal-input, .magpro-search-cover-input' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_placeholder_color',
			array(
				'label'     => esc_html__( 'Placeholder Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.magpro-search-modal-input::placeholder, .magpro-search-cover-input::placeholder' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_border_color',
			array(
				'label'     => esc_html__( 'Input Border Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.magpro-search-modal .magpro-search-input-wrap' => 'border-color: {{VALUE}};',
					'.magpro-search-cover-container'                => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'submit_btn_color',
			array(
				'label'     => esc_html__( 'Submit Button Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.magpro-search-modal-submit, .magpro-search-cover-submit' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'close_btn_color',
			array(
				'label'     => esc_html__( 'Close Button Color', 'mag-pro-elements' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.magpro-search-modal-close, .magpro-search-cover-close' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$search_style = ! empty( $settings['search_style'] ) ? $settings['search_style'] : 'full-screen';
		$placeholder  = ! empty( $settings['placeholder'] ) ? $settings['placeholder'] : esc_html__( 'Type to search and hit enter...', 'mag-pro-elements' );
		$hint_text    = ! empty( $settings['hint_text'] ) ? $settings['hint_text'] : esc_html__( 'Press ESC to close or click outside', 'mag-pro-elements' );
		$show_label   = ! empty( $settings['show_label'] ) && 'yes' === $settings['show_label'];
		$label_text   = ! empty( $settings['trigger_label'] ) ? $settings['trigger_label'] : '';
		$icon         = ! empty( $settings['search_icon'] ) ? $settings['search_icon'] : array( 'value' => 'fas fa-search', 'library' => 'fa-solid' );
		$unique_id    = $this->get_id();
		?>
		<div class="magpro-widget-search-wrap" data-search-style="<?php echo esc_attr( $search_style ); ?>">
			<button type="button" class="magpro-search-trigger" data-target-style="<?php echo esc_attr( $search_style ); ?>" aria-label="<?php esc_attr_e( 'Search', 'mag-pro-elements' ); ?>" title="<?php esc_attr_e( 'Search', 'mag-pro-elements' ); ?>">
				<span class="magpro-search-trigger-icon">
					<?php
					if ( ! empty( $icon['value'] ) && class_exists( '\Elementor\Icons_Manager' ) ) {
						\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
					} else {
						echo '<i class="fas fa-search" aria-hidden="true"></i>';
					}
					?>
				</span>
				<?php if ( $show_label && ! empty( $label_text ) ) : ?>
					<span class="magpro-search-trigger-text"><?php echo esc_html( $label_text ); ?></span>
				<?php endif; ?>
			</button>

			<?php if ( 'header-cover' === $search_style ) : ?>
				<!-- Inline / Header Cover Search Container -->
				<div class="magpro-search-cover" id="magpro-cover-<?php echo esc_attr( $unique_id ); ?>" aria-hidden="true">
					<div class="magpro-search-cover-container">
						<form role="search" method="get" class="magpro-search-cover-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<i class="fas fa-search magpro-search-cover-icon" aria-hidden="true"></i>
							<input type="search" class="magpro-search-cover-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
							<button type="submit" class="magpro-search-cover-submit" aria-label="<?php esc_attr_e( 'Search', 'mag-pro-elements' ); ?>">
								<?php esc_html_e( 'Search', 'mag-pro-elements' ); ?>
							</button>
							<button type="button" class="magpro-search-cover-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro-elements' ); ?>">&times;</button>
						</form>
					</div>
				</div>
			<?php else : ?>
				<!-- Full-Screen Modal Search (Center Center) -->
				<div class="magpro-search-modal" id="magpro-modal-<?php echo esc_attr( $unique_id ); ?>" aria-hidden="true" role="dialog" aria-modal="true">
					<div class="magpro-search-modal-backdrop"></div>
					<button type="button" class="magpro-search-modal-close" aria-label="<?php esc_attr_e( 'Close search', 'mag-pro-elements' ); ?>">&times;</button>
					<div class="magpro-search-modal-inner">
						<form role="search" method="get" class="magpro-search-modal-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<label class="screen-reader-text" for="magpro-search-input-<?php echo esc_attr( $unique_id ); ?>"><?php esc_html_e( 'Search for:', 'mag-pro-elements' ); ?></label>
							<div class="magpro-search-input-wrap">
								<i class="fas fa-search magpro-search-modal-icon" aria-hidden="true"></i>
								<input type="search" id="magpro-search-input-<?php echo esc_attr( $unique_id ); ?>" class="magpro-search-modal-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
								<button type="submit" class="magpro-search-modal-submit" aria-label="<?php esc_attr_e( 'Submit search', 'mag-pro-elements' ); ?>">
									<i class="fas fa-arrow-right" aria-hidden="true"></i>
								</button>
							</div>
							<?php if ( ! empty( $hint_text ) ) : ?>
								<div class="magpro-search-modal-hint"><?php echo esc_html( $hint_text ); ?></div>
							<?php endif; ?>
						</form>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
