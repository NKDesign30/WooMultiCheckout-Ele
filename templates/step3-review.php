<div class="wmc-step wmc-step3">
    <h2><?php _e('Schritt 3: Überprüfung', 'woomulticheckout'); ?></h2>
    <form id="wmc-step3-form" method="post">
        <div class="wmc-review-section">
            <h3><?php _e('Zahlungsmethode', 'woomulticheckout'); ?></h3>
            <p id="wmc-review-payment-method">
                <!-- Display selected payment method here -->
                <select name="payment_method" id="payment-method">
                    <?php
                    $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
                    foreach ($available_gateways as $gateway) {
                        echo '<option value="' . esc_attr($gateway->id) . '">' . esc_html($gateway->get_title()) . '</option>';
                    }
                    ?>
                </select>
            </p>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Rabattcode', 'woomulticheckout'); ?></h3>
            <p id="wmc-review-coupon-code">
                <!-- Display applied coupon code here -->
                <input type="text" name="coupon_code" value="<?php echo esc_attr($couponCode); ?>">
            </p>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Lieferadresse', 'woomulticheckout'); ?></h3>
            <p>
                <span id="shipping-address-display"><!-- Display shipping address here --></span>
                <a href="#" id="edit-shipping-address"><?php _e('Bearbeiten', 'woomulticheckout'); ?></a>
            </p>
            <textarea name="shipping_address" id="shipping-address" class="hidden"><?php echo esc_textarea($shippingAddress); ?></textarea>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Rechnungsadresse', 'woomulticheckout'); ?></h3>
            <p>
                <span id="billing-address-display"><!-- Display billing address here --></span>
                <a href="#" id="edit-billing-address"><?php _e('Bearbeiten', 'woomulticheckout'); ?></a>
            </p>
            <textarea name="billing_address" id="billing-address" class="hidden"><?php echo esc_textarea($billingAddress); ?></textarea>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Bestellung', 'woomulticheckout'); ?></h3>
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
        <button type="button" id="wmc-update-order"><?php _e('Änderungen speichern', 'woomulticheckout'); ?></button>
        <button type="submit" id="wmc-place-order" name="place_order"><?php _e('Jetzt bestellen', 'woomulticheckout'); ?></button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggling between display and edit mode for shipping address
        var editShippingAddressLink = document.getElementById('edit-shipping-address');
        var shippingAddressDisplay = document.getElementById('shipping-address-display');
        var shippingAddressTextarea = document.getElementById('shipping-address');

        editShippingAddressLink.addEventListener('click', function(event) {
            event.preventDefault();
            shippingAddressDisplay.classList.add('hidden');
            shippingAddressTextarea.classList.remove('hidden');
        });

        // Toggling between display and edit mode for billing address
        var editBillingAddressLink = document.getElementById('edit-billing-address');
        var billingAddressDisplay = document.getElementById('billing-address-display');
        var billingAddressTextarea = document.getElementById('billing-address');

        editBillingAddressLink.addEventListener('click', function(event) {
            event.preventDefault();
            billingAddressDisplay.classList.add('hidden');
            billingAddressTextarea.classList.remove('hidden');
        });

        // Saving updated information
        var updateOrderButton = document.getElementById('wmc-update-order');
        updateOrderButton.addEventListener('click', function() {
            shippingAddressDisplay.textContent = shippingAddressTextarea.value;
            billingAddressDisplay.textContent = billingAddressTextarea.value;

            // Hide the textareas and display the updated addresses
            shippingAddressDisplay.classList.remove('hidden');
            shippingAddressTextarea.classList.add('hidden');
            billingAddressDisplay.classList.remove('hidden');
            billingAddressTextarea.classList.add('hidden');
        });
    });
</script>