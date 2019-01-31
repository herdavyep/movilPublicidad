<?php
/**
* wpparallax customizer repeater class
*
*
* @package wpparallax
*/

if( class_exists('WP_Customize_Control')):

        
    /**
     * Repeater Custom Control
    */
    class wpparallax_Repeater_Controler extends WP_Customize_Control {
    	/**
    	 * The control type.
    	 *
    	 * @access public
    	 * @var string
    	*/
       

        
    	public $type = 'repeater';

    	public $wpparallax_box_label = '';

    	public $wpparallax_box_add_control = '';

    	private $cats = '';

    	private $pages = '';

    	private $layouts = '';

    	/**
    	 * The fields that each container row will contain.
    	 *
    	 * @access public
    	 * @var array
    	 */
    	public $fields = array();

    	/**
    	 * Repeater drag and drop controler
    	 *
    	 * @since  1.0.0
    	 */
    	public function __construct( $manager, $id, $args = array(), $fields = array() ) {
    		$this->fields = $fields;
    		$this->wpparallax_box_label = $args['wpparallax_box_label'] ;
    		$this->wpparallax_box_add_control = $args['wpparallax_box_add_control'];
    		$this->cats = get_categories(array( 'hide_empty' => false ));
    		$this->pages = get_pages();
    		$this->layouts = wp_parallax_section_layouts();
    		parent::__construct( $manager, $id, $args );
    	}

    	public function render_content() {

    		$values = json_decode($this->value());
    		?>
    		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

    		<?php if($this->description){ ?>
    			<span class="description customize-control-description">
    			<?php echo wp_kses_post($this->description); ?>
    			</span>
    		<?php } ?>

    		<ul class="wpparallax-repeater-field-control-wrap">
    			<?php
    			$this->wpparallax_get_fields();
    			?>
    		</ul>

    		<input type="hidden" <?php esc_attr( $this->link() ); ?> class="wpparallax-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
    		<button type="button" class="button wpparallax-add-control-field"><?php echo esc_html( $this->wpparallax_box_add_control ); ?></button>
    		<?php
    	}

    	private function wpparallax_get_fields(){
    		$fields = $this->fields;
    		$values = json_decode($this->value());

    		if(is_array($values)){
    		foreach($values as $value){
    		?>
    		<li class="wpparallax-repeater-field-control">
     		<h3 class="wpparallax-repeater-field-title"><?php echo esc_html( $this->wpparallax_box_label ); ?></h3>

    		
    		<div class="wpparallax-repeater-fields">
    		<?php
    			foreach ($fields as $key => $field) {
    			$class = isset($field['class']) ? $field['class'] : '';
    			$style = isset($field['style']) ? $field['style'] : '';
    			?>
    			<div class="wpparallax-fields wpparallax-type-<?php echo esc_attr($field['type']).' '.esc_attr($class); ?>" style="<?php echo esc_attr($style);?>">
	    			<?php 
	    				$label = isset($field['label']) ? $field['label'] : '';
	    				$description = isset($field['description']) ? $field['description'] : '';
	    				if($field['type'] != 'checkbox'){ ?>
	    					<span class="customize-control-fields"><?php echo esc_html( $label ); ?></span>
	    					<span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
	    				<?php 
	    				}

	    				$new_value = isset($value->$key) ? $value->$key : '';

	    				$default = isset($field['default']) ? $field['default'] : '';

	    				switch ($field['type']) {


	    					case 'text':
	    						echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
	    						break;


	    					case 'upload':
	    						$image = $image_class= "";
	    						if($new_value){	
	    							$image = '<img src="'.esc_url($new_value).'" style="max-width:100%;"/>';	
	    							$image_class = ' hidden';
	    						}
	    						echo '<div class="wpparallax-fields-wrap">';
	    						echo '<div class="attachment-media-view">';
	    						echo '<div class="placeholder'.esc_attr($image_class).'">';
	    						esc_html_e('No image selected', 'wpparallax');
	    						echo '</div>';
	    						echo '<div class="thumbnail thumbnail-image">';
	    						echo esc_attr($image);
	    						echo '</div>';
	    						echo '<div class="actions clearfix">';
	    						echo '<button type="button" class="button wpparallax-delete-button align-left">'.esc_html__('Remove', 'wpparallax').'</button>';
	    						echo '<button type="button" class="button wpparallax-upload-button alignright">'.esc_html__('Select Image', 'wpparallax').'</button>';
	    						echo '<input data-default="'.esc_attr($default).'" class="upload-id" data-name="'.esc_attr($key).'" type="hidden" value="'.esc_attr($new_value).'"/>';
	    						echo '</div>';
	    						echo '</div>';
	    						echo '</div>';							
	    						break;

	    					case 'category':
	    						echo '<select data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
	    						echo '<option value="0">'.esc_html__('Select Category', 'wpparallax').'</option>';
	    						echo '<option value="-1">'.esc_html__('Latest Posts', 'wpparallax').'</option>';
	                                foreach ( $this->cats as $cat )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($cat->term_id), selected($new_value, $cat->term_id, false), esc_html($cat->name));
	                                }
	                      		echo '</select>';
	    						break;

	    					case 'select':
	    						$options = $field['options'];
	    						echo '<select class="select-bg" data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
	                                foreach ( $options as $option => $val )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
	                                }
	                      		echo '</select>';
	    						break;

	    					
	    					case 'colorpicker':
	    						echo '<input class="custom" data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
	    						break;


	    					case 'switch':
	    						$switch = $field['switch'];
	    						$switch_class = ($new_value == 'on') ? 'switch-on' : '';
	    						echo '<div class="onoffswitch '.esc_attr($switch_class).'">';
	    	                        echo '<div class="onoffswitch-inner">';
	    	                            echo '<div class="onoffswitch-active">';
	    	                                echo '<div class="onoffswitch-switch">'.esc_html($switch["on"]).'</div>';
	    	                            echo '</div>';
	    	                            echo '<div class="onoffswitch-inactive">';
	    	                                echo '<div class="onoffswitch-switch">'.esc_html($switch["off"]).'</div>';
	    	                            echo '</div>';
	    	                        echo '</div>';
	    		                echo '</div>';
	    		                echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
	    						break;

	    					case 'page':	
	    						echo '<select data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'" id="dropdown-pages">';
	    						echo '<option value="">'.esc_html__('Select Pages', 'wpparallax').'</option>';
	                                foreach ( $this->pages as $page )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($page->ID), selected($new_value, $page->ID, false), esc_html($page->post_title));
	                                }
	                      		echo '</select>';
	                      	break;

	    					case 'layouts':
	    						$options = $this->layouts;
	    						echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'" id="dropdown-layouts">';
	    						echo '<option value="default">'.esc_html__('Default layout', 'wpparallax').'</option>';
	                                foreach ( $options as $option => $val )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
	                                }
	                      		echo '</select>';	    					
	    					break;

	    					default:
	    						break;
	    				}
	    			?>
    			</div>
    			<?php
    			} ?>

    			<div class="clearfix wpparallax-repeater-footer">
    				<div class="alignright">
    				<a class="wpparallax-repeater-field-remove" href="#remove"><?php esc_html_e('Delete', 'wpparallax') ?></a> |
    				<a class="wpparallax-repeater-field-close" href="#close"><?php esc_html_e('Close', 'wpparallax') ?></a>
    				</div>
    			</div>
    		</div>
    		</li>
    		<?php	
    		}
    		}
    	}

    }

endif;