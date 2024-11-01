<?php
/**
 * Plugin Name: UDSSL Time Tracker
 * Plugin URI: http://udssl.com/udssl-time-tracker/
 * Description: UDSSL Time Tracker. Track your time easily. View graphs of time data.
 * Version: 1.0.2
 * Author: UDSSL 
 * Author URI: http://udssl.com/udssl-time-tracker/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: udssl
 * Domain Path: /languages/
 */
if( !defined( 'ABSPATH' ) ){
    header('HTTP/1.0 403 Forbidden');
    die('No Direct Access Allowed!');
}

/**
 * Path and URL definitions
 */
if ( !defined('UDSSL_TT_PATH') )
    define( 'UDSSL_TT_PATH', plugin_dir_path( __FILE__ ) );
if ( !defined('UDSSL_TT_URL') )
    define( 'UDSSL_TT_URL', plugin_dir_url( __FILE__ ) );

/**
 * The UDSSL Time Tracker Class
 */
class UDSSL_TT{
    /**
     * Time Management
     */
    public $time;

    /**
     * Category Management
     */
    public $category;

    /**
     * Project Management
     */
    public $project;

    /**
     * Task Management
     */
    public $task;

    /**
     * Payments Management
     */
    public $payments;

    /**
     * Database
     */
    public $database;

    /**
     * Admin
     */
    public $admin;

    /**
     * Setup
     */
    public $setup;

    /**
     * Enqueues
     */
    public $enqueues;

    /**
     * App
     */
    public $app;

    /**
     * Components
     */
    public $components;

    /**
     * Template Router
     */
    public $router;

    /**
     * Security Gate
     */
    public $gate;


    /**
     * UDSSL Time Tracker Constructor
     */
    function __construct(){
        /**
         * Load Translation Files.
         */
        $this->load_language('udssl');

        /**
         * Create UDSSL Time Tracker tables on plugin activation.
         */
        register_activation_hook( __FILE__, array( $this, 'activation' ));

        /**
         * Flush rewrite rules on deactivation.
         */
        register_deactivation_hook( __FILE__, array( $this, 'deactivation' ));
    }

    /**
     * Initialize UDSSL Time Tracker
     */
    function initialize(){
        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-db-interface.php';
        $this->database = new UDSSL_TT_DB_Interface();

        include_once UDSSL_TT_PATH . 'admin/class-udssl-tt-admin.php';
        $this->admin = new UDSSL_TT_Admin();

        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-enqueues.php';
        $this->enqueues = new UDSSL_TT_Enqueues();

        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-app.php';
        $this->app = new UDSSL_TT_App();

        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-components.php';
        $this->components = new UDSSL_TT_Components();

        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-router.php';
        $this->router = new UDSSL_TT_Router();

        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-gate.php';
        $this->gate = new UDSSL_TT_Gate();

        include_once UDSSL_TT_PATH . 'inc/class-udssl-tt-setup.php';
        $this->setup = new UDSSL_TT_Setup();

        /**
         * UDSSL Time Tracker API
         */
        include_once UDSSL_TT_PATH . 'api/class-udssl-tt-time.php';
        $this->time = new UDSSL_TT_Time_Management();

        include_once UDSSL_TT_PATH . 'api/class-udssl-tt-category.php';
        $this->category = new UDSSL_TT_Category_Management();

        include_once UDSSL_TT_PATH . 'api/class-udssl-tt-project.php';
        $this->project = new UDSSL_TT_Project_Management();

        include_once UDSSL_TT_PATH . 'api/class-udssl-tt-task.php';
        $this->task = new UDSSL_TT_Task_Management();

        include_once UDSSL_TT_PATH . 'api/class-udssl-tt-payment.php';
        $this->payments = new UDSSL_TT_Payments();

    }

    /**
     * On UDSSL TT Activation
     */
    function activation(){
        /**
         * Create UDSSL TT Tables
         */
        $this->setup->create_tables();

        /**
         * Install UDSSL TT Data
         */
        $this->setup->install_data();

        /**
         * Time and Payment Apps Rewrite
         */
        $this->time->time_rewrite();
        $this->payments->payment_rewrite();

        /**
         * Categories, Projects and Tasks
         */
        $this->category->category_api_rewrite();
        $this->project->project_api_rewrite();
        $this->task->task_api_rewrite();

        /**
         * UDSSL Router
         */
        $this->router->router_rewrite();

        /**
         * Flush Rewrite Rules
         */
        flush_rewrite_rules();
    }

    /**
     * On UDSSL TT Deactivation
     */
    function deactivation(){
        /**
         * Flush Rewrite Rules
         */
        flush_rewrite_rules();
    }

    /**
     * Load Translation Files
     *
     * Translation domain: udssl
     */
    function load_language($domain){
        load_plugin_textdomain(
            $domain,
            null,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
}

/**
 * Instantiate the UDSSL Time Tracker
 */
$udssl_tt = new UDSSL_TT();

/**
 * Initialize all components of the UDSSL Time Tracker
 */
$udssl_tt->initialize();
?>