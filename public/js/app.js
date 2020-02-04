jQuery(function ($) {
	'use strict';

	Handlebars.registerHelper('eq', function (a, b, options) {
		return a === b ? options.fn(this) : options.inverse(this);
	});

	var ENTER_KEY = 13;
	var ESCAPE_KEY = 27;

	var ajax = {
		url: '/front/steps',
		index: function (callback) {
			$.ajax({
				method: 'GET',
				url: this.url,
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					callback(JSON.parse(data));
				});
		},
	};

	var App = {
		init: function () {
			ajax.index(function (todo) {
				App.render(todo);
			});
			this.todoTemplate = Handlebars.compile($('#todo-template').html());
			this.footerTemplate = Handlebars.compile($('#footer-template').html());
		},
		render: function (todo = null) {
			if (todo) {
				this.todo = todo;
			}
			$('.todo-list').html(this.todoTemplate(todo.steps));
		},
	};

	App.init();
});
