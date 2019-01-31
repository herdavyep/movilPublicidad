<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Framework Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Wpop_Demo_Importer extends Wpop_Demo_Importer_Abstract {
  /**
   *
   * option database/data name
   * @access public
   * @var string
   *
   */
  public $opt_id;

  /**
   *
   * demo items
   * @access public
   * @var array
   *
   */
  public $items = array();
  /**
   *
   * instance
   * @access private
   * @var class
   *
   */
  private static $instance = null;
  // run framework construct
  public function __construct( $settings, $items, $opt_id ) {
    $this->opt_id = $opt_id;
    $this->settings = apply_filters( 'wpop_importer_settings', $settings );
    $this->items    = apply_filters( 'wpop_importer_items', $items );
    if( ! empty( $this->items ) ) {
      $this->addAction( 'admin_menu', 'admin_menu');
      $this->addAction( 'wp_ajax_wpop_demo_importer', 'import_process' );
    }
    $this->addAction('operation_importer_display','admin_page');
    
  }
  // instance
  public static function instance( $settings = array(), $items = array(), $opt_id ) {
    if ( is_null( self::$instance ) ) {
      self::$instance = new self( $settings, $items, $opt_id );
    }
    return self::$instance;
  }

  // adding option page
  public function admin_menu() {
    $defaults_menu_args = array(
      'menu_parent'     => '',
      'menu_title'      => '',
      'menu_type'       => '',
      'menu_slug'       => '',
      'menu_icon'       => '',
      'menu_capability' => 'manage_options',
      'menu_position'   => null,
    );
    $args = wp_parse_args( $this->settings, $defaults_menu_args );
    if( $args['menu_type'] == 'add_submenu_page' ) {
      call_user_func( $args['menu_type'], $args['menu_parent'], $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ) );
    } else {
      call_user_func( $args['menu_type'], $args['menu_title'], $args['menu_title'], $args['menu_capability'], $args['menu_slug'], array( &$this, 'admin_page' ), $args['menu_icon'], $args['menu_position'] );
    }
  }

  // output demo items
  public function admin_page() {
    $nonce = wp_create_nonce('wpop_importer');
  ?>
  <div class="wrap wpop-importer">
   
    <div id="welcome-panel" class="welcome-panel">
      <div class="welcome-panel-content">
        <p class="about-description"><?php _e('Make sure that you\'ve installed all the required & recommended plugins before proceeding with the demo installation here.', 'wpop-demo-importer' ); ?></p><br>
      </div>
    </div>
          <div class="kel-checkbox">
              <div class="desc"><?php _e( 'Reset Database ?', 'wpop-demo-importer' ); ?>
                <p><?php _e('(Enable this option to reset database and import demo)','wpop-demo-importer') ?></p>
              </div>

              <input type="checkbox" id="database-reset" name="wpop-database-reset" value="true" >
              <label for="database-reset"></label>
          </div>
    <div class="wpop-demo-browser">
      <?php
        foreach ($this->items as $item => $value ) :
          $opt = get_option($this->opt_id);
          $imported_class = '';
          $btn_text = '';
          $status = '';
          if (!empty($opt[$item])) {
            $imported_class = 'imported';
            $btn_text .= __( 'Re-Import', 'wpop-demo-importer' );
            $status .= __( 'Imported', 'wpop-demo-importer' );
          } else {
            $btn_text .= __( 'Import', 'wpop-demo-importer' );
            $status .= __( 'Not Imported', 'wpop-demo-importer' );
          }
      ?>
        <div class="wpop-demo-item <?php echo esc_attr($imported_class); ?>" data-wpop-importer>
          <div class="wpop-demo-screenshot">
            <?php
              $image_url = '';
              if (file_exists(WPOP_IMPORTER_CONTENT_DIR . $item . '/screenshot.png')) {
                $image_url = WPOP_IMPORTER_CONTENT_URI . $item . '/screenshot.png';
              } else if ( file_exists( WPOP_IMPORTER_CONTENT_DIR . $item . '/screenshot.jpg') ) {
                $image_url = WPOP_IMPORTER_CONTENT_URI . $item . '/screenshot.jpg';
              } else {
                $image_url = WPOP_IMPORTER_URI . '/assets/img/screenshot.png';
              }
            ?>
            <div class="wpop-tag"><?php echo $status;?></div>
            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr($value['title']); ?>">
          </div>
          <h2 class="wpop-demo-name"><?php echo esc_attr($value['title']); ?></h2>
          <div class="wpop-demo-actions">
            <a class="button button-secondary import-btn" href="#" data-import="<?php echo esc_attr($item); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-reset="false">
              <?php echo esc_attr($btn_text); ?></a>
            <a class="button button-primary" target="_blank" href="<?php echo esc_url($value['preview_url']); ?>"><?php _e( 'Preview', 'wpop-demo-importer' ); ?></a>
          </div>
          
          <div class="wpop-importer-response"><span class="dismiss" title="Dismis this messages.">X</span></div>
        </div><!-- /.wpop-demo-item -->
      <?php endforeach; ?>
      <div class="clear"></div>
    </div><!-- /.wpop-demo-browser -->
  </div><!-- /.wrap -->
  <?php
  }

  /**
   * Import Proccess
   */
  public function import_process() {
    if ( function_exists( 'ini_get' ) ) {
      if ( 300 < ini_get( 'max_execution_time' ) ) {
        @ini_set( 'max_execution_time', 300 );
      }
      if ( 256 < intval( ini_get( 'memory_limit' ) ) ) {
        @ini_set( 'memory_limit', '256M' );
      }
    } else {
     echo 'ini_get does not exist';
    }
    $id = $_POST['id'];
    $reset = $_POST['reset'];

    //Database reset
    if($reset == 'true'){
      $this->database_reset();
    }

    // Import Smart Slider
      $this->set_smart_slider();  

    //Setup Customizer options
      $this->set_theme_options();

    // Import XML Data
      $this->import_xml_data();

    //Setup Widgets
      $this->set_widgets();

    // Setup Reading
      $this->set_pages_for_reading();

    // Setup Menu
    if (isset($this->items[$id]['menus'])) {
      $this->set_menu();
    }
    die();
    
  }

  //Reset Database
  function database_reset() {
      global $wpdb;
      $options = array(
          'offset' => 0,
          'orderby' => 'post_date',
          'order' => 'DESC',
          'post_type' => 'post',
          'post_status' => 'publish'
      );

      $statuses = array( 'publish', 'future', 'draft', 'pending', 'private', 'trash', 'inherit', 'auto-draft', 'scheduled' );
      $types = array(
          'post',
          'page',
          'attachment',
          'nav_menu_item',
          'wpcf7_contact_form',
          'product',
          'portfolio',
          'testimonial',
          'team'
      );

      // delete posts
      foreach ( $types as $type ) {
          foreach ( $statuses as $status ) {
              $options[ 'post_type' ] = $type;
              $options[ 'post_status' ] = $status;

              $posts = get_posts( $options );
              $offset = 0;
              while ( count( $posts ) > 0 ) {
                  if ( $offset == 10 ) {
                      break;
                  }
                  $offset++;
                  foreach ( $posts as $post ) {
                      wp_delete_post( $post->ID, true );
                  }
                  $posts = get_posts( $options );
              }
          }
      }


      // Delete categories, tags, etc
      $taxonomies_array = array( 'category', 'post_tag', 'portfolio-category', 'testimonial-category', 'team-category', 'nav_menu', 'product_cat' );
      foreach ( $taxonomies_array as $tax ) {
          $cats = get_terms( $tax, array( 'hide_empty' => false, 'fields' => 'ids' ) );
          foreach ( $cats as $cat ) {
              wp_delete_term( $cat, $tax );
          }
      }


      // Delete Slider Revolution Sliders
      if ( class_exists( 'RevSlider' ) ) {
          $sliderObj = new RevSlider();
          foreach ( $sliderObj->getArrSliders() as $slider ) {
              $slider->initByID( $slider->getID() );
              $slider->deleteSlider();
          }
      }

      // Delete Widgets
      global $wp_registered_widget_controls;

      $widget_controls = $wp_registered_widget_controls;

      $available_widgets = array();

      foreach ( $widget_controls as $widget ) {
          if ( !empty( $widget[ 'id_base' ] ) && !isset( $available_widgets[ $widget[ 'id_base' ] ] ) ) { // no dupes
              $available_widgets[] = $widget[ 'id_base' ];
          }
      }

      update_option( 'sidebars_widgets', array( 'wp_inactive_widgets' => array() ) );
      foreach ( $available_widgets as $widget_data ) {
          update_option( 'widget_' . $widget_data, array() );
      }

      //Clear "uploads" folder
      $this->arwp_clear_uploads( $this->uploads_dir[ 'basedir' ] );
  }

  /**
   * Clear "uploads" folder
   * @param string $dir
   * @return bool
   */
  private function arwp_clear_uploads( $dir ) {
      $files = array_diff( scandir( $dir ), array( '.', '..' ) );
      foreach ( $files as $file ) {
          ( is_dir( "$dir/$file" ) ) ? $this->arwp_clear_uploads( "$dir/$file" ) : unlink( "$dir/$file" );
      }

      return ( $dir != $this->uploads_dir[ 'basedir' ] ) ? rmdir( $dir ) : true;
  }

  /**
   * Import XML data by WordPress Importer
   */
  public function import_xml_data() {

    if ( ! wp_verify_nonce( $_POST['nonce'], 'wpop_importer' ) ){
      die( 'Authentication Error!!!' ); 
    }
    
    $id = $_POST['id'];
    $file = WPOP_IMPORTER_CONTENT_DIR . $id . '/content.xml';

    if ( ! defined('WP_LOAD_IMPORTERS') ) { 
      define( 'WP_LOAD_IMPORTERS', true );
    }
    
    $importer_error = false;

    if ( !class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) ){
            require_once($class_wp_importer);
        } else {
            $importer_error = true;
        }
    }


      if ( ! class_exists( 'WP_Import' ) ) {
          $class_wp_import = wp_normalize_path( dirname( __FILE__ ) ) . '/wordpress-importer.php';
          if ( file_exists( $class_wp_import ) && ! class_exists( 'WP_Import' ) ){
            require $class_wp_import;
          }else{
            $importer_error = true;
          }
      }

      if($importer_error){
          die(__("Error on import", 'wpop-demo-importer'));
      } else {
        if(!is_file( $file )){
            esc_html_e("File Error!!!", 'wpop-demo-importer');
        } else {
          $wp_import = new WP_Import();


          $wp_import->fetch_attachments = true;
          $wp_import->import( $file );
          $options = get_option($this->opt_id);
          $options[$id] = true;
          update_option( $this->opt_id, $options );
      }

    }

  }

  function set_theme_options() {
      $id = $_POST['id'];
      if(defined('WPOP_PRO')){
        $file = WPOP_IMPORTER_CONTENT_DIR . $id . '/options.txt';
        if ( file_exists( $file ) ) {
          // Get file contents and decode
          $data = file_get_contents( $file );
          $decoded_data = cs_decode_string( $data );
          update_option( $this->opt_id, $decoded_data );
        }
      }else{
        $customizer_filepath = WPOP_IMPORTER_CONTENT_DIR . $id . '/options.dat';
        if ( file_exists( $customizer_filepath ) ) {
            $customizer_file = file_get_contents( $customizer_filepath, true );
            if ( !empty( $customizer_file ) ) {
                $options = unserialize( $customizer_file );
                // Loop through the mods.
                foreach ( $options[ 'mods' ] as $key => $val ) {

                    // Save the mod.
                    set_theme_mod( $key, $val );
                }
                echo esc_html__( 'Customizer Settings saved.', 'wpop-demo-importer' ) . '<br>';
            } else {
                echo esc_html__( 'Customizer Settings could not be imported', 'wpop-demo-importer' ) . '<br>';
            }
        } else {
            echo esc_html__( 'Customizer Settings file not found.', 'wpop-demo-importer' ) . '<br>';
        }
      }  
  }


  /**
   * Update Widgets
   */
        function set_widgets() {
            $id = $_POST['id'];
            $widget_filepath = WPOP_IMPORTER_CONTENT_DIR . $id . '/widgets.wie';
            if ( file_exists( $widget_filepath ) ) {
                global $wp_registered_sidebars;

                $widget_file = file_get_contents( $widget_filepath, true );
                $data = json_decode( $widget_file );
                // Have valid data?
                // If no data or could not decode
                if ( empty( $data ) || !is_object( $data ) ) {
                    wp_die(
                            _e( 'Widget data is not available', 'wpop-demo-importer' ), '', array( 'back_link' => true )
                    );
                }

                global $wp_registered_widget_controls;

                $widget_controls = $wp_registered_widget_controls;

                $available_widgets = array();

                foreach ( $widget_controls as $widget ) {

                    if ( !empty( $widget[ 'id_base' ] ) && !isset( $available_widgets[ $widget[ 'id_base' ] ] ) ) { // no dupes
                        $available_widgets[ $widget[ 'id_base' ] ][ 'id_base' ] = $widget[ 'id_base' ];
                        $available_widgets[ $widget[ 'id_base' ] ][ 'name' ] = $widget[ 'name' ];
                    }
                }

                // Get all existing widget instances
                $widget_instances = array();
                foreach ( $available_widgets as $widget_data ) {
                    $widget_instances[ $widget_data[ 'id_base' ] ] = get_option( 'widget_' . $widget_data[ 'id_base' ] );
                }

                // Begin results
                $results = array();

                // Loop import data's sidebars
                foreach ( $data as $sidebar_id => $widgets ) {

                    // Skip inactive widgets
                    // (should not be in export file)
                    if ( 'wp_inactive_widgets' == $sidebar_id ) {
                        continue;
                    }

                    // Check if sidebar is available on this site
                    // Otherwise add widgets to inactive, and say so
                    if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
                        $sidebar_available = true;
                        $use_sidebar_id = $sidebar_id;
                        $sidebar_message_type = 'success';
                        $sidebar_message = '';
                    } else {
                        $sidebar_available = false;
                        $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                        $sidebar_message_type = 'error';
                        $sidebar_message = _e( 'Widget area does not exist in theme (using Inactive)', 'wpop-demo-importer' );
                    }

                    // Result for sidebar
                    $results[ $sidebar_id ][ 'name' ] = !empty( $wp_registered_sidebars[ $sidebar_id ][ 'name' ] ) ? $wp_registered_sidebars[ $sidebar_id ][ 'name' ] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
                    $results[ $sidebar_id ][ 'message_type' ] = $sidebar_message_type;
                    $results[ $sidebar_id ][ 'message' ] = $sidebar_message;
                    $results[ $sidebar_id ][ 'widgets' ] = array();

                    // Loop widgets
                    foreach ( $widgets as $widget_instance_id => $widget ) {

                        $fail = false;

                        // Get id_base (remove -# from end) and instance ID number
                        $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                        $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

                        // Does site support this widget?
                        if ( !$fail && !isset( $available_widgets[ $id_base ] ) ) {
                            $fail = true;
                            $widget_message_type = 'error';
                            $widget_message = __( 'Site does not support widget', 'wpop-demo-importer' ); // explain why widget not imported
                        }

                        // Filter to modify settings object before conversion to array and import
                        // Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
                        // Ideally the newer wie_widget_settings_array below will be used instead of this
                        $widget = apply_filters( 'wie_widget_settings', $widget ); // object
                        // Convert multidimensional objects to multidimensional arrays
                        // Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
                        // Without this, they are imported as objects and cause fatal error on Widgets page
                        // If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
                        // It is probably much more likely that arrays are used than objects, however
                        $widget = json_decode( wp_json_encode( $widget ), true );

                        // Filter to modify settings array
                        // This is preferred over the older wie_widget_settings filter above
                        // Do before identical check because changes may make it identical to end result (such as URL replacements)
                        $widget = apply_filters( 'wie_widget_settings_array', $widget );

                        // Does widget with identical settings already exist in same sidebar?
                        if ( !$fail && isset( $widget_instances[ $id_base ] ) ) {

                            // Get existing widgets in this sidebar
                            $sidebars_widgets = get_option( 'sidebars_widgets' );
                            $sidebar_widgets = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array(); // check Inactive if that's where will go
                            // Loop widgets with ID base
                            $single_widget_instances = !empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
                            foreach ( $single_widget_instances as $check_id => $check_widget ) {

                                // Is widget in same sidebar and has identical settings?
                                if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && ( array ) $widget == $check_widget ) {

                                    $fail = true;
                                    $widget_message_type = 'warning';
                                    $widget_message = __( 'Widget already exists', 'wpop-demo-importer' ); // explain why widget not imported

                                    break;
                                }
                            }
                        }

                        // No failure
                        if ( !$fail ) {

                            // Add widget instance
                            $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                            $single_widget_instances = !empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                            $single_widget_instances[] = $widget; // add it
                            // Get the key it was given
                            end( $single_widget_instances );
                            $new_instance_id_number = key( $single_widget_instances );

                            // If key is 0, make it 1
                            // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                            if ( '0' === strval( $new_instance_id_number ) ) {
                                $new_instance_id_number = 1;
                                $single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[ 0 ];
                                unset( $single_widget_instances[ 0 ] );
                            }

                            // Move _multiwidget to end of array for uniformity
                            if ( isset( $single_widget_instances[ '_multiwidget' ] ) ) {
                                $multiwidget = $single_widget_instances[ '_multiwidget' ];
                                unset( $single_widget_instances[ '_multiwidget' ] );
                                $single_widget_instances[ '_multiwidget' ] = $multiwidget;
                            }

                            // Update option with new widget
                            update_option( 'widget_' . $id_base, $single_widget_instances );

                            // Assign widget instance to sidebar
                            $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                            // Avoid rarely fatal error when the option is an empty string
                            // https://github.com/churchthemes/widget-importer-exporter/pull/11
                            if ( !$sidebars_widgets ) {
                                $sidebars_widgets = array();
                            }

                            $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                            $sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id; // add new instance to sidebar

                            update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data
                            // After widget import action
                            $after_widget_import = array(
                                'sidebar' => $use_sidebar_id,
                                'sidebar_old' => $sidebar_id,
                                'widget' => $widget,
                                'widget_type' => $id_base,
                                'widget_id' => $new_instance_id,
                                'widget_id_old' => $widget_instance_id,
                                'widget_id_num' => $new_instance_id_number,
                                'widget_id_num_old' => $instance_id_number
                            );
                            do_action( 'wie_after_widget_import', $after_widget_import );

                            // Success message
                            if ( $sidebar_available ) {
                                $widget_message_type = 'success';
                                $widget_message = esc_html__( 'Imported', 'wpop-demo-importer' );
                            } else {
                                $widget_message_type = 'warning';
                                $widget_message = esc_html__( 'Imported to Inactive', 'wpop-demo-importer' );
                            }
                        }

                        // Result for widget instance
                        $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'name' ] = isset( $available_widgets[ $id_base ][ 'name' ] ) ? $available_widgets[ $id_base ][ 'name' ] : $id_base; // widget name or ID if name not available (not supported by site)
                        $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'title' ] = !empty( $widget[ 'title' ] ) ? $widget[ 'title' ] : esc_html__( 'No Title', 'wpop-demo-importer' ); // show "No Title" if widget instance is untitled
                        $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'message_type' ] = $widget_message_type;
                        $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'message' ] = $widget_message;
                    }
                }
            } else {
                echo esc_html__( 'Widget Importer file not found.', 'wpop-demo-importer' ) . '<br>';
            }
        }

  /* Set Smart Slider */
  public function set_smart_slider(){
    $id = $_POST['id'];
    $file = WPOP_IMPORTER_CONTENT_DIR . $id . '/slider.ss3';
    if(file_exists($file)){
      SmartSlider3::import($file);
    }
  }      

  /**
   * Set Homepage and Front page
   */
  public function set_pages_for_reading() {
    $id = $_POST['id'];

    // Set Home
    if (isset($this->items[$id]['front_page'])) {
      $page = get_page_by_title($this->items[$id]['front_page']);

      if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
      }
    }

    // Set Blog
    if (isset($this->items[$id]['blog_page'])) {
      $page = get_page_by_title($this->items[$id]['blog_page']);

      if ( isset( $page->ID ) ) {
        update_option( 'page_for_posts', $page->ID );
        update_option( 'show_on_front', 'page' );
      }
    }
  }

  /**
   * Setup Menu
   */
  public function set_menu() {
    $id = $_POST['id'];
    
    // Store All Menu
    $menu_locations = array();

    foreach ($this->items[$id]['menus'] as $key => $value) {
      $menu = get_term_by( 'name', $value, 'nav_menu' );
      if (isset($menu->term_id)) {
        $menu_locations[$key] = $menu->term_id;
      }
    }

    // Set Menu If has
    if (isset($menu_locations)) {
      set_theme_mod( 'nav_menu_locations', $menu_locations );
    }
  }
}