
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpparallax
 */

get_header(); 
$wpparallax_layout = esc_attr(get_post_meta($post->ID, 'wpparallax_page_options', true));

$wpparallax_layout = !empty($wpparallax_layout)?$wpparallax_layout:'default_layout';

if($wpparallax_layout=='default_layout'){
do_action('wp_parallax_breadcrumb');
?>

	<div class="wpop-container clearfix">
		<div class="inner-container clearfix">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">

					<?php
					while ( have_posts() ) : the_post();
						the_content();

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div>		
	</div>
<?php
}else{
	?>
      <div class="wpparallax-home">
		<?php
		while ( have_posts() ) : the_post();

			the_content();

		endwhile; // End of the loop.
		?>      	
      </div>
	<?php
}
get_footer();
