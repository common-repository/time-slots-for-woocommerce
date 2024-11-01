<?php

/**
 * @link              https://gettimeslots.com
 * @since             1.0.0
 * @package           WC_Time_Slots
 *
 * @wordpress-plugin
 * Plugin Name:       Time Slots for WooCommerce
 * Plugin URI:        https://gettimeslots.com
 * Description:       Free Version. Dynamically adds a list of day and time slots to a WooCommerce product page for booking.
 * Version:           1.0.7
 * Author:            Colby Albarado
 * Author URI:        https://colbyalbo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       time-slots-for-woocommerce
 * Domain Path:       /languages
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2019 Eyebox Media LLC
*/

if (!defined('WPINC')) {
    die;
}

if (!class_exists('EBXWCTS_Time_Slot')) {
    class EBXWCTS_Time_Slot
    {
        public function __construct()
        {
            if (!function_exists('activate_wcts_plugin')) {
                function activate_wcts_plugin()
                {
                    require_once plugin_dir_path(__FILE__) . 'admin/loader/class-wc-time-slots-activator.php';
                    $activation = new WCTS_Plugin_Activator;
                }
                register_activation_hook(__FILE__, 'activate_wcts_plugin');
            }
            //Constants for directory and version
            if (!defined('WCTS_VERSION')) {
                define('WCTS_VERSION', '1.0.7');
            }
            if (!defined('WCTS_TEXT_DOMAIN')) {
                define('WCTS_TEXT_DOMAIN', 'time-slots-for-woocommerce');
            }
            if (!defined('WCTS_PATH')) {
                define('WCTS_PATH', __DIR__ . '/');
            }

            if (is_admin()) {
                //Require the main admin file
                require_once plugin_dir_path(__FILE__) . 'admin/wc-time-slots-admin.php';
            }

            require_once plugin_dir_path(__FILE__) . 'public/wc-time-slots-view.php';
        }
    }
    new EBXWCTS_Time_Slot();
}
