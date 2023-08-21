<?php
/**
 * Plugin Name: WooCommerce Multistep Checkout for Elementor
 * Description: Elementor widget for WooCommerce that provides a multistep checkout process.
 * Version: 1.0.0
 * Author: NKDesign30
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-multistep-checkout.php';
require_once plugin_dir_path(__FILE__) . 'templates/step1-shipping.php';
require_once plugin_dir_path(__FILE__) . 'templates/step2-payment.php';
require_once plugin_dir_path(__FILE__) . 'templates/step3-review.php';

// Initialize the widget
function init_woocommerce_multistep_checkout() {
    $multistep_checkout = new Multistep_Checkout();
    $multistep_checkout->init();
}

add_action('plugins_loaded', 'init_woocommerce_multistep_checkout');
