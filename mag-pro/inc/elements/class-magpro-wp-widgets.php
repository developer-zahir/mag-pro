<?php
/**
 * MagPro Classic WordPress Widgets for Sidebars & Widget Areas
 *
 * Registers standard WP_Widget classes so all MagPro widgets can be
 * used in any theme sidebar, footer, off-canvas, or block widget area.
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Tabbed Posts Widget
 */
class MagPro_WP_Widget_Tabs extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_tabs',
			esc_html__( 'MagPro - Tabbed Posts (Sidebar)', 'mag-pro' ),
			array(
				'description' => esc_html__( 'Display tabbed posts (Recent, Popular, Trending) in sidebars.', 'mag-pro' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$title_style   = ! empty( $instance['title_style'] ) ? $instance['title_style'] : 'style-1';
		$show_view_all = ! empty( $instance['show_view_all'] );
		$view_all_text = ! empty( $instance['view_all_text'] ) ? $instance['view_all_text'] : esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = ! empty( $instance['view_all_url'] ) ? $instance['view_all_url'] : '';

		$count         = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 4;
		$show_author   = ! empty( $instance['show_author'] );
		$show_date     = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$show_views    = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$show_comments = ! empty( $instance['show_comments'] );

		$thumb_w       = ! empty( $instance['thumb_w'] ) ? intval( $instance['thumb_w'] ) : 80;
		$thumb_h       = ! empty( $instance['thumb_h'] ) ? intval( $instance['thumb_h'] ) : 65;

		if ( ! empty( $title ) ) {
			\MagPro_Helpers::render_section_title( $title, $title_style, $show_view_all, $view_all_text, $view_all_url, 'far fa-clock' );
		}

		$recent_query  = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'date' ) );
		$popular_query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'comment_count' ) );
		$random_query  = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'orderby' => 'rand' ) );
		?>
		<div class="magpro-tabs-wrap" style="box-shadow: none;">
			<div class="magpro-tabs-nav">
				<button type="button" class="magpro-tab-button active" data-tab="recent">
					<i class="far fa-clock"></i> <?php esc_html_e( 'Recent', 'mag-pro' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="popular">
					<i class="fas fa-fire"></i> <?php esc_html_e( 'Popular', 'mag-pro' ); ?>
				</button>
				<button type="button" class="magpro-tab-button" data-tab="comments">
					<i class="fas fa-random"></i> <?php esc_html_e( 'Trending', 'mag-pro' ); ?>
				</button>
			</div>

			<div class="magpro-tabs-content">
				<div class="magpro-tab-panel magpro-tab-recent active">
					<?php $this->render_items( $recent_query, $show_author, $show_date, $show_views, $show_comments, $thumb_w, $thumb_h ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-popular">
					<?php $this->render_items( $popular_query, $show_author, $show_date, $show_views, $show_comments, $thumb_w, $thumb_h ); ?>
				</div>
				<div class="magpro-tab-panel magpro-tab-comments">
					<?php $this->render_items( $random_query, $show_author, $show_date, $show_views, $show_comments, $thumb_w, $thumb_h ); ?>
				</div>
			</div>
		</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	private function render_items( $query, $show_author, $show_date, $show_views, $show_comments, $thumb_w, $thumb_h ) {
		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'mag-pro' ) . '</p>';
			return;
		}
		while ( $query->have_posts() ) :
			$query->the_post();
			$p_id  = get_the_ID();
			$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
			?>
			<div class="magpro-compact-item" style="box-shadow: none;">
				<div class="magpro-compact-thumb magpro-hover-zoom-in" style="width: <?php echo esc_attr( $thumb_w ); ?>px; height: <?php echo esc_attr( $thumb_h ); ?>px;">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" style="height: 100%; object-fit: cover;" loading="lazy" />
					</a>
				</div>
				<div class="magpro-compact-content">
					<h5 class="magpro-post-title" style="font-size: 13px; margin: 0 0 5px 0;">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>
					<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}

	public function form( $instance ) {
		$title         = $instance['title'] ?? esc_html__( 'Popular Posts', 'mag-pro' );
		$title_style   = $instance['title_style'] ?? 'style-1';
		$show_view_all = ! empty( $instance['show_view_all'] );
		$view_all_text = $instance['view_all_text'] ?? esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = $instance['view_all_url'] ?? '';
		$count         = $instance['count'] ?? 4;
		$show_author   = ! empty( $instance['show_author'] );
		$show_date     = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$show_views    = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$show_comments = ! empty( $instance['show_comments'] );
		$thumb_w       = $instance['thumb_w'] ?? 80;
		$thumb_h       = $instance['thumb_h'] ?? 65;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>"><?php esc_html_e( 'Title Style:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_style' ) ); ?>">
				<option value="style-1" <?php selected( $title_style, 'style-1' ); ?>><?php esc_html_e( 'Style 1: Modern Left Accent Bar', 'mag-pro' ); ?></option>
				<option value="style-2" <?php selected( $title_style, 'style-2' ); ?>><?php esc_html_e( 'Style 2: Solid Badge Header', 'mag-pro' ); ?></option>
				<option value="style-3" <?php selected( $title_style, 'style-3' ); ?>><?php esc_html_e( 'Style 3: Underline Dual-Color Bar', 'mag-pro' ); ?></option>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_view_all ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_view_all' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_view_all' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_view_all' ) ); ?>"><?php esc_html_e( 'Show "View All" Button', 'mag-pro' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'view_all_url' ) ); ?>"><?php esc_html_e( '"View All" URL:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_all_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all_url' ) ); ?>" type="text" value="<?php echo esc_attr( $view_all_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Posts Per Tab:', 'mag-pro' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="10" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<p>
			<label><?php esc_html_e( 'Thumbnail Size (W x H px):', 'mag-pro' ); ?></label><br>
			<input class="tiny-text" name="<?php echo esc_attr( $this->get_field_name( 'thumb_w' ) ); ?>" type="number" value="<?php echo esc_attr( $thumb_w ); ?>" size="3"> px &times;
			<input class="tiny-text" name="<?php echo esc_attr( $this->get_field_name( 'thumb_h' ) ); ?>" type="number" value="<?php echo esc_attr( $thumb_h ); ?>" size="3"> px
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_views ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_views' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"><?php esc_html_e( 'Show View Count', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_author ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php esc_html_e( 'Show Author', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_comments ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_comments' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>"><?php esc_html_e( 'Show Comments', 'mag-pro' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['title_style']   = sanitize_key( $new_instance['title_style'] );
		$instance['show_view_all'] = ! empty( $new_instance['show_view_all'] ) ? 1 : 0;
		$instance['view_all_text'] = sanitize_text_field( $new_instance['view_all_text'] );
		$instance['view_all_url']  = esc_url_raw( $new_instance['view_all_url'] );
		$instance['count']         = intval( $new_instance['count'] );
		$instance['show_views']    = ! empty( $new_instance['show_views'] ) ? 1 : 0;
		$instance['show_date']     = ! empty( $new_instance['show_date'] ) ? 1 : 0;
		$instance['show_author']   = ! empty( $new_instance['show_author'] ) ? 1 : 0;
		$instance['show_comments'] = ! empty( $new_instance['show_comments'] ) ? 1 : 0;
		$instance['thumb_w']       = intval( $new_instance['thumb_w'] );
		$instance['thumb_h']       = intval( $new_instance['thumb_h'] );
		return $instance;
	}
}

/**
 * 2. Post List / Compact Posts Widget
 */
class MagPro_WP_Widget_List extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_list',
			esc_html__( 'MagPro - Post List (Sidebar)', 'mag-pro' ),
			array(
				'description' => esc_html__( 'Display recent or category post list with thumbnails in sidebars.', 'mag-pro' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$title_style   = ! empty( $instance['title_style'] ) ? $instance['title_style'] : 'style-1';
		$show_view_all = ! empty( $instance['show_view_all'] );
		$view_all_text = ! empty( $instance['view_all_text'] ) ? $instance['view_all_text'] : esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = ! empty( $instance['view_all_url'] ) ? $instance['view_all_url'] : '';

		$category      = ! empty( $instance['category'] ) ? $instance['category'] : '';
		$count         = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 5;
		$show_author   = ! empty( $instance['show_author'] );
		$show_date     = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$show_views    = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$show_comments = ! empty( $instance['show_comments'] );
		$show_badge    = ! empty( $instance['show_badge'] );
		$thumb_w       = ! empty( $instance['thumb_w'] ) ? intval( $instance['thumb_w'] ) : 85;
		$thumb_h       = ! empty( $instance['thumb_h'] ) ? intval( $instance['thumb_h'] ) : 70;

		if ( ! empty( $title ) ) {
			\MagPro_Helpers::render_section_title( $title, $title_style, $show_view_all, $view_all_text, $view_all_url, 'far fa-newspaper' );
		}

		$query = \MagPro_Helpers::get_posts(
			array(
				'posts_per_page' => $count,
				'category'       => $category,
			)
		);

		if ( $query->have_posts() ) {
			echo '<div class="magpro-list-items" style="gap: 12px;">';
			while ( $query->have_posts() ) :
				$query->the_post();
				$p_id  = get_the_ID();
				$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'thumbnail' );
				?>
				<div class="magpro-compact-item" style="box-shadow: none;">
					<div class="magpro-compact-thumb magpro-hover-zoom-in" style="width: <?php echo esc_attr( $thumb_w ); ?>px; height: <?php echo esc_attr( $thumb_h ); ?>px;">
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" style="height: 100%; object-fit: cover;" loading="lazy" />
						</a>
						<?php if ( $show_badge ) : ?>
							<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
						<?php endif; ?>
					</div>
					<div class="magpro-compact-content">
						<h5 class="magpro-post-title" style="font-size: 13px; margin: 0 0 5px 0;">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h5>
						<?php echo \MagPro_Helpers::get_post_meta( $p_id, $show_author, $show_date, $show_views, $show_comments ); ?>
					</div>
				</div>
				<?php
			endwhile;
			echo '</div>';
			wp_reset_postdata();
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title         = $instance['title'] ?? esc_html__( 'Recent Posts', 'mag-pro' );
		$title_style   = $instance['title_style'] ?? 'style-1';
		$show_view_all = ! empty( $instance['show_view_all'] );
		$view_all_text = $instance['view_all_text'] ?? esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = $instance['view_all_url'] ?? '';
		$category      = $instance['category'] ?? '';
		$count         = $instance['count'] ?? 5;
		$show_author   = ! empty( $instance['show_author'] );
		$show_date     = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$show_views    = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$show_comments = ! empty( $instance['show_comments'] );
		$show_badge    = ! empty( $instance['show_badge'] );
		$thumb_w       = $instance['thumb_w'] ?? 85;
		$thumb_h       = $instance['thumb_h'] ?? 70;
		$categories    = \MagPro_Helpers::get_categories_list();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>"><?php esc_html_e( 'Title Style:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_style' ) ); ?>">
				<option value="style-1" <?php selected( $title_style, 'style-1' ); ?>><?php esc_html_e( 'Style 1: Modern Left Accent Bar', 'mag-pro' ); ?></option>
				<option value="style-2" <?php selected( $title_style, 'style-2' ); ?>><?php esc_html_e( 'Style 2: Solid Badge Header', 'mag-pro' ); ?></option>
				<option value="style-3" <?php selected( $title_style, 'style-3' ); ?>><?php esc_html_e( 'Style 3: Underline Dual-Color Bar', 'mag-pro' ); ?></option>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_view_all ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_view_all' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_view_all' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_view_all' ) ); ?>"><?php esc_html_e( 'Show "View All" Button', 'mag-pro' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'view_all_url' ) ); ?>"><?php esc_html_e( '"View All" URL:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_all_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all_url' ) ); ?>" type="text" value="<?php echo esc_attr( $view_all_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<?php foreach ( $categories as $cat_id => $cat_name ) : ?>
					<option value="<?php echo esc_attr( $cat_id ); ?>" <?php selected( $category, $cat_id ); ?>><?php echo esc_html( $cat_name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Posts:', 'mag-pro' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="15" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<p>
			<label><?php esc_html_e( 'Thumbnail Size (W x H px):', 'mag-pro' ); ?></label><br>
			<input class="tiny-text" name="<?php echo esc_attr( $this->get_field_name( 'thumb_w' ) ); ?>" type="number" value="<?php echo esc_attr( $thumb_w ); ?>" size="3"> px &times;
			<input class="tiny-text" name="<?php echo esc_attr( $this->get_field_name( 'thumb_h' ) ); ?>" type="number" value="<?php echo esc_attr( $thumb_h ); ?>" size="3"> px
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_views ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_views' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"><?php esc_html_e( 'Show View Count', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_author ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php esc_html_e( 'Show Author', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_badge ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_badge' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_badge' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_badge' ) ); ?>"><?php esc_html_e( 'Show Category Badge', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_comments ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_comments' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>"><?php esc_html_e( 'Show Comments', 'mag-pro' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['title_style']   = sanitize_key( $new_instance['title_style'] );
		$instance['show_view_all'] = ! empty( $new_instance['show_view_all'] ) ? 1 : 0;
		$instance['view_all_text'] = sanitize_text_field( $new_instance['view_all_text'] );
		$instance['view_all_url']  = esc_url_raw( $new_instance['view_all_url'] );
		$instance['category']      = sanitize_text_field( $new_instance['category'] );
		$instance['count']         = intval( $new_instance['count'] );
		$instance['show_views']    = ! empty( $new_instance['show_views'] ) ? 1 : 0;
		$instance['show_date']     = ! empty( $new_instance['show_date'] ) ? 1 : 0;
		$instance['show_author']   = ! empty( $new_instance['show_author'] ) ? 1 : 0;
		$instance['show_badge']    = ! empty( $new_instance['show_badge'] ) ? 1 : 0;
		$instance['show_comments'] = ! empty( $new_instance['show_comments'] ) ? 1 : 0;
		$instance['thumb_w']       = intval( $new_instance['thumb_w'] );
		$instance['thumb_h']       = intval( $new_instance['thumb_h'] );
		return $instance;
	}
}

/**
 * 3. Social Follow Us Widget
 */
class MagPro_WP_Widget_Social extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_social',
			esc_html__( 'MagPro - Social Follow (Sidebar)', 'mag-pro' ),
			array(
				'description' => esc_html__( 'Display social media follow buttons in sidebars.', 'mag-pro' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$title_style = ! empty( $instance['title_style'] ) ? $instance['title_style'] : 'style-1';
		$columns     = ! empty( $instance['columns'] ) ? intval( $instance['columns'] ) : 2;

		if ( ! empty( $title ) ) {
			\MagPro_Helpers::render_section_title( $title, $title_style, false, '', '', 'fas fa-share-alt' );
		}
		?>
		<div class="magpro-social-wrap" style="box-shadow: none;">
			<div class="magpro-social-grid" style="grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr); gap: 8px;">
				<?php if ( ! empty( $instance['facebook'] ) ) : ?>
					<a href="<?php echo esc_url( $instance['facebook'] ); ?>" class="magpro-social-btn magpro-social-facebook" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-facebook-f"></i> Facebook</span>
						<span><i class="fas fa-thumbs-up"></i></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $instance['twitter'] ) ) : ?>
					<a href="<?php echo esc_url( $instance['twitter'] ); ?>" class="magpro-social-btn magpro-social-twitter" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-twitter"></i> Twitter</span>
						<span><i class="fas fa-plus"></i></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $instance['youtube'] ) ) : ?>
					<a href="<?php echo esc_url( $instance['youtube'] ); ?>" class="magpro-social-btn magpro-social-youtube" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-youtube"></i> YouTube</span>
						<span><i class="fas fa-play"></i></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $instance['instagram'] ) ) : ?>
					<a href="<?php echo esc_url( $instance['instagram'] ); ?>" class="magpro-social-btn magpro-social-instagram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-instagram"></i> Instagram</span>
						<span><i class="fas fa-camera"></i></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $instance['pinterest'] ) ) : ?>
					<a href="<?php echo esc_url( $instance['pinterest'] ); ?>" class="magpro-social-btn magpro-social-pinterest" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-pinterest-p"></i> Pinterest</span>
						<span><i class="fas fa-pin"></i></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $instance['telegram'] ) ) : ?>
					<a href="<?php echo esc_url( $instance['telegram'] ); ?>" class="magpro-social-btn magpro-social-telegram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-telegram-plane"></i> Telegram</span>
						<span><i class="fas fa-paper-plane"></i></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title       = $instance['title'] ?? esc_html__( 'Follow Us', 'mag-pro' );
		$title_style = $instance['title_style'] ?? 'style-1';
		$columns     = $instance['columns'] ?? 2;
		$fb          = $instance['facebook'] ?? 'https://facebook.com/';
		$tw          = $instance['twitter'] ?? 'https://twitter.com/';
		$yt          = $instance['youtube'] ?? 'https://youtube.com/';
		$ig          = $instance['instagram'] ?? 'https://instagram.com/';
		$pin         = $instance['pinterest'] ?? '';
		$tg          = $instance['telegram'] ?? '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>"><?php esc_html_e( 'Title Style:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_style' ) ); ?>">
				<option value="style-1" <?php selected( $title_style, 'style-1' ); ?>><?php esc_html_e( 'Style 1: Modern Left Accent Bar', 'mag-pro' ); ?></option>
				<option value="style-2" <?php selected( $title_style, 'style-2' ); ?>><?php esc_html_e( 'Style 2: Solid Badge Header', 'mag-pro' ); ?></option>
				<option value="style-3" <?php selected( $title_style, 'style-3' ); ?>><?php esc_html_e( 'Style 3: Underline Dual-Color Bar', 'mag-pro' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Columns:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
				<option value="1" <?php selected( $columns, 1 ); ?>>1 Column</option>
				<option value="2" <?php selected( $columns, 2 ); ?>>2 Columns</option>
			</select>
		</p>
		<p><label>Facebook URL:</label><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $fb ); ?>"></p>
		<p><label>Twitter/X URL:</label><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $tw ); ?>"></p>
		<p><label>YouTube URL:</label><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $yt ); ?>"></p>
		<p><label>Instagram URL:</label><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $ig ); ?>"></p>
		<p><label>Pinterest URL:</label><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" type="text" value="<?php echo esc_attr( $pin ); ?>"></p>
		<p><label>Telegram URL:</label><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'telegram' ) ); ?>" type="text" value="<?php echo esc_attr( $tg ); ?>"></p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['title_style'] = sanitize_key( $new_instance['title_style'] );
		$instance['columns']     = intval( $new_instance['columns'] );
		$instance['facebook']    = esc_url_raw( $new_instance['facebook'] );
		$instance['twitter']     = esc_url_raw( $new_instance['twitter'] );
		$instance['youtube']     = esc_url_raw( $new_instance['youtube'] );
		$instance['instagram']   = esc_url_raw( $new_instance['instagram'] );
		$instance['pinterest']   = esc_url_raw( $new_instance['pinterest'] );
		$instance['telegram']    = esc_url_raw( $new_instance['telegram'] );
		return $instance;
	}
}

/**
 * 4. Post Slider Widget (Sidebar)
 */
class MagPro_WP_Widget_Slider extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_slider',
			esc_html__( 'MagPro - Post Slider (Sidebar)', 'mag-pro' ),
			array(
				'description' => esc_html__( 'Display a responsive touch carousel/slider in sidebars.', 'mag-pro' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$title_style   = ! empty( $instance['title_style'] ) ? $instance['title_style'] : 'style-1';
		$show_view_all = ! empty( $instance['show_view_all'] );
		$view_all_text = ! empty( $instance['view_all_text'] ) ? $instance['view_all_text'] : esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = ! empty( $instance['view_all_url'] ) ? $instance['view_all_url'] : '';

		$category      = ! empty( $instance['category'] ) ? $instance['category'] : '';
		$count         = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 4;
		$show_views    = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$show_date     = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$show_badge    = isset( $instance['show_badge'] ) ? (bool) $instance['show_badge'] : true;
		$slide_height  = ! empty( $instance['slide_height'] ) ? intval( $instance['slide_height'] ) : 200;

		if ( ! empty( $title ) ) {
			\MagPro_Helpers::render_section_title( $title, $title_style, $show_view_all, $view_all_text, $view_all_url, 'fas fa-sliders-h' );
		}

		$query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'category' => $category ) );
		if ( $query->have_posts() ) {
			?>
			<div class="magpro-slider-wrap" data-autoplay="true" data-speed="4000" data-desktop="1" data-tablet="1" data-mobile="1" style="box-shadow: none;">
				<div class="magpro-slider-viewport">
					<div class="magpro-slider-track">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							$p_id  = get_the_ID();
							$thumb = \MagPro_Helpers::get_thumbnail_url( $p_id, 'medium_large' );
							?>
							<div class="magpro-slide-item">
								<div class="magpro-slide-card magpro-hover-zoom-in" style="height: <?php echo esc_attr( $slide_height ); ?>px; box-shadow: none;">
									<a href="<?php the_permalink(); ?>" class="magpro-slide-img-link">
										<div class="magpro-slide-thumb" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
									</a>
									<div class="magpro-slide-overlay"></div>
									<div class="magpro-slide-content">
										<?php if ( $show_badge ) : ?>
											<?php echo \MagPro_Helpers::get_category_badge( $p_id ); ?>
										<?php endif; ?>
										<h4 class="magpro-post-title" style="color: #ffffff; font-size: 14px; margin: 6px 0;">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h4>
										<?php echo \MagPro_Helpers::get_post_meta( $p_id, false, $show_date, $show_views, false ); ?>
									</div>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
				<button type="button" class="magpro-slider-btn magpro-slider-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
				<button type="button" class="magpro-slider-btn magpro-slider-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
				<div class="magpro-slider-dots"></div>
			</div>
			<?php
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title         = $instance['title'] ?? esc_html__( 'Featured Carousel', 'mag-pro' );
		$title_style   = $instance['title_style'] ?? 'style-1';
		$show_view_all = ! empty( $instance['show_view_all'] );
		$view_all_text = $instance['view_all_text'] ?? esc_html__( 'View All', 'mag-pro' );
		$view_all_url  = $instance['view_all_url'] ?? '';
		$category      = $instance['category'] ?? '';
		$count         = $instance['count'] ?? 4;
		$slide_height  = $instance['slide_height'] ?? 200;
		$show_views    = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$show_date     = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$show_badge    = isset( $instance['show_badge'] ) ? (bool) $instance['show_badge'] : true;
		$categories    = \MagPro_Helpers::get_categories_list();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>"><?php esc_html_e( 'Title Style:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_style' ) ); ?>">
				<option value="style-1" <?php selected( $title_style, 'style-1' ); ?>><?php esc_html_e( 'Style 1: Modern Left Accent Bar', 'mag-pro' ); ?></option>
				<option value="style-2" <?php selected( $title_style, 'style-2' ); ?>><?php esc_html_e( 'Style 2: Solid Badge Header', 'mag-pro' ); ?></option>
				<option value="style-3" <?php selected( $title_style, 'style-3' ); ?>><?php esc_html_e( 'Style 3: Underline Dual-Color Bar', 'mag-pro' ); ?></option>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_view_all ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_view_all' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_view_all' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_view_all' ) ); ?>"><?php esc_html_e( 'Show "View All" Button', 'mag-pro' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'view_all_url' ) ); ?>"><?php esc_html_e( '"View All" URL:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_all_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all_url' ) ); ?>" type="text" value="<?php echo esc_attr( $view_all_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<?php foreach ( $categories as $cat_id => $cat_name ) : ?>
					<option value="<?php echo esc_attr( $cat_id ); ?>" <?php selected( $category, $cat_id ); ?>><?php echo esc_html( $cat_name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'slide_height' ) ); ?>"><?php esc_html_e( 'Slide Height (px):', 'mag-pro' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'slide_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slide_height' ) ); ?>" type="number" value="<?php echo esc_attr( $slide_height ); ?>" size="3"> px
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_views ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_views' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"><?php esc_html_e( 'Show View Count', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date', 'mag-pro' ); ?></label><br>

			<input class="checkbox" type="checkbox" <?php checked( $show_badge ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_badge' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_badge' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_badge' ) ); ?>"><?php esc_html_e( 'Show Category Badge', 'mag-pro' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['title_style']   = sanitize_key( $new_instance['title_style'] );
		$instance['show_view_all'] = ! empty( $new_instance['show_view_all'] ) ? 1 : 0;
		$instance['view_all_text'] = sanitize_text_field( $new_instance['view_all_text'] );
		$instance['view_all_url']  = esc_url_raw( $new_instance['view_all_url'] );
		$instance['category']      = sanitize_text_field( $new_instance['category'] );
		$instance['count']         = intval( $new_instance['count'] );
		$instance['slide_height']  = intval( $new_instance['slide_height'] );
		$instance['show_views']    = ! empty( $new_instance['show_views'] ) ? 1 : 0;
		$instance['show_date']     = ! empty( $new_instance['show_date'] ) ? 1 : 0;
		$instance['show_badge']    = ! empty( $new_instance['show_badge'] ) ? 1 : 0;
		return $instance;
	}
}

/**
 * 5. News Ticker Widget (Sidebar)
 */
class MagPro_WP_Widget_Ticker extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'magpro_wp_ticker',
			esc_html__( 'MagPro - News Ticker (Sidebar)', 'mag-pro' ),
			array(
				'description' => esc_html__( 'Display breaking news ticker in sidebars.', 'mag-pro' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$label_text = ! empty( $instance['label_text'] ) ? $instance['label_text'] : esc_html__( 'Trending News', 'mag-pro' );
		$category   = ! empty( $instance['category'] ) ? $instance['category'] : '';
		$count      = ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 6;
		$style      = ! empty( $instance['style'] ) ? $instance['style'] : 'marquee';
		$show_views = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;

		$query = \MagPro_Helpers::get_posts( array( 'posts_per_page' => $count, 'category' => $category ) );
		if ( $query->have_posts() ) {
			$posts = $query->posts;
			?>
			<div class="magpro-ticker-wrap magpro-ticker-<?php echo esc_attr( $style ); ?>-wrap" style="box-shadow: none; border-radius: 4px; margin-bottom: 15px;">
				<div class="magpro-ticker-container" style="padding: 0 10px;">
					<div class="magpro-ticker-label">
						<i class="fas fa-fire"></i>
						<span><?php echo esc_html( $label_text ); ?></span>
					</div>

					<?php if ( 'marquee' === $style ) : ?>
						<div class="magpro-ticker-marquee">
							<div class="magpro-ticker-marquee-track">
								<?php
								for ( $loop = 0; $loop < 2; $loop++ ) :
									foreach ( $posts as $p ) :
										$p_id  = $p->ID;
										$views = \MagPro_Helpers::get_post_views( $p_id );
									?>
										<span class="magpro-ticker-marquee-item">
											<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
											<?php if ( $show_views ) : ?>
												<span class="magpro-ticker-views"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
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
							$cnt = 0;
							foreach ( $posts as $p ) :
								$p_id   = $p->ID;
								$views  = \MagPro_Helpers::get_post_views( $p_id );
								$active = ( 0 === $cnt ) ? 'active' : '';
								?>
								<div class="magpro-ticker-item <?php echo esc_attr( $active ); ?>">
									<span class="magpro-ticker-bullet">&bull;</span>
									<a href="<?php echo esc_url( get_permalink( $p_id ) ); ?>"><?php echo esc_html( get_the_title( $p_id ) ); ?></a>
									<?php if ( $show_views ) : ?>
										<span class="magpro-ticker-views" style="margin-left: 6px;"><i class="far fa-eye"></i> <?php echo esc_html( $views ); ?></span>
									<?php endif; ?>
								</div>
								<?php
								$cnt++;
							endforeach;
							?>
						</div>
						<div class="magpro-ticker-controls">
							<button type="button" class="magpro-ticker-btn magpro-ticker-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
							<button type="button" class="magpro-ticker-btn magpro-ticker-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$label_text = $instance['label_text'] ?? esc_html__( 'Trending News', 'mag-pro' );
		$category   = $instance['category'] ?? '';
		$count      = $instance['count'] ?? 6;
		$style      = $instance['style'] ?? 'marquee';
		$show_views = isset( $instance['show_views'] ) ? (bool) $instance['show_views'] : true;
		$categories = \MagPro_Helpers::get_categories_list();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'label_text' ) ); ?>"><?php esc_html_e( 'Label Text:', 'mag-pro' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label_text' ) ); ?>" type="text" value="<?php echo esc_attr( $label_text ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
				<option value="marquee" <?php selected( $style, 'marquee' ); ?>><?php esc_html_e( 'Continuous Marquee Ribbon', 'mag-pro' ); ?></option>
				<option value="slide" <?php selected( $style, 'slide' ); ?>><?php esc_html_e( 'Slide / Fade Rotator', 'mag-pro' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:', 'mag-pro' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<?php foreach ( $categories as $cat_id => $cat_name ) : ?>
					<option value="<?php echo esc_attr( $cat_id ); ?>" <?php selected( $category, $cat_id ); ?>><?php echo esc_html( $cat_name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Posts:', 'mag-pro' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_views ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_views' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"><?php esc_html_e( 'Show View Count', 'mag-pro' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance               = array();
		$instance['label_text'] = sanitize_text_field( $new_instance['label_text'] );
		$instance['category']   = sanitize_text_field( $new_instance['category'] );
		$instance['count']      = intval( $new_instance['count'] );
		$instance['style']      = sanitize_key( $new_instance['style'] );
		$instance['show_views'] = ! empty( $new_instance['show_views'] ) ? 1 : 0;
		return $instance;
	}
}

/**
 * Register all MagPro WP Sidebar Widgets
 */
function magpro_register_wp_sidebar_widgets() {
	register_widget( 'MagPro_WP_Widget_Tabs' );
	register_widget( 'MagPro_WP_Widget_List' );
	register_widget( 'MagPro_WP_Widget_Social' );
	register_widget( 'MagPro_WP_Widget_Slider' );
	register_widget( 'MagPro_WP_Widget_Ticker' );
}
add_action( 'widgets_init', 'magpro_register_wp_sidebar_widgets' );
