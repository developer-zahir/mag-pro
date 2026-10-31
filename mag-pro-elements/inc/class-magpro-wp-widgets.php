<?php
/**
 * MagPro Classic WordPress Widgets
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Classic Widgets
 */
function magpro_register_classic_widgets() {
	register_widget( 'MagPro_WP_Widget_Tabs' );
	register_widget( 'MagPro_WP_Widget_Recent' );
}
add_action( 'widgets_init', 'magpro_register_classic_widgets' );

/**
 * Tabbed Posts Classic Widget
 */
class MagPro_WP_Widget_Tabs extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_tabs',
			esc_html__( 'MagPro - Tabbed Posts', 'mag-pro-elements' ),
			array( 'description' => esc_html__( 'Displays Recent, Popular and Trending posts in tabs.', 'mag-pro-elements' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$count = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 4;
		echo do_shortcode( '[magpro_tabs count="' . $count . '"]' );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$count = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 4;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts per tab:', 'mag-pro-elements' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="10" value="<?php echo esc_attr( $count ); ?>" size="3" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? intval( $new_instance['count'] ) : 4;
		return $instance;
	}
}

/**
 * Recent Posts Classic Widget
 */
class MagPro_WP_Widget_Recent extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_recent',
			esc_html__( 'MagPro - Recent Posts', 'mag-pro-elements' ),
			array( 'description' => esc_html__( 'Displays recent posts with thumbnail cards.', 'mag-pro-elements' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'mag-pro-elements' );
		$count = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 5;

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
		echo do_shortcode( '[magpro_list count="' . $count . '"]' );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mag-pro-elements' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'mag-pro-elements' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="10" value="<?php echo esc_attr( $count ); ?>" size="3" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? intval( $new_instance['count'] ) : 5;
		return $instance;
	}
}

