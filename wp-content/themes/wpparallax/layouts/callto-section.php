<?php
/**
 * The template for displaying about layout.
 *
 * @package wpparallax
 */
?>

	<div class="callto">
		<?php  
            $query = new WP_Query( 'page_id='.$page_id );
            while ( $query->have_posts() ) : $query->the_post();
        ?>

		<div class="parallax-content clearfix">
			<span class="callto-title wow fadeInLeft">
				<?php the_title();?>
			</span>
			<?php
			$post_content = get_the_content(); 
			if($post_content != "") : ?>
				<p class="wow fadeInRight"> 
					<?php echo esc_attr(wp_trim_words(get_the_content(),20)); ?>
				</p>
			<?php endif; ?>
				<a class="callto-button wow fadeInUp" href="<?php echo esc_url($callto_link);?>"><?php echo esc_html($callto_text);?></a>
		</div>
		<?php 
	        endwhile;    
	        wp_reset_postdata();
        ?>
	</div>