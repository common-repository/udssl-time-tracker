var app = app || {};
var ENTER_KEY = 13;
jQuery(function() {
    app.TimeSlots = new TimeSlots();
    app.Categories = new Categories();
    app.Projects = new Projects();
    app.Tasks = new Tasks();

    app.TimeTrackerView = new app.TimeTrackerView();
    app.TaskManageView = new app.TaskManageView();
    app.ProjectManageView= new app.ProjectManageView();
    app.CategoryManageView = new app.CategoryManageView();
});
