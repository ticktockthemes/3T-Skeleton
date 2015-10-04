/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to manage social icons.
 */

(function($) {
	$.TTT_Social_Icons_Control = function(data) {
		var self = this;

		self.data = data;

		setTimeout(function() {
			self.init();
		}, 1000);
	};

	$.TTT_Social_Icons_Control.prototype = {
		init: function() {
			var self = this;

			// Get control container.
			self.container = $('#' + self.data.type + '-' + self.data.settings['default']);

			// Setup link to configure social networks.
			self.container.on('click', 'a[data-linked]', function() {
				var linked = $('#ttt-social-config-' + $(this).attr('data-linked'));

				linked.closest('.accordion-section').find('.accordion-section-title').trigger('click');
			});

			// Track change in input fields.
			self.container.on('change', 'input[type="checkbox"]', function() {
				var value = {};

				self.container.find('input[type="checkbox"]').each(function(i, e) {
					if (e.checked && !$(e).closest('[data-network]').hasClass('hidden')) {
						value[$(e).attr('name')] = 1;
					}
				});

				wp.customize.control(self.data.settings['default']).setting.set(value);
			});
		},
	}
})(jQuery);