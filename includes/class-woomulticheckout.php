<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WooMultiCheckout_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'woomulticheckout';
    }

    public function get_title()
    {
        return __('WooCommerce MultiStep Checkout', 'woomulticheckout');
    }

    public function get_icon()
    {
        return 'fa fa-shopping-cart';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {
        // Add your controls here.
    }

    protected function render()
    {
        echo '<div class="woomulticheckout-widget">';
        echo '<h2>WooCommerce MultiStep Checkout</h2>';
        echo '<p>This is a placeholder for the WooCommerce MultiStep Checkout widget.</p>';
        echo '</div>';
    }
}
