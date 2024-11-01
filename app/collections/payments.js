var app = app || {};
var Payments = Backbone.Collection.extend({
    model: app.Payment,
    url: udssl_tt_payment
});
