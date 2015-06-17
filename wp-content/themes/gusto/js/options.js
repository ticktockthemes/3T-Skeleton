/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to toggle dependency options.
 */

( function( $ ) {
	$(document).ready(function() {
		// Setup options toggle for Theme Layout
		var layoutHide = $('#customize-control-theme_layout .button-group li.active input').val() == 'full' ? 'hide' : 'show'; 

		$('#customize-control-boxed_layout-background_image')[layoutHide]();
		$('#customize-control-boxed_layout-background_repeat')[layoutHide]();
		$('#customize-control-boxed_layout-background_position')[layoutHide]();
		$('#customize-control-boxed_layout-background_attachment')[layoutHide]();
		$('#customize-control-boxed_layout-background_size')[layoutHide]();

		$('#customize-control-theme_layout .button-group li a').click(function() {
			var func = $(this).children('input').val() == 'full' ? 'hide' : 'show';
	
			$('#customize-control-boxed_layout-background_image')[func]();
			$('#customize-control-boxed_layout-background_repeat')[func]();
			$('#customize-control-boxed_layout-background_position')[func]();
			$('#customize-control-boxed_layout-background_attachment')[func]();
			$('#customize-control-boxed_layout-background_size')[func]();
		}).filter('.active').trigger('click');

		// Setup options toggle for Logo Type
		var logoTextHide 	= $('#customize-control-logo_type .button-group li.active input').val() == 'text' ? 'hide' : 'show',
			logoImageHide 	= $('#customize-control-logo_type .button-group li.active input').val() == 'image' ? 'hide' : 'show';
		$('#customize-control-image_logo')[logoTextHide]();
		$('#customize-control-image_retina_logo')[logoTextHide]();
		$('#customize-control-text_logo')[logoImageHide]();

		$('#customize-control-logo_type .button-group li a').click(function() {
			if ($(this).children('input').val() == 'text') {
				$('#customize-control-text_logo').show();
				$('#customize-control-image_logo').hide();
				$('#customize-control-image_retina_logo').hide();
			} else {
				$('#customize-control-text_logo').hide();
				$('#customize-control-image_logo').show();
				$('#customize-control-image_retina_logo').show();
			}
		}).filter('.active').trigger('click');

		// Setup options toggle for Custom Font
		$('#customize-control-custom_font .button-group li a').click(function() {
			var func = $(this).children('input').val() == 'no' ? 'hide' : 'show';
	
			$('#customize-control-custom_fonts')[func]();
		}).filter('.active').trigger('click');

		// Setup options toggle for WP color picker
		// $('.customize-control-color .wp-picker-container .wp-color-result').click(function() {
		// 	$(this).closest('li.customize-control-color').toggleClass('picker-open');
		// });
	});
} )( jQuery );
