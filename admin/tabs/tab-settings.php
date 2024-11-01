<?php
/**
 * UDSSL Time Tracker Settings
 */
if( !defined( 'ABSPATH' ) ){
    header('HTTP/1.0 403 Forbidden');
    die('No Direct Access Allowed!');
}

/**
 * UDSSL Time Tracker Options
 */
$options = get_option('udssl_tt_options');

/**
 * Preset Section
 */
add_settings_section(
    'settings',
    esc_attr__('Settings', 'udssl'),
    'settings_callback',
    'manage-udssl'
);
function settings_callback(){
    _e('Configure UDSSL Time Tracker Settings', 'udssl');
}

/**
 * Block Visitors
 */
add_settings_field(
    'block_visitors',
    esc_attr__('Block Visitors', 'udssl'),
    'block_visitors_callback',
    'manage-udssl',
    'settings',
    $options
);
function block_visitors_callback($options){
    $option = checked( $options['settings']['block_visitors'], true, false);
    echo '<input name="udssl_tt_options[settings][block_visitors]" type="checkbox"' .
        esc_html( $option ) . ' >';
    echo ' <span class="description" >' . esc_attr__('Block non-logged in visitors', 'udssl') . '</span>';
}

/**
 * Save Reset Presets
 */
add_settings_section(
    'save_reset',
    esc_attr__('Save Settings', 'udssl'),
    'save_reset_callback',
    'manage-udssl'
);
function save_reset_callback(){
    echo '<input name="udssl_tt_options[save_settings]"
        type="submit" class="button-primary" value="' . esc_attr__('Save Settings', 'udssl') .'" />';
    echo ' <input name="udssl_tt_options[reset_settings]"
        type="submit" class="button-secondary" value="' . esc_attr__('Reset', 'udssl') .'" />';
}
?>
