<?php
/**
 *
 * main admin file for administration areas
 *
 * @since      1.0.0
 * @package    WC_Time_Slots
 * @subpackage WC_Time_Slots/admin
 * @author     Colby Albarado <ca@colbyalbo.com>
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once ( plugin_dir_path( __FILE__ ) . 'loader/plugin-dependancy.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'settings/metabox-enable-time-slots.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'settings/options-time-slots.php' );
do_action('ebxwcts_admin_hook');

if( ! function_exists('wcts_add_admin_styles') ) {
    add_action('admin_enqueue_scripts','wcts_add_admin_styles');
    function wcts_add_admin_styles() {
        wp_enqueue_style( 'wcts-admin-page', plugins_url( 'css/options.css', __FILE__ ), array(), WCTS_VERSION );
    }
}
