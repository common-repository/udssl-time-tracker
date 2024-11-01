<?php
/**
 * UDSSL Time Tracker Components
 */
class UDSSL_TT_Components{
    /**
     * Constructor
     */
    function __construct(){
        /**
         * UDSSL Time Tracker Action Links
         */
        add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);

        /**
         * UDSSL Time Tracker Navigation
         */
        add_action('udssl_nav', array($this, 'navigation'));
    }

    /**
     * UDSSL Time Tracker Action Links
     */
    function action_links($links, $file){
        if('udssl-time-tracker/index.php' == $file){
            $links[] = '<a href="'. get_admin_url(null, 'admin.php?page=manage-udssl-tt') .'">' . esc_attr__('Settings', 'udssl') . '</a>';
            $links[] = '<a href="' . get_home_url() . '/time-tracker/" >' . esc_attr__('Tracker', 'udssl') . '</a>';
        }
        return $links;
    }

    /**
     * UDSSL Time Tracker Navigation
     */
    function navigation(){
    ?>
<a class="navbar-brand" href="#"><img src="<?php echo UDSSL_TT_URL; ?>assets/page-icon.png" /></a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link"
                href="<?php echo get_home_url()  . '/time-tracker/'; ?>"><?php _e('Time Tracker', 'udssl') ?></a>
        </li>
        <li class="nav-item"><a class="nav-link"
                href="<?php echo get_home_url() . '/payment-tracker/'; ?>"><?php _e('Payment Tracker', 'udssl') ?></a>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('admin.php?page=manage-udssl-tt'); ?>"
                ><?php _e('Admin', 'udssl') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="http://udssl.com/udssl-time-tracker/"
                ><?php _e('UDSSL', 'udssl') ?></a></li>
    </ul>
</div>
<?php
    }

    /**
     * UDSSL Time Tracker Head Top
     */
    function headtop(){
    ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="shortcut icon" href="<?php echo UDSSL_TT_URL; ?>favicon.png">
<?php
    }
}
?>