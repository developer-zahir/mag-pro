<?php
/**
 * MagPro Tabbed Posts Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Tabs extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-tabs';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Tabbed Posts', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Tab Settings', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'posts_count',
			array(
				'label'   => esc_html__( 'Posts Per Tab', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 10,
			)
		);

		$this->end_controls_section();
	}

	private function render_post_list( $query ) {
		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro-elements' ) . '</p>';
			return;
		}

		while ( $query->have_posts() ) :
			$query->the_post();
			$p_id  = get_the_ID();
			$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
			?>
			<div class="magpro-compact-item">
				<div class="magpro-compact-thumb">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
					</a>
				</div>
				<div class="magpro-compact-content">
					<h5 class="magpro-post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>
					<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, true, true ); ?>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['posts_count'] ) ? intval( $settings['posts_count'] ) : 4;

		// 1. Recent Posts Query
		$recent_query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'orderby'        => 'date',
			)
		);

		// 2. Popular Posts Query (comment count)
		$popular_query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'orderby'        => 'comment_count',
			)
		);

		// 3. Random/Trending Posts Query
		$random_query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'orderby'        => 'rand',
			)
		);
		?>
		<div class="magpro-tabs-wrap">
			<div class="magpro-tabs-nav">
				<button type="button" class="magpro-tab-button active" data-tab="recent">
					<i class="far fa-clock"></i> <?php esc_html_e( 'Recent', 'mag-pro-elements' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="popular">
					<i class="fas fa-fire"></i> <?php esc_html_e( 'Popular', 'mag-pro-elements' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="comments">
					<i class="fas fa-random"></i> <?php esc_html_e( 'Trending', 'mag-pro-elements' ); ?>
				</button>
			</div>

			<div class="magpro-tabs-content">
				<div class="magpro-tab-panel magpro-tab-recent active">
					<?php $this->render_post_list( $recent_query ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-popular">
					<?php $this->render_post_list( $popular_query ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-comments">
					<?php $this->render_post_list( $random_query ); ?>
				</div>
			</div>
		</div>
		<?php
	}
}

