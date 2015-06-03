/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to toggle dependency options.
 */

( function( $ ) {
	$(document).ready(function() {
		// Setup options toggle for Theme Layout
		$('#customize-control-theme_layout label.btn').click(function() {
			var func = $(this).children().val() == 'full' ? 'addClass' : 'removeClass';
	
			$('#customize-control-boxed_background_image')[func]('hide');
			$('#customize-control-boxed_background_repeat')[func]('hide');
			$('#customize-control-boxed_background_position')[func]('hide');
			$('#customize-control-boxed_background_attachment')[func]('hide');
			$('#customize-control-boxed_background_size')[func]('hide');
		}).filter('.active').trigger('click');

		// Setup options toggle for Logo Type
		$('#customize-control-logo_type label.btn').click(function() {
			if ($(this).children().val() == 'text') {
				$('#customize-control-text_logo').removeClass('hide');
				$('#customize-control-image_logo').addClass('hide');
				$('#customize-control-image_retina_logo').addClass('hide');
			} else {
				$('#customize-control-text_logo').addClass('hide');
				$('#customize-control-image_logo').removeClass('hide');
				$('#customize-control-image_retina_logo').removeClass('hide');
			}
		}).filter('.active').trigger('click');
	});
} )( jQuery );
