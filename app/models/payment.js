var app = app || {};
app.Payment = Backbone.Model.extend({
    defaults: {
        time: '2013-10-25 15:00:00',
        category: 'Category 1',
        project: 'Project 1',
        task: 'Task 1',
        paid: '10',
        charges: '1',
        effective: '9'
    }
});
