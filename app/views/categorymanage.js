var app = app || {}
app.CategoryManageView = Backbone.View.extend({
  el: '#category',

  events: {
    'click #c_add_category': 'c_add_category',
  },

  initialize: function () {
    this.listenTo(app.Categories, 'add', this.render)
    this.listenTo(app.Categories, 'reset', this.render)

    app.Categories.fetch()
  },

  render: function () {
    var category_select_html = _.template(
      jQuery('#category-select-template').html()
    )({
      categories: app.Categories.toJSON(),
    })
    jQuery('#c_category_list').html(category_select_html)
  },

  c_add_category: function (event) {
    if (
      !jQuery('#c_category_name').val().trim() ||
      !jQuery('#c_category_description').val().trim()
    ) {
      return
    }
    app.Categories.create({
      c_name: jQuery('#c_category_name').val().trim(),
      c_description: jQuery('#c_category_description')
        .val()
        .trim(),
    })
    jQuery('#c_category_name').val('')
    jQuery('#c_category_description').val('')
  },
})
