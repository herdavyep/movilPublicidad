<?php
/**
 * The template for displaying all Parallax Templates.
 *
 * @package wpparallax
 */
?>

	<div class="service-listing clearfix">
	<?php 

        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
	      $section_title = get_the_title();
	      if($show_title == 'on'){
	     ?>
		    <div class="section-title-wrap wow fadeInUp">
		        <h2 class="section-title">
		            <?php echo esc_html($section_title); ?>
		        </h2>
		        <div class="section-subtitle">
		          <?php echo esc_attr(wp_trim_words(get_the_content(),'20')); ?>
		        </div>
		    </div>
	     <?php
	     }
        endwhile;
        wp_reset_postdata();
		$args = array(
			'cat' => $cat_id,
			'posts_per_page' => 6
			);
		$query = new WP_Query($args);
		if($query->have_posts()):
			$count_service = 1;
            while ($query->have_posts()): $query->the_post();
			if($count_service==1){
				echo '<div class="service-row wow fadeInRight">';
			}	
		?>		
        <div class="service-list clearfix">
        	<?php if(has_post_thumbnail()): ?>
			<div class="service-image">
				<?php 
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'wpparallax-service-thumb',true); 
				?>
				<a href="<?php the_permalink();?>">
					<img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>">
				</a>		
			</div>
			<?php endif; ?>

			<div class="service-detail">
				<h3>
					<a href="<?php the_permalink();?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<div class="service-content">
					<p> <?php echo esc_attr(wp_trim_words(get_the_content(),15)); ?></p>
				</div>
			</div>
		</div>
         <?php
        $count_service++;
        if( $count_service==3 ){
            echo '</div>';
            $count_service=1;
        }
		
			endwhile;
			wp_reset_postdata();
		endif;
	?>
	</div>