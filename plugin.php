<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class WooMultiCheckout
{
  public function __construct()
  {
    add_action('elementor/widgets/widgets_registered', [$this, 'register_widget']);
  }

  public function register_widget()
  {
    require_once WOOMULTICHECKOUT_PLUGIN_DIR . 'includes/class-woomulticheckout.php';
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \WooMultiCheckout_Widget());
  }
}

new WooMultiCheckout();
