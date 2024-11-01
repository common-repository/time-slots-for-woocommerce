<?php 
/**
 *
 * Settings panel view using the WP Settings API
 *
 * @since      1.0.0
 * @package    WC_Time_Slots
 * @subpackage WC_Time_Slots/admin/views
 * @author     Colby Albarado <ca@colbyalbo.com>
 * 
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
} 
require_once ( WCTS_PATH . 'includes/class-time-arrays.php' );

add_action( 'admin_menu', 'ebxwcts_add_admin_menu' );
add_action( 'admin_init', 'ebxwcts_settings_init' );

function ebxwcts_add_admin_menu() {
    add_submenu_page( 'woocommerce', 'Time Slots', 'Time Slots', 'manage_options', 'time-slots-options-page', 'ebxwcts_options_page' );
}

function ebxwcts_settings_init() {
    register_setting( 'ebxwcts-options', 'ebxwcts_option_settings', array( 'sanitize_callback' => 'ebxwcts_sanitize_validate',) );
    add_settings_section(
        'ebxwcts_options_section',
        __( 'Set Your Options Here', WCTS_TEXT_DOMAIN ),
        'ebxwcts_options_section_callback',
        'ebxwcts-options'
    );

    add_settings_field(
        'ebxwcts_label',
        __( 'Set Label for Drop Down', WCTS_TEXT_DOMAIN ),
        'ebxwcts_label_render',
        'ebxwcts-options',
        'ebxwcts_options_section'
    );
    add_settings_field(
        'ebxwcts_days_array',
        __( 'Set the Days of the Week', WCTS_TEXT_DOMAIN ),
        'ebxwcts_days_array_render',
        'ebxwcts-options',
        'ebxwcts_options_section'
    );

    do_action('ebxwcts_field_settings');

    add_settings_field(
        'ebxwcts_time_slots',
        __('Select Times', WCTS_TEXT_DOMAIN ),
        'ebxwcts_time_slots_render',
        'ebxwcts-options',
        'ebxwcts_options_section'
    );
    add_settings_field(
        'ebxwcts_time_zone',
        __('Select Time Zone', WCTS_TEXT_DOMAIN ),
        'ebxwcts_time_zone_render',
        'ebxwcts-options',
        'ebxwcts_options_section'
    );
    add_settings_field(
        'ebxwcts_remove_data',
        __('Remove Time Slot Data on Uninstall?', WCTS_TEXT_DOMAIN ),
        'ebxwcts_remove_data_render',
        'ebxwcts-options',
        'ebxwcts_options_section'
    );
}

if(!function_exists('ebxwcts_label_render') ){
    function ebxwcts_label_render() {
        $options = get_option( 'ebxwcts_option_settings');
        ?>
        <input type='text' name='ebxwcts_option_settings[ebxwcts_label]' value='<?php _e($options['ebxwcts_label'], WCTS_TEXT_DOMAIN); ?>' maxlength="65" size="65" required>
        <?php
    }
}

if(!function_exists('ebxwcts_days_array_render') ){
    function ebxwcts_days_array_render() {
        $options = get_option('ebxwcts_option_settings');
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach($days as $day) {
        ?>
            <label for="ebxwcts-<?=$day?>-input"><?=__($day, WCTS_TEXT_DOMAIN)?></label>
            <input id="ebxwcts-<?=$day?>-input" type="checkbox" name="ebxwcts_option_settings[ebxwcts_days_array][]" value="<?=$day?>" <?php !isset($options['ebxwcts_days_array']) ?: (in_array($day, $options['ebxwcts_days_array']) ? checked(true) : '' ); ?>>
        <?php
        }
    }
}

do_action('ebxwcts_field_callbacks');

if(!function_exists('ebxwcts_time_slots_render')){
    function ebxwcts_time_slots_render() {
        $options = get_option('ebxwcts_option_settings');
        $times = EBXWCTS_TimeValues::$wcts_time_values;
        $volume = !isset($options['ebxwcts_slot_volume']) ? 1 : $options['ebxwcts_slot_volume'];
        $i=1;
        while($i <= $volume) : 
        ?>
            <label for="ebxwcts-time-slots-input<?=$i?>"><?php _e( 'Time Slot '.$i, WCTS_TEXT_DOMAIN ); ?></label>
            <select id="ebxwcts-time-slots-input<?=$i?>" name="ebxwcts_option_settings[ebxwcts_time_slots][]" autoComplete="off">
            <?php 
            $g = $i - 1;
            foreach($times as $val){
                $check = !isset($options['ebxwcts_time_slots'][$g]) ? '' : selected($val, $options['ebxwcts_time_slots'][$g]);
                echo '<option value="'.$val.'"'. $check .'>'.$val.'</option>';
            }
        echo '</select><br>'; $i++; endwhile;
        
    }
}

if(!function_exists('ebxwcts_time_zone_render')){
    function ebxwcts_time_zone_render() {
        $options = get_option('ebxwcts_option_settings');
        $zones = EBXWCTS_TimeValues::$timezones;
        ?>
            <label for="ebxwcts-time-zone-input"><?php _e( 'Select Your Timezone', WCTS_TEXT_DOMAIN ); ?></label>
            <select id="ebxwcts-time-zone-input" name="ebxwcts_option_settings[ebxwcts_time_zone]" autoComplete="off">
            <?php 
            foreach($zones as $key => $val){
                $kv = $key . ',' . $val;
                $check = isset($options['ebxwcts_time_zone']) ? esc_attr(selected($options['ebxwcts_time_zone'], $kv)): '';
                echo '<option value="'.$kv.'"'. $check .'>'.$key.'</option>';
            }
        echo '</select>';
    }
}

if(!function_exists('ebxwcts_remove_data_render')){
    function ebxwcts_remove_data_render() {
        $options = get_option('ebxwcts_option_settings');
        ?>
            <input id="ebxwcts-remove-data-input" type="checkbox" name="ebxwcts_option_settings[ebxwcts_remove_data]" value="1" <?php !isset($options['ebxwcts_remove_data']) ? :  checked(1, $options['ebxwcts_remove_data']); ?>>
            <label for="ebxwcts-remove-data-input"><?php _e( 'Enabling this will delete all settings if the plugin is deleted. Do not enable this if you are going to install the pro version. Note: Deactivating the plugin will NOT remove settings.', WCTS_TEXT_DOMAIN ); ?></label>
        <?php 
    }
}

function ebxwcts_sanitize_validate($input) {
    if(!isset($input['ebxwcts_label'])){
        $input['ebxwcts_label'] = sanitize_text_field('Please Select a Time Slot:');
    }
    if(!isset($input['ebxwcts_days_array'])){
        $input['ebxwcts_days_array'] = array_map('sanitize_text_field',['none']);
    }
    if(!isset($input['ebxwcts_outlook_fence'])){
        $input['ebxwcts_outlook_fence'] = absint(7);
    }
    if(!isset($input['ebxwcts_day_offset'])){
        $input['ebxwcts_day_offset'] = absint(1);
    }
    if(!isset($input['ebxwcts_slot_volume'])){
        $input['ebxwcts_slot_volume'] = absint(2);
    }
    if(!isset($input['ebxwcts_time_slots'])){
        $input['ebxwcts_time_slots'] = array_map('sanitize_text_field',['NOT SET']);
    }
    if(!isset($input['ebxwcts_time_zone'])){
        $input['ebxwcts_time_zone'] = sanitize_text_field('Midway Island (GMT-11:00),Pacific/Midway');
    }
    if(!isset($input['ebxwcts_remove_data'])){
        $input['ebxwcts_remove_data'] = absint(0);
    }
    $input['ebxwcts_label'] = sanitize_text_field($input['ebxwcts_label']);
    $input['ebxwcts_days_array'] = array_map('sanitize_text_field', $input['ebxwcts_days_array']);
    $input['ebxwcts_outlook_fence'] = absint($input['ebxwcts_outlook_fence']);
    $input['ebxwcts_day_offset'] = absint($input['ebxwcts_day_offset']);
    $input['ebxwcts_slot_volume'] = absint($input['ebxwcts_slot_volume']);
    $input['ebxwcts_time_slots'] = array_map('sanitize_text_field', $input['ebxwcts_time_slots']);
    $input['ebxwcts_remove_data'] = absint($input['ebxwcts_remove_data']);
    $input['ebxwcts_time_zone'] = sanitize_text_field($input['ebxwcts_time_zone']);
    return $input;
}

function ebxwcts_options_section_callback() {
    echo __( 'Set all of your time slot options below.', WCTS_TEXT_DOMAIN );
}

function ebxwcts_options_page() {
    ?>
    <div class="wcts-main-container">
    <div class="wcts-left-col">
    <form action='options.php' method='post'>
        <h1>Time Slots Settings</h1>
        <?php
        settings_errors();
        settings_fields('ebxwcts-options');
        do_settings_sections('ebxwcts-options');
        submit_button();
        ?>

    </form>
    <?php do_action('ebxwcts_after_settings'); ?>
    </div>
    <?php require( WCTS_PATH . 'includes/settings-instructions.php' ); ?>
    </div>
    <?php
}
