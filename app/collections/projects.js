var app = app || {};
var Projects = Backbone.Collection.extend({
    model: app.Project,
    url: udssl_tt_project
});
