<?php

/*

Template Name:Home

*/
get_header();
$wpparallax_homepage = get_theme_mod('wp_parallax_homepage');
$values = json_decode($wpparallax_homepage);
if(!empty($values)):

foreach( $values as $value){
	$page_enable = $value->wp_parallax_enable_section;
	$page_id = $value->wp_parallax_page;
	$show_title = isset($value->wp_parallax_show_title) ? $value->wp_parallax_show_title : 'on' ;
	$cat_id = $value->wp_parallax_cat;
	$layout = $value->wp_parallax_layout;
	$bg_type = $value->wp_parallax_bg_type;
	$bg_image = $value->wp_parallax_bg_image;
	$bg_video = $value->wp_parallax_bg_video;
	$bg_color = $value->wp_parallax_bg_color;
	$callto_text = $value->wp_parallax_callto_text;
	$callto_link = $value->wp_parallax_callto_url;

	$overlay_div = '';
	$type = '';
	if( ($bg_type=='image') && $bg_image ){
	   $type = 'style="background:url('.esc_url($bg_image).')"';
	   $overlay_div  ='<div class="img-overlay"></div>';
	} elseif($bg_type=='color' && $bg_color){ 
		$type =  'style="background-color:'.($bg_color).'"'; 
	} elseif($bg_type=='video' && $bg_video){ 
		$type = 'data-jarallax-video="'.esc_url($bg_video).'"'; 
	}
?>
<?php if(!empty($page_id) && $page_enable=='on'): ?>
<section class="parallax-section <?php echo esc_attr($layout).'-layout';?>" id="<?php echo 'section-'.absint($page_id); ?>" 
<?php echo ($type); ?> >
<?php echo  ($overlay_div); ?>
	<div class="wpop-container">
		<?php
	
		switch ($layout) {
			case 'about':
				$template = "layouts/about";
			break;

			case 'service':
				$template = "layouts/service";
			break;

			case 'portfolio':
				$template = "layouts/portfolio";
			break;

			case 'testimonial':
				$template = "layouts/testimonial";
			break;

			case 'blog':
				$template = "layouts/blog";
			break;

			case 'team':
				$template = "layouts/team";
			break;

			case 'callto':
				$template = "layouts/callto";
			break;

			case 'map':
				$template = "layouts/map";
			break;

			default:
				$template = "layouts/default";
			break;
		}
		include(locate_template($template."-section.php"));	
		?>
    </div>
</section>
<?php
endif;
}//foreach
endif;



get_footer();
