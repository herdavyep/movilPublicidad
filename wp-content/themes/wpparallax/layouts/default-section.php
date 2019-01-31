<?php
/**
 * The template for displaying about layout.
 *
 * @package wpparallax
 */
?>

<div class="parallax-content">
	<?php  
        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
	      $section_title = get_the_title();
          if($show_title == 'on'){
          wp_parallax_section_title($section_title);
          }
	      ?>
        <div class="default-content">
        	<?php the_content();?>
        </div>
        <?php
        endwhile; 
        wp_reset_postdata();
    ?>	
	
</div>