<?php
/**
 * Initialize XPRESSION Importer
 */
$asp = 'add_'.'submenu_'.'page';

$settings      = array(
  'menu_parent' => 'themes.php',
  'menu_title'  => esc_html__('Wpop Demo Importer', 'wpparallax'),
  'menu_type'   => $asp,
  'menu_slug'   => 'wpop-import',
);

$opt_id = 'theme_mods_wpparallax';

/**
 * Front Page & Blog Page are page name strings. hence cannot be translated here
 */
$options        = array(

    'default' => array(
      'title'         => esc_html__('Default', 'wpparallax'),
      'preview_url'   => 'http://demo.wpoperation.com/wpparallax/default/',
      'front_page'    => 'Home', 
      'blog_page'     => 'Blog',
      'menus'         => array(
          'menu-1' => esc_html__( 'Menu 1', 'wpparallax' ),
      ),
      'revslider'     => false,
    ),

    'education' => array(
      'title'         => esc_html__('Education', 'wpparallax'),
      'preview_url'   => 'http://demo.wpoperation.com/wpparallax/education/',
      'front_page'    => 'Home', 
      'blog_page'     => 'Blog',
      'menus'         => array(
          'menu-1' => esc_html__( 'Menu 1', 'wpparallax' ),
      ),
      'revslider'     => false,
    ),

    'medical' => array(
      'title'         => esc_html__('Medical', 'wpparallax'),
      'preview_url'   => 'http://demo.wpoperation.com/wpparallax/medical/',
      'front_page'    => 'Home', 
      'blog_page'     => 'Blog',
      'menus'         => array(
          'menu-1' => esc_html__( 'Menu 1', 'wpparallax' ),
      ),
      'revslider'     => false,
    ),

    'construction' => array(
      'title'         => esc_html__('Construction', 'wpparallax'),
      'preview_url'   => 'http://demo.wpoperation.com/wpparallax/construction/',
      'front_page'    => 'Home', 
      'blog_page'     => 'Blog',
      'menus'         => array(
          'menu-1' => esc_html__( 'Menu 1', 'wpparallax' ),
      ),
      'revslider'     => false,
    ),

    'restaurant' => array(
      'title'         => esc_html__('Restaurant', 'wpparallax'),
      'preview_url'   => 'http://demo.wpoperation.com/wpparallax/restaurant/',
      'front_page'    => 'Home', 
      'blog_page'     => 'Blog',
      'menus'         => array(
          'menu-1' => esc_html__( 'Main Menu', 'wpparallax' ),
      ),
      'revslider'     => false,
    ),

    'business' => array(
      'title'         => esc_html__('Business', 'wpparallax'),
      'preview_url'   => 'http://demo.wpoperation.com/wpparallax/business/',
      'front_page'    => 'Home', 
      'blog_page'     => 'Blog',
      'menus'         => array(
          'menu-1' => esc_html__( 'Menu 1', 'wpparallax' ),
      ),
      'revslider'     => false,
    ),
);

if( class_exists( 'Wpop_Demo_Importer' ) ) {
    Wpop_Demo_Importer::instance( $settings, $options, $opt_id );
}


