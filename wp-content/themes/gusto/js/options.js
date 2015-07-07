/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to toggle dependency options.
 */

( function( $ ) {
	$(document).ready(function() {
		// Setup options toggle for Theme Layout
		$('#customize-control-theme_layout .button-group li').click(function() {
			var func = $(this).find('input').val() == 'full' ? 'hide' : 'show';

			$('#customize-control-boxed_layout-background_image')[func]();
			$('#customize-control-boxed_layout-background_repeat')[func]();
			$('#customize-control-boxed_layout-background_position')[func]();
			$('#customize-control-boxed_layout-background_attachment')[func]();
			$('#customize-control-boxed_layout-background_size')[func]();
		}).filter('.active').trigger('click');

		// Setup options toggle for Logo Type
		$('#customize-control-logo_type .button-group li').click(function() {
			if ($(this).find('input').val() == 'text') {
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
		$('#customize-control-custom_font .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';
	
			$('#customize-control-custom_fonts')[func]();
		}).trigger('change');

		// Setup options toggle for Header Social Icons
		$('#customize-control-show_header_social_icons .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';

			$('#customize-control-header_social_icons')[func]();
		}).trigger('change');

		// Setup options toggle for Footer Widgets
		$('#customize-control-footer_widgets .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';
	
			$('#customize-control-footer_widgets_layout')[func]();
		}).trigger('change');

		// Setup options toggle for Custom Copyright
		$('#customize-control-custom_copyright .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';
	
			$('#customize-control-custom_copyright_text')[func]();
		}).trigger('change');

		// Setup options toggle for Footer Social Icons
		$('#customize-control-show_footer_social_icons .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';

			$('#customize-control-footer_social_icons')[func]();
		}).trigger('change');

		// Setup options toggle for Automatic Post Excerpts
		$('#customize-control-automatic_post_excerpts .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';

			$('#customize-control-automatic_excerpts_length')[func]();
		}).trigger('change');

		// Setup options toggle for Location Box
		$('#customize-control-location_box .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';

			$('#customize-control-location_box_data')[func]();
		}).trigger('change');

		// Setup options toggle for Custom Marker
		$('#customize-control-custom_marker .switch input').change(function() {
			var func = this.checked ? 'show' : 'hide';

			$('#customize-control-custom_marker_image')[func]();
		}).trigger('change');
	});
} )( jQuery );
