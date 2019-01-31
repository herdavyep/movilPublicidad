<?php
/**
 * Wpparallax Sections
 *
 * Widget to display Homepage sections.
 *
 * @package Wpparallax
 */

add_action( 'widgets_init', 'wp_parallax_register_parallax_sections_widget' );

function wp_parallax_register_parallax_sections_widget() {
    register_widget( 'wp_parallax_parallax_sections' );
}

class wp_parallax_parallax_sections extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'wp_parallax_homepage_sections',
            'description' => esc_html__( 'Display homepage sections with prebuilt layouts.', 'wpparallax' )
        );
        parent::__construct( 'wp_parallax_homepage_sections', esc_html__( 'Wpparallax Sections', 'wpparallax' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        global $wpparallax_page_dropdown, $wpparallax_section_layout, $wpparallax_cat_dropdown, $wpparallax_bg_layout;
        
        $fields = array(

            'section_enable' => array(
                'wpparallax_widgets_name' => 'section_enable',
                'wpparallax_widgets_title' => esc_html__( 'Hide / Show Section', 'wpparallax' ),
                'wpparallax_widgets_default'=>'show', 
                'wpparallax_widgets_field_options'=>array('show'=>'Show','hide'=>'Hide'),
                'wpparallax_widgets_field_type' => 'switch'
            ),   


            'wpparallax_page' => array(
                'wpparallax_widgets_name' => 'wpparallax_page',
                'wpparallax_widgets_title' => esc_html__( 'Choose Page', 'wpparallax' ),
                'wpparallax_widgets_default'      => 0,
                'wpparallax_widgets_field_type' => 'select',
                'wpparallax_widgets_field_options' => $wpparallax_page_dropdown,
                'wpparallax_widgets_class' => 'dropdown-pages'
            ), 

            'wpparallax_layout' => array(
                'wpparallax_widgets_name' => 'wpparallax_layout',
                'wpparallax_widgets_title' => esc_html__( 'Choose Layout', 'wpparallax' ),
                'wpparallax_widgets_default'      => 'default',
                'wpparallax_widgets_field_type' => 'select',
                'wpparallax_widgets_field_options' => $wpparallax_section_layout,
                'wpparallax_widgets_class' => 'dropdown-layout'
            ), 

            'wpparallax_cat' => array(
                'wpparallax_widgets_name' => 'wpparallax_cat',
                'wpparallax_widgets_title' => esc_html__( 'Choose Category', 'wpparallax' ),
                'wpparallax_widgets_default'      => 0,
                'wpparallax_widgets_field_type' => 'select',
                'wpparallax_widgets_field_options' => $wpparallax_cat_dropdown,
                'wpparallax_widgets_class' => 'dropdown-cat',
                'wpparallax_widgets_style' => 'display:none'
            ), 

            'wpparallax_callto_text' => array(
                'wpparallax_widgets_name'         => 'wpparallax_callto_text',
                'wpparallax_widgets_title'        => esc_html__( 'Enter Button text', 'wpparallax' ),
                'wpparallax_widgets_default'      => esc_html__('Join Now','wpparallax'),
                'wpparallax_widgets_field_type'   => 'text',
                'wpparallax_widgets_class'=> 'call-to',
                'wpparallax_widgets_style' => 'display:none'
            ), 

            'wpparallax_callto_url' => array(
                'wpparallax_widgets_name'         => 'wpparallax_callto_url',
                'wpparallax_widgets_title'        => esc_html__( 'Enter Button URL', 'wpparallax' ),
                'wpparallax_widgets_field_type'   => 'url',
                'wpparallax_widgets_class'=> 'call-to',
                'wpparallax_widgets_style' => 'display:none'
            ),

            'wpparallax_bg_type' => array(
                'wpparallax_widgets_name' => 'wpparallax_bg_type',
                'wpparallax_widgets_title' => esc_html__( 'Choose Background Type', 'wpparallax' ),
                'wpparallax_widgets_default'      => 'color',
                'wpparallax_widgets_field_type' => 'select',
                'wpparallax_widgets_field_options' => $wpparallax_bg_layout,
                'wpparallax_widgets_class'=> 'dropdown-bg',
            ), 

            'wpparallax_bg_color' => array(
                'wpparallax_widgets_name' => 'wpparallax_bg_color',
                'wpparallax_widgets_title' => esc_html__( 'Choose Color', 'wpparallax' ),
                'wpparallax_widgets_field_type' => 'color',
                'wpparallax_widgets_class' => 'bg-type color',
            ), 

            'wpparallax_bg_image' => array(
                'wpparallax_widgets_name' => 'wpparallax_bg_image',
                'wpparallax_widgets_title' => esc_html__( 'Choose Image', 'wpparallax' ),
                'wpparallax_widgets_field_type' => 'upload',
                'wpparallax_widgets_class'=> 'bg-type image',
                'wpparallax_widgets_style' => 'display:none'
            ), 

            'wpparallax_bg_video' => array(
                'wpparallax_widgets_name'         => 'wpparallax_bg_video',
                'wpparallax_widgets_title'        => esc_html__( 'Enter video URL', 'wpparallax' ),
                'wpparallax_widgets_field_type'   => 'text',
                'wpparallax_widgets_class'=> 'bg-type video',
                'wpparallax_widgets_style' => 'display:none'
            ),         
                        
        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }
        $section_enable  =  empty( $instance['section_enable'] ) ? 'show' : $instance['section_enable'];
        $page_id   = empty( $instance['wpparallax_page'] ) ? '' : $instance['wpparallax_page'];
        $wpparallax_layout = empty( $instance['wpparallax_layout'] ) ? 'default' : $instance['wpparallax_layout'];
        $cat_id = empty( $instance['wpparallax_cat'] ) ? 0 : $instance['wpparallax_cat'];
        $callto_text = empty( $instance['wpparallax_callto_text'] ) ? 'Join Now' : $instance['wpparallax_callto_text'];
        $callto_link =  empty( $instance['wpparallax_callto_url'] ) ? '' : $instance['wpparallax_callto_url'];
        $bg_type = empty( $instance['wpparallax_bg_type'] ) ? 0 : $instance['wpparallax_bg_type'];
        $bg_color = empty( $instance['wpparallax_bg_color'] ) ? '#fff' : $instance['wpparallax_bg_color'];
        $bg_image = empty( $instance['wpparallax_bg_image'] ) ? '' : $instance['wpparallax_bg_image'];
        $bg_video = empty( $instance['wpparallax_bg_video'] ) ? '' : $instance['wpparallax_bg_video'];

        $overlay_div = '';
        $type = '';
        if( ($bg_type=='image') && $bg_image ){
           $type = 'style="background:url('.esc_url($bg_image).')"';
        } elseif($bg_type=='color'){ 
            $type =  'style="background-color:'.esc_attr($bg_color).'"'; 
        } elseif($bg_type=='video'){ 
            $type = 'data-jarallax-video="'.esc_attr($bg_video).'"'; 
        }

        echo wp_kses_post($before_widget);
    ?>
<?php if($section_enable == 'show'){?>
    <section class="parallax-section <?php echo esc_attr($wpparallax_layout).'-layout';?>" id="<?php echo 'section-'.absint($page_id); ?>" 
 <?php echo ($type); ?> >
 <?php echo  ($overlay_div); ?>
	<div class="wpop-container">
		<?php
	
		switch ($wpparallax_layout) {
			case 'about':
				$template = "/layouts/about";
			break;

			case 'service':
				$template = "/layouts/service";
			break;

			case 'portfolio':
				$template = "/layouts/portfolio";
			break;

			case 'testimonial':
				$template = "/layouts/testimonial";
			break;
        
	        case 'team':
				$template = "/layouts/team";
			break;
        
			case 'blog':
				$template = "/layouts/blog";
			break;

			case 'callto':
				$template = "/layouts/callto";
			break;

			case 'map':
				$template = "/layouts/map";
			break;

			default:
				$template = "/layouts/default";
			break;
		}
		include(locate_template($template."-section.php"));	
		?>
    </div>
</section>
  <?php }?>      
    <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    wp_parallax_widgets_updated_field_value()      defined in widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$wpparallax_widgets_name] = wp_parallax_widgets_updated_field_value( $widget_field, $new_instance[$wpparallax_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    wp_parallax_widgets_show_widget_field()        defined in widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $wpparallax_widgets_field_value = !empty( $instance[$wpparallax_widgets_name]) ? esc_attr($instance[$wpparallax_widgets_name] ) : '';
            wp_parallax_widgets_show_widget_field( $this, $widget_field, $wpparallax_widgets_field_value );
        }
    }
}