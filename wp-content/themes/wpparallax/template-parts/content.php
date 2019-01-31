<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wpparallax
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wow slideInUp'); ?>>
	<div class="entry-content content-blog">

		<?php 
			if( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID() ), 'wpparallax-single-blog-image', true);
		?>
			<div class="main-blog-left">
				<div class="wp-img">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $image[0] ); ?>" class="img-responsive">
					</a>
				</div>
			</div>
		<?php } ?>
		
		<div class="main-blog-right">		

				<a href="<?php the_permalink(); ?>" class="title-text"><?php the_title(); ?></a>
		
			<ul class="metadata">
				<li class="author"><i class="fa fa-user"></i> <?php the_author(); ?></li>
				<li><i class="fa fa-folder-open"></i> <?php the_category( ', ' ) ?></li>
				<li class="date"><i class="fa fa-calendar"></i> <span><?php echo the_time( 'd F Y' ); ?></span></li>
				<li class="comment"><i class="fa fa-comment"></i> <span><?php comments_popup_link('No Comments', 'Comment : 1', 'Comments : %'); ?></span></li>
			</ul>

			<div class="description">
				<?php
	              $content_length = get_theme_mod('wp_parallax_archive_page_excerpts',400);
	              ?>
					<p> <?php echo esc_attr( wp_trim_words(get_the_content(),absint($content_length)) ); ?>
						<div class="btn-readmore"><a href="<?php the_permalink();?>"><?php echo esc_html__('Read More','wpparallax');?></a></div>
					</p>	              
	              <?php

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wpparallax' ),
						'after'  => '</div>',
					) );
				?>
				<div class="tags">
					<?php the_tags( ); ?>
				</div>
			</div>

		</div>
		
	</div><!-- .entry-content -->

</article><!-- #post-## -->