<?php
/**
 * UDSSL Time Tracker Enqueues
 */
class UDSSL_TT_Enqueues{
    /**
     * Constructor
     */
    function __construct(){
        /**
         * Twitter Bootstrap
         */
        add_action('wp_enqueue_scripts', array($this, 'bootstrap'));

        /**
         * Moment, Backbone and Underscore
         */
        add_action('wp_enqueue_scripts', array($this, 'moment'));
        add_action('wp_enqueue_scripts', array($this, 'underscore'));
        add_action('wp_enqueue_scripts', array($this, 'backbone'));

        /**
         * Other Head Enqueues
         */
        add_action('wp_enqueue_scripts', array($this, 'charts_js'));
        add_action('wp_enqueue_scripts', array($this, 'app'));
    }

    /**
     * Enqueue Underscore JS
     */
    function underscore(){
        wp_enqueue_script('underscore');
    }


    /**
     * Enqueue Backbone JS
     */
    function backbone(){
        wp_enqueue_script('backbone');
    }

    /**
     * Enqueue Twitter Bootstrap
     */
    function bootstrap(){
        wp_enqueue_style('bootstrap', UDSSL_TT_URL . 'lib/bootstrap/bootstrap.min.css');
        wp_enqueue_script('bootstrap-js', UDSSL_TT_URL . 'lib/bootstrap/bootstrap.bundle.min.js', array('jquery'), null, true);
    }

    /**
     * Enqueue Charts JS
     */
    function charts_js(){
        wp_enqueue_script('charts-js', UDSSL_TT_URL . 'lib/chartjs/chart.min.js', array(), null, true);
    }

    /**
     * Enqueue Moment JS
     */
    function moment(){
        wp_enqueue_script('moment');
    }

    /**
     * UDSSL Time Tracker Core Scripts ans Styles
     */
    function app(){
        wp_enqueue_script('udssl-tt-utilities', UDSSL_TT_URL . 'app/core/udssl-time-tracker-utilities.js', array('jquery'), null, true);
        wp_enqueue_style('udssl-tt-style', UDSSL_TT_URL . 'css/udssl-tt.css');
    }
}
?>