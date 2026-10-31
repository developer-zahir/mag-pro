<?php
/**
 * Mag Pro Helpers
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MagPro_Helpers {

	/**
	 * Get category options for Elementor controls
	 */
	public static function get_categories_list() {
		$options = array(
			'' => esc_html__( 'All Categories', 'mag-pro-elements' ),
		);

		$categories = get_categories(
			array(
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => false,
			)
		);

		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
				$options[ $category->term_id ] = $category->name;
			}
		}

		return $options;
	}

	/**
	 * Run query for posts
	 */
	public static function get_posts( $settings = array() ) {
		$posts_per_page = ! empty( $settings['posts_per_page'] ) ? intval( $settings['posts_per_page'] ) : 5;
		$category_id    = ! empty( $settings['category'] ) ? $settings['category'] : '';
		$orderby        = ! empty( $settings['orderby'] ) ? sanitize_key( $settings['orderby'] ) : 'date';
		$order          = ! empty( $settings['order'] ) ? sanitize_key( $settings['order'] ) : 'DESC';
		$offset         = ! empty( $settings['offset'] ) ? intval( $settings['offset'] ) : 0;

		$args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $posts_per_page,
			'orderby'             => $orderby,
			'order'               => $order,
			'ignore_sticky_posts' => true,
		);

		if ( ! empty( $category_id ) ) {
			$args['cat'] = intval( $category_id );
		}

		if ( $offset > 0 ) {
			$args['offset'] = $offset;
		}

		return new WP_Query( $args );
	}

	/**
	 * Get post featured image URL with elegant fallback
	 */
	public static function get_thumbnail_url( $post_id, $size = 'large' ) {
		if ( has_post_thumbnail( $post_id ) ) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
			if ( ! empty( $src[0] ) ) {
				return esc_url( $src[0] );
			}
		}

		// Fallback SVG placeholder with MagPro style
		return 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22600%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20600%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1%20text%20%7B%20fill%3A%23999%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A30pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1%22%3E%3Crect%20width%3D%22600%22%20height%3D%22400%22%20fill%3D%22%23212530%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22180%22%20y%3D%22210%22%3EMag%20Pro%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';
	}

	/**
	 * Get primary category badge markup
	 */
	public static function get_category_badge( $post_id ) {
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) {
			return '';
		}

		$first_cat = $categories[0];
		return sprintf(
			'<a href="%1$s" class="magpro-cat-badge">%2$s</a>',
			esc_url( get_category_link( $first_cat->term_id ) ),
			esc_html( $first_cat->name )
		);
	}

	/**
	 * Get formatted post view count
	 */
	public static function get_post_views( $post_id ) {
		$views = get_post_meta( $post_id, '_magpro_post_views', true );
		if ( empty( $views ) ) {
			$views = 0;
		}
		$views = intval( $views );

		if ( $views >= 1000000 ) {
			return round( $views / 1000000, 1 ) . 'M';
		} elseif ( $views >= 1000 ) {
			return round( $views / 1000, 1 ) . 'K';
		}
		return number_format_i18n( $views );
	}

	/**
	 * Get post meta markup with author, date, views, and comments switches
	 */
	public static function get_post_meta( $post_id, $show_author = true, $show_date = true, $show_views = true, $show_comments = false ) {
		$output = '<div class="magpro-post-meta">';

		if ( $show_author ) {
			$author_id = get_post_field( 'post_author', $post_id );
			$output   .= sprintf(
				'<span class="magpro-meta-item magpro-meta-author"><i class="far fa-user"></i> <a href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( $author_id ) ),
				esc_html( get_the_author_meta( 'display_name', $author_id ) )
			);
		}

		if ( $show_date ) {
			$output .= sprintf(
				'<span class="magpro-meta-item magpro-meta-date"><i class="far fa-clock"></i> %1$s</span>',
				esc_html( get_the_time( get_option( 'date_format' ), $post_id ) )
			);
		}

		if ( $show_views ) {
			$output .= sprintf(
				'<span class="magpro-meta-item magpro-meta-views"><i class="far fa-eye"></i> %1$s</span>',
				esc_html( self::get_post_views( $post_id ) )
			);
		}

		if ( $show_comments ) {
			$comment_count = get_comments_number( $post_id );
			$output       .= sprintf(
				'<span class="magpro-meta-item magpro-meta-comments"><i class="far fa-comment"></i> %1$s</span>',
				esc_html( $comment_count )
			);
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Generate aspect ratio and manual height style attribute
	 */
	public static function get_image_aspect_style( $aspect_ratio = '16:9', $custom_height = '' ) {
		if ( 'custom' === $aspect_ratio && ! empty( $custom_height ) ) {
			return 'height: ' . intval( $custom_height ) . 'px;';
		}

		switch ( $aspect_ratio ) {
			case '4:3':
				return 'aspect-ratio: 4 / 3; height: auto;';
			case '1:1':
				return 'aspect-ratio: 1 / 1; height: auto;';
			case '3:2':
				return 'aspect-ratio: 3 / 2; height: auto;';
			case '21:9':
				return 'aspect-ratio: 21 / 9; height: auto;';
			case '16:9':
			default:
				return 'aspect-ratio: 16 / 9; height: auto;';
		}
	}

	/**
	 * Get hover animation class for images
	 */
	public static function get_hover_animation_class( $animation = 'none' ) {
		if ( empty( $animation ) || 'none' === $animation ) {
			return 'magpro-hover-none';
		}
		return 'magpro-hover-' . sanitize_html_class( $animation );
	}

	/**
	 * Truncate excerpt cleanly
	 */
	public static function get_excerpt( $post_id, $words = 15 ) {
		$post = get_post( $post_id );
		if ( ! $post ) {
			return '';
		}

		$text = ! empty( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;
		$text = wp_strip_all_tags( $text );
		$text = wp_trim_words( $text, $words, '&hellip;' );

		return $text;
	}

	/**
	 * Render Section Header with multiple professional magazine styles and View All button
	 *
	 * @param string $title
	 * @param string $style 'style-1' (Left Accent), 'style-2' (Solid Badge), 'style-3' (Underline Dual), 'style-4' (Bordered Box), 'style-5' (Line Divider), 'style-6' (Gradient Accent)
	 * @param bool   $show_view_all
	 * @param string $view_all_text
	 * @param string $view_all_url
	 * @param mixed  $icon FontAwesome icon string or Elementor icon array
	 * @param int    $category Selected category ID (for auto-linking)
	 * @param bool   $auto_link Whether to automatically link View All to selected category
	 */
	public static function render_section_title( $title, $style = 'style-1', $show_view_all = false, $view_all_text = 'View All', $view_all_url = '', $icon = '', $category = 0, $auto_link = true ) {
		if ( empty( $title ) ) {
			return;
		}

		$valid_styles = array( 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6' );
		$style        = in_array( $style, $valid_styles, true ) ? $style : 'style-1';

		// Auto-link to selected category if enabled
		if ( $show_view_all && $auto_link && ! empty( $category ) && intval( $category ) > 0 ) {
			$cat_link = get_category_link( intval( $category ) );
			if ( ! is_wp_error( $cat_link ) && ! empty( $cat_link ) ) {
				$view_all_url = $cat_link;
			}
		}

		// Fallback to blog archive if View All is enabled but URL is still empty
		if ( $show_view_all && empty( $view_all_url ) ) {
			$page_for_posts = get_option( 'page_for_posts' );
			$view_all_url   = $page_for_posts ? get_permalink( $page_for_posts ) : home_url( '/' );
		}
		?>
		<div class="magpro-section-header magpro-header-<?php echo esc_attr( $style ); ?>">
			<div class="magpro-section-title-wrap">
				<h3 class="magpro-widget-title">
					<?php if ( ! empty( $icon ) ) : ?>
						<span class="magpro-section-icon">
							<?php
							if ( is_array( $icon ) && ! empty( $icon['value'] ) && class_exists( '\Elementor\Icons_Manager' ) ) {
								\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
							} elseif ( is_string( $icon ) && ! empty( $icon ) ) {
								echo '<i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i>';
							}
							?>
						</span>
					<?php endif; ?>
					<span class="magpro-title-text"><?php echo esc_html( $title ); ?></span>
				</h3>
			</div>

			<?php if ( 'style-5' === $style ) : ?>
				<div class="magpro-header-line-fill" aria-hidden="true"></div>
			<?php endif; ?>

			<?php if ( $show_view_all && ! empty( $view_all_url ) ) : ?>
				<div class="magpro-view-all-wrap">
					<a href="<?php echo esc_url( $view_all_url ); ?>" class="magpro-view-all">
						<span class="magpro-view-all-text"><?php echo esc_html( ! empty( $view_all_text ) ? $view_all_text : esc_html__( 'View All', 'mag-pro-elements' ) ); ?></span>
						<i class="fas fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}

