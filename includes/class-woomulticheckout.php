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
        $current_step = isset($_GET['step']) ? intval($_GET['step']) : 1;

        switch ($current_step) {
            case 1:
                $template_path = plugin_dir_path(dirname(__FILE__)) . 'templates/step1-shipping.php';
                break;
            case 2:
                $template_path = plugin_dir_path(dirname(__FILE__)) . 'templates/step2-payment.php';
                break;
            case 3:
                $template_path = plugin_dir_path(dirname(__FILE__)) . 'templates/step3-review.php';
                break;
            default:
                $template_path = plugin_dir_path(dirname(__FILE__)) . 'templates/step1-shipping.php';
                break;
        }

        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo 'Vorlagendatei nicht gefunden: ' . $template_path;
        }
    }

    public function enqueue_wmc_scripts()
    {
        // Überprüfen Sie, ob Sie sich auf Schritt 3 befinden
        $current_step = isset($_GET['step']) ? intval($_GET['step']) : 1;
        if ($current_step === 3) {
            // Skript für Schritt 3 in die Warteschlange stellen
            wp_enqueue_script('wmc-step3', plugin_dir_url(__FILE__) . 'assets/js/step3.js', array('jquery'), '1.0.0', true);

            // Lokalisieren Sie das Skript, um die AJAX-URL zu übergeben
            wp_localize_script('wmc-step3', 'wmc_params', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }
    }
}

// Stellen Sie sicher, dass die Methode enqueue_wmc_scripts() zum richtigen Zeitpunkt aufgerufen wird.
add_action('wp_enqueue_scripts', [WooMultiCheckout_Widget::class, 'enqueue_wmc_scripts']);
