<?php
/**
 * Register widget area and call widget files
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package Wpparallax
 */

/**
 * ===========================================================================================================
 * Register Widgets Area
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_parallax_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar', 'wpparallax' ),
        'id'            => 'sidebar-right',
        'description'   => esc_html__( 'Add widgets here.', 'wpparallax' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Left Sidebar', 'wpparallax' ),
        'id'            => 'sidebar-left',
        'description'   => esc_html__( 'Add widgets here.', 'wpparallax' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Shop Sidebar', 'wpparallax' ),
        'id'            => 'sidebar-shop',
        'description'   => esc_html__( 'Add widgets here.', 'wpparallax' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    $footer_widget_regions = apply_filters( 'wp_parallax_footer_widget_regions', 4 );
    
    for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
        
        register_sidebar( array(
            'name'              => sprintf( esc_html__( 'Footer Widget Area %d', 'wpparallax' ), $i ),
            'id'                => sprintf( 'footer-%d', $i ),
            'description'       => sprintf( esc_html__( ' Add Widgetized Footer Region %d.', 'wpparallax' ), $i ),
            'before_widget'     => '<section id="%1$s" class="widget %2$s">',
            'after_widget'      => '</section>',
            'before_title'      => '<h4 class="widget-title"><span class="title-bg">',
            'after_title'       => '</span></h4>',
        ));
    }   
}
add_action( 'widgets_init', 'wp_parallax_widgets_init' );

/*===========================================================================================================*/
/**
 * Define categories in dropdown
 */
$wpparallax_categories = get_categories( array( 'hide_empty' => 0 ) );
foreach ( $wpparallax_categories as $wpparallax_category ) {
    $wpparallax_cat_array[$wpparallax_category->term_id] = $wpparallax_category->cat_name;
}
$wpparallax_cat_dropdown['0'] = esc_html__( 'Select Category', 'wpparallax' );
foreach ( $wpparallax_categories as $wpparallax_category ) {
    $wpparallax_cat_dropdown[$wpparallax_category->term_id] = $wpparallax_category->cat_name;
}

//dropdown pages
$wpparallax_pages = get_pages();
$wpparallax_page_dropdown['0'] = esc_html__( 'Select Page', 'wpparallax' );
foreach ( $wpparallax_pages as $wpparallax_page ) {
    $wpparallax_page_dropdown[$wpparallax_page->ID] = $wpparallax_page->post_title;
}


/**
 * Section layout
 */
$wpparallax_section_layout = array(
	'default' =>  esc_html__( 'Default Layout', 'wpparallax' ),
    'about' =>  esc_html__( 'About Layout', 'wpparallax' ),
    'service' =>  esc_html__( 'Service Layout', 'wpparallax' ),
    'portfolio'=> esc_html__('Portfolio Layout','wpparallax'),
    'testimonial'=> esc_html__('Testimonial Layout','wpparallax'),
    'team'=> esc_html__('Team Layout','wpparallax'),
    'blog'=> esc_html__('Blog Layout','wpparallax'),
    'callto'=> esc_html__('Call to Action','wpparallax'),
    'map'=> esc_html__('Google Map','wpparallax')    
    );

/**
 * Background layout
 */
$wpparallax_bg_layout = array(
	'color' =>  esc_html__( 'Color', 'wpparallax' ),
    'image' =>  esc_html__( 'Image', 'wpparallax' ),
    'video' =>  esc_html__( 'Video', 'wpparallax' ),
    );



/*--------------------------------------------------------------------------------------------------------*/
/**
 * Load individual widgets file and required related files too.
 */

 get_template_part('/inc/widgets/widget','fields'); // widget fields
 get_template_part('/inc/widgets/contact','info'); // contact info
 get_template_part('/inc/widgets/wpparallax','sections'); // homepage sections
