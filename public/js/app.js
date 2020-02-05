jQuery(function ($) {
	'use strict';

	Handlebars.registerHelper('eq', function (a, b, options) {
		return a === b ? options.fn(this) : options.inverse(this);
	});

	const ENTER_KEY = 13;
	const ESCAPE_KEY = 27;

	let ajax = {
		url: '/steps',
		index: function (callback) {
			$.ajax({
				method: 'GET',
				url: this.url
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					callback(JSON.parse(data));
				});
		},
		store: function (body, callback) {
			$.ajax({
				method: 'POST',
				url: this.url,
				data: { body: body }
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					const result = JSON.parse(data);
					result.success !== false ? callback(result) : App.showMessage(result.message);
				});
		},
		update: function (id, body, callback) {
			$.ajax({
				method: 'POST',
				url: this.url + '/' + id,
				data: {
					body: body,
					_method: 'PUT'
				},
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					const result = JSON.parse(data);
					result.success !== false ? callback(id, body) : App.showMessage(result.message);
				});
		},
		destroy: function (id, callback) {
			$.ajax({
				method: 'POST',
				url: this.url + '/' + id,
				data: { _method: 'DELETE' }
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					const result = JSON.parse(data);
					result.success !== false ? callback(id) : App.showMessage(result.message);
				});
		},
		destroyCompleted: function (callback) {
			$.ajax({
				method: 'POST',
				url: this.url + '/completed',
				data: { _method: 'DELETE' }
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					const result = JSON.parse(data);
					result.success !== false ? callback() : App.showMessage(result.message);
				});
		},
		toggleCompleted: function (id, isCompleted, callback) {
			$.ajax({
				method: 'POST',
				url: this.url + '/' + id + '/' + (isCompleted ? 'activate' : 'complete'),
				data: {
					id: id,
					_method: 'PUT'
				}
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					const result = JSON.parse(data);
					result.success !== false ? callback(id) : App.showMessage(result.message);
				});
		},
		toggleAllCompleted: function (complete, callback) {
			$.ajax({
				method: 'POST',
				url: this.url + '/all/' + (complete ? 'complete' : 'activate'),
				data: { _method: 'PUT' }
			})
				.fail(function() {
					alert('Ошибка загруки данных');
				})
				.done(function(data) {
					const result = JSON.parse(data);
					result.success !== false ? callback(complete) : App.showMessage(result.message);
				});
		},
	};

	let App = {
		init: function () {
			this.todoTemplate = Handlebars.compile($('#todo-template').html());
			this.footerTemplate = Handlebars.compile($('#footer-template').html());
			this.filter = this.getFilter();

			ajax.index(function (todo) {
				App.bindEvents();
				App.render(todo);
			});
		},
		getFilter: function () {
			const uri = window.location.pathname;
			const filter = uri.slice(uri.lastIndexOf('/') + 1);
			return (filter === 'active' || filter === 'completed') ? filter : 'all';
		},
		showMessage: function (message) {
			$('#message').text(message);
		},
		clearMessage: function () {
			$('#message').empty();
		},
		bindEvents: function () {
			$('.new-todo').on('keyup', this.storeStepToServer.bind(this));
			$('.toggle-all').on('change', this.toggleAllCompletedOnServer.bind(this));
			$('.footer').on('click', '.clear-completed', this.destroyCompletedOnServer.bind(this));
			$('.todo-list')
				.on('dblclick', 'label', this.editingMode.bind(this))
				.on('keyup', '.edit', this.editKeyup.bind(this))
				.on('focusout', '.edit', this.updateOnServer.bind(this))
				.on('click', '.destroy', this.destroyOnServer.bind(this))
				.on('change', '.toggle', this.toggleStepCompletedOnServer.bind(this));
		},
		render: function (todo = null) {
			this.clearMessage();
			let steps = this.getFilteredSteps(todo);
			$('.todo-list').html(this.todoTemplate(steps));
			$('.main').toggle(steps.length > 0);
			$('.toggle-all').prop('checked', this.getActiveSteps().length === 0 || this.filter === 'completed');
			this.renderFooter();
			$('.new-todo').focus();
		},
		renderFooter: function () {
			let stepCount = this.steps.length;
			let activeStepCount = this.getActiveSteps().length;
			let template = this.footerTemplate({
				activeStepCount: activeStepCount,
				completedSteps: stepCount - activeStepCount,
				filter: this.filter
			});

			$('.footer').toggle(stepCount > 0).html(template);
		},
		getActiveSteps: function () {
			return this.steps.filter(function (step) {
				return !step.is_completed;
			});
		},
		getCompletedSteps: function () {
			return this.steps.filter(function (step) {
				return step.is_completed;
			});
		},
		getFilteredSteps: function (todo) {
			if (todo) {
				this.steps = todo.steps;
			}

			if (this.filter === 'active') {
				return this.getActiveSteps();

			}

			if (this.filter === 'completed') {
				return this.getCompletedSteps();

			}

			return this.steps;
		},
		getStepIdFromEl: function (el) {
			return $(el).closest('li').data('id');
		},
		getStep: function (id) {
			return this.steps.find(step => { return step.id === id; });
		},
		getStepIndex: function (id) {
			let steps = this.steps;
			let i = steps.length;

			while (i--) {
				if (steps[i].id === id) {
					return i;
				}
			}
		},
		editingMode: function (e) {
			let $input = $(e.target).closest('li').addClass('editing').find('.edit');
			let tmpStr = $input.val();
			$input.val('');
			$input.val(tmpStr);
			$input.focus();
		},
		editKeyup: function (e) {
			if (e.which === ENTER_KEY) {
				e.target.blur();
			}

			if (e.which === ESCAPE_KEY) {
				$(e.target).data('abort', true).blur();
			}
		},
		storeStepToClient: function (step) {
			this.steps.push({
				id: step.id,
				body: step.body,
				is_completed: step.is_completed
			});
		},
		updateOnClient: function (id, body) {
			this.steps[this.getStepIndex(id)].body = body;
		},
		destroyOnClient: function (id) {
			this.steps.splice(this.getStepIndex(id), 1);
			this.render();
		},
		destroyCompletedOnClient: function () {
			this.steps = this.getActiveSteps();
		},
		toggleStepCompletedOnClient: function (id) {
			let i = this.getStepIndex(id);
			this.steps[i].is_completed = !this.steps[i].is_completed;
		},
		toggleAllCompletedOnClient: function (complete) {
			this.steps.forEach(function (step) {
				step.is_completed = complete;
			});
		},
		storeStepToServer: function (e) {
			let $input = $(e.target);
			let body = $input.val().trim();

			if (e.which !== ENTER_KEY || !body) {
				return;
			}

			ajax.store(body, function(step) {
				App.storeStepToClient(step);
				App.render();
			});

			$input.val('');
		},
		updateOnServer: function (e) {
			let el = e.target;
			let $el = $(el);
			let body = $el.val().trim();

			if ($el.data('abort')) {
				$el.data('abort', false);
			} else if (!body) {
				this.destroy(e);
			} else {
				let id = this.getStepIdFromEl(el);
				ajax.update(id, body, function (id, body) {
					App.updateOnClient(id, body);
					App.render();
				});
			}
		},
		destroyOnServer: function (e) {
			let id = this.getStepIdFromEl(e.target);
			ajax.destroy(id, function (id) {
				App.destroyOnClient(id);
				App.render();
			});
		},
		destroyCompletedOnServer: function () {
			ajax.destroyCompleted(function () {
				App.destroyCompletedOnClient();
				App.render();
			});
		},
		toggleStepCompletedOnServer: function (e) {
			let id = this.getStepIdFromEl(e.target);
			ajax.toggleCompleted(id, this.getStep(id).is_completed, function (id) {
				App.toggleStepCompletedOnClient(id);
				App.render();
			});
		},
		toggleAllCompletedOnServer: function (e) {
			let complete = $(e.target).prop('checked');
			ajax.toggleAllCompleted(complete, function (complete) {
				App.toggleAllCompletedOnClient(complete);
				App.render();
			});
		},
	};

	App.init();
});
