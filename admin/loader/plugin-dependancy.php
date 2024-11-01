<?php
/**
 *
 * generates notifications if dependant plugins are not activated.
 *
 * @since      1.0.0
 * @package    WC_Time_Slots
 * @subpackage WC_Time_Slots/includes
 * @author     Colby Albarado <ca@colbyalbo.com>
 * 
 */
    
//check if WooCommerce is activated 
if( ! function_exists( 'ebxwcts_activated_check' ) ) {
    function ebxwcts_activated_check() {
        $wp_v = get_bloginfo('version');
        $wp_min = '3.9.0';
        $php_min = '5.6.0';
        $php_v = PHP_VERSION;
        if( version_compare( $php_v, $php_min) <= 0 ){
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html__( 'Notice: Time Slots needs a minimum PHP version of '. $php_min .', your version is '. $php_v .'.', 'WCTS_TEXT_DOMAIN' ); ?></p>
            </div>
            <?php
        } else if( $wp_v <= $wp_min ) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html__( 'Notice: Time Slots needs a minimum WordPress version of '. $wp_min .', your version is '. $wp_v .'.', 'WCTS_TEXT_DOMAIN' ); ?></p>
            </div>
            <?php
        } else {
            return;
        }

        if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'woocommerce' ) ) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html__( 'Notice: WooCommerce needs to be activated for WooCommerce Time Slots to work.', 'WCTS_TEXT_DOMAIN' ); ?></p>
            </div>
            <?php
        } else {
            return;
        }
    }
    add_action('admin_notices', 'ebxwcts_activated_check');
}