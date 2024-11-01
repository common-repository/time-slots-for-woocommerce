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

class WCTS_Woo_Add {

    public function __construct() {
        add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_item_data' ], 10, 3 );
        add_filter( 'woocommerce_get_item_data', [ $this, 'display_item_data' ], 10, 2 );
        add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'save_item_order' ], 10, 4 );
    }

    public function add_item_data( $cart_item_data, $product_id, $variation_id ) {
        $ebx_data = filter_input( INPUT_POST, 'eb-call-option', FILTER_SANITIZE_STRING );
        if( empty( $ebx_data ) ) {
            return $cart_item_data;
        }
        $cart_item_data['eb-call-option'] = $ebx_data;
        return $cart_item_data;
    }
    
    public function display_item_data( $item_data, $cart_item ) {
        if( empty( $cart_item['eb-call-option'] ) ) {
            return $item_data;
        }
        $item_data[] = array(
            'key' => __( 'Consulting', WCTS_TEXT_DOMAIN ),
            'value' => wc_clean( $cart_item['eb-call-option'] ),
            'display' => '',
        );
        return $item_data;
    }

    function save_item_order( $item, $cart_item_key, $values, $order ){
        if( empty( $values['eb-call-option'] ) ) {
            return;
        }
        $item->add_meta_data( __( 'Consulting', WCTS_TEXT_DOMAIN ), $values['eb-call-option'] );
    }
}    
