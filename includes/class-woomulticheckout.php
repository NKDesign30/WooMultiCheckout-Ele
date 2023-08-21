<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class WooMultiCheckout extends \Elementor\Widget_Base {

    public function get_name() {
        return 'woomulticheckout';
    }

    public function get_title() {
        return __('WooCommerce Multistep Checkout', 'woomulticheckout');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_categories() {
        return ['woocommerce'];
    }

    protected function _register_controls() {
        // Add widget controls here (e.g., color picker, text input, etc.)
    }

    protected function render() {
        // Render the widget on the page
        $settings = $this->get_settings_for_display();

        // Include the template files for each step
        include WMC_PLUGIN_PATH . 'templates/step1-shipping.php';
        include WMC_PLUGIN_PATH . 'templates/step2-payment.php';
        include WMC_PLUGIN_PATH . 'templates/step3-review.php';
    }
}

