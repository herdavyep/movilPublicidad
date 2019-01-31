<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpparallax
 */

?>

	</div><!-- #content -->

	<?php do_action( 'wp_parallax_before_footer' ); ?>
	
		<footer id="colophon" class="site-footer" role="contentinfo">
            
				<?php
					/**
					 * @hooked wp_parallax_footer_widgets - 0
					 * @hooked wp_parallax_credit - 10
					 */
					do_action( 'wp_parallax_footer' ); 
				?>		
			
		</footer><!-- #colophon -->
		
	<?php do_action( 'wp_parallax_before_footer' ); ?>
	<?php 
    $search_enable = get_theme_mod('wp_parallax_search_enable','show');
	if($search_enable == 'show'){?>
	<div class="full-search-container">
	   <a href="javascript:void(0)" class="closebtn" >&times;</a>
	   <?php get_search_form(); ?>
	</div> 
	<?php }?>
	<!--<div id="wpop-top">
		<a href="javascript:void(0)">
			<i class="fa fa-angle-up"></i>	
		</a>
	</div>-->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
