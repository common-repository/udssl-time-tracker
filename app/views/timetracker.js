var app = app || {}
app.TimeTrackerView = Backbone.View.extend({
  el: '#time',

  timeTemplate: _.template(jQuery('#time-template').html()),

  events: {
    'click #t_add_slot': 't_add_slot_button',
    'keypress #t_description': 't_add_slot_input',

    'change #t_project': 't_select_project',
    'change #t_category': 't_select_category',
  },

  initialize: function () {
    this.listenTo(app.TimeSlots, 'add', this.addOne)
    this.listenTo(app.TimeSlots, 'reset', this.addAll)

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

    app.TimeSlots.fetch()
  },

  render: function () {
    jQuery('#t_main').html(
      this.timeTemplate({ t_total_slots: 5 })
    )
  },

  addOne: function (slot) {
    var view = new app.TimeSlotView({ model: slot })
    jQuery('#time-slot-list').append(view.render().el)
    jQuery('#t_start').val(slot.get('t_end'))
  },

  addAll: function () {
    jQuery('#time-slot-list').html('')
    app.TimeSlots.each(this.addOne, this)
  },

  updateCategorySelect: function () {
    var category_select_html = _.template(
      jQuery('#category-select-template').html()
    )({
      categories: app.Categories.toJSON(),
    })
    jQuery('#t_category').html(category_select_html)
  },

  renderProjectSelect: function () {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: 'none',
    })
    jQuery('#t_project').html(project_select_html)
  },

  renderTaskSelect: function () {
    var task_select_html = _.template(
      jQuery('#task-select-template').html()
    )({
      tasks: app.Tasks.toJSON(),
      project: 'none',
    })
    jQuery('#t_task').html(task_select_html)
  },

  t_add_slot_input: function (event) {
    if (
      event.which !== ENTER_KEY ||
      !jQuery('#t_description').trim()
    ) {
      return
    }
    this.create_time_slot()
  },

  t_add_slot_button: function (event) {
    if (!jQuery('#t_description').val().trim()) {
      return
    }
    this.create_time_slot()
  },

  create_time_slot: function () {
    app.TimeSlots.create({
      t_start: jQuery('#t_start').val().trim(),
      t_end: jQuery('#t_end').val().trim(),
      t_duration: parseInt(
        jQuery('#t_duration').val().trim(),
        10
      ),
      t_category: jQuery('#t_category').val().trim(),
      t_project:
        jQuery('#t_project').val() &&
        jQuery('#t_project').val().trim(),
      t_task:
        jQuery('#t_task').val() &&
        jQuery('#t_task').val().trim(),
      t_description: jQuery('#t_description').val().trim(),
    })
    jQuery('#t_description').val('none')
  },

  t_select_project: function () {
    var task_select_html = _.template(
      jQuery('#task-select-template').html()
    )({
      tasks: app.Tasks.toJSON(),
      project:
        jQuery('#t_project').val() &&
        jQuery('#t_project').val().trim(),
    })
    jQuery('#t_task').html(task_select_html)
  },

  t_select_category: function (e) {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: jQuery('#t_category').val().trim(),
    })
    jQuery('#t_project').html(project_select_html)
    this.t_select_project()
  },
})
