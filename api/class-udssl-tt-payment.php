<?php
/**
 * UDSSL Time Tracker Payments
 */
class UDSSL_TT_Payments{
    /**
     * Constructor
     */
    function __construct(){
        add_action('template_redirect', array($this, 'redirect_payment_api'));
        add_action('init', array($this, 'payment_rewrite'));
    }

    /**
     * Add Rewrites for the Payment API
     */
    function payment_rewrite(){
        $payment_template = 'udssl_tt_payment/?$';
        add_rewrite_rule($payment_template, 'index.php?udssl_tt_payment=api', 'top');
        add_rewrite_tag('%udssl_tt_payment%', '([^&]+)');
    }

    /**
     * Redirect Payment API
     */
    function redirect_payment_api(){
        global $wp_query;
        if(!isset($wp_query->query_vars['udssl_tt_payment']))
            return;

        header('application/json');
        $query_var = $wp_query->query_vars['udssl_tt_payment'];
        if ( $query_var == 'api' ) {
            $this->payment_api();
        }
        exit;
    }

    /**
     * Payment API
     */
    function payment_api(){
        /**
         * Permission Check
         */
        global $udssl_tt;
        $udssl_tt->gate->check_request();

        do_action('udssl_tt_payment_api');

        /**
         * Serve Request
         */
        if ( 'POST' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->add_payment();
        } else if ( 'GET' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->get_payments();
        }
    }

    /**
     * Get Payments
     */
    function get_payments(){
        global $udssl_tt;
        $payments = $udssl_tt->database->get_payments();
        $output = array();
        foreach($payments as $payment){
            array_push($output, array(
                'time' => date('Y-m-d h:i A', $payment['time']),
                'category' => esc_html( $payment['category'] ),
                'project' => esc_html( $payment['project'] ),
                'task' => esc_html( $payment['task'] ),
                'paid' => esc_html( $payment['paid'] / 100 ),
                'charges' => esc_html( $payment['charges'] / 100 ),
                'effective' => esc_html( $payment['effective'] / 100 )
            ));
        }
        echo json_encode($output);
    }

    /**
     * Add Payment
     */
    function add_payment(){
        global $udssl_tt;
        $input = json_decode(file_get_contents("php://input"));
        $r = $udssl_tt->database->add_payment($input); // Sanitization done in db class
        if($r){
            $output = array( esc_html( $r ), 'Success');
        } else {
            $output = array( esc_html( $r ), 'Failure');
        }
        $q = $udssl_tt->database->update_task_payment($input); // Sanitization done in db class
        echo json_encode($output);
    }
}
?>
