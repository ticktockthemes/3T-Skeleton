/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to manage location box that will be displayed in map.
 */

(function($) {
	$.TTT_Location_Control = function(data) {
		var self = this;

		self.data = data;

		setTimeout(function() {
			self.init();
		}, 1000);
	};

	$.TTT_Location_Control.prototype = {
		init: function() {
			var self = this;

			// Get control container.
			self.container = $('#' + self.data.type + '-' + self.data.settings['default']);

			// Define Backbone model for location box.
			var LocationBox = Backbone.Model.extend({
				urlRoot: '#',

				// Default attributes for item.
				defaults: {
					index: null,
					enable: true,
					latitude: '',
					longitude: '',
					content: '',
				},

				// Toggle the `enable` state of this item.
				toggle: function() {
					this.save({
						enable: !this.get('enable'),
					});
				}
			}),

			LocationBoxView = Backbone.View.extend({
				// … is a div tag.
				tagName: 'div',

				// The DOM events specific to an item.
				events: {
					'click .toggle-location': 'toggle',
					'click .remove-location': 'destroy',
					'change .input-text'    : 'update',
				},

				initialize: function() {
					// Cache the template function for a single item.
					this.template = _.template(jQuery('#ttt-location-control-template').text());

					// Listen to necessary events.
					this.listenTo(this.model, 'destroy', this.remove);
				},

				// Render the item.
				render: function() {
					this.$el.html(this.template(this.model.toJSON()));

					return this;
				},

				toggle: function() {
					this.model.toggle();
				},

				destroy: function() {
					this.model.destroy();
				},

				update: function(event) {
					this.model.set($(event.target).attr('name'), $(event.target).val());
				},
			}),

			LocationBoxList = Backbone.Collection.extend({
				// Reference to this collection’s model.
				model: LocationBox,

				// Fetch existing items.
				fetch: function() {
					// Add saved items to collection.
					for (var i = 0; i < self.data.value.length; i++) {
						this.create({
							index: i + 1,
							enable: self.data.value[i].enable,
							latitude: self.data.value[i].latitude,
							longitude: self.data.value[i].longitude,
							content: self.data.value[i].content,
						});
					}
				},
			});

			LocationBoxListView = Backbone.View.extend({
				// Instead of generating a new element, bind to the existing skeleton of the list already present in the HTML.
				el: self.container,

				// Delegate events for creating new item and updating existing item.
				events: {
					'click .add-location'   : 'create',
					'click .toggle-location': 'update',
					'change .input-text'    : 'update',
				},

				initialize: function() {
					// Create new collection.
					this.collection = new LocationBoxList();

					// At initialization we bind to the relevant events on the collection, when items are added or changed.
					this.listenTo(this.collection, 'add', this.addOne);
					this.listenTo(this.collection, 'reset', this.addAll);

					// Kick things off by loading any preexisting location boxes that might be saved before.
					this.collection.fetch();
				},

				// Add a single item to the list by creating a view for it, and appending its element to the table.
				addOne: function(item) {
					// Set item title.
					if (!item.get('index')) {
						item.set('index', this.$el.find('.location-boxes').children().length + 1);
					}

					// Create view.
					var view = new LocationBoxView({model: item});
					this.$el.find('.location-boxes').append(view.render().$el.hide());
					view.render().$el.slideDown();
				},

				// Add all items in the collection at once.
				addAll: function() {
					this.collection.each(this.addOne, this);
				},

				// Create new item.
				create: function() {
					this.collection.create();
				},

				// Update changes.
				update: function() {
					var value = [];

					this.collection.each(function(item) {console.log(154, item);
						value.push({
							enable: item.get('enable'),
							latitude: item.get('latitude'),
							longitude: item.get('longitude'),
							content: item.get('content'),
						});
					});

					wp.customize.control(self.data.settings['default']).setting.set(value);
				},
			});

			new LocationBoxListView();
		},
	}
})(jQuery);