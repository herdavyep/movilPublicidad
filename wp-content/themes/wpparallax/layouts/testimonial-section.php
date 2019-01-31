<?php
/**
 * The template for displaying all Parallax Templates.
 *
 * @package wpparallax
 */
?>

<div class="testimonial">
	<?php 

        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
          $section_title = get_the_title();
	      if($show_title == 'on'){
	      wp_parallax_section_title($section_title);
	      }
        endwhile;
        wp_reset_postdata();

    ?>
	<section class="testimonial-section">
		<div class="section-wrapper clearfix">
		    <div class="testimonialwrap">
		        <?php
					$args = array(
						'cat' => $cat_id,
						'posts_per_page' => -1
						);

		            $testimonial_query = new WP_Query( $args );
		               if( $testimonial_query->have_posts() ) { while( $testimonial_query->have_posts() ) { $testimonial_query->the_post();
		               $image_id = get_post_thumbnail_id();
		               $image_path = wp_get_attachment_image_src( $image_id, 'wpparallax-port-thumb2', true );                           
		        ?>
		            <div class="testimonialinfo">
		                <?php if( has_post_thumbnail() ) { ?>
		                    <div class="testimonial-image wow fadeInRight">
		                        <figure><img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php the_title_attribute(); ?>" /></figure>
		                    </div>
		                <?php   } ?>
		                <div class="testimonial-info wow fadeInLeft">
		                    <h4><?php the_title(); ?></h4>
		                    <div class="kr-testimonial-desc">
		                    <?php the_excerpt(); ?>
		                    </div>
		                </div>                         
		            </div>
		        <?php  } } wp_reset_postdata(); ?> 
		    </div>
		</div>
	</section>
</div>