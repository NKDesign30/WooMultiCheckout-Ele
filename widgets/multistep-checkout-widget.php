<?php

class Multistep_Checkout_Widget extends \Elementor\Widget_Base
{
  public function get_name()
  {
    return 'multistep-checkout';
  }

  public function get_title()
  {
    return 'Multistep Checkout';
  }

  public function get_icon()
  {
    return 'eicon-woocommerce';
  }

  public function get_categories()
  {
    return ['woocommerce'];
  }

  protected function _register_controls()
  {
    // Add widget controls here
  }

  protected function render()
  {
    // Render the widget content here
    echo '<div class="multistep-checkout-widget">';
    include plugin_dir_path(__FILE__) . '../templates/step1-shipping.php';
    include plugin_dir_path(__FILE__) . '../templates/step2-payment.php';
    include plugin_dir_path(__FILE__) . '../templates/step3-review.php';
    echo '</div>';
  }
}
