<?php
/**
 *
 * public view for displaying the time slots
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
do_action('ebxwcts_before_slot_view');

//check to make sure woocommerce is installed and activated
if( in_array( 'woocommerce/woocommerce.php',  get_option( 'active_plugins' ) ) ) {
    require_once ( plugin_dir_path( __FILE__ ) . 'classes/class-add-info-wc.php' );
    if( ! function_exists( 'ebxwcts_add_consulting_call' ) ) {
        add_action( 'woocommerce_before_add_to_cart_quantity', 'ebxwcts_add_consulting_call' );
        function ebxwcts_add_consulting_call() {
            if (
                get_post_type( get_the_ID() ) == 'product' && get_post_meta( get_the_ID(),
                '_ebxwcts_time_slot_check', true ) && !null == ( get_option('ebxwcts_option_settings')['ebxwcts_days_array'] ) 
                ) {
                    require_once( plugin_dir_path( __FILE__ ) . 'classes/class-slot-builder.php' );
                   ?>
                    <div class="ebxwcts-time-slot-wrapper" style="margin-bottom: 20px; clear: both;">
                        <h3><?php esc_html_e( get_option('ebxwcts_option_settings')['ebxwcts_label'], WCTS_TEXT_DOMAIN ); ?></h3>
                        <h3><?php esc_html_e( 'Time Zone: ' . $ebxwcts_time_zone, WCTS_TEXT_DOMAIN ); ?></h3>
                        <?php if( !null == $ebxwcts_timeslots ){ ?>
                        <select id="daySelect" name="eb-call-option" required>
                            <?php 
                                echo '<option value=" " disabled >' . esc_html__( 'Select an option...', WCTS_TEXT_DOMAIN ) . '</option>';
                                foreach( $ebxwcts_timeslots as $date ) {
                                    _e( '<option value="' . esc_attr($date) . '">' . esc_html($date) . '</option>', WCTS_TEXT_DOMAIN );
                                }
                            ?>
                        </select>
                        <?php } else {
                            echo '<h3>Sorry, there are no available time slots.</h3>';
                        } ?>
                    </div>
                <?php
            } else {
                return;
            }
        }
    }
    new WCTS_Woo_Add;
    do_action('ebxwcts_after_slot_view');
}
