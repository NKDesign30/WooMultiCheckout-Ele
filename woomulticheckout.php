<?php

/**
 * Plugin Name: WooMultiCheckout for Elementor
 * Description: A custom Elementor widget for WooCommerce multistep checkout.
 * Version: 1.0.2
 * Author: NKDesign30
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WMC_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WMC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the widget class and functions
require_once WMC_PLUGIN_PATH . 'includes/class-woomulticheckout.php';
require_once WMC_PLUGIN_PATH . 'includes/functions.php';

// Register the widget in Elementor
add_action('elementor/widgets/widgets_registered', 'register_woomulticheckout_widget');

function register_woomulticheckout_widget()
{
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \WooMultiCheckout());
}
