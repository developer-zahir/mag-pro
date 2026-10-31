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
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Ticker Settings', 'mag-pro-elements' ),
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
				'default' => 6,
				'min'     => 1,
				'max'     => 15,
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
		?>
		<div class="magpro-ticker-wrap" style="border-radius: 4px; margin-bottom: 25px;">
			<div class="magpro-ticker-container" style="max-width: 100%; padding: 0 12px;">
				<div class="magpro-ticker-label">
					<i class="fas fa-fire"></i>
					<span><?php echo esc_html( $settings['label_text'] ); ?></span>
				</div>

				<div class="magpro-ticker-content">
					<?php
					$count = 0;
					while ( $query->have_posts() ) :
						$query->the_post();
						$active = ( 0 === $count ) ? 'active' : '';
						?>
						<div class="magpro-ticker-item <?php echo esc_attr( $active ); ?>">
							<span class="magpro-ticker-bullet">&bull;</span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
						<?php
						$count++;
					endwhile;
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
			</div>
		</div>
		<?php
		wp_reset_postdata();
	}
}

