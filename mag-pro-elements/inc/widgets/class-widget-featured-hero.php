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
		// Content Section
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Hero Settings', 'mag-pro-elements' ),
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

		$this->add_control(
			'show_badge',
			array(
				'label'        => esc_html__( 'Show Category Badge', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'mag-pro-elements' ),
				'label_off'    => esc_html__( 'No', 'mag-pro-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_date',
			array(
				'label'        => esc_html__( 'Show Date', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'mag-pro-elements' ),
				'label_off'    => esc_html__( 'No', 'mag-pro-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_author',
			array(
				'label'        => esc_html__( 'Show Author', 'mag-pro-elements' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'mag-pro-elements' ),
				'label_off'    => esc_html__( 'No', 'mag-pro-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$layout   = ! empty( $settings['layout'] ) ? $settings['layout'] : '5_posts';
		$count    = ( '5_posts' === $layout ) ? 5 : ( ( '3_columns' === $layout ) ? 3 : 4 );

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

		$posts = $query->posts;
		?>
		<div class="magpro-hero-wrap">
			<?php if ( '5_posts' === $layout ) : ?>
				<div class="magpro-hero-grid-5">
					<?php if ( isset( $posts[0] ) ) : 
						$lead_id = $posts[0]->ID;
						$thumb   = \MagPro_Helpers::get_thumbnail_url( $lead_id, 'large' );
					?>
						<div class="magpro-hero-lead magpro-hero-card">
							<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>" class="magpro-hero-img-link">
								<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
							</a>
							<div class="magpro-hero-overlay"></div>
							<div class="magpro-hero-content">
								<?php if ( 'yes' === $settings['show_badge'] ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $lead_id ); ?>
								<?php endif; ?>
								<h2 class="magpro-post-title">
									<a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a>
								</h2>
								<?php echo \MagPro_Helpers::get_post_meta( $lead_id, 'yes' === $settings['show_author'], 'yes' === $settings['show_date'] ); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="magpro-hero-subgrid">
						<?php for ( $i = 1; $i < count( $posts ); $i++ ) : 
							$p_id  = $posts[ $i ]->ID;
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
						?>
							<div class="magpro-hero-card">
								<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
									<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
								</a>
								<div class="magpro-hero-overlay"></div>
								<div class="magpro-hero-content">
									<?php if ( 'yes' === $settings['show_badge'] ) : ?>
										<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
									<?php endif; ?>
									<h3 class="magpro-post-title">
										<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									</h3>
									<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, 'yes' === $settings['show_date'] ); ?>
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
						<div class="magpro-hero-card">
							<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>" class="magpro-hero-img-link">
								<div class="magpro-hero-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
							</a>
							<div class="magpro-hero-overlay"></div>
							<div class="magpro-hero-content">
								<?php if ( 'yes' === $settings['show_badge'] ) : ?>
									<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
								<?php endif; ?>
								<h3 class="magpro-post-title">
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
								</h3>
								<?php echo \MagPro_Helpers::get_post_meta( $p_id, 'yes' === $settings['show_author'], 'yes' === $settings['show_date'] ); ?>
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

