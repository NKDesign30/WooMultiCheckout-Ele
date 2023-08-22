<div class="wmc-step wmc-step3">
    <h2><?php _e('Schritt 3: Überprüfung', 'woomulticheckout'); ?></h2>
    <form id="wmc-step3-form" method="post">
        <?php $available_gateways = WC()->payment_gateways->get_available_payment_gateways(); ?>
        <div class="wmc-review-section">
            <h3><?php _e('Zahlungsmethode', 'woomulticheckout'); ?> <span class="edit-link" data-edit="payment-method">bearbeiten</span></h3>
            <p id="payment-method-display">
                <?php
                $selected_gateway = WC()->session->get('chosen_payment_method');
                echo esc_html($available_gateways[$selected_gateway]->get_title());
                ?>
            </p>
            <select name="payment_method" id="payment-method" class="hidden">
                <?php
                foreach ($available_gateways as $gateway) {
                    echo '<option value="' . esc_attr($gateway->id) . '">' . esc_html($gateway->get_title()) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Rabattcode', 'woomulticheckout'); ?> <span class="edit-link" data-edit="coupon-code">bearbeiten</span></h3>
            <p id="coupon-code-display">
                <?php
                $applied_coupons = WC()->cart->get_applied_coupons();
                echo esc_html(implode(', ', $applied_coupons));
                ?>
            </p>
            <input type="text" name="coupon_code" id="coupon-code" class="hidden" value="<?php echo esc_attr(implode(', ', $applied_coupons)); ?>">
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Lieferadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="shipping-address">bearbeiten</span></h3>
            <p id="shipping-address-display">
                <?php
                $shipping_address = WC()->customer->get_shipping_address_1() . ', ' . WC()->customer->get_shipping_city() . ', ' . WC()->customer->get_shipping_postcode();
                echo esc_html($shipping_address);
                ?>
            </p>
            <textarea name="shipping_address" id="shipping-address" class="hidden"><?php echo esc_textarea($shipping_address); ?></textarea>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Rechnungsadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="billing-address">bearbeiten</span></h3>
            <p id="billing-address-display">
                <?php
                $billing_address = WC()->customer->get_billing_address_1() . ', ' . WC()->customer->get_billing_city() . ', ' . WC()->customer->get_billing_postcode();
                echo esc_html($billing_address);
                ?>
            </p>
            <textarea name="billing_address" id="billing-address" class="hidden"><?php echo esc_textarea($billing_address); ?></textarea>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Bestellung', 'woomulticheckout'); ?> <span>bearbeiten</span></h3>
            <div id="wmc-review-order">
                <!-- Display order details here -->
                <?php
                $cart = WC()->cart;
                if (!empty($cart->get_cart())) {
                    echo '<ul>';
                    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        echo '<li>' . esc_html($_product->get_name()) . ' x ' . esc_html($cart_item['quantity']) . ' - ' . wc_price($_product->get_price() * $cart_item['quantity']) . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
        <button type="submit" id="wmc-place-order" name="place_order"><?php _e('Jetzt bestellen', 'woomulticheckout'); ?></button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editLinks = document.querySelectorAll('.edit-link');
        editLinks.forEach(function(editLink) {
            editLink.addEventListener('click', function(event) {
                event.preventDefault();
                var editId = event.target.getAttribute('data-edit');
                var displayElement = document.getElementById(editId + '-display');
                var editElement = document.getElementById(editId);
                displayElement.classList.toggle('hidden');
                editElement.classList.toggle('hidden');
            });
        });
    });
</script>