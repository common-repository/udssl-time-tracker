var app = app || {}
app.TaskManageView = Backbone.View.extend({
  el: '#task',

  events: {
    'click #ta_add_task': 'ta_add_task',

    'change #ta_project_list': 'ta_select_project',
  },

  initialize: function () {
    this.listenTo(app.Tasks, 'add', this.render)
    this.listenTo(app.Tasks, 'reset', this.render)

    this.listenTo(app.Projects, 'add', this.renderProjects)
    this.listenTo(
      app.Projects,
      'reset',
      this.renderProjects
    )

    app.Tasks.fetch()
  },

  render: function () {
    var task_select_html = _.template(
      jQuery('#task-select-template').html()
    )({
      tasks: app.Tasks.toJSON(),
      project: 'none',
    })
    jQuery('#ta_task_list').html(task_select_html)
  },

  renderProjects: function () {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: 'none',
    })
    jQuery('#ta_project_list').html(project_select_html)
  },

  ta_add_task: function (event) {
    if (
      !jQuery('#ta_task_name').val().trim() ||
      !jQuery('#ta_task_description').val().trim()
    ) {
      return
    }
    app.Tasks.create({
      ta_project: jQuery('#ta_project_list').val().trim(),
      ta_name: jQuery('#ta_task_name').val().trim(),
      ta_description: jQuery('#ta_task_description')
        .val()
        .trim(),
    })
    jQuery('#ta_task_name').val('')
    jQuery('#ta_task_description').val('')
  },

  ta_select_project: function () {
    var task_select_html = _.template(
      jQuery('#task-select-template').html()
    )({
      tasks: app.Tasks.toJSON(),
      project: jQuery('#ta_project_list').val().trim(),
    })
    jQuery('#ta_task_list').html(task_select_html)
  },
})
