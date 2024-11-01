var app = app || {};
var Tasks = Backbone.Collection.extend({
    model: app.Task,
    url: udssl_tt_task
});

