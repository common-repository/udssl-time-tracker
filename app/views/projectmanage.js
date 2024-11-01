var app = app || {}
app.ProjectManageView = Backbone.View.extend({
  el: '#project',

  events: {
    'click #p_add_project': 'p_add_project',
    'change #p_category_list': 'p_select_category',
  },

  initialize: function () {
    this.listenTo(app.Projects, 'add', this.render)
    this.listenTo(app.Projects, 'reset', this.render)

    this.listenTo(
      app.Categories,
      'add',
      this.renderCategories
    )
    this.listenTo(
      app.Categories,
      'reset',
      this.renderCategories
    )

    app.Projects.fetch()
  },

  render: function () {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: 'none',
    })
    jQuery('#p_project_list').html(project_select_html)
  },

  renderCategories: function () {
    var category_select_html = _.template(
      jQuery('#category-select-template').html()
    )({
      categories: app.Categories.toJSON(),
    })
    jQuery('#p_category_list').html(category_select_html)
  },

  p_add_project: function (event) {
    if (
      !jQuery('#p_project_name').val().trim() ||
      !jQuery('#p_project_description').val().trim()
    ) {
      return
    }
    app.Projects.create({
      p_category: jQuery('#p_category_list').val().trim(),
      p_name: jQuery('#p_project_name').val().trim(),
      p_description: jQuery('#p_project_description')
        .val()
        .trim(),
    })
    jQuery('#p_project_name').val('')
    jQuery('#p_project_description').val('')
  },

  p_select_category: function () {
    var project_select_html = _.template(
      jQuery('#project-select-template').html()
    )({
      projects: app.Projects.toJSON(),
      category: jQuery('#p_category_list').val().trim(),
    })
    jQuery('#p_project_list').html(project_select_html)
  },
})
