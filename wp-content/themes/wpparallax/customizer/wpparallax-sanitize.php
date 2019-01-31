<?php


//Text
function wp_parallax_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

// Number
function wp_parallax_sanitize_number( $input ) {
    $output = intval($input);
     return $output;
}

//Checkbox
function wp_parallax_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

// Number Float-val
function wp_parallax_floatval( $input ) {
    $output = floatval( $input );
     return $output;
}


//switch option
function wp_parallax_sanitize_switch_option( $input ) {
    $valid_keys = array(
            'show'  => esc_html__( 'Show', 'wpparallax' ),
            'hide'  => esc_html__( 'Hide', 'wpparallax' )
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

//breadcrumb sanitize
function wp_parallax_sanitize_breadcrumb($input){
    $all_tags = array(
        'a'=>array(
            'href'=>array()
        )
     );
    return wp_kses($input,$all_tags);
    
}

//radio box sanitization function
function wp_parallax_sanitize_radio( $input, $setting ){
 
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible radio box options 
    $choices = $setting->manager->get_control( $setting->id )->choices;
                     
    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
     
}