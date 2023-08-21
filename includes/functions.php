<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function wmc_apply_coupon_code($coupon_code) {
    // Use WooCommerce functions to apply the coupon code
    WC()->cart->add_discount(sanitize_text_field($coupon_code));
}

function wmc_place_order($shipping_info, $payment_info) {
    // Create a new order in WooCommerce
    $order = wc_create_order();

    // Set the shipping and billing information
    $order->set_address($shipping_info, 'shipping');
    $order->set_address($payment_info, 'billing');

    // Add the products from the cart to the order
    foreach (WC()->cart->get_cart() as $cart_item) {
        $order->add_product($cart_item['data'], $cart_item['quantity']);
    }

    // Set the payment method
    $order->set_payment_method($payment_info['payment_method']);

    // Calculate the totals and save the order
    $order->calculate_totals();
    $order->save();

    // Empty the cart
    WC()->cart->empty_cart();

    return $order->get_id();
}
// Handle the AJAX request to apply the coupon code
add_action('wp_ajax_wmc_apply_coupon', 'wmc_ajax_apply_coupon');
add_action('wp_ajax_nopriv_wmc_apply_coupon', 'wmc_ajax_apply_coupon');

function wmc_ajax_apply_coupon() {
    $coupon_code = $_POST['coupon_code'];
    wmc_apply_coupon_code($coupon_code);
    wp_send_json_success();
}

// Handle the AJAX request to place the order
add_action('wp_ajax_wmc_place_order', 'wmc_ajax_place_order');
add_action('wp_ajax_nopriv_wmc_place_order', 'wmc_ajax_place_order');

function wmc_ajax_place_order() {
    parse_str($_POST['shipping_info'], $shipping_info);
    parse_str($_POST['payment_info'], $payment_info);
    $order_id = wmc_place_order($shipping_info, $payment_info);
    wp_send_json_success(['order_id' => $order_id]);
}
