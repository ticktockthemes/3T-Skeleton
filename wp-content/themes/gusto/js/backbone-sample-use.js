/**
 * @version    $Id$
 * @package    HiSella
 * @author     BraveBits Co., Ltd. <admin@bravebits.vn>
 * @copyright  Copyright (C) 2014 BraveBits Co., Ltd. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.bravebits.vn/
 */

/**
 * Base list handler.
 */
jQuery(function($) {
	var Item = Backbone.Model.extend({
		// Default attributes for list item.
		defaults: function() {
			return {
				title: "empty todo...",
				order: Todos.nextOrder(),
				done: false
			};
		},

		// Toggle the done state of list item.
		toggle: function() {
			this.save({done: !this.get("done")});
		}
	});

	var ItemList = Backbone.Collection.extend({
		// Reference to this collection’s model.
		model: Item,

		// Save all of the items under the "items-backbone" namespace.
		localStorage: new Backbone.LocalStorage('items-backbone'),

		// Filter down the list of all items that are finished.
		done: function() {
			return this.where({done: true});
		},

		// Filter down the list to only items that are still not finished.
		remaining: function() {
			return this.where({done: false});
		},

		// We keep the items in sequential order, despite being saved by unordered GUID in the database.
		// This generates the next order number for new items.
		nextOrder: function() {
			if (!this.length) return 1;
			return this.last().get('order') + 1;
		},

		// Items are sorted by their original insertion order.
		comparator: 'order',
	});

	// Create our global collection of items.
	var Items = new ItemList;

	var ItemView = Backbone.View.extend({
		// … is a table row tag.
		tagName:  'tr',

		// Cache the template function for a single item.
		template: _.template($('#item-template').html()),

		// The DOM events specific to an item.
		events: {
			'click .toggle'   : 'toggleDone',
			'dblclick .view'  : 'edit',
			'click a.destroy' : 'clear',
			'keypress .edit'  : 'updateOnEnter',
			'blur .edit'      : 'close',
		},

		// The ItemView listens for changes to its model, re-rendering.
		// Since there’s a one-to-one correspondence between an Item and an ItemView in this list app,
		// we set a direct reference on the model for convenience.
		initialize: function() {
			this.listenTo(this.model, 'change', this.render);
			this.listenTo(this.model, 'destroy', this.remove);
		},

		// Re-render the titles of the todo item.
		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			this.$el.toggleClass('done', this.model.get('done'));
			this.input = this.$('.edit');
			return this;
		},

		// Toggle the 'done' state of the model.
		toggleDone: function() {
			this.model.toggle();
		},

		// Switch this view into 'editing' mode, displaying the input field.
		edit: function() {
			this.$el.addClass('editing');
			this.input.focus();
		},

		// Close the 'editing' mode, saving changes to the item.
		close: function() {
			var value = this.input.val();
			if (!value) {
				this.clear();
			} else {
				this.model.save({title: value});
				this.$el.removeClass('editing');
			}
		},

		// If you hit enter, we’re through editing the item.
		updateOnEnter: function(e) {
			if (e.keyCode == 13) this.close();
		},

		// Remove the item, destroy the model.
		clear: function() {
			this.model.destroy();
		}
	});

	var ListView = Backbone.View.extend({
		// Instead of generating a new element, bind to the existing skeleton of the list already present in the HTML.
		el: $('#item-list'),

		// Our template for the line of statistics at the bottom of the app.
		statsTemplate: _.template($('#stats-template').html()),

		// Delegate events for creating new items, and clearing completed ones.
		events: {
			'keypress #new-todo'     : 'createOnEnter',
			'click #clear-completed' : 'clearCompleted',
			'click #toggle-all'      : 'toggleAllComplete',
		},

		// At initialization we bind to the relevant events on the Items collection, when items are added or changed.
		// Kick things off by loading any preexisting items that might be saved in localStorage.
		initialize: function() {
			this.input = this.$('#new-item');
			this.allCheckbox = this.$('#toggle-all')[0];

			this.listenTo(Items, 'add', this.addOne);
			this.listenTo(Items, 'reset', this.addAll);
			this.listenTo(Items, 'all', this.render);

			this.footer = this.$('footer');
			this.main = $('#main');

			Items.fetch();
		},

		// Re-rendering the list just means refreshing the statistics — the rest of the list doesn’t change.
		render: function() {
			var done = Todos.done().length;
			var remaining = Todos.remaining().length;

			if (Todos.length) {
				this.main.show();
				this.footer.show();
				this.footer.html(this.statsTemplate({done: done, remaining: remaining}));
			} else {
				this.main.hide();
				this.footer.hide();
			}

			this.allCheckbox.checked = !remaining;
		},

		// Add a single item to the list by creating a view for it, and appending its element to the table.
		addOne: function(item) {
			var view = new ItemView({model: item});
			this.$('#item-list').append(view.render().el);
		},

		// Add all items in the Items collection at once.
		addAll: function() {
			Items.each(this.addOne, this);
		},

		// If you hit return in the main input field, create new Item model, persisting it to localStorage.
		createOnEnter: function(e) {
			if (e.keyCode != 13) return;
			if (!this.input.val()) return;

			Items.create({title: this.input.val()});
			this.input.val('');
		},

		// Clear all done items, destroying their models.
		clearCompleted: function() {
			_.invoke(Items.done(), 'destroy');
			return false;
		},

		toggleAllComplete: function () {
			var done = this.allCheckbox.checked;
			Items.each(function(item) { item.save({'done': done}); });
		}
	});

	var List = new ListView;
});
