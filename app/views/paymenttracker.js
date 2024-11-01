var app = app || {}
app.PaymentTrackerView = Backbone.View.extend({
  el: '#payment',

  events: {
    'click #pay_add_payment': 'pay_add_payment',

    'change #pay_project': 'pay_select_project',
    'change #pay_category': 'pay_select_category',
  },

  initialize: function () {
    this.listenTo(app.Payments, 'add', this.addOne)
    this.listenTo(app.Payments, 'reset', this.addAll)

    this.listenTo(
      app.Categories,
      'add',
      this.updateCategorySelect
    )
    this.listenTo(
      app.Categories,
      'reset',
      this.updateCategorySelect
    )

    this.listenTo(
      app.Projects,
      'add',
      this.renderProjectSelect
    )
    this.listenTo(
      app.Projects,
      'reset',
      this.renderProjectSelect
    )

    this.listenTo(app.Tasks, 'add', this.renderTaskSelect)
    this.listenTo(app.Tasks, 'reset', this.renderTaskSelect)

    app.Payments.fetch()
    app.Categories.fetch()
    app.Projects.fetch()
    app.Tasks.fetch()
  },

  addOne: function (payment) {
    var view = new app.PaymentView({ model: payment })
    jQuery('#payments-list').append(view.render().el)
  },

  addAll: function () {
    jQuery('#payments-list').html('')
    app.Payments.each(this.addOne, this)
  },

  updateCategorySelect: function () {
    var category_select_html = _.template(
      jQuery('#category-select-template').html()
    )({
      categories: app.Categories.toJSON(),
    })
    jQuery('#pay_category').html(category_select_html)
  },

  renderProjectSelect: function () {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: 'none',
    })
    jQuery('#pay_project').html(project_select_html)
  },

  renderTaskSelect: function () {
    var task_select_html = _.template(
      jQuery('#task-select-template').html()
    )({
      tasks: app.Tasks.toJSON(),
      project: 'none',
    })
    jQuery('#pay_task').html(task_select_html)
  },

  pay_add_payment: function (event) {
    if (!jQuery('#pay_paid').val().trim()) {
      return
    }
    this.create_payment()
  },

  create_payment: function () {
    app.Payments.create({
      time: jQuery('#pay_time').val().trim(),
      category: jQuery('#pay_category').val().trim(),
      project: jQuery('#pay_project').val().trim(),
      task:
        jQuery('#pay_task').val() &&
        jQuery('#pay_task').val().trim(),
      paid: jQuery('#pay_paid').val().trim(),
      charges: jQuery('#pay_charges').val().trim(),
      effective: jQuery('#pay_effective').val().trim(),
    })
    jQuery('#pay_paid').val('10')
  },

  pay_select_project: function () {
    var task_select_html = _.template(
      jQuery('#task-select-template').html()
    )({
      tasks: app.Tasks.toJSON(),
      project: jQuery('#pay_project').val().trim(),
    })
    jQuery('#pay_task').html(task_select_html)
  },

  pay_select_category: function () {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: jQuery('#pay_category').val().trim(),
    })
    jQuery('#pay_project').html(project_select_html)
    this.pay_select_project()
  },
})
