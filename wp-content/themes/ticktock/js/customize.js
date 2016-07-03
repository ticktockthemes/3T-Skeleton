(function($) {
	$(window).load(function() {
		setTimeout(function() {
			var api = wp.customize;

			// Setup Color Picker custom control.
			$('.ui.form.color-picker').each(function(i, e) {
				$(e).find('input').spectrum({
					showInput: true,
					showInitial: true,
					allowEmpty: true,
					showAlpha: true,
					clickoutFiresChange: true,
					preferredFormat: 'hex',
					color: api.control($(e).attr('id')).setting.get() != '' ? api.control($(e).attr('id')).setting.get() : null,
					change: function(color) {
						api.control($(e).attr('id')).setting.set(color.getAlpha() == 1 ? color.toHexString() : color.toRgbString());
					}
				});
			});

			// Setup Dropdown Select and Typography custom control.
			$('.ui.form.dropdown-select, .ui.form.typography').each(function(i, e) {
				$(e).find('select').val(api.control($(e).attr('id')).setting.get()).dropdown();

				$(e).find('.menu .item').click(function() {
					api.control($(e).attr('id')).setting.set($(this).data('value'));
				});
			});

			// Setup Radio Button custom control.
			$('.ui.form.radio-button').each(function(i, e) {
				$(e).find('button[data-value="' + api.control($(e).attr('id')).setting.get() + '"]').addClass('positive');

				$(e).on('click', 'button', function() {
					$(this).addClass('positive').siblings().removeClass('positive');
					api.control($(e).attr('id')).setting.set($(this).data('value'));
				});
			});

			// Setup Toggle custom control.
			$('.ui.form.toggle').each(function(i, e) {
				if (api.control($(e).attr('id')).setting.get()) {
					$(e).find('input').attr('checked', 'checked');
				}

				$(e).find('.ui.toggle.checkbox').checkbox();

				$(e).on('change', 'input', function() {
					api.control($(e).attr('id')).setting.set(this.checked ? 1 : 0);
				});
			});

			// Setup dependencies for Theme Layout option.
			$('#theme_layout.ui.form').on('click', 'button', function() {
				$('[id^="customize-control-boxed_background"]')[api.control('theme_layout').setting.get() == 'boxed' ? 'show' : 'hide']();
			}).closest('.control-section').children('h3').click(function() {
				$('[id^="customize-control-boxed_background"]')[api.control('theme_layout').setting.get() == 'boxed' ? 'show' : 'hide']();
			});

			// Setup dependencies for Logo Type option.
			$('#logo_type.ui.form').on('click', 'button', function() {
				$('#customize-control-logo_text')[api.control('logo_type').setting.get() == 'text' ? 'show' : 'hide']();
				$('[id^="customize-control-logo_image"]')[api.control('logo_type').setting.get() == 'image' ? 'show' : 'hide']();
			}).closest('.control-section').children('h3').click(function() {
				$('#customize-control-logo_text')[api.control('logo_type').setting.get() == 'text' ? 'show' : 'hide']();
				$('[id^="customize-control-logo_image"]')[api.control('logo_type').setting.get() == 'image' ? 'show' : 'hide']();
			});

			// Setup dependencies for Footer Widget Area option.
			api.control('footer_widget_area').setting.bind('change', function() {
				$('#customize-control-manage_footer_widgets')[api.control('footer_widget_area').setting.get() ? 'show' : 'hide']();
			});

			$('#footer_widget_area.ui.form').closest('.control-section').children('h3').click(function() {
				$('#customize-control-manage_footer_widgets')[api.control('footer_widget_area').setting.get() ? 'show' : 'hide']();
			});

			// Setup dependencies for Show Copyright option.
			api.control('show_copyright').setting.bind('change', function() {
				$('#customize-control-custom_copyright_text')[api.control('show_copyright').setting.get() ? 'show' : 'hide']();
			});

			$('#show_copyright.ui.form').closest('.control-section').children('h3').click(function() {
				$('#customize-control-custom_copyright_text')[api.control('show_copyright').setting.get() ? 'show' : 'hide']();
			});
		}, 2000);
	});

	// Define function to manager footer widgets.
	$.ticktock_manage_footer_widgets = function() {
		// Jump to option panel to manage widgets at 'footer_widget_area' sidebar.
		$('#accordion-section-sidebar-widgets-footer_widget_area > h3').trigger('click');

		// Override the back button to return to the Footer option panel.
		setTimeout(function() {
			var orig = $('.customize-section-back:visible'), cloned = orig.clone(false);

			orig.hide().after(cloned.click(function() {
				$('#accordion-section-footer > h3').trigger('click');

				// Restore the original back button.
				cloned.remove();
				orig.show();
			}));
		}, 1000);
	};
})(jQuery);
