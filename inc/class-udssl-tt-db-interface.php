<?php
/**
 * UDSSL Time Tracker Database Interface
 */
class UDSSL_TT_DB_Interface{
    /**
     * Time Table
     */
    private $time_table = 'time';

    /**
     * Task Table
     */
    private $task_table = 'task';

    /**
     * Project Table
     */
    private $project_table = 'project';

    /**
     * Category Table
     */
    private $category_table = 'category';

    /**
     * Payment Table
     */
    private $payment_table = 'payment';

    /**
     * Get Time Slots
     */
    function get_time_slots(){
        global $wpdb;
        $time_table = $wpdb->prefix . $this->time_table;
        $time_table = esc_sql($time_table);

        $start = strtotime(date('Y-m-d', current_time('timestamp')));
        $end = $start + DAY_IN_SECONDS;

        $where = " $start < t_start and t_end < $end ";
        $time_slots = $wpdb->get_results(
            "
            SELECT *
            FROM $time_table
            WHERE $where
            LIMIT 100
            ", ARRAY_A
        );

        if(!$time_slots){
            $where = " $start < t_end and t_end < $end ";
            $time_slots = $wpdb->get_results(
                "
                SELECT *
                FROM $time_table
                WHERE $where
                LIMIT 100
                ", ARRAY_A
            );
        }

        if(!$time_slots){
            $end = $start;
            $start = $start - DAY_IN_SECONDS;

            $where = " $start < t_start and t_end < $end ";
            $time_slots = $wpdb->get_results(
                "
                SELECT *
                FROM $time_table
                WHERE $where
                LIMIT 100
                ", ARRAY_A
            );
        }

        return $time_slots;
    }

    /**
     * Add Time Slot
     */
    function add_time_slot($data){
        global $wpdb;
        $time_table = $wpdb->prefix . $this->time_table;
        $time_table = esc_sql($time_table);

        $data = array(
            't_id'          => null,
            't_start'       => strtotime($data->t_start),
            't_end'         => strtotime($data->t_end),
            't_duration'    => strtotime($data->t_end) - strtotime($data->t_start),
            't_category'    => sanitize_text_field( $data->t_category ),
            't_project'     => sanitize_text_field( $data->t_project ),
            't_task'        => sanitize_text_field( $data->t_task ),
            't_description' => sanitize_text_field( $data->t_description )
        );

        $r = $wpdb->insert( $time_table, $data );
        return $r;
    }

    /**
     * Get Categories
     */
    function get_category_list(){
        global $wpdb;
        $category_table = $wpdb->prefix . $this->category_table;
        $category_table = esc_sql($category_table);
        $categories = $wpdb->get_results(
            "
            SELECT *
            FROM $category_table
            LIMIT 100
            ", ARRAY_A
        );

        return $categories;
    }

    /**
     * Add Category
     */
    function add_category($data){
        global $wpdb;
        $category_table = $wpdb->prefix . $this->category_table;
        $category_table = esc_sql($category_table);

        $data = array(
            'c_id'          => null,
            'c_name'    => sanitize_text_field( $data->c_name ),
            'c_description' => sanitize_text_field( $data->c_description )
        );

        $r = $wpdb->insert( $category_table, $data );
        return $r;
    }

    /**
     * Get Projects
     */
    function get_project_list(){
        global $wpdb;
        $project_table = $wpdb->prefix . $this->project_table;
        $project_table = sanitize_text_field($project_table);
        $projects = $wpdb->get_results(
            "
            SELECT *
            FROM $project_table
            LIMIT 100
            ", ARRAY_A
        );

        return $projects;
    }

    /**
     * Add Project
     */
    function add_project($data){
        global $wpdb;
        $project_table = $wpdb->prefix . $this->project_table;
        $project_table = esc_sql($project_table);

        $data = array(
            'p_id'          => null,
            'p_category'    => sanitize_text_field( $data->p_category ),
            'p_name'    => sanitize_text_field( $data->p_name ),
            'p_description' => sanitize_text_field( $data->p_description )
        );

        $r = $wpdb->insert( $project_table, $data );
        return $r;
    }

    /**
     * Get Tasks
     */
    function get_task_list(){
        global $wpdb;
        $task_table = $wpdb->prefix . $this->task_table;
        $task_table = sanitize_text_field($task_table);
        $tasks = $wpdb->get_results(
            "
            SELECT *
            FROM $task_table
            WHERE ta_state != 2 or ta_state is null
            LIMIT 100
            ", ARRAY_A
        );

        return $tasks;
    }

    /**
     * Add Task
     */
    function add_task($data){
        global $wpdb;
        $task_table = $wpdb->prefix . $this->task_table;
        $task_table = sanitize_text_field($task_table);

        $data = array(
            'ta_id'          => null,
            'ta_project'    => sanitize_text_field( $data->ta_project ),
            'ta_name'    => sanitize_text_field( $data->ta_name ),
            'ta_description' => sanitize_text_field( $data->ta_description ),
            'ta_state' => 0,
            'ta_price' => 0
        );

        $r = $wpdb->insert( $task_table, $data );
        return $r;
    }

    /**
     * Update Task
     */
    function update_task($data){
        global $wpdb;
        $task_table = $wpdb->prefix . $this->task_table;
        $task_table = esc_sql($task_table);

        $data = array(
            'ta_id'          => null,
            'ta_project'    => sanitize_text_field( $data->ta_project ),
            'ta_name'    => sanitize_text_field( $data->ta_name ),
            'ta_description' => sanitize_text_field( $data->ta_description ),
            'ta_price' => 0
        );

        $r = $wpdb->update( $task_table, $data );
        return $r;
    }

    /**
     * Get Payments
     */
    function get_payments(){
        global $wpdb;
        $payment_table = $wpdb->prefix . $this->payment_table;
        $payment_table = sanitize_text_field($payment_table);
        $payments = $wpdb->get_results(
            "
            SELECT *
            FROM $payment_table
            LIMIT 100
            ", ARRAY_A
        );

        return $payments;
    }

    /**
     * Add Payment
     */
    function add_payment($data){
        global $wpdb;
        $payment_table = $wpdb->prefix . $this->payment_table;
        $payment_table = sanitize_text_field($payment_table);

        $data = array(
            'id' => null,
            'time' => strtotime($data->time),
            'category' => sanitize_text_field( $data->category ),
            'project' => sanitize_text_field( $data->project ),
            'task' => sanitize_text_field( $data->task ),
            'paid' => sanitize_text_field( $data->paid * 100 ),
            'charges' => sanitize_text_field( $data->charges * 100 ),
            'effective' => sanitize_text_field( $data->effective * 100 )
        );

        $r = $wpdb->insert( $payment_table, $data );
        return $r;
    }

    /**
     * Update Task (Payment)
     */
    function update_task_payment($data){
        global $wpdb;
        $task_table = $wpdb->prefix . $this->task_table;
        $task_table = sanitize_text_field($task_table);
        $where = array( 'ta_project' => $data->project,
            'ta_name' => sanitize_text_field( $data->task ));

        $data = array(
            'ta_price' => sanitize_text_field( $data->paid * 100),
            'ta_state' => 2
        );
        $r = $wpdb->update( $task_table, $data, $where );
        return $r;
    }

    /**
     * Delete Tables on Uninstallation
     */
    function delete_tables(){
        global $wpdb;
        /**
         * Time Table
         */
        $table_name  = $wpdb->prefix . $this->time_table;
        $table_name = sanitize_text_field($table_name);
        $sql = "DROP TABLE IF EXISTS $table_name";
        $e = $wpdb->query( $wpdb->prepare($sql));

        /**
         * Task Table
         */
        $table_name  = $wpdb->prefix . $this->task_table;
        $table_name = esc_sql($table_name);
        $sql = "DROP TABLE IF EXISTS $table_name";
        $e = $wpdb->query( $wpdb->prepare($sql));

        /**
         * Project Table
         */
        $table_name  = $wpdb->prefix . $this->project_table;
        $table_name = esc_sql($table_name);
        $sql = "DROP TABLE IF EXISTS $table_name";
        $e = $wpdb->query( $wpdb->prepare($sql));

        /**
         * Category Table
         */
        $table_name  = $wpdb->prefix . $this->category_table;
        $table_name = esc_sql($table_name);
        $sql = "DROP TABLE IF EXISTS $table_name";
        $e = $wpdb->query( $wpdb->prepare($sql));

        /**
         * Payment Table
         */
        $table_name  = $wpdb->prefix . $this->payment_table;
        $table_name = esc_sql($table_name);
        $sql = "DROP TABLE IF EXISTS $table_name";
        $e = $wpdb->query( $wpdb->prepare($sql));
    }
}
?>
