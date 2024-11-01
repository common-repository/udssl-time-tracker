var app = app || {};
app.Task = Backbone.Model.extend({
    defaults: {
        ta_project: 'Project 1',
        ta_name: 'Task 1',
        ta_description: 'Sample Task Description'
    }
});
