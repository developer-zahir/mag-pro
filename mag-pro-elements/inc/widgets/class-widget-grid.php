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
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Grid Settings', 'mag-pro-elements' ),
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$columns  = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';

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
					<article class="magpro-grid-card">
						<div class="magpro-grid-thumb">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
							</a>
							<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
						</div>
						<div class="magpro-grid-content">
							<h4 class="magpro-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<?php echo \MagPro_Helpers::get_post_meta( $p_id, true, true ); ?>

							<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
								<p class="magpro-grid-excerpt"><?php echo esc_html( \MagPro_Helpers::get_excerpt( $p_id, 14 ) ); ?></p>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_read_more'] ) : ?>
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

