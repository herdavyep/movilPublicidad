<?php

/**
 * Enqueue scripts and styles.
 */
function wp_parallax_scripts() {
	wp_enqueue_style('font-awesome-css',get_template_directory_uri().'/assets/ext/css/font-awesome.min.css');
	wp_enqueue_style('owl-carousel-v2',get_template_directory_uri().'/assets/ext/lightslider/lightslider.css');
	wp_enqueue_style( 'prettyPhoto-style', get_template_directory_uri() .'/assets/ext/prettyphoto/prettyPhoto.css', array(), '3.1.6' );
    wp_enqueue_style( 'animate-css', get_template_directory_uri() .'/assets/css/animate.css', array(), '3.5.1' );
    /** Enqueue Google Fonts **/
    $create = _x( 'on', 'Create Round Font: on or off', 'wpparallax' );
    $open_sans = _x( 'on', 'Open Sans font: on or off', 'wpparallax' );
    $raleway = _x( 'on', 'Raleway font: on or off', 'wpparallax' );
	if ( 'off' !== $create || 'off' !== $open_sans ||  'off' !== $raleway) {
		$font_families = array();
		if ( 'off' !== $create ) {
			$font_families[] = 'Crete+Round:400,400i';
		} 
		if ( 'off' !== $open_sans ) {
			$font_families[] = 'Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i';
		}		
		if ( 'off' !== $raleway ) {
			$font_families[] = 'Raleway:300,400,500,700';
		}
		$wp_parallax_font_query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		wp_enqueue_style('google-fonts', add_query_arg($wp_parallax_font_query_args, "//fonts.googleapis.com/css"));
	}
	wp_enqueue_style( 'wpparallax-style', get_stylesheet_uri() );
    wp_enqueue_style( 'responsive-css', get_template_directory_uri() .'/assets/css/responsive.css', array(), '1.0' );

	/* Scripts */

	wp_enqueue_script( 'wpparallax-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
    $wow = get_theme_mod('wp_parallax_wow_animation_option','show');
    $smoothscroll = get_theme_mod('wp_parallax_smooth_scroll_option','show');
    if($wow == 'show'){
    wp_enqueue_script( 'wow', get_template_directory_uri() .'/assets/js/wow.js', array( 'jquery' ), '1.1.2', true );
    }
    if($smoothscroll == 'show'){
    wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() .'/assets/ext/smoothscroll/SmoothScroll.min.js', array( 'jquery' ), '1.1.2', true );
    }
    wp_enqueue_script( 'light-slider', get_template_directory_uri() . '/assets/ext/lightslider/lightslider.js', array('jquery'), '2.2.1', true );
    wp_enqueue_script( 'jquery-prettyphoto', get_template_directory_uri() .'/assets/ext/prettyphoto/jquery.prettyPhoto.js', array( 'jquery' ), '3.1.6', true );
	wp_enqueue_script( 'wpparallax-parallax-bg', get_template_directory_uri() . '/assets/js/jarallax/jarallax.js', array(), '20151215', true );
	wp_enqueue_script( 'wpparallax-jquery-nav', get_template_directory_uri() . '/assets/js/jquery.nav.js', array('jquery'), '1.2.1', true );
	wp_enqueue_script( 'wpparallax-jquery-sticky', get_template_directory_uri() . '/assets/js/jquery.sticky.js',array('jquery'), '2015125', true);
	wp_enqueue_script( 'wpparallax-parallax-element', get_template_directory_uri() . '/assets/js/jarallax/jarallax-element.js', array(), '20151215', true );
	wp_enqueue_script( 'wpparallax-parallax-video', get_template_directory_uri() . '/assets/js/jarallax/jarallax-video.js', array(), '20151215', true );
	wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri(). '/assets/ext/isotope/isotope.pkgd.js',array('jquery'));
    wp_enqueue_script( 'packery-mode-pkgd', get_template_directory_uri(). '/assets/ext/isotope/packery-mode.pkgd.js',array('jquery'));
	wp_enqueue_script( 'wpparallax-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_register_script( 'wpparallax-common-script', get_template_directory_uri() . '/assets/js/wpparallax-common.js', array('jquery','imagesloaded','masonry'), '20151215', true );

	/**
     * wp localize
    */
    $sticky = get_theme_mod('wp_parallax_sticky_menu','show');
    wp_localize_script( 'wpparallax-common-script', 'wpparallax_option', array(
        'mode'=> esc_html($wow),
        'is_sticky' => $sticky,
        ) );

    wp_enqueue_script('wpparallax-common-script');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_parallax_scripts' );


//admin scripts
function wp_parallax_admin_scripts() {
    if ( function_exists( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_register_script( 'of-media-uploader', get_template_directory_uri() . '/assets/js/media-uploader.js', array('jquery'), 1.70);
    wp_enqueue_script( 'of-media-uploader' );
    wp_localize_script( 'of-media-uploader', 'wpparallax_l10n', array(
        'upload' => esc_html__( 'Upload', 'wpparallax' ),
        'remove' => esc_html__( 'Remove', 'wpparallax' )
        ));	
	wp_enqueue_style( 'wp-color-picker' );        
    wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wpparallax-admin-styles', get_template_directory_uri() . '/assets/admin/css/admin.css');
	wp_enqueue_script( 'wpparallax-admin-scripts', get_template_directory_uri() . '/assets/admin/js/admin.js', array('jquery','jquery-ui-datepicker','customize-controls'), '2230', true );
		

}
add_action( 'admin_enqueue_scripts', 'wp_parallax_admin_scripts' );