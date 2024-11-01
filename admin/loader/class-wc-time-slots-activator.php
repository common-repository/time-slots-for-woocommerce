<?php

/**
 * Fired during plugin activation, sets initial values for time slot settings
 *
 * @since      1.0.0
 * @package    WC_Time_Slots
 * @subpackage WC_Time_Slots/includes
 * @author     Colby Albarado <ca@colbyalbo.com>
 * 
 */
if (!defined('WPINC')) {
    die;
}

class WCTS_Plugin_Activator
{
    /**
     *
     * @since    1.0.0
     * 
     */
    public function __construct()
    {
        $this->activate();
    }

    public function activate()
    {
        if (null == get_option('ebxwcts_option_settings')) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            if (!current_user_can('manage_options')) {
                return;
            }
            $args = [
                'ebxwcts_label' => 'Please Select a Time Slot:',
                'ebxwcts_days_array' => ['Monday'],
                'ebxwcts_outlook_fence' => absint(7),
                'ebxwcts_day_offset' => absint(1),
                'ebxwcts_slot_volume' => absint(2),
                'ebxwcts_time_slots' => ['NOT SET', 'NOT SET'],
                'ebxwcts_time_zone' => 'Central Time (US & Canada) (GMT-06:00),US/Central'
            ];
            update_option('ebxwcts_option_settings', $args);
        } else if (!null == get_option('ebxwcts_option_settings')) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            if (!current_user_can('manage_options')) {
                return;
            }
            $ebxwcts_option_settings = get_option('ebxwcts_option_settings');
            $ebxwcts_option_settings['ebxwcts_outlook_fence'] = absint(7);
            $ebxwcts_option_settings['ebxwcts_day_offset'] = absint(1);
            $ebxwcts_option_settings['ebxwcts_slot_volume'] = absint(2);
            update_option('ebxwcts_option_settings', $ebxwcts_option_settings);
        } else {
            return;
        }
    }
}
