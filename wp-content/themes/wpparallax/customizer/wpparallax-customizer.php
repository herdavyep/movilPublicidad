<?php
 get_template_part('inc/repeater-controller/wp','customizer');

function wp_parallax_custom_customize_register( $wp_customize ) {

 /* Option list of all post */
  $wpparallax_options_posts = array();
  $wpparallax_options_posts_obj = get_posts('posts_per_page=-1');
  $wpparallax_options_posts[''] = esc_html__( 'Choose Post', 'wpparallax' );
  foreach ( $wpparallax_options_posts_obj as $wpparallax_posts ) {
      $wpparallax_options_posts[$wpparallax_posts->ID] = $wpparallax_posts->post_title;
  }

 /* Option list of all categories */
  $wpparallax_args = array(
     'type'                     => 'post',
     'orderby'                  => 'name',
     'taxonomy'                 => 'category'
  );
  $wpparallax_option_categories = array();
  $wpparallax_category_lists = get_categories( $wpparallax_args );
  $wpparallax_option_categories[''] = esc_html__( 'Choose Category', 'wpparallax' );
  foreach( $wpparallax_category_lists as $wpparallax_category ){
      $wpparallax_option_categories[$wpparallax_category->term_id] = $wpparallax_category->name;
  }

    /**
     * Add General Settings panel
     */

    $wp_customize->add_panel( 'general_settings', array(
        'priority'         =>      1,
        'capability'       =>      'edit_theme_options',
        'theme_supports'   =>      '',
        'title'            =>      esc_html__( 'General Settings', 'wpparallax' ),
        'description'      =>      esc_html__( 'This allows to edit general theme settings', 'wpparallax' ),
    ));

    $wp_customize->get_section('title_tagline')->panel = 'general_settings';
    $wp_customize->remove_section('header_image');
    $wp_customize->get_section('background_image')->panel = 'general_settings';
    $wp_customize->get_section('static_front_page')->panel = 'general_settings';
    $wp_customize->get_section('colors')->panel = 'general_settings'; 

    /* Color Option */

    $wp_customize->add_setting(
        'wp_parallax_theme_color', array(
            'default' => '#017bbd',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'wp_parallax_theme_color', 
            array(
            'label' => esc_html__('Theme Color','wpparallax'), 
            'section' => 'colors',
            'settings' => 'wp_parallax_theme_color',
            'priority' => 1
            )
        )
    );

    /* Animation Option */

    $wp_customize->add_section( 'wp_parallax_animation_section', array(
        'title'           =>      esc_html__('Homepage Aniation', 'wpparallax'),
        'priority'        =>      35,
        'panel'           => 'general_settings'
    ));

    $wp_customize->add_setting( 'wp_parallax_wow_animation_option', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_wow_animation_option',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable/Disable Animation', 'wpparallax' ),
      'section'   => 'wp_parallax_animation_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'wpparallax' ),
            'hide'  => esc_html__( 'Disable', 'wpparallax' )
          ),
      'priority'  => 1
    ) ) );  

    $wp_customize->add_setting( 'wp_parallax_smooth_scroll_option', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_smooth_scroll_option',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable/Disable Smooth Scroll', 'wpparallax' ),
      'section'   => 'wp_parallax_animation_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'wpparallax' ),
            'hide'  => esc_html__( 'Disable', 'wpparallax' )
          ),
      'priority'  => 2
    ) ) );     

    /*===========================================================================================================
     * Header Pannel
    */

    $wp_customize->add_panel(
        'wp_parallax_header_settings_panel', 
            array(
                'priority'       => 2,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => esc_html__( 'Header Settings', 'wpparallax' ),
            ) 
    );

    /* Header Layouts */

    $wp_customize->add_section( 'wp_parallax_header_layouts_section', array(
        'title'           =>     esc_html__('Header Layouts', 'wpparallax'),
        'priority'        =>      '1',
        'panel'           => 'wp_parallax_header_settings_panel'
    ));

    $wp_customize->add_setting( 'wp_parallax_header_layouts', array(
      'capability' => 'edit_theme_options',
      'default' => 'layout1',
      'sanitize_callback' => 'wp_parallax_sanitize_radio',
    ) );

    $wp_customize->add_control(
        'wp_parallax_header_layouts',
        array(
            'type'      => 'radio',
            'choices'   => array(
                              'layout1' => esc_html__('Layout One','wpparallax'),
                              'layout2' => esc_html__('Layout Two','wpparallax'),
                              'layout3' => esc_html__('Layout Three','wpparallax'),
                           ),
            'label'     => esc_html__( 'Choose Header Layouts', 'wpparallax' ),
            'section'   => 'wp_parallax_header_layouts_section',
            'priority'  => 1
        )
    ); 

    /* Top header */

    $wp_customize->add_section( 'wp_parallax_top_header_section', array(
        'title'           =>     esc_html__('Top Header settings', 'wpparallax'),
        'priority'        =>      '1',
        'panel'           => 'wp_parallax_header_settings_panel'
    ));

    $wp_customize->add_setting( 'wp_parallax_top_header_show', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
      'transport' => 'postMessage'
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_top_header_show',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hide / Show Top header', 'wpparallax' ),
      'section'   => 'wp_parallax_top_header_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'wpparallax' ),
            'hide'  => esc_html__( 'Hide', 'wpparallax' )
          ),
      'priority'  => 1
    ) ) ); 

    $wp_customize->selective_refresh->add_partial( 'wp_parallax_top_header_show', array(
      'selector'        => '.top-header',
      'container_inclusive' => true,
      'render_callback' => 'wp_parallax_top_header',
    ) );  
   /* Header info */

    $wp_customize->add_setting( 'wp_parallax_info_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Wp_Customize_Seperator_Control( $wp_customize, 'wp_parallax_info_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Header Info', 'wpparallax' ),
      'section'   => 'wp_parallax_top_header_section',
      'priority'  => 2
    ) ) );   

    $wp_customize->add_setting(
        'wp_parallax_header_contact', 
        array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'wp_parallax_sanitize_text'                   
        )
    );    
    $wp_customize->add_control(
        'wp_parallax_header_contact',
        array(
            'type'      => 'text',
            'label'     => esc_html__( 'Contact no.', 'wpparallax' ),
            'section'   => 'wp_parallax_top_header_section',
            'priority'  => 3
        )
    );  

   $wp_customize->selective_refresh->add_partial( 'wp_parallax_header_contact', array(
      'selector'        => '.header-info',
      'container_inclusive' => true,
      'render_callback' => 'wp_parallax_header_info',
    ) );    

    $wp_customize->add_setting(
        'wp_parallax_header_email', 
        array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'wp_parallax_sanitize_text'                   
        )
    );    
    $wp_customize->add_control(
        'wp_parallax_header_email',
        array(
            'type'      => 'text',
            'label'     => esc_html__( 'Email Address', 'wpparallax' ),
            'section'   => 'wp_parallax_top_header_section',
            'priority'  => 4
        )
    ); 

   $wp_customize->selective_refresh->add_partial( 'wp_parallax_header_email', array(
      'selector'        => '.header-info',
      'container_inclusive' => true,
      'render_callback' => 'wp_parallax_header_info',
    ) );  

    /* social Icons */

    $wp_customize->add_setting( 'wp_parallax_social_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Wp_Customize_Seperator_Control( $wp_customize, 'wp_parallax_social_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Social Icons Settings', 'wpparallax' ),
      'section'   => 'wp_parallax_top_header_section',
      'priority'  => 5
    ) ) ); 

    $socials = array('Facebook','Twitter','Instagram','Pinterest');
    foreach($socials as $social){

    $wp_customize->add_setting('wp_parallax_'.$social,
            array(
              'default' => '',
              'sanitize_callback' => 'esc_url_raw',
              'transport'=>'postMessage'
              )
            );

    $wp_customize->add_control( 'wp_parallax_'.$social,
        array(
            'label'  => sprintf(esc_html__(' %s', 'wpparallax' ),$social),
            'description'=>sprintf(esc_html__( 'Enter URL for %s', 'wpparallax' ),$social),
            'section' => 'wp_parallax_top_header_section',
            'type' => 'url',
            'priority'=> 6
        )
    ); 

   $wp_customize->selective_refresh->add_partial( 'wp_parallax_'.$social, array(
      'selector'        => '.header-icons',
      'container_inclusive' => true,
      'render_callback' => 'wpparallax_social_icons',
    ) ); 

    }//end foreach;

    /* Bottom header */

    $wp_customize->add_section( 'wp_parallax_bottom_header_section', array(
        'title'           =>      esc_html__('Bottom Header Settings', 'wpparallax'),
        'priority'        =>      '2',
        'panel'           => 'wp_parallax_header_settings_panel'
    ));

    $wp_customize->add_setting( 'wp_parallax_menu_type', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
      'transport' => 'postMessage'
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_menu_type',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Choose Menu Layout', 'wpparallax' ),
      'section'   => 'wp_parallax_bottom_header_section',
      'choices'   => array(
            'show'  => esc_html__( 'Primary', 'wpparallax' ),
            'hide'  => esc_html__( 'Parallax', 'wpparallax' )
          ),
      'priority'  => 1
    ) ) ); 

   $wp_customize->selective_refresh->add_partial( 'wp_parallax_menu_type', array(
      'selector'        => '.main-navigation',
      'container_inclusive' => true,
      'render_callback' => 'wp_parallax_nav',
    ) ); 

    $wp_customize->add_setting( 'wp_parallax_sticky_menu', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_sticky_menu',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Sticky Menu', 'wpparallax' ),
      'section'   => 'wp_parallax_bottom_header_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'wpparallax' ),
            'hide'  => esc_html__( 'Disable', 'wpparallax' )
          ),
      'priority'  => 2
    ) ) ); 

    $wp_customize->add_setting( 'wp_parallax_search_enable', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
      'transport' => 'postMessage'
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_search_enable',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Search Icon', 'wpparallax' ),
      'section'   => 'wp_parallax_bottom_header_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'wpparallax' ),
            'hide'  => esc_html__( 'Hide', 'wpparallax' )
          ),
      'priority'  => 3
    ) ) ); 

    if(class_exists('woocommerce')){    
    $wp_customize->add_setting( 'wp_parallax_cart_enable', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
      'transport' => 'postMessage'
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_cart_enable',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Cart Icon', 'wpparallax' ),
      'section'   => 'wp_parallax_bottom_header_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'wpparallax' ),
            'hide'  => esc_html__( 'Hide', 'wpparallax' )
          ),
      'priority'  => 4
    ) ) );  
    }
    /*===========================================================================================================
     * Homepage Pannel
    */

    $wp_customize->add_panel(
        'wp_parallax_homepage_settings_panel', 
            array(
                'priority'       => 2,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => esc_html__( 'Homepage Settings', 'wpparallax' ),
            ) 
    );

    /* Slider Section */   

    $wp_customize->add_section( 'wp_parallax_slider_section', array(
        'title'           =>      esc_html__('Slider settings', 'wpparallax'),
        'priority'        =>      '1',
        'panel'           => 'wp_parallax_homepage_settings_panel'
    ));

    $wp_customize->add_setting( 'wp_parallax_slider_show', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
    ) );
    
    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_slider_show',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hide/Show Slider', 'wpparallax' ),
      'section'   => 'wp_parallax_slider_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'wpparallax' ),
            'hide'  => esc_html__( 'Hide', 'wpparallax' )
          ),
      'priority'  => 1
    ) ) );  

     $wp_customize->add_setting('wp_parallax_slider_cat',array(
         'default' => 0,
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'wp_parallax_sanitize_number',
         )
      );

    $wp_customize->add_control( 'wp_parallax_slider_cat',
         array(
             'label'  => esc_html__( 'Choose Category for slider ', 'wpparallax' ),
             'description'=> esc_html__('Choose the category of posts for homepage slider','wpparallax'),
             'section' => 'wp_parallax_slider_section',
             'type' => 'select',
             'choices' => $wpparallax_option_categories
         )
    ); 
       
    /*------------sidebar settings---------------------------------*/

    //Archive page sidebars
    $wp_customize->add_panel(
     'wp_parallax_archive_settings',
      array(
         'priority' => 32,
         'capability' => 'edit_theme_options',
         'theme_supports' => '',
         'title' => esc_html__( 'Archive Page Settings', 'wpparallax' ),
      )
    ); 
    $wp_customize -> add_section(
          'wp_parallax_archive_page_options',
          array(
              'title' => esc_html__('Archive Page settings','wpparallax'),
              'priority' => 30,
              'panel' => 'wp_parallax_archive_settings'
          ));

    $wp_customize->add_setting(
          'archive_page_sidebars_layout', array(
              'default'       =>      'rightsidebar',
              'sanitize_callback' => 'wp_parallax_sanitize_radio'
              ));

    $imagepath =  get_template_directory_uri() . '/assets/images/';  

    $wp_customize->add_control( new WP_Customize_Radioimage_Control(
          $wp_customize,
          'archive_page_sidebars_layout',
          array(
              'section'       =>      'wp_parallax_archive_page_options',
              'label'         =>      esc_html__('Archive Page Sidebar Option', 'wpparallax'),
              'type'          =>      'radioimage',
              'choices'       =>      array( 
                'leftsidebar' => esc_url($imagepath).'left-sidebar.png',  
                'rightsidebar' => esc_url($imagepath).'right-sidebar.png', 
                'bothsidebar' => esc_url($imagepath).'both-sidebar.png',
                'nosidebar' => esc_url($imagepath).'no-sidebar.png',
                ))));

    $wp_customize->add_setting(
          'wp_parallax_archive_page_excerpts', array(
              'default'       =>      400,
              'sanitize_callback' => 'absint'
              ));
    $wp_customize -> add_control(
          'wp_parallax_archive_page_excerpts',
          array(
              'label' => esc_html__('Archive Post Excerpt Length', 'wpparallax'),
              'description'=> esc_html__('<strong>Note:</strong> This will not change first post length','wpparallax'),
              'section' => 'wp_parallax_archive_page_options',
              'type' => 'number',
              ));  

  /**
  *Breadcrumb settings................................................................................................
  */
    $wp_customize->add_panel(
       'wp_parallax_breadcrumb_settings',
        array(
           'priority' => 40,
           'capability' => 'edit_theme_options',
           'theme_supports' => '',
           'title' => esc_html__( 'Breadcrumb Settings', 'wpparallax' ),
       )
    ); 
    $wp_customize->add_section(
       'wp_parallax_breadcrumb',
       array(
           'title' => esc_html__( 'Breadcrumb', 'wpparallax' ),
           'priority' => 30,
           'panel' => 'wp_parallax_breadcrumb_settings'
       )
    );

    $wp_customize->add_setting( 'wp_parallax_breadcrumb_section_option', array(
        'default' => 'show',
        'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Wp_customize_Switch_Control( $wp_customize, 'wp_parallax_breadcrumb_section_option',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Enable / Disable Option', 'wpparallax' ),
        'section'   => 'wp_parallax_breadcrumb',
        'priority'  => 1,
        'choices'   => array(
              'show'  => esc_html__( 'Enable', 'wpparallax' ),
              'hide'  => esc_html__( 'Disable', 'wpparallax' )
            )
    ) ) );   
    $wp_customize->add_setting(
      'wp_parallax_breadcrumb_image',
      array(
          'default' => '',
          'sanitize_callback'=>'esc_url_raw'
          )
    );
    $wp_customize->add_control(
     new wp_customize_Image_Control(
         $wp_customize,
         'wp_parallax_breadcrumb_image',
         array(
             'label'      => esc_html__( 'Post/page Breadcrumb Image', 'wpparallax' ),
             'description'=> esc_html__('suggested dimensions for Breadcrumb:1920x325','wpparallax'),
             'section'    => 'wp_parallax_breadcrumb',
             'settings'   => 'wp_parallax_breadcrumb_image',
             'priority' => 2,
         )
      )
    ); 
    /*===========================================================================================================
     * Footer Pannel
    */

    $wp_customize->add_panel(
        'wp_parallax_footer_settings_panel', 
            array(
                'priority'       => 40,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => esc_html__( 'Footer Settings', 'wpparallax' ),
            ) 
    );

    $wp_customize->add_section( 'wp_parallax_footer_section', array(
        'title'           =>     esc_html__('Footer Section', 'wpparallax'),
        'priority'        =>      '1',
        'panel'           => 'wp_parallax_footer_settings_panel'
    ));

    $wp_customize->add_setting( 'wp_parallax_footer_icon_show', array(
      'default' => 'show',
      'sanitize_callback' => 'wp_parallax_sanitize_switch_option',
      'transport' => 'postMessage'
    ) );

    $wp_customize->add_control( new Wp_Customize_Switch_Control( $wp_customize, 'wp_parallax_footer_icon_show',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hide / Show social icon', 'wpparallax' ),
      'section'   => 'wp_parallax_footer_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'wpparallax' ),
            'hide'  => esc_html__( 'Hide', 'wpparallax' )
          ),
      'priority'  => 1
    ) ) );  

    $wp_customize->add_setting(
        'wp_parallax_footer_text', 
        array(
            'default'   => '',
            'transport' => 'postMessage',
            'sanitize_callback' => 'wp_kses_post'                   
        )
    );    
    $wp_customize->add_control(
        'wp_parallax_footer_text',
        array(
            'type'      => 'textarea',
            'label'     => esc_html__( 'Copyright Text', 'wpparallax' ),
            'section'   => 'wp_parallax_footer_section',
            'priority'  => 4
        )
    ); 
    $wp_customize->selective_refresh->add_partial( 'wp_parallax_footer_text', array(
      'selector'        => '.footer-left',
      'render_callback' => 'wp_parallax_footer_info',
    ) );       
}
add_action( 'customize_register', 'wp_parallax_custom_customize_register' );