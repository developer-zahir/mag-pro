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
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'List Settings', 'mag-pro-elements' ),
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

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
					<article class="magpro-list-card">
						<div class="magpro-list-thumb">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
							</a>
							<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
						</div>
						<div class="magpro-list-content">
							<h4 class="magpro-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<?php echo \MagPro_Helpers::get_post_meta( $p_id, true, true, true ); ?>

							<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
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

