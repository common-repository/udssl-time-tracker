<?php
/**
 *  UDSSL Time Tracker Time Management
 */
class UDSSL_TT_Time_Management{
    /**
     * Constructor
     */
    function __construct(){
        add_action('template_redirect', array($this, 'redirect_time_api'));
        add_action('init', array($this, 'time_rewrite'));
    }

    /**
     * Add Rewrites for the Timeslot API
     */
    function time_rewrite(){
        $time_api = 'udssl_tt_timeslot/?$';
        add_rewrite_rule($time_api, 'index.php?time_api=yes', 'top');
        add_rewrite_tag('%time_api%', '([^&]+)');
    }

    /**
     * Redirect Timeslots API
     */
    function redirect_time_api(){
        global $wp_query;
        if(!isset($wp_query->query_vars['time_api']))
            return;

        header('application/json');
        $query_var = $wp_query->query_vars['time_api'];
        if ( $query_var == 'yes' ) {
            $this->timeslot_api();
        }
        exit;
    }

    /**
     * Time Slots API
     */
    function timeslot_api(){
        /**
         * Permission Check
         */
        global $udssl_tt;
        $udssl_tt->gate->check_request();

        do_action('udssl_tt_timeslot_api');

        /**
         * Serve Request
         */
        if ( 'POST' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->add_time_slot();
        } else if ( 'GET' ==esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->get_time_slots();
        }
    }

    /**
     * Get Timeslots
     */
    function get_time_slots(){
        global $udssl_tt;
        $timeslots = $udssl_tt->database->get_time_slots();
        $output = array();
        foreach($timeslots as $timeslot){
            array_push($output, array(
                't_start' => date('Y-m-d h:i A', $timeslot['t_start']),
                't_end' => date('Y-m-d h:i A', $timeslot['t_end']),
                't_duration' => floor($timeslot['t_duration'] / 60),
                't_category' => esc_attr( $timeslot['t_category'] ),
                't_project' => esc_attr( $timeslot['t_project'] ),
                't_task' => esc_attr( $timeslot['t_task'] ),
                't_description' => esc_attr( $timeslot['t_description'] )
            ));
        }
        echo json_encode($output);
    }

    /**
     * Add Time Slot
     */
    function add_time_slot(){
        global $udssl_tt;
        $input = json_decode(file_get_contents("php://input"));
        $r = $udssl_tt->database->add_time_slot($input); // Sanitization done in db class.
        if($r){
            $output = array( esc_html( $r ), 'Success');
        } else {
            $output = array( esc_html( $r ), 'Failure');
        }
        echo json_encode($output);

    }
}
?>
