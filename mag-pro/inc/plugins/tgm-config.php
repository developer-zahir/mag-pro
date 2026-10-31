<?php
/**
 * TGM Plugin Activation configuration for Mag Pro.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'magpro_register_required_plugins' );

/**
 * Register required and recommended plugins.
 */
function magpro_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Mag Pro Elements',
			'slug'               => 'mag-pro-elements',
			'source'             => get_template_directory() . '/inc/plugins/mag-pro-elements.zip',
			'required'           => true,
			'version'            => '2.0.0',
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'     => 'Elementor Website Builder',
			'slug'     => 'elementor',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'mag-pro',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
