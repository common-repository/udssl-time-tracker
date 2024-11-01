var app = app || {};
app.PaymentView = Backbone.View.extend({
    tagName: 'tr',

    template: _.template( jQuery('#payment-template').html() ),

    initialize: function() {
        this.listenTo(this.model, 'change', this.render);
        this.listenTo(this.model, 'destroy', this.remove);
    },

    render: function() {
        this.$el.html( this.template( this.model.toJSON() ) );
        return this;
    },
});

