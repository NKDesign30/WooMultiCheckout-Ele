<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */


function hello_elementor_child_enqueue_scripts()
{
  wp_enqueue_style(
    'hello-elementor-child-style',
    get_stylesheet_directory_uri() . '/style.css',
    [
      'hello-elementor-theme-style',
    ],
    rand(111, 9999)
  );
}

// START: don't send email if customer clicks on "order now" //
add_filter('woocommerce_gzd_instant_order_confirmation', 'my_child_disable_instant_order_confirmation', 1, 10);

function my_child_disable_instant_order_confirmation($disable)
{
  return false;
}
// END: don't send email if customer clicks on "order now" //

add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);

// Remove TablePress Default CSS
add_filter('tablepress_use_default_css', '__return_false');

// https://wordpress.org/support/topic/remove-featured-image-from-product-page-gallery/
function remove_featured_image($html, $attachment_id)
{
  global $post, $product;

  $featured_image = get_post_thumbnail_id($post->ID);

  if ($attachment_id == $featured_image)
    $html = '';

  return $html;
}
add_filter('woocommerce_single_product_image_thumbnail_html', 'remove_featured_image', 10, 2);

// Start Chat Upon Button Click Script integration
add_action("wp_enqueue_scripts", "add_blst_script");
function add_blst_script()
{
  // wp_enqueue_script('userlike_js', get_template_directory_uri() . "/inc/startUserlike.js", array('jquery'), null);
  wp_enqueue_script('userlike_js', get_stylesheet_directory_uri() . "/inc/startUserlike.js", array('jquery'), null);
}

//add_action( 'woocommerce_email_after_order_table', 'add_payment_method_to_admin_new_order', 15, 2 );

/**
 * Add used coupons to the order confirmation email
 *
 */
function add_payment_method_to_admin_new_order($order, $is_admin_email)
{

  if ($is_admin_email) {

    if ($order->get_used_coupons()) {

      $coupons_count = count($order->get_used_coupons());

      echo '<h4>' . __('Verwendete Gutscheine') . ' (' . $coupons_count . ')</h4>';

      echo '<p><strong>' . __('Verwendete Gutscheine') . ':</strong> ';

      $i = 1;
      $coupons_list = '';

      foreach ($order->get_used_coupons() as $coupon) {
        $coupons_list .=  $coupon;
        if ($i < $coupons_count)
          $coupons_list .= ', ';
        $i++;
      }

      echo '<p><strong>Verwendete Gutscheine (' . $coupons_count . ') :</strong> ' . $coupons_list . '</p>';
    } // endif get_used_coupons

  } // endif $is_admin_email
}



add_action('woocommerce_admin_order_data_after_billing_address', 'custom_checkout_field_display_admin_order_meta', 10, 1);

/**
 * Add used coupons to the order edit page
 *
 */
function custom_checkout_field_display_admin_order_meta($order)
{

  if ($order->get_used_coupons()) {

    $coupons_count = count($order->get_used_coupons());

    echo '<h4>' . __('Coupons used') . ' (' . $coupons_count . ')</h4>';

    echo '<p><strong>' . __('Coupons used') . ':</strong> ';

    $i = 1;

    foreach ($order->get_used_coupons() as $coupon) {
      echo $coupon;
      if ($i < $coupons_count)
        echo ', ';
      $i++;
    }

    echo '</p>';
  }
}
// Prüfung bei WooCommerce ob Straße und Hausnummer bei der Adresse eingetragen wurden

add_action('woocommerce_checkout_process', 'custom_validation_process');

function custom_validation_process()
{
  global $woocommerce;

  if (isset($_POST['billing_address_1']) and $_POST['billing_address_1'] != '') {
    if (!preg_match('/([A-Za-z.]+ [0-9a-z]+)/Uis', $_POST['billing_address_1'])) {
      if (function_exists('wc_add_notice'))
        wc_add_notice(__('Bitte Straße und Hausnummer eintragen'), 'error');
      else
        $woocommerce->add_error(__('Bitte Straße und Hausnummer eintragen'));
    }
  }

  if (isset($_POST['ship_to_different_address'])) {
    if (isset($_POST['shipping_address_1']) and $_POST['shipping_address_1'] != '') {
      if (!preg_match('/([A-Za-z.]+ [0-9a-z]+)/Uis', $_POST['shipping_address_1'])) {
        if (function_exists('wc_add_notice'))
          wc_add_notice(__('Bitte Straße und Hausnummer eintragen'), 'error');
        else
          $woocommerce->add_error(__('Bitte Straße und Hausnummer eintragen'));
      }
    }
  }
}

// Show Coupon Codes in Order eMails
// https://stackoverflow.com/questions/47322228/add-applied-coupon-code-in-admin-new-order-email-template-woocommerce/47341961#47341961
// The email function hooked that display the text
add_action('woocommerce_email_after_order_table', 'display_applied_coupons', 10, 4);
// add_action( 'woocommerce_email_before_order_table', 'display_applied_coupons', 10, 4 );
function display_applied_coupons($order, $sent_to_admin, $plain_text, $email)
{

  // Only for admins and when there at least 1 coupon in the order
  if (!$sent_to_admin && count($order->get_items('coupon')) == 0) return;

  foreach ($order->get_items('coupon') as $coupon) {
    $coupon_codes[] = $coupon->get_code();
  }
  // For one coupon
  if (count($coupon_codes) == 1) {
    $coupon_code = reset($coupon_codes);
    echo '<p>' . __('Gutschein: ') . $coupon_code . '<p>';
  }
  // For multiple coupons
  else {
    $coupon_codes = implode(', ', $coupon_codes);
    echo '<p>' . __('Gutscheine: ') . $coupon_codes . '<p>';
  }
}
// WooCommerce Fix V.7.8 hat ein Problem nach Update von Elementor oder WooCommerce wieder entfernen 
add_action('wp_enqueue_scripts', 'custom_enqueue_wc_cart_fragments');
function custom_enqueue_wc_cart_fragments()
{
  wp_enqueue_script('wc-cart-fragments');
}
//Änderung der AGBs und NL
add_action('init', 'my_child_move_legal_checkboxes', 10);
function my_child_move_legal_checkboxes()
{
  // Remove
  remove_action('woocommerce_review_order_after_payment', 'woocommerce_gzd_template_render_checkout_checkboxes', 10);
  // Readd before submit button
  add_action('woocommerce_gzd_review_order_before_submit', 'woocommerce_gzd_template_render_checkout_checkboxes', 10);
}
/**
 * Pre-populate Woocommerce checkout fields
 */
add_filter('woocommerce_checkout_get_value', function ($input, $key) {
  global $current_user;
  switch ($key):
    case 'billing_first_name':
    case 'shipping_first_name':
      return $current_user->first_name;
      break;

    case 'billing_last_name':
    case 'shipping_last_name':
      return $current_user->last_name;
      break;
    case 'billing_email':
      return $current_user->user_email;
      break;
    case 'billing_phone':
      return $current_user->phone;
      break;

  endswitch;
}, 10, 2);



//Gutschein
add_action('woocommerce_before_calculate_totals', 'check_cart_items_count', 10, 1);

function check_cart_items_count($cart)
{
  if (is_admin() && !defined('DOING_AJAX'))
    return;

  if (did_action('woocommerce_before_calculate_totals') >= 2)
    return;

  // Set your coupon code here
  $coupon_code = 'vital-set3';

  // Get the count of cart items
  $cart_items_count = $cart->get_cart_contents_count();

  // If coupon is applied and items in cart are less than 3
  if ($cart->has_discount($coupon_code) && $cart_items_count < 3) {
    // Remove the coupon code
    $cart->remove_coupon($coupon_code);

    // Display a message
    wc_print_notice('Der Gutschein ' . $coupon_code . ' kann erst ab einer Menge von 3 Produkten angewendet werden.', 'notice');
  }
}
// Test
function my_custom_message()
{
  echo '<div class="woocommerce-message">This is a custom message!</div>';
}
add_action('woocommerce_before_cart', 'my_custom_message');
// PayPal logo
function woocommerce_paypal_payments_gateway_icon($icon, $id)
{
  if ($id === 'ppcp-gateway') {
    return '<img src="http://staging.neurolab-vital.de/wp-content/uploads/2023/08/4202081logopaymentpaypalsocialsocialmedia-115606_115695.svg" alt="PayPal Payments" />';
  } else {
    return $icon;
  }
}
add_filter('woocommerce_gateway_icon', 'woocommerce_paypal_payments_gateway_icon', 10, 2);


function add_ajaxurl_cdata_to_front()
{
?>
  <script type="text/javascript">
    //<![CDATA[
    ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    //]]> 
  </script>
<?php
}
add_action('wp_head', 'add_ajaxurl_cdata_to_front', 1);

function woocommerce_update_cart_action()
{
  error_log("AJAX-Handler 'woocommerce_update_cart' wurde aufgerufen.");

  $cart_item_key = $_POST['cart_item_key'];
  $cart_item_qty = $_POST['cart_item_qty'];

  WC()->cart->set_quantity($cart_item_key, $cart_item_qty);

  wp_die();
}
add_action('wp_ajax_woocommerce_update_cart', 'woocommerce_update_cart_action');
add_action('wp_ajax_nopriv_woocommerce_update_cart', 'woocommerce_update_cart_action');

// AJAX-Handler für das Aktualisieren des Warenkorb-Gesamtpreises
add_action('wp_ajax_wmc_update_cart_total', 'wmc_update_cart_total');
add_action('wp_ajax_nopriv_wmc_update_cart_total', 'wmc_update_cart_total');

function wmc_update_cart_total()
{
  $cart_key = $_POST['cart_key'];
  $quantity = intval($_POST['quantity']);

  // Aktualisieren Sie die Produktmenge im Warenkorb
  WC()->cart->set_quantity($cart_key, $quantity);

  // Holen Sie sich den aktualisierten Warenkorb-Gesamtbetrag
  $cart_total = WC()->cart->get_cart_total();

  wp_send_json_success(['cart_total' => strip_tags($cart_total)]);
}

/*
* Cart Counter
*
*/ //Enqueue Ajax Scripts
add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity');

function update_cart_item_quantity()
{
  if (isset($_POST['cart_item_key']) && isset($_POST['quantity'])) {
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);

    WC()->cart->set_quantity($cart_item_key, $quantity);
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }
  wp_die();
}
function enqueue_woo_multicheckout_scripts()
{
  wp_enqueue_script('woo-multicheckout', get_site_url() . '/wp-content/plugins/woocommerce-multistep-checkout/assets/js/woo-multicheckout.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_woo_multicheckout_scripts');
