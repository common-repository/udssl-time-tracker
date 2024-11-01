var app = app || {};
app.TimeSlot = Backbone.Model.extend({
    defaults: {
        t_start: '2013-10-25 15:00:00',
        t_end: '2013-10-25 15:30:00',
        t_duration: '30',
        t_category: 'Category 1',
        t_project: 'Project 1',
        t_task: 'Task 1',
        t_description: 'Sample Description'
    }
});
