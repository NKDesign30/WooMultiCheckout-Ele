<?php

/**
 * Plugin Name: WooCommerce MultiStep Checkout
 * Description: A custom Elementor widget for WooCommerce MultiStep Checkout.
 * Version: 1.0.0
 * Author: NKDesign30
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin constants.
define('WOOMULTICHECKOUT_VERSION', '1.0.0');
define('WOOMULTICHECKOUT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WOOMULTICHECKOUT_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the main plugin class.
require_once WOOMULTICHECKOUT_PLUGIN_DIR . 'plugin.php';

function enqueue_woomulticheckout_styles()
{
    wp_enqueue_style('woomulticheckout-styles', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_woomulticheckout_styles');
