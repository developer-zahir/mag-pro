<?php
/**
 * Elementor Widgets Loader
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MagPro_Elementor_Loader {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		// Fallback for older Elementor versions
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets_legacy' ) );
	}

	/**
	 * Register Mag Pro Elements Category
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'magpro-elements',
			array(
				'title' => esc_html__( 'Mag Pro Elements', 'mag-pro-elements' ),
				'icon'  => 'fa fa-newspaper',
			)
		);
	}

	/**
	 * Include widget class files
	 */
	private function include_widgets() {
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-featured-hero.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-block-1.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-block-2.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-grid.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-list.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-videos.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-ticker.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-tabs.php';
		require_once MAGPRO_ELEMENTS_DIR . 'inc/widgets/class-widget-social.php';
	}

	/**
	 * Register Widgets (Modern Elementor)
	 */
	public function register_widgets( $widgets_manager ) {
		$this->include_widgets();

		$widgets_manager->register( new \MagPro_Widget_Featured_Hero() );
		$widgets_manager->register( new \MagPro_Widget_Block_1() );
		$widgets_manager->register( new \MagPro_Widget_Block_2() );
		$widgets_manager->register( new \MagPro_Widget_Grid() );
		$widgets_manager->register( new \MagPro_Widget_List() );
		$widgets_manager->register( new \MagPro_Widget_Videos() );
		$widgets_manager->register( new \MagPro_Widget_Ticker() );
		$widgets_manager->register( new \MagPro_Widget_Tabs() );
		$widgets_manager->register( new \MagPro_Widget_Social() );
	}

	/**
	 * Register Widgets (Legacy Elementor)
	 */
	public function register_widgets_legacy() {
		if ( class_exists( '\Elementor\Plugin' ) && method_exists( \Elementor\Plugin::instance()->widgets_manager, 'register_widget_type' ) ) {
			$this->include_widgets();

			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Featured_Hero() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Block_1() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Block_2() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Grid() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_List() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Videos() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Ticker() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Tabs() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \MagPro_Widget_Social() );
		}
	}
}

MagPro_Elementor_Loader::instance();

