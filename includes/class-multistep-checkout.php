<?php

class Multistep_Checkout {
    public function init() {
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widget']);
    }

    public function register_widget() {
        // Include the widget file
        require_once plugin_dir_path(__FILE__) . '../widgets/multistep-checkout-widget.php';

        // Register the widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Multistep_Checkout_Widget());
    }
}

