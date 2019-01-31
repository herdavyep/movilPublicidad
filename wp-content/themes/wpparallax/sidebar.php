<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpparallax
 */

if( !is_search() ){
	$post_sidebar = esc_attr(get_post_meta($post->ID, 'wpparallax_page_layouts', true));
}

if ( is_archive() || is_home() || is_search() ) {
    $post_sidebar = get_theme_mod('archive_page_sidebars_layout','rightsidebar');
}

if ( wp_parallax_is_woocommerce_activated() ) {
if( is_product_category() || is_shop() || is_singular('product') ) {
    $post_sidebar = 'rightsidebar';
}
}
          
if( !$post_sidebar ){
	$post_sidebar = 'rightsidebar';
}

if ( $post_sidebar ==  'nosidebar' ) {
	return;
}


if( $post_sidebar == 'rightsidebar' || $post_sidebar == 'bothsidebar'  && is_active_sidebar('sidebar-right')){
	?>
		<aside id="secondaryright" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-right' ); ?>
		</aside><!-- #secondary -->
	<?php
}

if( $post_sidebar == 'leftsidebar' || $post_sidebar == 'bothsidebar'  && is_active_sidebar('sidebar-left')){
	?>
		<aside id="secondaryleft" class="widget-area left" role="complementary">
			<?php dynamic_sidebar( 'sidebar-left' ); ?>
		</aside><!-- #secondary -->
	<?php
}


