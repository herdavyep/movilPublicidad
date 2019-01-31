<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wpparallax
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpparallax_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    if(is_search()){
        $classes[] = 'rightsidebar';
    }
    if(is_singular(array( 'post','page' ))){
        global $post;
        $post_sidebar = get_post_meta($post->ID, 'wpparallax_page_layouts', true);
        if(!$post_sidebar){
            $post_sidebar = 'rightsidebar';
        }
        
         $classes[] = $post_sidebar;
        
    }
        if( is_archive() || is_home() ){
        $post_sidebar = get_theme_mod('archive_page_sidebars_layout','rightsidebar');
        if(!$post_sidebar){
            $post_sidebar = 'rightsidebar';
        }

        $classes[] = esc_html($post_sidebar);
    }

    if ( wp_parallax_is_woocommerce_activated() ) {
        
        if( is_product_category() || is_shop() || is_singular('product')) {
            $woo_page_layout = 'rightsidebar';
            $classes[] = $woo_page_layout;
        }
    }
	return $classes;
}
add_filter( 'body_class', 'wpparallax_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function wp_parallax_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'wp_parallax_pingback_header' );

/*
** Theme Custom Functions Goes here...
*================================================================================================*/

if ( ! function_exists( 'wp_parallax_skip_links' ) ) {
	/**
	 * Skip links
	 * @since  1.0.0
	 * @return void
	 */
	function wp_parallax_skip_links() {
		?>
			<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'wpparallax' ); ?></a>
			<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'wpparallax' ); ?></a>
		<?php
	}
}
/*Social Icons */
if(!function_exists('wp_parallax_social_icons')){
	function wp_parallax_social_icons(){
		$fb = get_theme_mod('wp_parallax_Facebook');
		$twet = get_theme_mod('wp_parallax_Twitter');
		$insta = get_theme_mod('wp_parallax_Instagram');
		$pin = get_theme_mod('wp_parallax_Pinterest');
		?>
		<div class="header-icons">
			<ul>
				<?php if($fb){?>
				<li><a href="<?php echo esc_url($fb)?>"><i class="fa fa-facebook"></i></a></li>
				<?php }?>
				<?php if($twet){?>
				<li><a href="<?php echo esc_url($twet)?>"><i class="fa fa-twitter"></i></a></li>
				<?php }?>
				<?php if($insta){?>
				<li><a href="<?php echo esc_url($insta)?>"><i class="fa fa-instagram"></i></a></li>
				<?php }?>
				<?php if($pin){?>
				<li><a href="<?php echo esc_url($pin)?>"><i class="fa fa-pinterest"></i></a></li>
				<?php }?>														
			</ul>
		</div>
		<?php
	}
}

/*Header Info */

if(!function_exists('wp_parallax_header_info')){
	function wp_parallax_header_info(){
		$contact_no = get_theme_mod('wp_parallax_header_contact');
		$email = get_theme_mod('wp_parallax_header_email');
	    ?>
	    <div class="header-info">
	    	<ul>
	    		<?php if($contact_no):?>
			    	<li>
			    		<i class="fa fa-phone"></i>
			    		<a href="callto:<?php echo esc_attr($contact_no);?>"><?php echo esc_html($contact_no);?></a>
			    	</li>
			        <?php endif; if($email):?>
			        <li>
			        	<i class="fa fa-envelope"></i>
			        	<a href="mailto<?php echo esc_attr($email);?>"><?php echo esc_html($email);?></a>
			        </li>
		        <?php endif;?>	
	    	</ul>	    	
	    </div>
	    <?php
	}
}

/* Top Header */

if(!function_exists('wp_parallax_top_header')){
	function wp_parallax_top_header(){ 
        $top_header_show = get_theme_mod('wp_parallax_top_header_show','show');
        if($top_header_show == 'show'):
		?>
		<div class="top-header">
			<div class="wpop-container">
				<div class="top-header-wrap clearfix">
					<?php 
					  wp_parallax_header_info();
					  wp_parallax_social_icons();
					?>
				</div>
			</div>
		</div>
		<?php
		endif;
	}
}

if ( ! function_exists( 'wp_parallax_button_header' ) ) {
	/**
	 * Display Site Branding
	 * @since  1.0.0
	 * @return void
	 */
	function wp_parallax_button_header() { ?>
		<div class="header-wrap">
			<div class="wpop-container">
			    <div class="nav-wrap clearfix">
					<div class="site-branding">
						<?php
							if ( function_exists( 'the_custom_logo' ) ) {
								the_custom_logo();
							}
						?>
						<div class="as-logo-wrap">
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : 
							?>
							<p class="site-description"><?php echo esc_attr($description); ?></p>
							<?php endif; ?>
						</div>
					</div><!-- .site-branding -->
	                <?php wp_parallax_nav();?>
                </div>
			</div>
		</div>
	
	<?php
	}
}


/*Slider function */
if(!function_exists('wp_parallax_slider')){
	function wp_parallax_slider(){	
		$slider_options = get_theme_mod( 'wp_parallax_slider_show','show' );
		if($slider_options == 'show' ){ ?>
			<ul class="wpop-slider cS-hidden">
				<?php
				    $slider_cat_id = intval( get_theme_mod( 'wp_parallax_slider_cat', '0' ));
				    if( !empty( $slider_cat_id ) ) {
				    $slider_args = array(
				        'post_type' => 'post',
				        'tax_query' => array(
				            array(
				                'taxonomy'  => 'category',
				                'field'     => 'id', 
				                'terms'     => $slider_cat_id                                                                 
				            )),
				        'posts_per_page' => 8
				    );
				    $slider_query = new WP_Query( $slider_args );
				    if( $slider_query->have_posts() ) { while( $slider_query->have_posts() ) { $slider_query->the_post();

				    $image_path = wp_get_attachment_image_src( get_post_thumbnail_id(), 'wpparallax-slider-image', true );	                          
				?>
				<li class="main-slider">
					<img src="<?php echo esc_url($image_path[0]); ?>" alt="<?php the_title_attribute(); ?>"/>
					<div class="banner-slider-info">
						<h2 class="caption-title wow fadeInUp" data-wow-duration="0.7s">										
							<?php
                             the_title();
							?>
						</h2>
						<div class="caption-content wow fadeInUp" data-wow-duration="0.7s">
							<?php echo esc_attr(wp_trim_words( get_the_content(), 10)); ?>
						</div>
						<a class="slider-button wow fadeInRight" data-wow-duration="0.7s" href="<?php the_permalink(); ?>">
							<?php echo esc_html__('View More','wpparallax'); ?>
						</a>								
					</div>
				</li>
				<?php  } } wp_reset_postdata();  } ?> 
			</ul>
			<?php
        }
    }
}

/*breadcrumb */

if(!function_exists('wp_parallax_header_banner_x')){
function wp_parallax_header_banner_x() {
            
    $breadcrumb_enable = get_theme_mod('wp_parallax_breadcrumb_section_option','show');
    if($breadcrumb_enable=='show'){
    if(is_page_template( 'tmpl-home.php' ) || is_home() || is_front_page()):
    else :

        ?>
            <div class="header-banner-container">
                <div class="wpop-container">
                    <div class="page-title-wrap">
                        <?php
                            if(is_archive()) {
                                the_archive_title( '<h1 class="page-title">', '</h1>' );
                            } elseif(is_single() || is_singular('page')) {
                                wp_reset_postdata();
                                the_title('<h1 class="page-title">', '</h1>');
                            } elseif(is_search()) {
                                ?>
                                <h1 class="page-title"><?php printf(esc_html__( 'Search Results for: %s', 'wpparallax' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                                <?php
                            } elseif(is_404()) {
                                ?>
                                <h1 class="page-title"><?php esc_html_e( '404 Error', 'wpparallax' ); ?></h1>
                                <?php
                            }elseif(is_product){
                            	the_title( '<h1 class="page-title">', '</h1>' );

                            }else{
                            	the_archive_title( '<h1 class="page-title">', '</h1>' );
                            }
	                          
	                        wp_parallax_breadcrumbs();	    
                        ?>
                    </div>
                </div>
            </div>
        <?php
    endif;
}
}
}

/**
 * Footer Section Function Area
**/

if ( ! function_exists( 'wp_parallax_footer_widgets' ) ) {
	/**
	 * Display the theme footer widgets
	 * @since  1.0.0
	 * @return void
	 */
	function wp_parallax_footer_widgets() {

        if ( is_active_sidebar( 'footer-4' ) ) {
			$widget_columns = apply_filters( 'wp_parallax_footer_widget_regions', 4 );		
        } elseif ( is_active_sidebar( 'footer-3' ) ) {
			$widget_columns = apply_filters( 'wp_parallax_footer_widget_regions', 3 );
		} elseif ( is_active_sidebar( 'footer-2' ) ) {
			$widget_columns = apply_filters( 'wp_parallax_footer_widget_regions', 2 );
		} elseif ( is_active_sidebar( 'footer-1' ) ) {
			$widget_columns = apply_filters( 'wp_parallax_footer_widget_regions', 1 );
		} else {
			$widget_columns = apply_filters( 'wp_parallax_footer_widget_regions', 0 );
		}

		if ( $widget_columns > 0 ) : ?>

			<section class="footer-widgetswrap col-<?php echo intval( $widget_columns ); ?> clearfix">				
				<div class="top-footer-wrap">
					<div class="wpop-container clearfix">
						<?php $i = 0; while ( $i < $widget_columns ) : $i++; ?>		
							<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>		
								<div class="block footer-widget wow fadeInRight">
						        	<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
								</div>		
					        <?php endif; ?>		
						<?php endwhile; ?>
					</div>
				</div>
			</section><!-- .footer-widgets  -->
	    <?php endif;
	}
}

if(! function_exists('wp_parallax_footer_info')){
	function wp_parallax_footer_info(){
		$footer_copyright = get_theme_mod('wp_parallax_footer_text');
		?>
		<div class="footer-left wow fadeInLeft">
			<?php if( !empty( $footer_copyright ) ) { ?>
				<?php echo wp_kses_post(apply_filters( 'wp_parallax_copyright_text', $footer_copyright )); ?>	
			<?php } else ?>

			<?php if ( apply_filters( 'wp_parallax_credit_link', true ) ) { 
				/*printf( esc_html__( '%1$s By %2$s', 'wpparallax' ), ' ', '<a href=" ' . esc_url('https://wpoperation.com/') . ' " rel="designer" target="_blank">Wpoperation</a>' ); */?>
			<?php }?>
		</div><!-- .footer-left -->			
		<?php
	}
}

if ( ! function_exists( 'wp_parallax_credit' ) ) {
	/**
	 * Display the theme credit/button footer
	 * @since  1.0.0
	 * @return void
	 */
	function wp_parallax_credit() {
		$footer_social = get_theme_mod('wp_parallax_footer_icon_show','show');
		
		?>
			<div class="bottom-footer">	
				<div class="wpop-container clearfix">
                      <?php  wp_parallax_footer_info();?>
					<div class="footer-right wow fadeInRight">
						<?php 
						if($footer_social=='show'){
                          wp_parallax_social_icons();
						}
						?>
					</div>
				</div>
			</div>			
		<?php
	}
}