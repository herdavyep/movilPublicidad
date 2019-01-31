<?php

/**
 * Query WooCommerce activation
 * @since  1.0.0
 */
if ( ! function_exists( 'wp_parallax_is_woocommerce_activated' ) ) {
    function wp_parallax_is_woocommerce_activated() {
        return class_exists( 'woocommerce' ) ? true : false;
    }
}

/**
* Parallax sections Layouts
*
*/
if(!function_exists('wp_parallax_section_layouts')){
	function wp_parallax_section_layouts(){
		$layouts = array('about'=> esc_html__('About Layout','wpparallax'),
    			         'service'=> esc_html__('Service Layout','wpparallax'),
    			         'portfolio'=> esc_html__('Portfolio Layout','wpparallax'),
    			         'testimonial'=> esc_html__('Testimonial Layout','wpparallax'),
                         'team'=> esc_html__('Team Layout','wpparallax'),
                         'blog'=> esc_html__('Blog Layout','wpparallax'),
    			         'callto'=> esc_html__('Call to Action','wpparallax'),
                         'map'=> esc_html__('Google Map','wpparallax')
    			        );
		return $layouts;
	}
}
/**
* Parallax Menu
*
*/
function wp_parallax_get_parallax_sections() {
	$wpparallax_homepage = get_theme_mod('wp_parallax_homepage');
	$values = json_decode($wpparallax_homepage);
    if($values!=''){
	foreach( $values as $value):
	$page_id = $value->wp_parallax_page;
	$menu_name = $value->wp_parallax_menu_text;
            $enabled_section[] = array(
                'id' => 'section-' . $page_id,
                'menu_text' => $menu_name,
            );
    endforeach;
    return $enabled_section;
}
}

/*Get nav menu */

if(!function_exists('wp_parallax_nav')){
	function wp_parallax_nav(){
		?>
	<nav id="site-navigation" class="main-navigation">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i></button>
		<?php
		    $wpparallax_plx_menu_enable = get_theme_mod('wp_parallax_menu_type');
	        if( $wpparallax_plx_menu_enable == 'hide' ){ ?>
	            <ul class="nav plx-nav">
	                <li class="current">
	                    <a href="<?php echo esc_url(home_url()); ?>/#plx-slider-section" >
	                        <?php esc_html_e('Home', 'wpparallax'); ?>
	                    </a>
	                </li>
	                <?php
	                $wpparallax_enabled_sections = wp_parallax_get_parallax_sections('menu');
                    if($wpparallax_enabled_sections!=''){
	                foreach ($wpparallax_enabled_sections as $wpparallax_enabled_section) : ?>
	                    <?php if($wpparallax_enabled_section['menu_text'] != '') : ?>
	                    <li>
	                        <a href="<?php echo esc_url(home_url()); ?>/#<?php echo esc_attr($wpparallax_enabled_section['id']) ?>" >
	                            <?php  echo esc_attr($wpparallax_enabled_section['menu_text']); ?>
	                        </a>
	                    </li>
	                    <?php endif; ?>
	                    <?php
	                endforeach; }?>
	            </ul>
	            <?php        
	        }else{			
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',

			) );
		}
        $search_enable = get_theme_mod('wp_parallax_search_enable','show');
        $cart_enable = get_theme_mod('wp_parallax_cart_enable','show');
        if($search_enable == 'show' || $cart_enable == 'show'){
		  wp_parallax_search_cart();
        }
		?>
	</nav><!-- #site-navigation -->
		<?php
	}
}

if(!function_exists('wp_parallax_search_cart')){
	function wp_parallax_search_cart(){
		?>
        <div class="search-cart-wrap clearfix">
		    	
			<?php 
            $cart_enable = get_theme_mod('wp_parallax_cart_enable','show');
            if ( wp_parallax_is_woocommerce_activated() && $cart_enable == 'show' ) { ?>
			<div class="wpop-shopping-cart">
                    <?php wp_parallax_shopping_cart();
                    the_widget( 'WC_Widget_Cart', 'title=' ); 
				?>
			</div>
			<?php }
            $search_enable = get_theme_mod('wp_parallax_search_enable','show');
            if($search_enable == 'show'){?>
            <div class="search-wrap">
				<div class="search-icon">							
					<i class="fa fa-search"></i>
				</div>
			</div>
            <?php }?>          
		</div><!-- .search-cart-wrap-->				
		<?php
	}
}

/*===========================================================================================================*/
/**
 * Function for section title
 */

if(!function_exists('wp_parallax_section_title')){
	function wp_parallax_section_title($title){
		?>
    <div class="section-title-wrap wow fadeInUp">
        <h2 class="section-title">
            <?php echo esc_html($title); ?>
        </h2>
    </div>
		<?php
	}
}


/*===========================================================================================================*/
/**
 * Function for Breadcrumb
 */
function wp_parallax_breadcrumbs() {
    global $post;
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show

    $delimiter = '&gt;';

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $homeLink = esc_url( home_url() );

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1)
            echo '<div id="wpparallax-breadcrumb"><a href="' . esc_url($homeLink) . '">' . esc_attr__('Home', 'wpparallax') . '</a></div></div>';
    } else {

        echo '<div id="wpparallax-breadcrumb"><a href="' . esc_url($homeLink) . '">' . esc_attr__('Home', 'wpparallax') . '</a> ' . esc_attr($delimiter) . ' ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0)
                echo get_category_parents($thisCat->parent, TRUE, ' ' . esc_attr($delimiter) . ' ');
            echo '<span class="current">' . esc_html__('Archive by category','wpparallax').' "' . single_cat_title('', false) . '"' . '</span>';
        } elseif (is_search()) {
            echo '<span class="current">' . esc_html__('Search results for','wpparallax'). '"' . get_search_query() . '"' . '</span>';
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . esc_attr($delimiter) . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . esc_attr($delimiter) . ' ';
            echo '<span class="current">' . get_the_time('d') . '</span>';
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . esc_attr($delimiter) . ' ';
            echo '<span class="current">' . get_the_time('F') . '</span>';
        } elseif (is_year()) {
            echo '<span class="current">' . get_the_time('Y') . '</span>';
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . esc_url($homeLink) . '/' . esc_attr($slug['slug']) . '/">' . esc_attr($post_type->labels->singular_name) . '</a>';
                if ($showCurrent == 1)
                    echo ' ' . esc_attr($delimiter) . ' ' . '<span class="current">' . get_the_title() . '</span>';
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                if ($showCurrent == 0)
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                echo wp_parallax_sanitize_breadcrumb($cats);
                if ($showCurrent == 1)
                    echo '<span class="current">' . get_the_title() . '</span>';
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo '<span class="current">' . esc_attr($post_type->labels->singular_name) . '</span>';
        } elseif (is_attachment()) {
            if ($showCurrent == 1) echo ' ' . '<span class="current">' . get_the_title() . '</span>';
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1)
                echo '<span class="current">' . get_the_title() . '</span>';
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo wp_parallax_sanitize_breadcrumb($breadcrumbs[$i]);
                if ($i != count($breadcrumbs) - 1)
                    echo ' ' . esc_attr($delimiter). ' ';
            }
            if ($showCurrent == 1)
                echo ' ' . esc_attr($delimiter) . ' ' . '<span class="current">' . get_the_title() . '</span>';
        } elseif (is_tag()) {
            echo '<span class="current">' . esc_attr__('Posts tagged','wpparallax').' "' . single_tag_title('', false) . '"' . '</span>';
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo '<span class="current">' . esc_attr__('Articles posted by ','wpparallax'). esc_attr($userdata->display_name) . '</span>';
        } elseif (is_404()) {
            echo '<span class="current">' . 'Error 404' . '</span>';
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo esc_attr__('Page', 'wpparallax') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }

        echo '</div>';
    }
}


/* Filter for gallery images */

add_filter( 'wp_get_attachment_link', 'wp_parallax_sant_prettyadd' );

function wp_parallax_sant_prettyadd ($content) {
   $content = preg_replace("/<a/","<a rel=\"prettyPhoto[slides]\"",$content,1);
   return $content;
}