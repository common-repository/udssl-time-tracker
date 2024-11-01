<?php
if(!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN'))
	exit();

/**
 * Delete UDSSL Time Tracker Option
 */
delete_option('udssl_tt_option');

/**
 * Delete Tables
 */
include_once 'inc/class-udssl-tt-db-interface.php';
$udssl_db = new UDSSL_TT_DB_Interface();
$udssl_db->delete_tables();
?>
