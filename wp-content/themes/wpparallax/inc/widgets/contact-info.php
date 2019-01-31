<?php
/**
 * Contact Info widget
 *
 * @package wpparallax
 */
/**
 * Adds contact info widget.
 */
 if(!function_exists('wp_parallax_register_info_widget')){
add_action('widgets_init', 'wp_parallax_register_info_widget');

function wp_parallax_register_info_widget() {
    register_widget('wp_parallax_info');
}
}
if(!class_exists('wp_parallax_info')){
class wp_parallax_info extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'wp_parallax_info', esc_html__('WPOP-Contact Info','wpparallax'), array(
                'description' => esc_html__('A widget that shows contact information', 'wpparallax')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // This widget has no title
            // Other fields
            'title_info' => array(
                'wpparallax_widgets_name' => 'title_info',
                'wpparallax_widgets_title' => esc_html__('Info Title', 'wpparallax'),
                'wpparallax_widgets_field_type' => 'text',
            ),
            'location' => array(
                'wpparallax_widgets_name' => 'location',
                'wpparallax_widgets_title' => esc_html__('Location', 'wpparallax'),
                'wpparallax_widgets_field_type' => 'text',
            ),
            'phone' => array(
                'wpparallax_widgets_name' => 'phone',
                'wpparallax_widgets_title' => esc_html__('Phone', 'wpparallax'),
                'wpparallax_widgets_field_type' => 'text',
            ),
            'fax' => array(
                'wpparallax_widgets_name' => 'fax',
                'wpparallax_widgets_title' => esc_html__('Fax', 'wpparallax'),
                'wpparallax_widgets_field_type' => 'text',
            ),
            'email' => array(
                'wpparallax_widgets_name' => 'email',
                'wpparallax_widgets_title' => esc_html__('Email', 'wpparallax'),
                'wpparallax_widgets_field_type' => 'text',
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
    public function widget($args, $instance) {
        extract($args);
        echo wp_kses_post($before_widget);
        if($instance){
        $wpparallax_title_info = $instance['title_info'];
        $wpparallax_location = $instance['location'];
        $wpparallax_phome = $instance['phone'];
        $wpparallax_fax = $instance['fax'];
        $wpparallax_email = $instance['email'];
            ?>
                <div class="footer_info_wrap">
                    <?php if($wpparallax_title_info){ ?>
                        <h4 class="widget-title">
                            <?php echo esc_html($wpparallax_title_info); ?>
                        </h4>
                        
                    <?php } ?>
                    <div class="info_wrap">
                        <?php if($wpparallax_location){ ?>
                            <div class="location_info">
                                <span class="fa_icon_info"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                <span class="location"><?php echo esc_html($wpparallax_location); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($wpparallax_phome){ ?>
                            <div class="phone_info">
                                <span class="fa_icon_info"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                <span class="phone"><?php echo esc_html($wpparallax_phome); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($wpparallax_fax){ ?>
                            <div class="fax_info">
                                <span class="fa_icon_info"><i class="fa fa-fax" aria-hidden="true"></i></span>
                                <span class="fax"><?php echo esc_html($wpparallax_fax); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($wpparallax_email){ ?>
                            <div class="email_info">
                                <span class="fa_icon_info"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                <span class="email"><?php echo esc_html($wpparallax_email); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
        <?php
        }
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	wp_parallax_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$wpparallax_widgets_name] = wp_parallax_widgets_updated_field_value($widget_field, $new_instance[$wpparallax_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	wp_parallax_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $wpparallax_widgets_field_value = !empty($instance[$wpparallax_widgets_name]) ? esc_attr($instance[$wpparallax_widgets_name]) : '';
            wp_parallax_widgets_show_widget_field($this, $widget_field, $wpparallax_widgets_field_value);
        }
    }

}
}