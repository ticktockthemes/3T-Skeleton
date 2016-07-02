/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Preview Theme Layout option.
	wp.customize( 'theme_layout', function( value ) {
		value.bind( function( to ) {
			console.log( 'theme_layout', to );
		} );
	} );

	// Preview Background Image option for Boxed layout.
	wp.customize( 'boxed_background_image', function( value ) {
		value.bind( function( to ) {
			console.log( 'boxed_background_image', to );
		} );
	} );

	// Preview Background Repeat option for Boxed layout.
	wp.customize( 'boxed_background_repeat', function( value ) {
		value.bind( function( to ) {
			console.log( 'boxed_background_repeat', to );
		} );
	} );

	// Preview Background Position option for Boxed layout.
	wp.customize( 'boxed_background_position', function( value ) {
		value.bind( function( to ) {
			console.log( 'boxed_background_position', to );
		} );
	} );

	// Preview Background Attachment option for Boxed layout.
	wp.customize( 'boxed_background_attachment', function( value ) {
		value.bind( function( to ) {
			console.log( 'boxed_background_attachment', to );
		} );
	} );

	// Preview Background Size option for Boxed layout.
	wp.customize( 'boxed_background_size', function( value ) {
		value.bind( function( to ) {
			console.log( 'boxed_background_size', to );
		} );
	} );

	// Preview Page Transition Loading option.
	wp.customize( 'page_transition_loading', function( value ) {
		value.bind( function( to ) {
			console.log( 'page_transition_loading', to );
		} );
	} );

	// Preview Go-to-top Link option.
	wp.customize( 'go_to_top_link', function( value ) {
		value.bind( function( to ) {
			console.log( 'go_to_top_link', to );
		} );
	} );

	// Preview Use Unminified CSS option.
	wp.customize( 'use_unminified_css', function( value ) {
		value.bind( function( to ) {
			console.log( 'use_unminified_css', to );
		} );
	} );

	// Preview Logo Type option.
	wp.customize( 'logo_type', function( value ) {
		value.bind( function( to ) {
			console.log( 'logo_type', to );
		} );
	} );

	// Preview Logo Text option.
	wp.customize( 'logo_text', function( value ) {
		value.bind( function( to ) {
			console.log( 'logo_text', to );
		} );
	} );

	// Preview Logo Image option.
	wp.customize( 'logo_image', function( value ) {
		value.bind( function( to ) {
			console.log( 'logo_image', to );
		} );
	} );

	// Preview Logo Image For Retina option.
	wp.customize( 'logo_image_for_retina', function( value ) {
		value.bind( function( to ) {
			console.log( 'logo_image_for_retina', to );
		} );
	} );

	// Preview Site Icon option.
	wp.customize( 'site_icon', function( value ) {
		value.bind( function( to ) {
			console.log( 'site_icon', to );
		} );
	} );

	// Preview Heading Font option.
	wp.customize( 'heading_font', function( value ) {
		value.bind( function( to ) {
			console.log( 'heading_font', to );
		} );
	} );

	// Preview Body Font option.
	wp.customize( 'body_font', function( value ) {
		value.bind( function( to ) {
			console.log( 'body_font', to );
		} );
	} );

	// Preview Color Scheme option.
	wp.customize( 'color_scheme', function( value ) {
		value.bind( function( to ) {
			console.log( 'color_scheme', to );
		} );
	} );

	// Preview Accent Color option.
	wp.customize( 'accent_color', function( value ) {
		value.bind( function( to ) {
			console.log( 'accent_color', to );
		} );
	} );

	// Preview Sticky Header option.
	wp.customize( 'sticky_header', function( value ) {
		value.bind( function( to ) {
			console.log( 'sticky_header', to );
		} );
	} );

	// Preview Show Search Box option.
	wp.customize( 'show_search_box', function( value ) {
		value.bind( function( to ) {
			console.log( 'show_search_box', to );
		} );
	} );

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
} )( jQuery );
