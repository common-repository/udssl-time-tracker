var app = app || {};
var TimeSlots = Backbone.Collection.extend({
    model: app.TimeSlot,
    url: udssl_tt_timeslot
});
