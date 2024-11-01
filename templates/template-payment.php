<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php do_action('udssl_headtop'); ?>
    <title><?php esc_attr_e('Payment Tracker', 'udssl') ?> | <?php esc_attr_e('UDSSL Time Tracker', 'udssl') ?></title>
    <meta name="Description" content="<?php esc_attr_e('Payment Tracker for WordPress', 'udssl') ?>">
    <?php wp_head(); ?>
</head>

<body class="time-tracker">
    <?php $options = get_option('udssl_tt_options'); ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <?php do_action('udssl_nav'); ?>
                </nav><!-- /.navbar -->
                <legend><?php esc_attr_e('Payment Tracker', 'udssl') ?></legend>
            </div>
        </div>

        <div id="payment">
            <table id="payments-list" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php esc_attr_e('Time', 'udssl') ?></th>
                        <th><?php esc_attr_e('Category', 'udssl') ?></th>
                        <th><?php esc_attr_e('Project', 'udssl') ?></th>
                        <th><?php esc_attr_e('Task', 'udssl') ?></th>
                        <th><?php esc_attr_e('Paid', 'udssl') ?></th>
                        <th><?php esc_attr_e('Charge', 'udssl') ?></th>
                        <th><?php esc_attr_e('Effective', 'udssl') ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="form" class="udssl-unit">
                <legend><?php esc_attr_e('New Payment', 'udssl') ?> | <span id="clock">&nbsp;</span></legend>
                <table class="table table-condensed">
                    <tr>
                        <td><?php esc_attr_e('Time', 'udssl') ?> </td>
                        <td>
                            <input id="pay_time" type="text"
                                value="<?php echo esc_html(date('Y-m-d h:i A', current_time('timestamp'))); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Category', 'udssl') ?> </td>
                        <td>
                            <select id="pay_category" type="text" value="<?php esc_attr_e('Sample Category', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Project', 'udssl') ?> </td>
                        <td>
                            <select id="pay_project" type="text" value="<?php esc_attr_e('Sample Project', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Task', 'udssl') ?> </td>
                        <td>
                            <select id="pay_task" type="text" value="<?php esc_attr_e('Sample Task', 'udssl') ?>">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Paid', 'udssl') ?> </td>
                        <td>
                            <input id="pay_paid" type="text" value="10" />
                            <button id="pay_calculate" class="btn "><?php esc_attr_e('Calculate', 'udssl') ?></button>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Charges', 'udssl') ?> </td>
                        <td>
                            <input id="pay_charges" type="text" value="10" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_attr_e('Effective', 'udssl') ?> </td>
                        <td>
                            <input id="pay_effective" type="text" value="10" />
                        </td>
                    </tr>
                    <td></td>
                    <td>
                        <button id="pay_add_payment" class="btn"><?php esc_attr_e('Add Payment', 'udssl') ?></button>
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
                        echo '<button id="' . esc_html( $id ) . '" class="btn pay_preset" >' . esc_html( $name ) . '</button> ';
                    }
                    ?>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
        <hr>
        <div class="footer">
            <p class="text-muted"><?php esc_attr_e('UDSSL Time Tracker', 'udssl') ?></p>
        </div>
    </div> <!-- /container -->
    <?php include_once UDSSL_TT_PATH . 'app/templates/_templates.php'; ?>
    <?php wp_footer(); ?>
    <?php do_action('udssl_payment_tracker'); ?>
</body>

</html>