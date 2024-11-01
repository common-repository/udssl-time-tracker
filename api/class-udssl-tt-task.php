<?php
/**
 * UDSSL Time Tracker Task Management
 */
class UDSSL_TT_Task_Management{
    /**
     * Constructor
     */
    function __construct(){
        add_action('template_redirect', array($this, 'redirect_task_api'));
        add_action('init', array($this, 'task_api_rewrite'));
    }

    /**
     * Add Rewrites for the Task API
     */
    function task_api_rewrite(){
        $time_template = 'udssl_tt_task/?$';
        add_rewrite_rule($time_template, 'index.php?udssl_tt_task=yes', 'top');
        add_rewrite_tag('%udssl_tt_task%', '([^&]+)');
    }

    /**
     * Redirect Task API
     */
    function redirect_task_api(){
        global $wp_query;
        if(!isset($wp_query->query_vars['udssl_tt_task']))
            return;

        header('application/json');
        $query_var = $wp_query->query_vars['udssl_tt_task'];
        if ( $query_var == 'yes' ) {
            $this->task_api();
        }
        exit;
    }

    /**
     * Task API
     */
    function task_api(){
        /**
         * Permission Check
         */
        global $udssl_tt;
        $udssl_tt->gate->check_request();

        do_action('udssl_tt_task_api');

        /**
         * Serve Request
         */
        if ( 'POST' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->add_task();
        } else if ( 'GET' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->get_task_list();
        }
    }

    /**
     * Get Task List
     */
    function get_task_list(){
        global $udssl_tt;
        $task_list = $udssl_tt->database->get_task_list();
        $output = array();
        foreach($task_list as $task){
            array_push($output, array(
                'ta_project' => esc_html( $task['ta_project']),
                'ta_name' => esc_html( $task['ta_name']),
                'ta_description' => esc_html( $task['ta_description'])
            ));
        }
        echo json_encode($output);
    }

    /**
     * Add Task
     */
    function add_task(){
        global $udssl_tt;
        $input = json_decode(file_get_contents("php://input"));
        $r = $udssl_tt->database->add_task($input); // esc_sql done in db class.
        if($r){
            $output = array( esc_html( $r ), 'Success');
        } else {
            $output = array( esc_html( $r ), 'Failure');
        }
        echo json_encode($output);
    }
}
?>
