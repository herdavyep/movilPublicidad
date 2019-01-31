<?php
/**
 * The template for displaying about layout.
 *
 * @package wpparallax
 */
?>

<div class="about">
	<?php  
        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
	      $section_title = get_the_title();
	      if($show_title == 'on'){
	      wp_parallax_section_title($section_title);
	      }
	      ?>

			<div class="parallax-content clearfix">
				<?php 
	              $image_id = get_post_thumbnail_id();
	              $image_path = wp_get_attachment_image_src( $image_id, 'wpparallax-about-img', true );
	              $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	              if( has_post_thumbnail() ) { 
				?>
				<div class="about-img wow fadeInLeft">
					<img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
				</div>
				<?php }?>
				<?php
				$post_content = get_the_content(); 
				if($post_content != "") : ?>
				<div class="about-content wow fadeInRight">
					<p> 
						<?php echo esc_attr(wp_trim_words(get_the_content(),70)); ?>
						 <a class="read-more" href="<?php the_permalink();?>">
						 	<?php echo esc_html__('Read More','wpparallax');?>
						 </a>
					 </p>
				</div>
				<?php endif; ?>
			</div>
	        <?php 
        endwhile;    
        wp_reset_postdata();
    ?>
</div>