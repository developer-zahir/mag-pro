<?php
/**
 * Plugin installation and activation for Mag Pro theme.
 *
 * @package Mag Pro
 * @author  Developer Zahir
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'magpro_register_required_plugins' );

/**
 * Register the required plugins for Mag Pro theme.
 */
function magpro_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'               => esc_html__( 'Mag Pro Elements', 'mag-pro' ),
			'slug'               => 'mag-pro-elements',
			'source'             => get_template_directory() . '/inc/plugins/mag-pro-elements.zip',
			'required'           => true,
			'version'            => '1.0.3',
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'     => esc_html__( 'Elementor Website Builder', 'mag-pro' ),
			'slug'     => 'elementor',
			'required' => true,
		),
	);

	/*
	 * Array of configuration settings.
	 */
	$config = array(
		'id'           => 'mag-pro',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => false,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}

