<?php

if( ! defined( 'ABSPATH' ) ) {
	exit; 	// exit if accessed directly
}

add_action( 'tgmpa_register', 'wpparallax_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */

function wpparallax_register_required_plugins() {	

	$plugins = array(
		/**
		 * Bundled Plugins
		 */

		// Wpop demo importer
		array(
			'name'	             => esc_html__( 'Operation Demo Importer', 'wpparallax' ),
			'slug'               => 'operation-demo-importer',
			'required'           => false,
			'version'            => '1.0.3'  
		),

		/**
		 * Plugins from WordPress repository
		 */

		// Contact form 7
		array(
			'name'      => esc_html__( 'Contact Form 7', 'wpparallax' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
			'verson'    => '5.0.1'
		),

		// Elementor Addons
		array(
			'name'      => esc_html__( 'Elementor Essential Addons', 'wpparallax' ),
			'slug'      => 'essential-addons-for-elementor-lite',
			'required'  => false,
			'verson'    => '2.4.2'
		),

		// Elementor
		array(
			'name'      => esc_html__( 'Elementor', 'wpparallax' ),
			'slug'      => 'elementor',
			'required'  => false,
			'version'   => '1.9.7'
		),

		// Woocommerce
		array(
			'name'      => esc_html__( 'Woocommerce', 'wpparallax' ),
			'slug'      => 'woocommerce',
			'required'  => false,
			'version'   => '3.2.3'
		),

		//page builder
		array(
			'name'      => esc_html__( 'Page Builder by SiteOrigin', 'wpparallax' ),
			'slug'      => 'siteorigin-panels',
			'required'  => false,
			'version'   => '2.6.3'
		),
		
	);

	// Settings for plugin installation screen
	$config = array(
		'id'           => 'tgmpa-wpparallax',
		'default_path' => '',
		'menu'         => 'wpparallax-install-plugins',
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

/* PHP Closing tag is omitted */