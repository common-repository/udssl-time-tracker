<?php
/**
 * UDSSL Time Tracker Project Management
 */
class UDSSL_TT_Project_Management{
    /**
     * Constructor
     */
    function __construct(){
        add_action('template_redirect', array($this, 'redirect_project_api'));
        add_action('init', array($this, 'project_api_rewrite'));
    }

    /**
     * Add Rewrites for the Project API
     */
    function project_api_rewrite(){
        $time_template = 'udssl_tt_project/?$';
        add_rewrite_rule($time_template, 'index.php?udssl_tt_project=yes', 'top');
        add_rewrite_tag('%udssl_tt_project%', '([^&]+)');
    }

    /**
     * Redirect Project API
     */
    function redirect_project_api(){
        global $wp_query;
        if(!isset($wp_query->query_vars['udssl_tt_project']))
            return;

        header('application/json');
        $query_var = $wp_query->query_vars['udssl_tt_project'];
        if ( $query_var == 'yes' ) {
            $this->project_api();
        }
        exit;
    }

    /**
     * Project API
     */
    function project_api(){
        /**
         * Permission Check
         */
        global $udssl_tt;
        $udssl_tt->gate->check_request();

        do_action('udssl_tt_project_api');

        /**
         * Serve Request
         */
        if ( 'POST' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->add_project();
        } else if ( 'GET' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->get_project_list();
        }
    }

    /**
     * Get Project List
     */
    function get_project_list(){
        global $udssl_tt;
        $project_list = $udssl_tt->database->get_project_list();
        $output = array();
        foreach($project_list as $project){
            array_push($output, array(
                'p_category' => esc_html( $project['p_category'] ),
                'p_name' => esc_html( $project['p_name'] ),
                'p_description' => esc_html( $project['p_description'] )
            ));
        }
        echo json_encode($output);
    }

    /**
     * Add Project
     */
    function add_project(){
        global $udssl_tt;
        $input = json_decode(file_get_contents("php://input"));
        $r = $udssl_tt->database->add_project($input); // Sanitization done in db class.
        if($r){
            $output = array( esc_html( $r ), 'Success');
        } else {
            $output = array( esc_html( $r ), 'Failure');
        }
        echo json_encode($output);
    }
}
?>
