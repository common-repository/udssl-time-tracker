<?php
/**
 * UDSSL Time Tracker App Enqueue and Bootstrapper
 */
class UDSSL_TT_App{
    /**
     * Constructor
     */
    function __construct(){
        add_action('wp_enqueue_scripts', array($this, 'time_tracker'));
        add_action('wp_enqueue_scripts', array($this, 'payment_tracker'));
    }

    /**
     * Backbone Time Tracker App
     */
    function time_tracker(){
        if( defined('UDSSL_TT_ROUTE') && UDSSL_TT_ROUTE == 'time_tracker'){
            wp_enqueue_script( 'udssl-tt-model-timeslot', plugins_url( 'app/models/timeslot.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-category', plugins_url( 'app/models/category.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-project', plugins_url( 'app/models/project.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-task', plugins_url( 'app/models/task.js', dirname(__FILE__) ), array(), false, true);

            wp_enqueue_script( 'udssl-tt-collection-timeslots', plugins_url( 'app/collections/timeslots.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-collection-categories', plugins_url( 'app/collections/categories.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-collection-projects', plugins_url( 'app/collections/projects.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-collection-tasks', plugins_url( 'app/collections/tasks.js', dirname(__FILE__) ), array(), false, true);

            wp_enqueue_script( 'udssl-tt-views-timetracker', plugins_url( 'app/views/timetracker.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-views-timeslot', plugins_url( 'app/views/timeslot.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-views-taskmanage', plugins_url( 'app/views/taskmanage.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-views-projectmanage', plugins_url( 'app/views/projectmanage.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-views-categorymanage', plugins_url( 'app/views/categorymanage.js', dirname(__FILE__) ), array(), false, true);

            wp_enqueue_script( 'udssl-tt-app', plugins_url( 'app/core/udssl-time-tracker-app.js', dirname(__FILE__) ), array(), false, true);
        }
    }

    /**
     * Backbone Payment Tracker App
     */
    function payment_tracker(){
        if( defined('UDSSL_TT_ROUTE') && UDSSL_TT_ROUTE == 'payment_tracker'){
            wp_enqueue_script( 'udssl-tt-model-timeslot', plugins_url( 'app/models/timeslot.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-payment', plugins_url( 'app/models/payment.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-category', plugins_url( 'app/models/category.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-project', plugins_url( 'app/models/project.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-model-task', plugins_url( 'app/models/task.js', dirname(__FILE__) ), array(), false, true);

            wp_enqueue_script( 'udssl-tt-collection-payments', plugins_url( 'app/collections/payments.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-collection-categories', plugins_url( 'app/collections/categories.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-collection-projects', plugins_url( 'app/collections/projects.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-collection-tasks', plugins_url( 'app/collections/tasks.js', dirname(__FILE__) ), array(), false, true);

            wp_enqueue_script( 'udssl-tt-views-payment', plugins_url( 'app/views/payment.js', dirname(__FILE__) ), array(), false, true);
            wp_enqueue_script( 'udssl-tt-views-paymenttracker', plugins_url( 'app/views/paymenttracker.js', dirname(__FILE__) ), array(), false, true);

            wp_enqueue_script( 'udssl-tt-payment-app', plugins_url( 'app/core/udssl-payment-tracker-app.js', dirname(__FILE__) ), array(), false, true);
        }
    }
}
?>
