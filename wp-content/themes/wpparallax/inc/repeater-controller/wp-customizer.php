<?php
/**
* wpparallax repeater customizer
*
* @package wpparallax
*/



/**
* Load scripts for repeater 
*/
  function wp_parallax_enqueue_repeater_scripts() {
    wp_enqueue_media();
    wp_enqueue_script( 'wpparallax-repeater-script', get_template_directory_uri() . '/inc/repeater-controller/repeater-script.js',array( 'jquery','jquery-ui-sortable','customize-controls'),'2230',true);
    wp_enqueue_script( 'color-repeater-scriptsfa', get_template_directory_uri() . '/inc/repeater-controller/spectrum/spectrum.js');
    wp_enqueue_style('color-repeater-style', get_template_directory_uri() . '/inc/repeater-controller/spectrum/spectrum.css');
    wp_enqueue_style('wpparallax-repeater-style',get_template_directory_uri() . '/inc/repeater-controller/repeater-style.css');
} add_action( 'admin_enqueue_scripts', 'wp_parallax_enqueue_repeater_scripts');

/**
* Repeater customizer
*/
add_action( 'customize_register', 'wp_parallax_repeaters_customize_register' );
function wp_parallax_repeaters_customize_register( $wp_customize ) {
    
    require get_template_directory().'/inc/repeater-controller/repeater-class.php';
    
    
    $wp_customize->add_section( 'wp_parallax_homepage_section', array(
                  'priority'     => 4,
                  'panel'        => 'wp_parallax_homepage_settings_panel',
                  'title'        => esc_html__('Homepage Section', 'wpparallax')
                ));

    $wp_customize->add_setting( 'wp_parallax_homepage', array(
	    'sanitize_callback' => 'wp_parallax_sanitize_repeater',
	    'default' => json_encode(
	     	array(
	         	array(
                    'wp_parallax_enable_section'=>'on',
                    'wp_parallax_menu_text'=>'',
                    'wp_parallax_page' => '',
                    'wp_parallax_show_title' => 'on',
                    'wp_parallax_layout'=>'default',
                    'wp_parallax_cat'=>'0',
                    'wp_parallax_bg_type'  =>'color',
                    'wp_parallax_bg_color' =>'#fff',
                    'wp_parallax_callto_text'=>esc_html__('Get now','wpparallax'),
                    'wp_parallax_callto_url'=>'',
                    'wp_parallax_bg_image'=>'',
                    'wp_parallax_bg_video'=>'',
                    'wp_parallax_section_txt_color'=>''
                    
	            )
	     	)
	    )
	));

	$wp_customize->add_control(  new wpparallax_Repeater_Controler( $wp_customize, 'wp_parallax_homepage', 
        array(
            'label'   => esc_html__('Homepage Options','wpparallax'),
            'section' => 'wp_parallax_homepage_section',
            'wpparallax_box_label' => esc_html__('Section : ','wpparallax'),
            'wpparallax_box_add_control' => esc_html__('Add Section','wpparallax'),
        ),
        	array(

            'wp_parallax_enable_section' => array(
                'type'        => 'switch',
                'label'       => esc_html__( 'Enable Section', 'wpparallax' ),
                'switch' => array(
                    'on' => esc_html__('Yes','wpparallax' ),
                    'off' => esc_html__('No','wpparallax' )
                    ),
                'default'     => 'on'
            ),  

            'wp_parallax_menu_text' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Menu Text', 'wpparallax' ),
                'default'     => '',
                'class'       => 'un-bottom-block-cat1'
            ),	

	        'wp_parallax_page' => array(
	            'type'        => 'page',
	            'label'       => esc_html__( 'Select Pages', 'wpparallax' ),
	            'default'     => '',
	            'class'       => 'un-bottom-block-pages'
	        ),

            'wp_parallax_show_title' => array(
                'type'        => 'switch',
                'label'       => esc_html__( 'Show Page Title', 'wpparallax' ),
                'switch' => array(
                    'on' => esc_html__('Yes','wpparallax' ),
                    'off' => esc_html__('No','wpparallax' )
                    ),
                'default'     => 'on'
            ), 

            'wp_parallax_layout' => array(
                'type'        => 'layouts',
                'label'       => esc_html__( 'Choose Layout', 'wpparallax' ),
                'default'     => 'default',
                'class'       => 'un-bottom-block-layout'
            ), 

            'wp_parallax_cat' => array(
                'type'        => 'category',
                'label'       => esc_html__( 'Choose Category', 'wpparallax' ),
                'default'     => '0',
                'class'       => ' wpop-layout block-cat',
                'style'       => ''
            ),

            'wp_parallax_callto_text' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Button Text', 'wpparallax' ),
                'default'     => esc_html__( 'Get now', 'wpparallax' ),
                'class'       => ' wpop-layout call-to',
                'style'       => 'display: none'
            ),  

           'wp_parallax_callto_url' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Button URL', 'wpparallax' ),
                'default'     => '',
                'class'       => ' wpop-layout call-to',
                'style'       => 'display: none'
            ),  
                'wp_parallax_bg_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Choose Background Type', 'wpparallax' ),
                'default'     => 'color',
                'options'     => array('video'=> esc_html__('Video', 'wpparallax'),
                                        'color'=> esc_html__('Color', 'wpparallax'),
                                        'image'=>  esc_html__('Image', 'wpparallax')),
                'class'       => 'un-bottom-block-bg-type'
            ),

                'wp_parallax_bg_image' => array(
                'type'        => 'upload',
                'label'       => esc_html__( 'Background Image', 'wpparallax' ),
                'default'     => '',
                'class'       => 'bg-type image',
                'style'       => 'display: none'
            ),

                'wp_parallax_bg_video' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Background Video', 'wpparallax' ),
                'description' => esc_html__('Enter video URL','wpparallax'),
                'default'     => '',
                'class'       => 'bg-type video',
                'style'       => 'display: none'
            ),                 

                'wp_parallax_bg_color' => array(
                'type'        => 'colorpicker',
                'label'       => esc_html__( 'Background Color', 'wpparallax' ),
                'default'     => '#fff',
                'class'       => 'bg-type color'
            ),

                'wp_parallax_section_txt_color' => array(
                'type'        => 'colorpicker',
                'label'       => esc_html__( 'Font Color', 'wpparallax' ),
                'default'     => '#404040',
                'class'       => 'txt-type color'
            ),
        )
	));
    
    
    
/**
* Repeater Sanitize
*/
        function wp_parallax_sanitize_repeater($input){      
            $input_decoded = json_decode( $input, true );
            $allowed_html = array(
                'br' => array(),
                'em' => array(),
                'strong' => array(),
                'a' => array(
                    'href' => array(),
                    'class' => array(),
                    'id' => array(),
                    'target' => array()
                ),
                'button' => array(
                    'class' => array(),
                    'id' => array()
                )
            );    

            if(!empty($input_decoded)) {
                foreach ($input_decoded as $boxes => $box ){
                    foreach ($box as $key => $value){
                        $input_decoded[$boxes][$key] = sanitize_text_field( $value );
                    }
                }
                return json_encode($input_decoded);
            }    
            return $input;
        }
    
}