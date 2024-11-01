var app = app || {};
var Categories = Backbone.Collection.extend({
    model: app.Category,
    url: udssl_tt_category
});
