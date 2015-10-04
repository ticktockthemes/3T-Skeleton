/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to configure supported social nerworks.
 */

(function($) {
	$.TTT_Social_Config_Control = function(data) {
		var self = this;

		self.data = data;

		setTimeout(function() {
			self.init();
		}, 1000);
	};

	$.TTT_Social_Config_Control.prototype = {
		init: function() {
			var self = this;

			// Get control container.
			self.container = $('#' + self.data.type + '-' + self.data.settings['default']);

			// Set linked options visibility.
			for (var i in ttt_supported_social_networks) {
				if (!self.data.value || !self.data.value[i]) {
					$('[data-network="' + i + '"]').addClass('hidden');
				}
			}

			// Track change in input fields.
			self.container.on('change', 'input[type="text"]', function() {
				var value = {};

				self.container.find('input[type="text"]').each(function(i, e) {
					value[$(e).attr('name')] = $(e).val();
				});

				wp.customize.control(self.data.settings['default']).setting.set(value);

				// Set linked options visibility.
				if ($(this).val() == '') {
					$('[data-network="' + $(this).attr('name') + '"]').addClass('hidden');
				} else {
					$('[data-network="' + $(this).attr('name') + '"]').removeClass('hidden');
				}
			});
		},
	}
})(jQuery);