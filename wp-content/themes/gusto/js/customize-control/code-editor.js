/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to setup code editor.
 */

(function($) {
	$.TTT_Code_Editor_Control = function(data) {
		var self = this;

		self.data = data;

		setTimeout(function() {
			self.init();
		}, 1000);
	};

	$.TTT_Code_Editor_Control.prototype = {
		init: function() {
			var self = this;

			// Get control container.
			self.container = $('#' + self.data.type + '-' + self.data.settings['default']);

			// Setup code editor.
			self.container.on('click', '.codemirror', function() {
				var ThisCodeMirror;

				ThisCodeMirror = CodeMirror(
					function(elt) {
						self.container.find('.codemirror').replaceWith(
							$(elt).on('change', function() {
								var value = ThisCodeMirror.getValue();

								if (wp.customize.control(self.data.settings['default']).setting.get() != value) {
									wp.customize.control(self.data.settings['default']).setting.set(value);
								}
							})
						);

						$(elt).find('.CodeMirror-scroll').trigger('click');
					},
					{
						mode: self.data.language,
						autofocus: true,
						value: self.container.find('.codemirror').val(),
					}
				);
			});
		},
	}
})(jQuery);