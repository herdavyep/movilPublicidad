<?php

/**
 * Page and Post Page Display Layout Metabox function
*/ 
add_action('add_meta_boxes', 'wp_parallax_metabox_section');

if ( ! function_exists( 'wp_parallax_metabox_section' ) ) {
	
    function wp_parallax_metabox_section(){   
        add_meta_box('wp_parallax_display_layout', 
            esc_html__( 'Display Layout Options', 'wpparallax' ), 
            'wp_parallax_display_layout_callback', 
            array('page','post'), 
            'normal', 
            'high'
        );
        add_meta_box('wp_parallax_page_layout', 
            esc_html__( 'Choose Page Layout', 'wpparallax' ), 
            'wp_parallax_page_layout_callback', 
            'page',
            'side' 
            
        );        
    }
}

$wp_parallax_page_layouts =array(

    'leftsidebar' => array(
        'value'     => 'leftsidebar',
        'label'     => esc_html__( 'Left Sidebar', 'wpparallax' ),
        'thumbnail' => esc_url(get_template_directory_uri()) . '/assets/images/left-sidebar.png',
    ),
    'rightsidebar' => array(
        'value'     => 'rightsidebar',
        'label'     => esc_html__( 'Right Sidebar(Default)', 'wpparallax' ),
        'thumbnail' => esc_url(get_template_directory_uri()) . '/assets/images/right-sidebar.png',
    ),
     'nosidebar' => array(
        'value'     => 'nosidebar',
        'label'     => esc_html__( 'Full width', 'wpparallax' ),
        'thumbnail' => esc_url(get_template_directory_uri()) . '/assets/images/no-sidebar.png',
    ),
    'bothsidebar' => array(
        'value'     => 'bothsidebar',
        'label'     => esc_html__( 'Both Sidebar', 'wpparallax' ),
        'thumbnail' => esc_url(get_template_directory_uri()) . '/assets/images/both-sidebar.png',
    )
);

$wpparallax_page_options=array(
    'default_layout'=> esc_html__( 'Default Layout', 'wpparallax' ),
    'wpparallax_layout'=> esc_html__( 'Wpparallax Layout', 'wpparallax' ),
);

/**
 * Function for Page layout meta box
*/

if ( ! function_exists( 'wp_parallax_display_layout_callback' ) ) {
    function wp_parallax_display_layout_callback(){
        global $post, $wp_parallax_page_layouts;
        wp_nonce_field( basename( __FILE__ ), 'wp_parallax_settings_nonce' );
    ?>
        <table class="form-table">
            <tr>
              <td>            
                <?php
                  $i = 0;  
                  foreach ($wp_parallax_page_layouts as $field) {  
                  $wpparallax_page_metalayouts = esc_attr( get_post_meta( $post->ID, 'wpparallax_page_layouts', true ) ); 
                ?>            
                  <div class="radio-image-wrapper slidercat" id="slider-<?php echo intval($i); ?>" style="float:left; margin-right:30px;">
                    <label class="description">
                        <span>
                          <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" />
                        </span></br>
                        <input type="radio" name="wpparallax_page_layouts" value="<?php echo esc_html( $field['value'] ); ?>" <?php checked( esc_html( $field['value'] ), 
                            $wpparallax_page_metalayouts ); if(empty($wpparallax_page_metalayouts) && esc_html( $field['value'] )=='rightsidebar'){ echo "checked='checked'";  } ?>/>
                         <?php echo esc_html( $field['label'] ); ?>
                    </label>
                  </div>
                <?php  $i++; }  ?>
              </td>
            </tr>            
        </table>
    <?php
    }
}

/**
 * Save the custom metabox data
 */
 
if ( ! function_exists( 'wp_parallax_save_page_settings' ) ) {
    function wp_parallax_save_page_settings( $post_id ) { 
        global $wp_parallax_page_layouts, $post; 
        if ( !isset( $_POST[ 'wp_parallax_settings_nonce' ] ) || !wp_verify_nonce( $_POST[ 'wp_parallax_settings_nonce' ], basename( __FILE__ ) ) )  // Input var okay.
            return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
            return;        
        if ('page' == $_POST['post_type']) {  
            if (!current_user_can( 'edit_page', $post_id ) )  
                return $post_id;  
        } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
                return $post_id;  
        }    
        foreach ($wp_parallax_page_layouts as $field) {  
            $old = esc_attr( get_post_meta( $post_id, 'wpparallax_page_layouts', true) ); 
            $new = sanitize_text_field($_POST['wpparallax_page_layouts']); // Input var okay.
            if ($new && $new != $old) {  
                update_post_meta($post_id, 'wpparallax_page_layouts', $new);  
            } elseif ('' == $new && $old) {  
                delete_post_meta($post_id,'wpparallax_page_layouts', $old);  
            } 
         } 
    }
}
add_action('save_post', 'wp_parallax_save_page_settings');

/**
 * Function for wpparallax layout
*/

if ( ! function_exists( 'wp_parallax_page_layout_callback' ) ) {
    function wp_parallax_page_layout_callback(){
        global $post, $wpparallax_page_options;
        wp_nonce_field( basename( __FILE__ ), 'wp_parallax_settings_nonce' ); 
        ?>
        <div class="wpparallax-layout">
        <select name="wpparallax_page_options">
        <?php
      foreach ($wpparallax_page_options as $val=>$field) {  
      $wp_parallax_page_layout_option = esc_attr( get_post_meta( $post->ID, 'wpparallax_page_options', true ) ); 
       ?>            
        <option value="<?php echo esc_html( $val); ?>" <?php selected( esc_html( $val ), 
                            $wp_parallax_page_layout_option ); if(empty($wp_parallax_page_layout_option) && esc_html( $val )=='default_layout'){ echo "selected='selected'";  } ?>><?php echo esc_attr($field);?></option>
         
        <?php
        }
        ?>
      </select>
      </div>
      <?php
    }
}

/**
 * Save layout meta
 */
 
if ( ! function_exists( 'wp_parallax_save_page_layouts' ) ) {
    function wp_parallax_save_page_layouts( $post_id ) { 
        global $wpparallax_page_options, $post; 
        if ( !isset( $_POST[ 'wp_parallax_settings_nonce' ] ) || !wp_verify_nonce( $_POST[ 'wp_parallax_settings_nonce' ], basename( __FILE__ ) ) ) // Input var okay.
            return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
            return;        
        if ('page' == $_POST['post_type']) {  
            if (!current_user_can( 'edit_page', $post_id ) )  
                return $post_id;  
        } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
                return $post_id;  
        }    
        foreach ($wpparallax_page_options as $field) {  
            $old = esc_attr( get_post_meta( $post_id, 'wpparallax_page_options', true) ); 
            $new = sanitize_text_field($_POST['wpparallax_page_options']); // Input var okay.
            if ($new && $new != $old) {  
                update_post_meta($post_id, 'wpparallax_page_options', $new);  
            } elseif ('' == $new && $old) {  
                delete_post_meta($post_id,'wpparallax_page_options', $old);  
            } 
         } 
    }
}
add_action('save_post', 'wp_parallax_save_page_layouts');