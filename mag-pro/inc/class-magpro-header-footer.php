<?php
/**
 * Header & Footer Builder for Mag Pro.
 * Allows creating custom Headers and Footers using Elementor or standard editor.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MagPro_Header_Footer {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );
		add_action( 'save_post_magpro_hf', array( $this, 'save_metabox' ) );
		add_filter( 'manage_magpro_hf_posts_columns', array( $this, 'admin_columns_headers' ) );
		add_action( 'manage_magpro_hf_posts_custom_column', array( $this, 'admin_columns_content' ), 10, 2 );

		// Ensure Elementor supports this CPT
		add_action( 'elementor/init', array( $this, 'add_elementor_support' ) );

		// Register shortcode
		add_shortcode( 'magpro_template', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Register Custom Post Type for Header & Footer templates.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => _x( 'Header & Footer Builder', 'post type general name', 'mag-pro' ),
			'singular_name'      => _x( 'Header & Footer Template', 'post type singular name', 'mag-pro' ),
			'menu_name'          => _x( 'Header & Footer', 'admin menu', 'mag-pro' ),
			'name_admin_bar'     => _x( 'Header & Footer Template', 'add new on admin bar', 'mag-pro' ),
			'add_new'            => _x( 'Add New Template', 'template', 'mag-pro' ),
			'add_new_item'       => __( 'Add New Template', 'mag-pro' ),
			'new_item'           => __( 'New Template', 'mag-pro' ),
			'edit_item'          => __( 'Edit Template', 'mag-pro' ),
			'view_item'          => __( 'View Template', 'mag-pro' ),
			'all_items'          => __( 'All Templates', 'mag-pro' ),
			'search_items'       => __( 'Search Templates', 'mag-pro' ),
			'not_found'          => __( 'No templates found.', 'mag-pro' ),
			'not_found_in_trash' => __( 'No templates found in Trash.', 'mag-pro' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => is_user_logged_in(), // viewable by logged in for Elementor preview
			'show_ui'             => true,
			'show_in_menu'        => 'magpro-dashboard',
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'magpro-template' ),
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => 20,
			'supports'            => array( 'title', 'editor', 'elementor' ),
			'exclude_from_search' => true,
		);

		register_post_type( 'magpro_hf', $args );
	}

	/**
	 * Register Elementor support for magpro_hf post type.
	 */
	public function add_elementor_support() {
		add_post_type_support( 'magpro_hf', 'elementor' );

		// Automatically add magpro_hf to Elementor's supported post types if not already present
		$cpt_support = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
		if ( is_array( $cpt_support ) && ! in_array( 'magpro_hf', $cpt_support, true ) ) {
			$cpt_support[] = 'magpro_hf';
			update_option( 'elementor_cpt_support', $cpt_support );
		}
	}

	/**
	 * Register settings metabox.
	 */
	public function register_metabox() {
		add_meta_box(
			'magpro_hf_settings',
			__( 'Template Display Settings', 'mag-pro' ),
			array( $this, 'render_metabox' ),
			'magpro_hf',
			'normal',
			'high'
		);
	}

	/**
	 * Render settings metabox.
	 */
	public function render_metabox( $post ) {
		wp_nonce_field( 'magpro_hf_metabox_action', 'magpro_hf_nonce' );

		$type      = get_post_meta( $post->ID, '_magpro_template_type', true );
		$condition = get_post_meta( $post->ID, '_magpro_display_on', true );

		if ( empty( $type ) ) {
			$type = 'header';
		}
		if ( empty( $condition ) ) {
			$condition = 'entire_site';
		}
		?>
		<style>
			.magpro-hf-field { margin-bottom: 20px; }
			.magpro-hf-field label { display: block; font-weight: 600; margin-bottom: 6px; }
			.magpro-hf-field select { width: 100%; max-width: 400px; padding: 6px 10px; }
			.magpro-hf-desc { color: #64748b; font-size: 13px; margin-top: 4px; }
		</style>
		<div class="magpro-hf-metabox">
			<div class="magpro-hf-field">
				<label for="magpro_template_type"><?php esc_html_e( 'Type of Template:', 'mag-pro' ); ?></label>
				<select name="magpro_template_type" id="magpro_template_type">
					<option value="header" <?php selected( $type, 'header' ); ?>><?php esc_html_e( 'Header', 'mag-pro' ); ?></option>
					<option value="footer" <?php selected( $type, 'footer' ); ?>><?php esc_html_e( 'Footer', 'mag-pro' ); ?></option>
					<option value="before_footer" <?php selected( $type, 'before_footer' ); ?>><?php esc_html_e( 'Before Footer / Sticky Banner', 'mag-pro' ); ?></option>
				</select>
				<p class="magpro-hf-desc"><?php esc_html_e( 'Select whether this template will serve as the site Header or Footer.', 'mag-pro' ); ?></p>
			</div>

			<div class="magpro-hf-field">
				<label for="magpro_display_on"><?php esc_html_e( 'Display On:', 'mag-pro' ); ?></label>
				<select name="magpro_display_on" id="magpro_display_on">
					<option value="entire_site" <?php selected( $condition, 'entire_site' ); ?>><?php esc_html_e( 'Entire Website', 'mag-pro' ); ?></option>
					<option value="front_page" <?php selected( $condition, 'front_page' ); ?>><?php esc_html_e( 'Homepage / Front Page Only', 'mag-pro' ); ?></option>
					<option value="singulars" <?php selected( $condition, 'singulars' ); ?>><?php esc_html_e( 'All Singulars (Posts & Pages)', 'mag-pro' ); ?></option>
					<option value="posts" <?php selected( $condition, 'posts' ); ?>><?php esc_html_e( 'Single Posts Only', 'mag-pro' ); ?></option>
					<option value="pages" <?php selected( $condition, 'pages' ); ?>><?php esc_html_e( 'Single Pages Only', 'mag-pro' ); ?></option>
					<option value="archive" <?php selected( $condition, 'archive' ); ?>><?php esc_html_e( 'Blog / Archive Pages', 'mag-pro' ); ?></option>
					<option value="404" <?php selected( $condition, '404' ); ?>><?php esc_html_e( '404 Page Only', 'mag-pro' ); ?></option>
				</select>
				<p class="magpro-hf-desc"><?php esc_html_e( 'Choose which pages this header or footer should appear on.', 'mag-pro' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Save metabox settings.
	 */
	public function save_metabox( $post_id ) {
		if ( ! isset( $_POST['magpro_hf_nonce'] ) || ! wp_verify_nonce( $_POST['magpro_hf_nonce'], 'magpro_hf_metabox_action' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['magpro_template_type'] ) ) {
			update_post_meta( $post_id, '_magpro_template_type', sanitize_text_field( $_POST['magpro_template_type'] ) );
		}

		if ( isset( $_POST['magpro_display_on'] ) ) {
			update_post_meta( $post_id, '_magpro_display_on', sanitize_text_field( $_POST['magpro_display_on'] ) );
		}
	}

	/**
	 * Admin columns setup.
	 */
	public function admin_columns_headers( $columns ) {
		$new_columns = array();
		foreach ( $columns as $key => $title ) {
			$new_columns[ $key ] = $title;
			if ( 'title' === $key ) {
				$new_columns['magpro_type']      = __( 'Template Type', 'mag-pro' );
				$new_columns['magpro_condition'] = __( 'Display Rules', 'mag-pro' );
				$new_columns['magpro_shortcode'] = __( 'Shortcode', 'mag-pro' );
			}
		}
		return $new_columns;
	}

	/**
	 * Admin columns content.
	 */
	public function admin_columns_content( $column, $post_id ) {
		switch ( $column ) {
			case 'magpro_type':
				$type = get_post_meta( $post_id, '_magpro_template_type', true );
				$badge_color = '#0066cc';
				if ( 'footer' === $type ) {
					$badge_color = '#10b981';
				} elseif ( 'before_footer' === $type ) {
					$badge_color = '#f59e0b';
				}
				$label = ! empty( $type ) ? ucfirst( str_replace( '_', ' ', $type ) ) : __( 'Header', 'mag-pro' );
				echo '<span style="display:inline-block;padding:3px 9px;border-radius:4px;color:#fff;font-size:12px;font-weight:600;background:' . esc_attr( $badge_color ) . ';">' . esc_html( $label ) . '</span>';
				break;

			case 'magpro_condition':
				$cond = get_post_meta( $post_id, '_magpro_display_on', true );
				$labels = array(
					'entire_site' => __( 'Entire Website', 'mag-pro' ),
					'front_page'  => __( 'Homepage Only', 'mag-pro' ),
					'singulars'   => __( 'All Singulars', 'mag-pro' ),
					'posts'       => __( 'Single Posts Only', 'mag-pro' ),
					'pages'       => __( 'Single Pages Only', 'mag-pro' ),
					'archive'     => __( 'Archives', 'mag-pro' ),
					'404'         => __( '404 Page', 'mag-pro' ),
				);
				echo esc_html( isset( $labels[ $cond ] ) ? $labels[ $cond ] : __( 'Entire Website', 'mag-pro' ) );
				break;

			case 'magpro_shortcode':
				echo '<input type="text" readonly="readonly" value="' . esc_attr( '[magpro_template id="' . $post_id . '"]' ) . '" style="background:#f1f5f9;border:1px solid #cbd5e1;padding:4px 8px;font-size:11px;font-family:monospace;width:190px;" onclick="this.select();">';
				break;
		}
	}

	/**
	 * Resolve active template ID based on type and current context.
	 */
	public function get_active_template_id( $type = 'header' ) {
		$args = array(
			'post_type'      => 'magpro_hf',
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'meta_query'     => array(
				array(
					'key'   => '_magpro_template_type',
					'value' => $type,
				),
			),
		);

		$query = new WP_Query( $args );
		if ( ! $query->have_posts() ) {
			return false;
		}

		$fallback_entire_site = false;

		while ( $query->have_posts() ) {
			$query->the_post();
			$id        = get_the_ID();
			$condition = get_post_meta( $id, '_magpro_display_on', true );

			// Check specific conditions first
			if ( is_front_page() && 'front_page' === $condition ) {
				wp_reset_postdata();
				return $id;
			}
			if ( is_singular( 'post' ) && ( 'posts' === $condition || 'singulars' === $condition ) ) {
				wp_reset_postdata();
				return $id;
			}
			if ( is_page() && ! is_front_page() && ( 'pages' === $condition || 'singulars' === $condition ) ) {
				wp_reset_postdata();
				return $id;
			}
			if ( ( is_archive() || is_home() ) && 'archive' === $condition ) {
				wp_reset_postdata();
				return $id;
			}
			if ( is_404() && '404' === $condition ) {
				wp_reset_postdata();
				return $id;
			}
			if ( 'entire_site' === $condition && ! $fallback_entire_site ) {
				$fallback_entire_site = $id;
			}
		}
		wp_reset_postdata();

		return $fallback_entire_site;
	}

	/**
	 * Render template content by post ID.
	 */
	public function render_template_content( $template_id ) {
		if ( ! $template_id ) {
			return '';
		}

		// Check if Elementor was used to design this template
		if ( did_action( 'elementor/loaded' ) && \Elementor\Plugin::$instance->documents->get( $template_id )->is_built_with_elementor() ) {
			return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $template_id );
		}

		// Standard WordPress content fallback
		$post = get_post( $template_id );
		if ( $post ) {
			return apply_filters( 'the_content', $post->post_content );
		}

		return '';
	}

	/**
	 * Shortcode callback: [magpro_template id="123"]
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => 0,
			),
			$atts,
			'magpro_template'
		);

		$id = intval( $atts['id'] );
		if ( ! $id ) {
			return '';
		}

		return '<div class="magpro-hf-rendered-template magpro-template-' . esc_attr( $id ) . '">' . $this->render_template_content( $id ) . '</div>';
	}
}

MagPro_Header_Footer::instance();

/**
 * Public function to render Header.
 */
function magpro_render_header() {
	$hf = MagPro_Header_Footer::instance();
	$template_id = $hf->get_active_template_id( 'header' );

	if ( $template_id ) {
		echo '<header id="masthead" class="magpro-custom-header site-header">';
		echo $hf->render_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</header>';
	} else {
		// Render clean default fallback header
		magpro_render_fallback_header();
	}
}

/**
 * Public function to render Footer.
 */
function magpro_render_footer() {
	$hf = MagPro_Header_Footer::instance();
	$template_id = $hf->get_active_template_id( 'footer' );

	if ( $template_id ) {
		echo '<footer id="colophon" class="magpro-custom-footer site-footer">';
		echo $hf->render_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</footer>';
	} else {
		// Render clean default fallback footer
		magpro_render_fallback_footer();
	}
}

/**
 * Public function to render Before Footer.
 */
function magpro_render_before_footer() {
	$hf = MagPro_Header_Footer::instance();
	$template_id = $hf->get_active_template_id( 'before_footer' );

	if ( $template_id ) {
		echo '<div class="magpro-custom-before-footer">';
		echo $hf->render_template_content( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
}
