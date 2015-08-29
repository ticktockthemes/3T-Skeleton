/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to manage location box that will be displayed in map.
 */

(function($) {
	$.Gusto = $.Gusto || {};

	if (!$.Gusto.LocationBox) {
		$.Gusto.LocationBox = {
			Item: Backbone.Model.extend({
				urlRoot: '#',

				// Default attributes for item.
				defaults: {
					enable: 'yes',
					latitude: '',
					longitude: '',
					content: '',
				},
			}),

			ItemView: Backbone.View.extend({
				// … is a div tag.
				tagName: 'div',

				initialize: function() {
					// Cache the template function for a single item.
					this.template = _.template(jQuery('#ttt-location-control-template').text());
				},

				// Render the item.
				render: function() {
					this.$el.html(this.template(this.model.toJSON()));

					return this;
				},
			}),
		};

		$.Gusto.LocationBox.List = Backbone.Collection.extend({
			// Reference to this collection’s model.
			model: $.Gusto.LocationBox.Item,

			// Fetch existing items.
			fetch: function(storage) {
				// Get saved data from storage.
				var data = jQuery.unserialize(jQuery(storage).val());

				// Add saved items to collection.
				for (var i = 0; i < data.enable.length; i++) {
					this.create({
						enable: data.enable[i],
						latitude: data.latitude[i],
						longitude: data.longitude[i],
						content: data.content[i],
					});
				}

				// Save storage for later update.
				this.storage = storage;
			},

			// Update changes to storage.
			update: function(container) {
				var data = container.find('input[name], textarea[name]').serialize();

				// Convert all special characters to HTML entities.
				data = data.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
					return '&#'+i.charCodeAt(0)+';';
				});

				this.storage.val(data).trigger('change');
			},
		});

		$.Gusto.LocationBox.ListView = Backbone.View.extend({
			// Instead of generating a new element, bind to the existing skeleton of the list already present in the HTML.
			el: null,

			// Delegate events for creating new item and updating existing item.
			events: {
				'click .add-location'    : 'create',
				'click .toggle-location' : 'toggle',
				'click .remove-location' : 'remove',
				'change .input-text'     : 'update',
			},

			initialize: function() {
				// Create new collection.
				this.collection = new $.Gusto.LocationBox.List();

				// At initialization we bind to the relevant events on the collection, when items are added or changed.
				this.listenTo(this.collection, 'add', this.addOne);
				this.listenTo(this.collection, 'reset', this.addAll);

				// Kick things off by loading any preexisting location boxes that might be saved before.
				this.collection.fetch(this.$('.data-storage'));
			},

			// Add a single item to the list by creating a view for it, and appending its element to the table.
			addOne: function(item) {
				// Set item title.
				item.set('index', this.$('.location-boxes').children().length + 1);

				// Create view.
				var view = new $.Gusto.LocationBox.ItemView({model: item});
				this.$('.location-boxes').append(view.render().el);
			},

			// Add all items in the collection at once.
			addAll: function() {
				this.collection.each(this.addOne, this);
			},

			// Create new item.
			create: function() {
				this.collection.create();
			},

			// Toggle the 'enable' state of the model.
			toggle: function(event) {
				var value = this.$(event.target).attr('checked') ? 'yes' : 'no';
				
				this.$(event.target).parent().next().val(value);
				
				this.update();
			},

			// Remove an item.
			remove: function(event) {
				this.$(event.target).closest('.panel').parent().remove();
				
				this.update();
			},
			
			// Update changes to storage.
			update: function() {
				this.collection.update(this.$('.location-boxes'));
			},
		});
	}
})(jQuery);
