/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	//header search Enable or disable
	wp.customize("wp_parallax_search_enable", function(value) {
	    value.bind(function(to) {
	        if( to == 'show') {
	            $(".search-wrap").css('display','block');
	        } 
	        else {
	            $(".search-wrap").css('display','none');
	        }
	    } );
	});

	//header cart Enable or disable
	wp.customize("wp_parallax_cart_enable", function(value) {
	    value.bind(function(to) {
	        if( to == 'show') {
	            $(".wpop-shopping-cart").css('display','block');
	        } 
	        else {
	            $(".wpop-shopping-cart").css('display','none');
	        }
	    } );
	});

	//footer icons Enable or disable
	wp.customize("wp_parallax_footer_icon_show", function(value) {
	    value.bind(function(to) {
	        if( to == 'show') {
	            $(".footer-right").css('display','block');
	        } 
	        else {
	            $(".footer-right").css('display','none');
	        }
	    } );
	});

} )( jQuery );
