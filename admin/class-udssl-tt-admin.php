<?php
/**
 * UDSSL Time Tracker Administration
 */
class UDSSL_TT_Admin{
    /**
     * Options
     */
    private $options;

    /**
     * Tabs
     */
    private $tabs;

    /**
     * UDSSL Time Tracker Administration Constructor
     */
    function __construct(){
        $this->set_udssl_tt_default_options();

        add_action('after_setup_theme', array($this, 'udssl_tt_options_init'));

        $this->set_settings_page_tabs();

  		add_action('admin_menu', array($this, 'admin_menu'));

  		add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * UDSSL Time Tracker Default Options
     */
    function set_udssl_tt_default_options(){
        $this->options = array(
            'settings' => array(
                'block_visitors' => true
            ),
            'presets' => array(
                'Sleep' => array(
                    'name' => 'Sleep',
                    'category' => 'Life',
                    'project' => 'Rest',
                    'task' => 'Sleep'
                ),
                'Meal' => array(
                    'name' => 'Meal',
                    'category' => 'Life',
                    'project' => 'Meal',
                    'task' => 'Breakfast'
                ),
                'Nap' => array(
                    'name' => 'Nap',
                    'category' => 'Life',
                    'project' => 'Rest',
                    'task' => 'Nap'
                ),
                'Movies' => array(
                    'name' => 'Movies',
                    'category' => 'Life',
                    'project' => 'Entertainment',
                    'task' => 'Movies'
                ),
                'Songs' => array(
                    'name' => 'Songs',
                    'category' => 'Life',
                    'project' => 'Entertainment',
                    'task' => 'Songs'
                ),
                'Meeting' => array(
                    'name' => 'Meeting',
                    'category' => 'Work',
                    'project' => 'Office',
                    'task' => 'Meeting'
                ),
                'WordPress' => array(
                    'name' => 'WordPress',
                    'category' => 'Work',
                    'project' => 'Freelance',
                    'task' => 'WordPress'
                )
            )
        );
    }

    /**
     * UDSSL Time Tracker Options Initialization
     */
    function udssl_tt_options_init(){
        $udssl_tt_options = get_option('udssl_tt_options');
        if( false == $udssl_tt_options )
            update_option('udssl_tt_options', $this->options);
    }

    /**
     * UDSSL Time Tracker Page Tabs
     */
    function set_settings_page_tabs(){
        $this->tabs = array(
            'presets' => esc_attr__('Presets', 'udssl'),
            'settings' => esc_attr__('Settings', 'udssl'),
            'tracker' => esc_attr__('Tracker', 'udssl')
        );
    }

    /**
     * Admin Tabs for UDSSL Time Tracker
     */
    function udssl_settings_tabs(){
        if ( isset ( $_GET['tab'] ) ) :
            $current = sanitize_text_field( $_GET['tab'] );
        else:
            $current = 'presets';
        endif;

        $links = array();
        foreach( $this->tabs as $tab => $name ) :
            $tab = esc_html($tab);
            $name = esc_html($name);

            if ($tab == 'tracker') :
                $links[] = '<a class="nav-tab"
                href="' . get_home_url() . '/time-tracker/" > ' . $name . '</a>';
            elseif ( $tab == $current ) :
                $links[] = '<a class="nav-tab nav-tab-active"
                href="?page=manage-udssl-tt&tab=' .
                $tab . '" > ' . $name . '</a>';
            else :
                $links[] = '<a class="nav-tab"
                href="?page=manage-udssl-tt&tab=' .
                $tab . '" >' . $name . '</a>';
            endif;
        endforeach;

        echo '<h2 class="nav-tab-wrapper">';
            foreach ( $links as $link ):
                echo wp_kses($link, array('a' => 
                    array(
                        'href' => array(),
                        'class' => array()
                    )
                )); 
            endforeach;
        echo '</h2>';
    }

    /**
     * Register Settings for UDSSL Time Tracker
     */
	function register_settings(){
  		register_setting( 'udssl_tt_options', 'udssl_tt_options', array( $this, 'udssl_tt_options_validate' ) );
	}

    /**
     * UDSSL Time Tracker Admin Menu Registration
     */
	function admin_menu(){
  		$hook_suffix = add_menu_page(
            esc_attr__('Time Tracker', 'udssl'),
            esc_attr__('Time Tracker', 'udssl'),
            'manage_options',
            'manage-udssl-tt',
            array($this, 'render_admin_menu'),
            UDSSL_TT_URL . 'assets/udssl.png',
            25
  		);
  		add_action('admin_print_scripts-' . $hook_suffix, array($this, 'admin_scripts'));
	}

    /**
     * Render UDSSL Time Tracker Admin Menu
     */
	function render_admin_menu(){
  		echo '<div class="wrap">';
            echo '<div id="icon-udssl-tt" class="icon32"><br /></div>';
            echo '<h2>' . esc_attr__('UDSSL Time Tracker', 'udssl') . '</h2>';
            $this->udssl_settings_tabs();
            settings_errors();
            echo '<form action="options.php" method="post">';
                if ( isset ( $_GET['tab'] ) ) :
                    $tab = sanitize_text_field( $_GET['tab'] );
                else:
                    $tab = 'presets';
                endif;

                switch ( $tab ) :
                case 'presets' :
                    require UDSSL_TT_PATH . 'admin/tabs/tab-presets.php';
                    break;
                case 'settings' :
                    require UDSSL_TT_PATH . 'admin/tabs/tab-settings.php';
                    break;
                endswitch;

                settings_fields('udssl_tt_options');
                do_settings_sections('manage-udssl');

            echo '</form>';
  		echo '</div>';
	}

    /**
     * UDSSL Time Tracker Options Validation
     */
    function udssl_tt_options_validate($input){
        $options = get_option('udssl_tt_options');
        $output = $options;
        $defaults = $this->options;

        /**
         * Save Preset
         */
  		if(isset($input['save_preset'])){
            $name = sanitize_text_field($input['presets']['name']);
            $output['presets'][$name] = array(
                'name' => $name,
                'category' => sanitize_text_field($input['presets']['category']),
                'project' => sanitize_text_field($input['presets']['project']),
                'task' => sanitize_text_field($input['presets']['task'])
            );
            $message = esc_attr__('Preset Saved', 'udssl');
            $type = 'updated';
        }

        /**
         * Delete Preset
         */
        foreach($options['presets'] as $preset){
            $delete_name = 'delete_preset' . $preset['name'];
            if(isset($input[$delete_name])){
                $name = $preset['name'];
                if(isset($output['presets'][$name])){
                    unset($output['presets'][$name]);
                    $message = esc_attr__('Preset Deleted', 'udssl');
                } else {
                    $message = esc_attr__('No Preset Found', 'udssl');
                }
                $type = 'updated';
            }
        }

        /**
         * Reset Presets
         */
  		if(isset($input['reset_presets'])){
            $output['presets'] = $defaults['presets'];
            $message = esc_attr__('Presets Reset', 'udssl');
            $type = 'updated';
        }

        /**
         * Save Settings
         */
  		if(isset($input['save_settings'])){
            $output['settings']['block_visitors'] = (bool) $input['settings']['block_visitors'];
            $message = esc_attr__('Settings Saved', 'udssl');
            $type = 'updated';
        }

        /**
         * Reset Settings
         */
  		if(isset($input['reset_settings'])){
            $output['settings'] = $defaults['settings'];
            $message = esc_attr__('Settings Reset', 'udssl');
            $type = 'updated';
        }

        /**
         * Settings Updated Message
         */
        add_settings_error(
            'udssl',
            esc_attr('settings_updated'),
            esc_attr__($message),
            $type
        );

        return $output;
    }

    /**
     * UDSSL Time Tracker Admin Scripts
     */
    function admin_scripts(){
        wp_enqueue_style( 'udssl-tt-admin', UDSSL_TT_URL . 'css/udssl-tt-admin.css' );
    }
}
?>
