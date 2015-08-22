/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to toggle dependency options.
 */

(function($) {
	var GustoOptionsView = Backbone.View.extend({
		// Instead of generating a new element, bind to the existing skeleton of the list already present in the HTML.
		el: $('#customize-theme-controls'),

		// Delegate events for toggling child options.
		events: {
			// Register event to show customizer sections by default.
			'click li[id^="accordion-panel-ttt_panel_"]' : 'showOptions',

			// Register event to toggle child options for Theme Layout.
			'click #customize-control-theme_layout .button-group li' : 'toggleThemeLayout',

			// Register event to toggle child options for Logo Type.
			'click #customize-control-logo_type .button-group li' : 'toggleLogoType',

			// Register event to toggle child options for Custom Font.
			'change #customize-control-custom_font .switch input' : 'toggleCustomFont',

			// Register event to toggle child options for Header Social Icons.
			'change #customize-control-show_header_social_icons .switch input' : 'toggleHeaderSocialIcons',

			// Register event to toggle child options for Footer Widgets.
			'change #customize-control-footer_widgets .switch input' : 'toggleFooterWidgets',

			// Register event to toggle child options for Custom Copyright.
			'change #customize-control-custom_copyright .switch input' : 'toggleCustomCopyright',

			// Register event to toggle child options for Footer Social Icons.
			'change #customize-control-show_footer_social_icons .switch input' : 'toggleFooterSocialIcons',

			// Register event to toggle child options for Automatic Post Excerpts.
			'change #customize-control-automatic_post_excerpts .switch input' : 'toggleAutomaticPostExcerpts',

			// Register event to toggle child options for Location Box.
			'change #customize-control-location_box .switch input' : 'toggleLocationBox',

			// Register event to toggle child options for Custom Marker.
			'change #customize-control-custom_marker .switch input' : 'toggleCustomMarker',

			// Register event to toggle child options for Custom CSS.
			'change #customize-control-custom_css .switch input' : 'toggleCustomCSS',
		},

		// Initialize theme options panel
		initialize: function() {
			setTimeout(function() {
				// Move all customizer controls from sections to panels
				jQuery('li[id^="accordion-panel-ttt_panel_"]').each(function(i, e) {
					if (jQuery(e).attr('id').indexOf('ttt_panel_advances') < 0) {
						// Remove section title
						jQuery(e).find('li[id^="accordion-section-ttt_"] > h3').remove();
					}
				});
				
				// Trigger click event on active options to toggle appropriated child options.
				jQuery('#customize-control-theme_layout .button-group li').filter('.active').trigger('click');
				jQuery('#customize-control-logo_type .button-group li').filter('.active').trigger('click');

				// Trigger change event on checked options to toggle appropriated child options.
				jQuery('#customize-control-custom_font .switch input').trigger('change');
				jQuery('#customize-control-show_header_social_icons .switch input').trigger('change');
				jQuery('#customize-control-footer_widgets .switch input').trigger('change');
				jQuery('#customize-control-custom_copyright .switch input').trigger('change');
				jQuery('#customize-control-show_footer_social_icons .switch input').trigger('change');
				jQuery('#customize-control-automatic_post_excerpts .switch input').trigger('change');
				jQuery('#customize-control-location_box .switch input').trigger('change');
				jQuery('#customize-control-custom_marker .switch input').trigger('change');
				jQuery('#customize-control-custom_css .switch input').trigger('change');
			}, 500);
		},

		// Method to show customizer options.
		showOptions: function(event) {
			var panel = jQuery(event.target).closest('li');

			if (panel.attr('id').indexOf('ttt_panel_advances') < 0) {
				panel.find('li[id^="accordion-section-ttt_"]').addClass('open');
			}
		},

		// Method to toggle child options for Theme Layout.
		toggleThemeLayout: function(event) {
			var func = event.target.parentNode.querySelector('input').value == 'full' ? 'hide' : 'show';

			this.$('#customize-control-boxed_layout-background_image')[func]();
			this.$('#customize-control-boxed_layout-background_repeat')[func]();
			this.$('#customize-control-boxed_layout-background_position')[func]();
			this.$('#customize-control-boxed_layout-background_attachment')[func]();
			this.$('#customize-control-boxed_layout-background_size')[func]();
		},

		// Method to toggle child options for Logo Type.
		toggleLogoType: function(event) {
			if (event.target.parentNode.querySelector('input').value == 'text') {
				this.$('#customize-control-text_logo').show();
				this.$('#customize-control-image_logo').hide();
				this.$('#customize-control-image_retina_logo').hide();
			} else {
				this.$('#customize-control-text_logo').hide();
				this.$('#customize-control-image_logo').show();
				this.$('#customize-control-image_retina_logo').show();
			}
		},

		// Method to toggle child options for Custom Font.
		toggleCustomFont: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-custom_fonts')[func]();
		},

		// Method to toggle child options for Header Social Icons.
		toggleHeaderSocialIcons: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-header_social_icons')[func]();
		},

		// Method to toggle child options for Footer Widgets.
		toggleFooterWidgets: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-footer_widgets_layout')[func]();
		},

		// Method to toggle child options for Custom Copyright.
		toggleCustomCopyright: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-custom_copyright_text')[func]();
		},

		// Method to toggle child options for Footer Social Icons.
		toggleFooterSocialIcons: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-footer_social_icons')[func]();
		},

		// Method to toggle child options for Automatic Post Excerpts.
		toggleAutomaticPostExcerpts: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-automatic_excerpts_length')[func]();
		},

		// Method to toggle child options for Location Box.
		toggleLocationBox: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-location_box_data')[func]();
		},

		// Method to toggle child options for Custom Marker.
		toggleCustomMarker: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-custom_marker_image')[func]();
		},

		// Method to toggle child options for Custom CSS.
		toggleCustomCSS: function(event) {
			var func = event.target.checked ? 'show' : 'hide';

			this.$('#customize-control-custom_css_data')[func]();
		},
	});

	$(document).ready(function() {
		// Initialize theme options panel
		var GustoOptions = new GustoOptionsView;
	});
})(jQuery);
