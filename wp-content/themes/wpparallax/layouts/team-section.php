<?php
/**
 * The template for displaying all Parallax Templates.
 *
 * @package wpparallax
 */
?>
<div class="team clearfix">
<?php 
    $query = new WP_Query( 'page_id='.$page_id );
    while ( $query->have_posts() ) : $query->the_post();
      $section_title = get_the_title();
	      if($show_title == 'on'){
	      wp_parallax_section_title($section_title);
	      }
    endwhile;
    wp_reset_postdata();?>

	<div class="team-block-wrapper">
		<?php 
		$args = array(
			'cat' => $cat_id,
			'posts_per_page' => 5
			);
		$query = new WP_Query($args);
		if($query->have_posts()): ?>
		<div class="team-thumb-wrap">
		<?php
			while($query->have_posts()):
				$query->the_post();
			?>
			<a id="team-<?php echo the_ID(); ?>" class="team-thumb" href="#">
			<?php 
			if(has_post_thumbnail()):
				the_post_thumbnail('thumbnail'); 
			else: ?>
				<img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/team-dummy.jpg'); ?>">
			<?php
			endif;
			?>
			</a>
		<?php endwhile; ?>
		</div> <!-- team-thumb-wrap -->
		<?php endif; ?>

		<?php 
		$args = array(
			'cat' => $cat_id,
			'posts_per_page' => 5
			);
		$query = new WP_Query($args);
		if($query->have_posts()): ?>
		<div class="team-content-wrap">
		<?php
			while($query->have_posts()):
				$query->the_post();
			?>
			<div class="team-content team-<?php echo the_ID() ?>"> 
				<div class="team-quote"><?php the_excerpt(); ?></div>
				<div class="speaker-name">-<?php the_title(); ?></div>
			</div>
		<?php endwhile; ?>
		</div> <!-- team-thumb-wrap -->
		<?php endif; ?>
	</div> <!-- team-block-wrapper -->
</div> <!-- team section -->