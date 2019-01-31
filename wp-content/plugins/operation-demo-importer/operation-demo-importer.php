<?php
/**
 * Wpop Demo Importer
 *
 * @package     WpopDemoImporter
 * @author      WPOperation
 * @copyright   2017 WPOperation
 * @license     GPL-2.0+
 *
 * Plugin Name: Operation Demo Importer
 * Description: Demo Importer For WPOperation Themes
 * Version:     1.0.4
 * Author:      WPOperation
 * Author URI:  https://wpoperation.com
 * Text Domain: wpop-demo-importer
 * Domain Path: /languages/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Importer Path
 */
if( ! function_exists( 'wpop_importer_get_path_locate' ) ) {
  function wpop_importer_get_path_locate() {
    $dirname        = wp_normalize_path( dirname( __FILE__ ) );
    $plugin_dir     = wp_normalize_path( WP_PLUGIN_DIR );
    $located_plugin = ( preg_match( '#'. $plugin_dir .'#', $dirname ) ) ? true : false;
    $directory      = ( $located_plugin ) ? $plugin_dir : get_template_directory();
    $directory_uri  = ( $located_plugin ) ? WP_PLUGIN_URL : get_template_directory_uri();
    $basename       = str_replace( wp_normalize_path( $directory ), '', $dirname );
    $dir            = $directory . $basename;
    $uri            = $directory_uri . $basename;
    return apply_filters( 'wpop_importer_get_path_locate', array(
      'basename' => wp_normalize_path( $basename ),
      'dir'      => wp_normalize_path( $dir ),
      'uri'      => $uri
    ) );
  }
}

/**
 * Importer constants
 */
$get_path = wpop_importer_get_path_locate();

define( 'WPOP_IMPORTER_VER' , '1.0.0' );
define( 'WPOP_IMPORTER_DIR' , $get_path['dir'] );
define( 'WPOP_IMPORTER_URI' , $get_path['uri'] );
define( 'WPOP_IMPORTER_CONTENT_DIR' , get_stylesheet_directory() . '/inc/config/demos/' );
define( 'WPOP_IMPORTER_CONTENT_URI' , get_template_directory_uri() . '/inc/config/demos/' );



/**
 * Scripts and styles for admin
 */
function wpop_importer_enqueue_scripts() {

    wp_enqueue_script( 'wpop-importer', WPOP_IMPORTER_URI . '/assets/js/import.js', array( 'jquery' ), WPOP_IMPORTER_VER, true);
    wp_enqueue_style( 'wpop-importer-css', WPOP_IMPORTER_URI . '/assets/css/import.css', null, WPOP_IMPORTER_VER);
}

add_action( 'admin_enqueue_scripts', 'wpop_importer_enqueue_scripts' );

// Register Text Domain
function wpop_init(){
  load_plugin_textdomain( 'wpop-demo-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

}
add_action( 'init', 'wpop_init' );

/**
 *
 * Decode string for backup options (Source from codestar)
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_decode_string' ) ) {
  function cs_decode_string( $string ) {
    return unserialize( gzuncompress( stripslashes( call_user_func( 'base'. '64' .'_decode', rtrim( strtr( $string, '-_', '+/' ), '=' ) ) ) ) );
  }
}

/**
 * Load Importer
 */
require_once WPOP_IMPORTER_DIR . '/classes/abstract.class.php';
require_once WPOP_IMPORTER_DIR . '/classes/importer.class.php';
