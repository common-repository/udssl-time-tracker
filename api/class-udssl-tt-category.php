<?php
/**
 * UDSSL Time Tracker Category Management
 */
class UDSSL_TT_Category_Management{
    /**
     * Constructor
     */
    function __construct(){
        add_action('template_redirect', array($this, 'redirect_category_api'));
        add_action('init', array($this, 'category_api_rewrite'));
    }

    /**
     * Add Rewrites for the Category API
     */
    function category_api_rewrite(){
        $time_template = 'udssl_tt_category/?$';
        add_rewrite_rule($time_template, 'index.php?udssl_tt_category=yes', 'top');
        add_rewrite_tag('%udssl_tt_category%', '([^&]+)');
    }

    /**
     * Redirect Category API
     */
    function redirect_category_api(){
        global $wp_query;
        if(!isset($wp_query->query_vars['udssl_tt_category']))
            return;

        header('application/json');
        $query_var = $wp_query->query_vars['udssl_tt_category'];
        if ( $query_var == 'yes' ) {
            $this->category_api();
        }
        exit;
    }

    /**
     * Category API
     */
    function category_api(){
        /**
         * Permission Check
         */
        global $udssl_tt;
        $udssl_tt->gate->check_request();

        do_action('udssl_tt_category_api');

        /**
         * Serve Request
         */
        if ( 'POST' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->add_category();
        } else if ( 'GET' == esc_html( $_SERVER['REQUEST_METHOD'] )) {
            $this->get_category_list();
        }
    }

    /**
     * Get Category List
     */
    function get_category_list(){
        global $udssl_tt;
        $category_list = $udssl_tt->database->get_category_list();
        $output = array();
        foreach($category_list as $category){
            array_push($output, array(
                'c_name' => esc_html($category['c_name']),
                'c_description' => esc_html($category['c_description'])
            ));
        }
        echo json_encode($output);
    }

    /**
     * Add Category
     */
    function add_category(){
        global $udssl_tt;
        $input = json_decode(file_get_contents("php://input"));
        $r = $udssl_tt->database->add_category($input); // Sanitization done in db class
        if($r){
            $output = array( esc_html($r), 'Success');
        } else {
            $output = array( esc_html($r), 'Failure');
        }
        echo json_encode($output);
    }
}
?>
