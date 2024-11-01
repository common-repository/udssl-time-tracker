<?php
/**
 * UDSSL Time Tracker Gate
 */
class UDSSL_TT_Gate{
    /**
     * Check Request
     */
    function check_request(){
        do_action('udssl_tt_api_request');
        $options = get_option('udssl_tt_options');
        $block_visitors = $options['settings']['block_visitors'];
        if($block_visitors && !is_user_logged_in()){
            wp_die(esc_attr__('You should be logged in to use Time Tracker.', 'udssl'));
        }

    }
}
?>
