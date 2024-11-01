<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php do_action('udssl_headtop'); ?>
    <title><?php esc_attr_e('UDSSL Time Tracker', 'udssl') ?> | <?php esc_attr_e('Track Your Time', 'udssl') ?></title>
    <meta name="Description" content="<?php esc_attr_e('UDSSL Time Tracker from UDSSL', 'udssl') ?>">
    <?php wp_head(); ?>
</head>

<body class="time-tracker">
    <div class="container">
        <?php $options = get_option('udssl_tt_options'); ?>
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <?php do_action('udssl_nav'); ?>
                </nav>
                <legend><?php esc_attr_e('UDSSL Time Tracker', 'udssl') ?></legend>
            </div>
        </div>

        <div id="time">
            <div class="row">
                <div class="col">
                    <table id="time-slot-list" class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th><?php esc_attr_e('Start Time', 'udssl') ?></th>
                                <th><?php esc_attr_e('End Time', 'udssl') ?></th>
                                <th><?php esc_attr_e('Duration', 'udssl') ?></th>
                                <th><?php esc_attr_e('Category', 'udssl') ?></th>
                                <th><?php esc_attr_e('Project', 'udssl') ?></th>
                                <th><?php esc_attr_e('Task', 'udssl') ?></th>
                                <th><?php esc_attr_e('Description', 'udssl') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tracker"></div>
            <div id="form" class="udssl-unit">
                <legend><?php esc_attr_e('New Time Slot', 'udssl') ?> | <span id="clock">&nbsp;</span></legend>

                <table class="table table-condensed">
                    <tr>
                        <td><?php esc_attr_e('Start Time', 'udssl') ?> </td>
                        <td>
                            <input class="form-control" id="t_start" type="text"
                                value="<?php echo esc_html(date('Y-m-d h:i A', current_time('timestamp'))); ?>" />
                            <button id="t_add_10" class="btn t_add">10</button>
                            <button id="t_add_15" class="btn t_add">15</button>
                            <button id="t_add_20" class="btn t_add">20</button>
                            <button id="t_add_30" class="btn t_add">30</button>
                            <button id="t_add_45" class="btn t_add">45</button>
                            <button id="t_add_60" class="btn t_add">60</button>
                            <button id="t_add_90" class="btn t_add">90</button>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('End Time', 'udssl') ?> </td>
                        <td>
                            <input id="t_end" type="text"
                                value="<?php echo esc_html(date('Y-m-d h:i A', current_time('timestamp'))); ?>" />
                            <button id="t_add_minute" class="btn "><?php esc_attr_e('Add', 'udssl') ?></button>
                            <button id="t_subtract_minute" class="btn "><?php esc_attr_e('Subtract', 'udssl') ?></button>
                            <button id="t_now_minute" class="btn "><?php esc_attr_e('Now', 'udssl') ?></button>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Duration', 'udssl') ?> </td>
                        <td>
                            <input id="t_duration" type="text" value="30" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Category', 'udssl') ?> </td>
                        <td>
                            <select id="t_category" type="text" value="Sample Category">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Project', 'udssl') ?> </td>
                        <td>
                            <select id="t_project" type="text" value="Sample Project">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Task', 'udssl') ?> </td>
                        <td>
                            <select id="t_task" type="text" value="Sample Task">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Description', 'udssl') ?> </td>
                        <td>
                            <input id="t_description" type="text" value="none" />
                        </td>
                    </tr>
                    <td></td>
                    <td>
                        <button id="t_add_slot"
                            class="btn btn-large btn-success"><?php esc_attr_e('Add Time Slot', 'udssl') ?></button>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                    foreach($options['presets'] as $preset){
                        $id  = 't_preset';
                        $id .= '_' . $preset['category'];
                        $id .= '_' . $preset['project'];
                        $id .= '_' . $preset['task'];
                        $name = $preset['name'];
                        echo '<button id="' . esc_html( $id ) . '" class="btn t_preset" >' . esc_html( $name ) . '</button> ';
                    }
                    ?>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <div id="charts" class="row"></div>

        <div id="t_summary" class="row">
            <div class="col">
                <div id="t_summary_area">
                    <h3 class="muted"><?php esc_attr_e('Time Data Charts', 'udssl') ?></h3>
                    <button id="t_summary_button" class="btn"><?php esc_attr_e('Generate Charts', 'udssl') ?></button>
                    <div id="t_summary_total"></div>
                    <h4 class="muted"><?php esc_attr_e('Category Summary', 'udssl') ?></h4>
                    <canvas id="t_summary_table" class="tt-canvas"></canvas>
                    <h4 class="muted"><?php esc_attr_e('Project Summary', 'udssl') ?></h4>
                    <canvas id="t_project_summary_table" class="tt-canvas"></canvas>
                    <h4 class="muted"><?php esc_attr_e('Task Summary', 'udssl') ?></h4>
                    <canvas id="t_task_summary_table" class="tt-canvas"></canvas>
                </div>
            </div>
        </div>

        <h3 id="new-task" class="muted"><?php esc_attr_e('Add New Categories, Projects and Tasks', 'udssl') ?></h3>

        <hr style="margin:10px" />

        <div id="footer-boxes" class="row">
            <div class="col" id="category">
                <legend><?php esc_attr_e('Categories', 'udssl') ?></legend>

                <table class="table">
                    <tr>
                        <td><?php esc_attr_e('Categories', 'udssl') ?> </td>
                        <td>
                            <select id="c_category_list" type="text" value="<?php esc_attr_e('Sample Category', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Name', 'udssl') ?> </td>
                        <td>
                            <input id="c_category_name" type="text" value="<?php esc_attr_e('Sample Name', 'udssl') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Description', 'udssl') ?> </td>
                        <td>
                            <input id="c_category_description" type="text"
                                value="<?php esc_attr_e('Sample Description', 'udssl') ?>" />
                        </td>
                    </tr>
                    </tr>
                    <td></td>
                    <td>
                        <button id="c_add_category" class="btn"><?php esc_attr_e('Add Category', 'udssl') ?></button>
                    </td>
                    </tr>

                </table>
            </div>
            <div class="col" id="project">
                <legend><?php esc_attr_e('Projects', 'udssl') ?></legend>

                <table class="table">
                    <tr>
                        <td><?php esc_attr_e('Projects', 'udssl') ?> </td>
                        <td>
                            <select id="p_project_list" type="text" value="<?php esc_attr_e('Sample Project', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Categories', 'udssl') ?> </td>
                        <td>
                            <select id="p_category_list" type="text" value="<?php esc_attr_e('Sample Category', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td><?php esc_attr_e('Name', 'udssl') ?> </td>
                        <td>
                            <input id="p_project_name" type="text" value="<?php esc_attr_e('Sample Project', 'udssl') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Description', 'udssl') ?> </td>
                        <td>
                            <input id="p_project_description" type="text"
                                value="<?php esc_attr_e('Sample Project Description', 'udssl') ?>" />
                        </td>
                    </tr>
                    </tr>
                    <td></td>
                    <td>
                        <button id="p_add_project" class="btn"><?php esc_attr_e('Add Project', 'udssl') ?></button>
                    </td>
                    </tr>

                </table>
            </div>
            <div class="col" id="task">
                <legend><?php esc_attr_e('Tasks', 'udssl') ?></legend>

                <table class="table">
                    <tr>
                        <td><?php esc_attr_e('Tasks', 'udssl') ?> </td>
                        <td>
                            <select id="ta_task_list" type="text" value="<?php esc_attr_e('Sample Task', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Projects', 'udssl') ?> </td>
                        <td>
                            <select id="ta_project_list" type="text" value="<?php esc_attr_e('Sample Project', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td><?php esc_attr_e('Name', 'udssl') ?> </td>
                        <td>
                            <input id="ta_task_name" type="text" value="<?php esc_attr_e('Sample Task', 'udssl') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Description', 'udssl') ?> </td>
                        <td>
                            <input id="ta_task_description" type="text"
                                value="<?php esc_attr_e('Sample Task Description', 'udssl') ?>" />
                        </td>
                    </tr>
                    </tr>
                    <td></td>
                    <td>
                        <button id="ta_add_task" class="btn"><?php esc_attr_e('Add Task', 'udssl') ?></button>
                    </td>
                    </tr>

                </table>
            </div>
        </div>


        <hr>
        <div class="footer">
            <p class="text-muted"><?php esc_attr_e('UDSSL Time Tracker', 'udssl') ?></p>
        </div>

    </div>

    <?php include_once UDSSL_TT_PATH . 'app/templates/_templates.php'; ?>

    <!-- <div id="time-toolbar">
        <h3 id="toolbar_clock"></h3>
        <!-- <h3 id="toolbar_duration"></h3> -->
    <!-- <button href="#tracker" class="btn"><?php esc_attr_e('Tracker', 'udssl') ?></button>
    <button href="#charts" class="btn"><?php esc_attr_e('Charts', 'udssl') ?></button>
    <button href="#new-task" class="btn"><?php esc_attr_e('New Task', 'udssl') ?></button> -->
    <!-- <button href="#menu" class="btn"><?php esc_attr_e('Menu', 'udssl') ?></button </div> -->

    <?php wp_footer(); ?>
    <?php do_action('udssl_time_tracker'); ?>
</body>

</html>