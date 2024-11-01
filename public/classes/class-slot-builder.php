<?php
/**
 *
 * Adds the time slot value to the WooCommerce cart, checkout, email and order details
 *
 * @since      1.0.0
 * @package    WC_Time_Slots
 * @subpackage WC_Time_Slots/public
 * @author     Colby Albarado <ca@colbyalbo.com>
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class WCTS_Slot_Builder {
    public $timezone;
    public $time_slots;

    public function __construct() {
        $this->timezone = $this->set_date_range()[0];
        $this->time_slots = $this->build_slot_array();
    }

    public function set_date_range() {
        $timezone = explode(',', get_option('ebxwcts_option_settings')['ebxwcts_time_zone']);
        date_default_timezone_set($timezone[1]);
        $day_offset =  get_option('ebxwcts_option_settings')['ebxwcts_day_offset'];
        $day_fence = get_option('ebxwcts_option_settings')['ebxwcts_outlook_fence'];
        $current_date = new DateTime();
        $end_date = new DateTime();
        $current_date->add(new DateInterval('P'. $day_offset .'D'));
        $end_date->add(new DateInterval('P'. $day_fence .'D'));
        $date_range = new DatePeriod( $current_date, new DateInterval('P1D'), $end_date );
        $val = [ $timezone[0], $date_range ];
        return $val; 
    }

    public function build_slot_array($appointments = []) {
        $range = $this->set_date_range()[1];
        $appointments = $appointments;
        $weekday_array = array_map( 'esc_html', get_option('ebxwcts_option_settings')['ebxwcts_days_array']);
        $time_slot_array = array_map( 'esc_html', array_diff( get_option('ebxwcts_option_settings')['ebxwcts_time_slots'], ['NOT SET'] ) );
        $time_date_array = [];
        foreach( $range as $date ) {
            if( in_array( $date->format('l'), $weekday_array, true ) ) {
                foreach( $time_slot_array as $ts ){
                    $time_date_array[] = $date->format('D, M d, Y') . ' at ' . $ts; 
                }
            }
        }
        return $time_slots = array_diff($time_date_array, $appointments);
    }
}
                    
$ebxwcts_time_zone = (new WCTS_Slot_Builder)->timezone;
if( ! function_exists('ebxwcts_get_slots')) {
    function ebxwcts_get_slots() {
        $ebxwcts_timeslots = (new WCTS_Slot_Builder)->time_slots;
        return $ebxwcts_timeslots;
    }
}
$ebxwcts_timeslots =  apply_filters('ebxwcts_after_slot_builder', ebxwcts_get_slots() ); 


