<?php
/**
 *  UDSSL Time Tracker Page Router
 */
class UDSSL_TT_Router{
    /**
     * UDSSL Router Constructor
     */
    function __construct(){
        add_action('template_redirect', array($this, 'redirect_templates'));
        add_action('init', array($this, 'router_rewrite'));
    }

    /**
     * Add Rewrites for UDSSL Time Tracker.
     */
    function router_rewrite(){
        $time_tracker = 'time-tracker/?$';
        add_rewrite_rule($time_tracker, 'index.php?router=time_tracker', 'top');

        $payment_tracker = 'payment-tracker/?$';
        add_rewrite_rule($payment_tracker, 'index.php?router=payment_tracker', 'top');

        do_action('udssl_tt_router_rewrite');

        add_rewrite_tag('%router%', '([^&]+)');
    }

    /**
     * Redirect UDSSL Time Tracker Templates.
     */
    function redirect_templates(){
        global $wp_query;
        if(!isset($wp_query->query_vars['router']))
            return;

        do_action('udssl_tt_router_redirect');

        global $udssl_tt;

        $query_var = $wp_query->query_vars['router'];
        if ( $query_var == 'time_tracker' ) {
            /**
             * Permission Check
             */
            $udssl_tt->gate->check_request();
            define( 'UDSSL_TT_ROUTE', 'time_tracker' );
            require UDSSL_TT_PATH . 'templates/template-time.php';
        } else if( $query_var == 'payment_tracker' ) {
            /**
             * Permission Check
             */
            $udssl_tt->gate->check_request();
            define( 'UDSSL_TT_ROUTE', 'payment_tracker' );
            require UDSSL_TT_PATH . 'templates/template-payment.php';
        }
        die();
    }
}
?>
