/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to customize typography.
 */

(function($) {
	$.TTT_Typography_Control = function(data) {
		var self = this;

		self.data = data;

		setTimeout(function() {
			self.init();
		}, 1000);
	};

	$.TTT_Typography_Control.prototype = {
		init: function() {
			var self = this;

			// Get control container, font family selector and advanced panel toggler.
			self.container = $('#' + self.data.type + '-' + self.data.settings['default']);
			self.family_input = self.container.find('select[name="font_family"]');
			self.toggle_panel = self.container.find('.expand-panel').html('&gt;');

			// Define Backbone model for typography customization.
			var TypographyCustomization = Backbone.Model.extend({
				urlRoot: '#',

				// Default attributes for item.
				defaults: {
					font_family: '',
					font_size: '',
					line_height: '',
					spacing: '',
					font_style: '',
					text_transform: '',
					subset: '',
				},
			}),

			// Define Backbone view for typography customization.
			TypographyCustomizationView = Backbone.View.extend({
				// … is a div tag.
				tagName: 'div',

				initialize: function() {
					// Cache the template function for a single item.
					this.template = _.template(jQuery('#ttt-typography-control-template').text());
				},

				// Render the item.
				render: function() {
					this.$el.html(this.template(this.model.toJSON()));

					return this;
				},
			});

			// Init advanced settings panel.
			self.view = new TypographyCustomizationView({
				model: new TypographyCustomization(self.data.value),
			});

			$(document.body).append(self.view.render().$el);

			// Define function to update changes.
			function update(event) {
				self.view.model.set($(event.target).attr('name'), $(event.target).val());

				// Update changes to theme customize object.
				var value = {
					font_family: self.view.model.get('font_family'),
					font_size: self.view.model.get('font_size'),
					line_height: self.view.model.get('line_height'),
					spacing: self.view.model.get('spacing'),
					font_style: self.view.model.get('font_style'),
					text_transform: self.view.model.get('text_transform'),
					subset: self.view.model.get('subset'),
				};

				wp.customize.control(self.data.settings['default']).setting.set(value);
			};

			// Track change in font family selector.
			self.family_input.change(function(event) {
				update(event);
			});

			// Track change in advanced settings panel.
			self.view.$el.on('change', 'input[name], select[name]', function(event) {
				update(event);
			});

			// Setup action to show advanced settings panel.
			self.toggle_panel.click(function(event) {
				if (!self.toggle_panel.hasClass('open')) {
					// Close all opened advanced panel.
					$('.ttt-typography .expand-panel.open').trigger('click');
				}

				setTimeout(function() {
					// Toggle the advanced settings panel.
					self.view.$el.children('.panel').toggleClass('open');

					// Update text for advanced panel toggler.
					self.toggle_panel.toggleClass('open');
					self.toggle_panel.html(self.toggle_panel.hasClass('open') ? '&lt;' : '&gt;');
				}, 100);
			});
		},
	}
})(jQuery);