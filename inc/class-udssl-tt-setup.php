<?php
/**
 * UDSSL Time Tracker Setup
 */
class UDSSL_TT_Setup{
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
     * Create Tables
     */
    function create_tables(){
        $this->create_time_table();
        $this->create_task_table();
        $this->create_project_table();
        $this->create_category_table();
        $this->create_payment_table();

        do_action('udssl_tt_create_tables');
    }

    /**
     * Create Time Table
     */
    function create_time_table(){
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $time_table = $wpdb->prefix . $this->time_table;
        $time_sql = "CREATE TABLE IF NOT EXISTS $time_table (
            t_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            t_start BIGINT,
            t_end BIGINT,
            t_duration BIGINT DEFAULT 0,
            t_category VARCHAR(400),
            t_project VARCHAR(400),
            t_task VARCHAR(400),
            t_description VARCHAR(800)
        )
        engine = InnoDB
        default character set = utf8
        collate = utf8_unicode_ci;";

        $result = dbDelta($time_sql);

        return $result;
    }

    /**
     * Create Task Table
     */
    function create_task_table(){
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $task_table = $wpdb->prefix . $this->task_table;
        $task_sql = "CREATE TABLE IF NOT EXISTS $task_table (
            ta_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            ta_name VARCHAR(400),
            ta_description VARCHAR(800),
            ta_project VARCHAR(400),
            ta_state BIGINT,
            ta_price BIGINT
        )
        engine = InnoDB
        default character set = utf8
        collate = utf8_unicode_ci;";

        $result = dbDelta($task_sql);

        return $result;
    }

    /**
     * Create Project Table
     */
    function create_project_table(){
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $project_table = $wpdb->prefix . $this->project_table;
        $project_sql = "CREATE TABLE IF NOT EXISTS $project_table (
            p_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            p_name VARCHAR(400),
            p_description VARCHAR(800),
            p_category VARCHAR(400),
            p_state BIGINT
        )
        engine = InnoDB
        default character set = utf8
        collate = utf8_unicode_ci;";

        $result = dbDelta($project_sql);

        return $result;
    }

    /**
     * Create Category Table
     */
    function create_category_table(){
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $category_table = $wpdb->prefix . $this->category_table;
        $category_sql = "CREATE TABLE IF NOT EXISTS $category_table (
            c_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            c_name VARCHAR(400),
            c_description VARCHAR(800),
            c_state BIGINT
        )
        engine = InnoDB
        default character set = utf8
        collate = utf8_unicode_ci;";

        $result = dbDelta($category_sql);

        return $result;
    }

    /**
     * Create Payment Table
     */
    function create_payment_table(){
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $payment_table = $wpdb->prefix . $this->payment_table;
        $payment_sql = "CREATE TABLE IF NOT EXISTS $payment_table (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            time BIGINT,
            category VARCHAR(400),
            project VARCHAR(400),
            task VARCHAR(800),
            paid BIGINT,
            charges BIGINT,
            effective BIGINT
        )
        engine = InnoDB
        default character set = utf8
        collate = utf8_unicode_ci;";

        $result = dbDelta($payment_sql);

        return $result;
    }


    /**
     * Install Data
     */
    function install_data(){
        $this->install_category_data();
        $this->install_project_data();
        $this->install_task_data();
        $this->install_timeslot_data();

        do_action('udssl_tt_install_data');
    }

    /**
     * Install Category Data
     */
    function install_category_data(){
        global $wpdb;
        $table_name = $wpdb->prefix . $this->category_table;
        $filename = UDSSL_TT_PATH . 'data/category.data';
        $handle = fopen($filename, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = explode(',', $line);
                $wpdb->insert(
                    $table_name,
                    array(
                        'c_id' => $data[0],
                        'c_name' => $data[1],
                        'c_description' => $data[2],
                        'c_state' => $data[3]
                    )
                );
            }
            fclose($handle);
        }
    }

    /**
     * Install Project Data
     */
    function install_project_data(){
        global $wpdb;
        $table_name = $wpdb->prefix . $this->project_table;
        $filename = UDSSL_TT_PATH . 'data/project.data';
        $handle = fopen($filename, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = explode(',', $line);
                $wpdb->insert(
                    $table_name,
                    array(
                        'p_id' => $data[0],
                        'p_name' => $data[1],
                        'p_description' => $data[2],
                        'p_category' => $data[3],
                        'p_state' => $data[4]
                    )
                );
            }
            fclose($handle);
        }
    }

    /**
     * Install Task Data
     */
    function install_task_data(){
        global $wpdb;
        $table_name = $wpdb->prefix . $this->task_table;
        $filename = UDSSL_TT_PATH . 'data/task.data';
        $handle = fopen($filename, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = explode(',', $line);
                $wpdb->insert(
                    $table_name,
                    array(
                        'ta_id' => $data[0],
                        'ta_name' => $data[1],
                        'ta_description' => $data[2],
                        'ta_project' => $data[3],
                        'ta_state' => $data[4],
                        'ta_price' => $data[5]
                    )
                );
            }
            fclose($handle);
        }
    }

    /**
     * Install Timeslot Data
     */
    function install_timeslot_data(){
        global $wpdb;
        $table_name = $wpdb->prefix . $this->time_table;
        $filename = UDSSL_TT_PATH . 'data/timeslot.data';
        $handle = fopen($filename, 'r');

        if ($handle) {
            $end = 0;
            while (($line = fgets($handle)) !== false) {
                $data = explode(',', $line);
                $start = $end == 0 ? time() : $end;
                $end = $start + $data[1];
                $wpdb->insert(
                    $table_name,
                    array(
                        't_id' => $data[0],
                        't_start' => $start,
                        't_end' => $end,
                        't_duration' => $data[1],
                        't_category' => $data[2],
                        't_project' => $data[3],
                        't_task' => $data[4],
                        't_description' => $data[5],
                    )
                );
            }
            fclose($handle);
        }
    }
}
?>