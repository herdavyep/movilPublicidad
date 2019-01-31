<?php

/**
 * Wpparallax hooks
 */

/**
 * Header
 * @see  wp_parallax_skip_links() - 0
 * @see  wp_parallax_top_header() - 10
 * @see wp_parallax_top_nav (filter for top header navigation)
 * @see  wp_parallax_button_header() - 20
 */
add_action( 'wp_parallax_header', 'wp_parallax_skip_links', 	  0 );
add_action( 'wp_parallax_header', 'wp_parallax_top_header', 10 );
add_action( 'wp_parallax_header', 'wp_parallax_button_header', 20 );

/* Breadcrumb hook */
add_action( 'wp_parallax_breadcrumb', 'wp_parallax_header_banner_x');

/*slider hook */

add_action('wpop_main_slider','wp_parallax_slider');

/**
 * Footer
 * @see  wp_parallax_footer_widgets() - 0
 * @see  wp_parallax_credit() - 10
 */
add_action( 'wp_parallax_footer', 'wp_parallax_footer_widgets', 	  0 );
add_action( 'wp_parallax_footer', 'wp_parallax_credit', 10 );

