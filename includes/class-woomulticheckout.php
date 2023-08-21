<?php

namespace WooMultiCheckout;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class WooMultiCheckout extends Widget_Base
{

    public function get_name()
    {
        return 'woomulticheckout';
    }

    public function get_title()
    {
        return 'WooCommerce MultiStep Checkout';
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
        // Add your controls here
    }

    protected function render()
    {
        // Add your HTML and JavaScript code here
    }
}
