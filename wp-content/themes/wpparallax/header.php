<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpparallax
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<?php do_action( 'wp_parallax_before_header' ); ?>
	<?php 
	$header_layout = get_theme_mod('wp_parallax_header_layouts','layout1');
	$wp_parallax_slider_show = get_theme_mod('wp_parallax_slider_show','show');
	$wp_parallax_slider_cat = get_theme_mod('wp_parallax_slider_cat',0);
	if($header_layout != 'layout3') {
		$class_sl = 'slider-hidden';
		if( ($wp_parallax_slider_show == 'show') && ($wp_parallax_slider_cat != 0) ){
			$class_sl = '';
		}	
	}else{
		$class_sl = '';
	}
	
	$classes = get_body_class();
	if (!is_front_page() || !is_page_template('tpl_home.php')){ $home_inner='wpop-inner';} else{ $home_inner='';}?>
	
	<header id="masthead" class="site-header <?php echo esc_attr($home_inner).' '.esc_attr($header_layout) .' '.esc_attr($class_sl);?>">
		<?php
			/**
			 * @see  wp_parallax_skip_links() - 0
			 * @see  wp_parallax_top_header() - 10
			 * @see  wp_parallax_button_header() - 20
			**/			
			do_action( 'wp_parallax_header' ); 
		?>
	</header><!-- #masthead -->
		
	<?php do_action( 'wp_parallax_after_header' ); ?>

	<div id="content" class="site-content">
		<?php 
		if (in_array('page-template-tpl_home',$classes)) : ?>
		<div id="plx-slider-section">
			<?php do_action('wpop_main_slider'); ?>
		</div>
		<?php
		endif;
		?>
