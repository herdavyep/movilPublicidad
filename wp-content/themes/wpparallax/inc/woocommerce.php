<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package wpparallax
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function wp_parallax_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'wp_parallax_woocommerce_setup' );



/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function wp_parallax_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'wp_parallax_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function wp_parallax_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'wp_parallax_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function wp_parallax_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'wp_parallax_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function wp_parallax_woocommerce_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'wp_parallax_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function wp_parallax_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'wp_parallax_woocommerce_related_products_args' );

if ( ! function_exists( 'wp_parallax_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function wp_parallax_woocommerce_product_columns_wrapper() {
		$columns = wp_parallax_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'wp_parallax_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'wp_parallax_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function wp_parallax_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'wp_parallax_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'wp_parallax_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function wp_parallax_woocommerce_wrapper_before() {
		?>
		<?php do_action('wp_parallax_breadcrumb');?>
		<div class="wpop-container clearfix">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'wp_parallax_woocommerce_wrapper_before' );

if ( ! function_exists( 'wpparallax_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function wpparallax_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar('shop');?>
		</div><!--.wpop-container-->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'wpparallax_woocommerce_wrapper_after' );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);





/**
 * Header Type to Shopping Cart function 
**/
if ( wp_parallax_is_woocommerce_activated() ) {
    
    /**
     *  Cart function area for header one
    */
    if ( ! function_exists( 'wp_parallax_shopping_cart' ) ) {
       function wp_parallax_shopping_cart(){ ?>
            <a class="cart-contentsone" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_html_e( 'View your shopping cart', 'wpparallax' ); ?>">
               <div class="count">
                   <i class="fa fa-shopping-cart"></i>
                   <span class="cart-count"><?php echo wp_kses_data( sprintf(  WC()->cart->get_cart_contents_count() ) ); ?></span>
               </div>                                      
           </a>
       <?php
       }
    }

    if ( ! function_exists( 'wp_parallax_cart_header_link_fragment' ) ) {

        function wp_parallax_cart_header_link_fragment( $fragments ) {
            global $woocommerce;
            ob_start();
            wp_parallax_shopping_cart();
            $fragments['a.cart-contentsone'] = ob_get_clean();
            return $fragments;
        }
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'wp_parallax_cart_header_link_fragment' );

}



if ( ! function_exists( 'wpparallax_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function wpparallax_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php wpparallax_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
					$instance = array(
						'title' => '',
					);

					the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10);

function wpparallax_product_wrap(){
    woocommerce_template_loop_product_thumbnail();
    woocommerce_template_loop_product_link_close();
}

add_action('woocommerce_before_shop_loop_item_title','wpparallax_product_wrap',10);

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
function wpparallax_woocommerce_template_loop_price(){ ?>
    <div class="product-price-wrap clearfix">
        <?php woocommerce_template_loop_price(); ?>        
    </div>
<?php
}
add_action( 'woocommerce_after_shop_loop_item_title' ,'wpparallax_woocommerce_template_loop_price', 12 );

/*Woocommerce Breadcrumb */

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
add_filter( 'woocommerce_breadcrumb_defaults', 'wpparallax_change_breadcrumb_delimiter' );
function wpparallax_change_breadcrumb_delimiter( $defaults ) {
    $defaults['delimiter'] = ' &gt; ';
    return $defaults;
}

add_filter( 'woocommerce_show_page_title', 'wpparallax_woo_hide_page_title' );
function wpparallax_woo_hide_page_title() {
	
	return false;
	
}