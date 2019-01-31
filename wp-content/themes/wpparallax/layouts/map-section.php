<?php
/**
 * The template for displaying about layout.
 *
 * @package wpparallax
 */
?>

<div class="google-map">
	<?php  
        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
	      ?>
        	<div class="googlemap-toggle"><?php echo esc_html__('Map','wpparallax'); ?></div>
	
			<div class="googlemap-content">
				<?php the_content(); ?>
			</div>
	        <?php 
        endwhile;    
        wp_reset_postdata();
    ?>
</div>