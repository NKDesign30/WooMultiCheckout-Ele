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
        // Pfad zur Vorlagendatei
        $template_path = plugin_dir_path(dirname(__FILE__)) . 'templates/step1-shipping.php';

        // Überprüfen Sie, ob die Vorlagendatei existiert
        if (file_exists($template_path)) {
            // Laden Sie die Vorlagendatei
            include $template_path;
        } else {
            // Fehlermeldung anzeigen, wenn die Vorlagendatei nicht gefunden wird
            echo 'Vorlagendatei nicht gefunden: ' . $template_path;
        }
    }
}
