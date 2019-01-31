<?php
function wpparallax_dynamic_styles(){

    $header_image = get_theme_mod('wp_parallax_breadcrumb_image','');

    $output_css = '';

    if($header_image){ 

        $output_css .=
             '.header-banner-container{
                background-image: url('.esc_url($header_image).');
                background-repeat: no-repeat;
            }';
    }

    /**
    * Theme Color 
    */    
    $theme_color = get_theme_mod('wp_parallax_theme_color');
    $output_css .= "
            a, a:hover, a:focus, a:active, .header-icons ul li a:hover, .header-info ul li a:hover, .site-header.layout3 #site-navigation ul li a:hover, #site-navigation ul li.current-menu-item a, 
            .site-header.layout3 #site-navigation ul li.current a, #site-navigation ul li a:hover, #site-navigation ul li.current-menu-item a, 
            #site-navigation ul li.current a, section:hover .section-title:nth-child(even), section:focus .section-title:nth-child(even), .about a.read-more, .service-list .service-detail h3 a:hover, .blog-section .blogsinfo .blog-info a:hover,
            .blog-section .blog-info ul li a:hover span, .footer-widgetswrap .block.footer-widget ul a:hover, .bottom-footer .footer-right ul a:hover, .content-blog .main-blog-right .btn-readmore a:after, .content-blog .main-blog-right .title-text:hover,
            .content-blog .main-blog-right .btn-readmore a:hover, .content-blog .main-blog-right .metadata li:hover a, .pagination .current, .nav-links a:hover,.backtohome a:hover, .comment-wrapper .media-heading a,
            .content-blog .metadata .comment:hover, .comment-left a:hover, a.read-more,
            .comment-left a:hover:before, input[type=submit].woocommerce-Button:hover, 
            .comment-wrapper .media-body a:hover, .widget-area ul li:hover > a,
            .widget_recent_entries ul li:hover > a,
            .widget_pages ul li:hover > a,
            .widget_meta ul li:hover > a,
            .widget_archive ul li:hover > a,
            .widget_categories ul li:hover > a,
            .widget_nav_menu ul li:hover > a,
            .widget_recent_comments ul li:hover > a,
            .widget_recent_comments ul li .comment-author-link:hover a, .widget-area ul li:hover > a:before,
            .widget_recent_entries ul li:hover > a:before,
            .widget_pages ul li:hover > a:before,
            .widget_meta ul li:hover > a:before,
            .widget_archive ul li:hover > a:before,
            .widget_categories ul li:hover > a:before,
            .widget_nav_menu ul li:hover > a:before, 
            .woocommerce.woocommerce-page ul.products li.product .add_to_cart_button:hover,
            .woocommerce.woocommerce-page ul.products li.product .product_type_simple:hover,
            .woocommerce .cart .coupon input.button[type='submit']:hover,
            .woocommerce .place-order .button.alt:hover,
            .widget_shopping_cart_content a.button:hover, .woocommerce .woocommerce-breadcrumb a,
            .widget_price_filter .price_slider_amount button[type=submit]:hover,
            .woocommerce .cart button[type=submit].single_add_to_cart_button:hover,
            .woocommerce #review_form #respond .form-submit input:hover, .woocommerce ul.products li.product .add_to_cart_button:hover,.woocommerce ul.products li.product .price
            {
             color: $theme_color;
            }
            .button, input[type='button'], input[type='reset'], input[type='submit'], .full-search-container .search-form .search-submit, .full-search-container .closebtn, a.slider-button:hover, #plx-slider-section .lSSlideOuter .lSPager.lSpg > li:hover a, 
            #plx-slider-section .lSSlideOuter .lSPager.lSpg > li.active a, .section-title::before, .service-list .service-image,
            .testimonial-section .lSSlideOuter .lSPager.lSpg > li:hover a, .about a.read-more:hover, .nav-links a,.backtohome a,
            .testimonial-section .lSSlideOuter .lSPager.lSpg > li.active a, .widget-area .widget .widget-title:before, .widget_search .search-form .search-submit, .page-title-wrap .page-title:before, input[type=submit].woocommerce-Button,
            .woocommerce.woocommerce-page .onsale, .woocommerce.woocommerce-page .related.products .product .onsale, .woocommerce .onsale, .woocommerce .onsale, 
            .woocommerce.woocommerce-page ul.products li.product .add_to_cart_button, a.read-more:hover,
            .woocommerce.woocommerce-page ul.products li.product .product_type_simple,
            .woocommerce .cart .coupon input.button[type='submit'],
            .woocommerce .place-order .button.alt, .woocommerce .wc-proceed-to-checkout a.button.alt,
             .widget_shopping_cart_content a.button, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
            .widget_price_filter .price_slider_amount button[type=submit], .woocommerce-MyAccount-navigation ul li.is-active a,
            .woocommerce .cart button[type=submit].single_add_to_cart_button, .woocommerce-MyAccount-content fieldset legend:before,
            .woocommerce #review_form #respond .form-submit input, .woocommerce ul.products li.product .add_to_cart_button
            {
              background-color: $theme_color;
            } 

            .button, input[type='button'], input[type='reset'], input[type='submit'], .site-header.layout3, .site-header.layout3 .sticky-wrapper.is-sticky .header-wrap, a.slider-button:hover, .about a.read-more,
            .about a.read-more:hover, .team-content-wrap, .team-thumb.active:after, .pagination .current, .nav-links a,.backtohome a, .nav-links a:hover,.backtohome a:hover, input[type=submit].woocommerce-Button,
            .woocommerce.woocommerce-page ul.products li.product .add_to_cart_button, a.read-more,
            .woocommerce.woocommerce-page ul.products li.product .product_type_simple,
            .woocommerce .cart .coupon input.button[type='submit'],
            .woocommerce .place-order .button.alt, .woocommerce-error, 
             .widget_shopping_cart_content a.button,
            .widget_price_filter .price_slider_amount button[type=submit],
            .woocommerce .cart button[type=submit].single_add_to_cart_button,
            .woocommerce #review_form #respond .form-submit input, .woocommerce ul.products li.product .add_to_cart_button
            {
              border-color: $theme_color;
            } 

           .woocommerce.woocommerce-page  .onsale:before, .woocommerce .onsale:before, .woocommerce .onsale:before{
            border-color: transparent $theme_color transparent transparent;
           }
    "; 
    /**
    * Section font color 
    */
    $wp_parallax_homepage = get_theme_mod('wp_parallax_homepage');
    $wp_parallax_homepage_colors = json_decode($wp_parallax_homepage);
    if($wp_parallax_homepage_colors != ''):
    foreach( $wp_parallax_homepage_colors as $wp_parallax_homepage_color ){
        $font_color =  isset($wp_parallax_homepage_color->wp_parallax_section_txt_color) ? $wp_parallax_homepage_color->wp_parallax_section_txt_color : '';
        $layouts = $wp_parallax_homepage_color->wp_parallax_layout;
        $layout = '.'.$layouts.'-layout';
        
        if( $font_color ){
             $output_css .= 
                     "$layout{
                        color:".esc_html($font_color).";
                }";
        }
    }
    endif;

    wp_add_inline_style('wpparallax-style', $output_css);
} 
add_action('wp_enqueue_scripts', 'wpparallax_dynamic_styles');   