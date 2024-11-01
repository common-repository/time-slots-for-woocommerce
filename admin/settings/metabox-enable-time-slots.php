<?php
/**
 *
 * adds a checkbox to the publish metabox to enable time slots on the product
 *
 * @since      1.0.0
 * @package    WC_Time_Slots
 * @subpackage WC_Time_Slots/admin/partials
 * @author     Colby Albarado <ca@colbyalbo.com>
 */

 if ( ! defined( 'WPINC' ) ) {
	die;
}

//Adds checkbox option to the publish metabox
if ( ! function_exists( 'ebxwcts_display_time_slot_checkbox' ) ) {

    add_action( 'post_submitbox_misc_actions', 'ebxwcts_display_time_slot_checkbox' );
    function ebxwcts_display_time_slot_checkbox(){

        $post_id = get_the_ID();
        if ( get_post_type( $post_id ) != 'product' ) {

            return;

        }
        $value = get_post_meta( $post_id, '_ebxwcts_time_slot_check', true );
        wp_nonce_field( 'ebxwcts_time_slot_check_nonce_'.$post_id, 'ebxwcts_time_slot_check_nonce' );
        ?>

        <div class="misc-pub-section misc-pub-section-last">
            <label><input type="checkbox" value="1" <?php checked( $value, true, true ); ?> name="_ebxwcts_time_slot_check" /><?php esc_html_e( 'Enable Time Slots', 'WCTS_TEXT_DOMAIN' ); ?></label>
        </div>

        <?php
    }
}

//saves the value of the checkbox or deletes it if is not checked
if ( ! function_exists( 'ebxwcts_save_time_slot_field' ) ) {

    add_action( 'save_post', 'ebxwcts_save_time_slot_field' );
    function ebxwcts_save_time_slot_field( $post_id ){
        
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! isset( $_POST['ebxwcts_time_slot_check_nonce'] ) || ! wp_verify_nonce( $_POST['ebxwcts_time_slot_check_nonce'], 'ebxwcts_time_slot_check_nonce_'.$post_id ) ) {
            return;
        }
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        if ( isset( $_POST['_ebxwcts_time_slot_check'] ) ) {
            $data = sanitize_text_field( $_POST['_ebxwcts_time_slot_check'] );
            if( $data == 1 ){
            update_post_meta( $post_id, '_ebxwcts_time_slot_check', $data );
            }
        } else {
            delete_post_meta( $post_id, '_ebxwcts_time_slot_check' );
        }
    }
}