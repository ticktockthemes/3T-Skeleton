/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to manage custom fonts.
 */

(function($) {
	$.Gusto = $.Gusto || {};

	if (!$.Gusto.Typography) {
		$.Gusto.Typography = {
			Item: Backbone.Model.extend({
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

			ItemView: Backbone.View.extend({
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
			}),
		};

		$.Gusto.Typography.List = Backbone.Collection.extend({
			// Reference to this collection’s model.
			model: $.Gusto.Typography.Item,

			// Fetch existing items.
			fetch: function(storage) {
				// Get saved data from storage.
				var data = jQuery(storage).text();

				if (data) {
					// JSON decode saved data
					data = jQuery.parseJSON(data);

					// Add saved items to collection.
					for (var i in data) {
						// Set type to data
						data[i].type = i;

						this.create(data[i]);
					}
				}

				// Save storage for later update.
				this.storage = storage;
			},

			// Update changes to storage.
			update: function(container) {
				var data = {}, key;
				
				container.find('input[name], select[name]').each(function(i, e) {
					// Parse field name
					key = e.name.match(/^([^\[]+)\[([^\]]+)\]$/);

					if (key) {
						if (!data[key[1]]) {
							data[key[1]] = {};
						}
						
						data[key[1]][key[2]] = e.value;
					}
				});

				// Convert all special characters to HTML entities.
				data = JSON.stringify(data).replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
					return '&#'+i.charCodeAt(0)+';';
				});

				this.storage.val(data).trigger('change');
			},
		});

		$.Gusto.Typography.ListView = Backbone.View.extend({
			// Instead of generating a new element, bind to the existing skeleton of the list already present in the HTML.
			el: null,

			// Delegate events for creating new item and updating existing item.
			events: {
				'click .expand-panel' : 'expand',
				'change input[name]'  : 'update',
				'change select[name]' : 'update',
			},

			initialize: function() {
				// Create new collection.
				this.collection = new $.Gusto.Typography.List();

				// At initialization we bind to the relevant events on the collection, when items are added or changed.
				this.listenTo(this.collection, 'add', this.addOne);
				this.listenTo(this.collection, 'reset', this.addAll);

				// Kick things off by loading any preexisting location boxes that might be saved before.
				this.collection.fetch(this.$('.data-storage'));
			},

			// Add a single item to the list by creating a view for it, and appending its element to the table.
			addOne: function(item) {
				// Create view.
				var view = new $.Gusto.Typography.ItemView({model: item});
				this.$('.typography-types').append(view.render().el);
			},

			// Add all items in the collection at once.
			addAll: function() {
				this.collection.each(this.addOne, this);
			},
		
			// Expand advanced settings panel.
			expand: function(event) {
				var self = this, panel = jQuery(event.target).closest('label').children('.panel');
				
				// Check if panel is already opened.
				if (jQuery(event.target).hasClass('open')) {
					jQuery(event.target).prop('advanced-panel').removeClass('open');
					jQuery(event.target).removeClass('open').html('&gt;');

					return setTimeout(function() {
						jQuery(event.target).prop('advanced-panel').remove();
					}, 300);
				}

				// Close any visible advanced settings panel.
				jQuery(event.target).closest('.typography-types').find('.expand-panel.open').trigger('click');
				
				// Clone the advanced settings panel to document body.
				var open_panel = panel.clone().appendTo(document.body);
				
				// Open the advanced settings panel.
				setTimeout(function() {
					open_panel.addClass('open');
				}, 1);
				
				// Track changes in the advanced settings panel.
				open_panel.on('change', 'input[name], select[name]', function(event) {
					// Update value to original panel.
					panel.find('input[name], select[name]').each(function(i, e) {
						if (jQuery(e).attr('name') == jQuery(event.target).attr('name')) {
							jQuery(e).val(jQuery(event.target).val());
						}
					});
					
					self.update();
				})
				
				// Store panel for later reference.
				jQuery(event.target).addClass('open').html('&lt;').prop('advanced-panel', open_panel);
			},
			
			// Update changes to storage.
			update: function() {
				this.collection.update(this.$('.typography-types'));
			},
		});
	}
})(jQuery);
