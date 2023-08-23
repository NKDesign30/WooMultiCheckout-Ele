<div class="wmc-step wmc-step3">
    <h2><?php _e('Schritt 3: Überprüfung', 'woomulticheckout'); ?></h2>
    <form id="wmc-step3-form" method="post">
        <?php $available_gateways = WC()->payment_gateways->get_available_payment_gateways(); ?>
        <div class="wmc-review-section">
            <h3><?php _e('Zahlungsmethode', 'woomulticheckout'); ?> <span class="edit-link" data-edit="payment-method">bearbeiten</span></h3>
            <p id="payment-method-display">
                <?php
                $selected_gateway = WC()->session->get('chosen_payment_method');

                if (isset($available_gateways[$selected_gateway])) {
                    $gateway = $available_gateways[$selected_gateway];
                    echo $gateway->get_icon();
                    echo esc_html($gateway->get_title());
                }
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
                <span class="wmc-label">Name:</span> <span class="wmc-value" id="shipping-name-display"><?php echo esc_html(WC()->session->get('shipping_first_name') . ' ' . WC()->session->get('shipping_last_name')); ?></span><br>
                <span class="wmc-label">Adresse:</span> <span class="wmc-value" id="shipping-address-display"><?php echo esc_html(WC()->session->get('shipping_address_1') . ', ' . WC()->session->get('shipping_city') . ', ' . WC()->session->get('shipping_postcode')); ?></span>
            </p>
            <textarea name="shipping_address" id="shipping-address" class="hidden"><?php echo esc_textarea($shipping_address); ?></textarea>
        </div>
        <div class="wmc-review-section">
            <h3><?php _e('Rechnungsadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="billing-address">bearbeiten</span></h3>
            <p id="billing-address-display">
                <span class="wmc-label">Name:</span> <span class="wmc-value" id="billing-name-display"><?php echo esc_html(WC()->session->get('billing_first_name') . ' ' . WC()->session->get('billing_last_name')); ?></span><br>
                <span class="wmc-label">Adresse:</span> <span class="wmc-value" id="billing-address-display"><?php echo esc_html(WC()->session->get('billing_address_1') . ', ' . WC()->session->get('billing_city') . ', ' . WC()->session->get('billing_postcode')); ?></span>
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
    // Dieser Code wird ausgeführt, sobald das Dokument vollständig geladen ist.
    document.addEventListener('DOMContentLoaded', function() {

        // Hier werden die Versandinformationen aus dem LocalStorage geholt.
        var shippingFirstName = localStorage.getItem('shipping_first_name');
        var shippingLastName = localStorage.getItem('shipping_last_name');
        var shippingAddress1 = localStorage.getItem('shipping_address_1');
        var shippingCity = localStorage.getItem('shipping_city');
        var shippingPostcode = localStorage.getItem('shipping_postcode');
        var shippingCountry = localStorage.getItem('shipping_country');

        // Hier werden die Rechnungsinformationen aus dem LocalStorage geholt.
        var billingFirstName = localStorage.getItem('billing_first_name');
        var billingLastName = localStorage.getItem('billing_last_name');
        var billingAddress1 = localStorage.getItem('billing_address_1');
        var billingCity = localStorage.getItem('billing_city');
        var billingPostcode = localStorage.getItem('billing_postcode');
        var billingCountry = localStorage.getItem('billing_country');

        // Hier wird die ausgewählte Zahlungsmethode und der Rabattcode aus dem LocalStorage geholt.
        var selectedPaymentMethod = localStorage.getItem('payment_method');
        console.log("Aus LocalStorage: ", selectedPaymentMethod);

        var couponCode = localStorage.getItem('coupon_code');

        // Die geholten Versandinformationen werden im Überprüfungsbereich angezeigt.
        document.getElementById('shipping-name-display').textContent = shippingFirstName + ' ' + shippingLastName;
        document.getElementById('shipping-address-display').textContent = shippingAddress1 + ', ' + shippingCity + ', ' + shippingPostcode;

        // Die geholten Rechnungsinformationen werden im Überprüfungsbereich angezeigt.
        document.getElementById('billing-name-display').textContent = billingFirstName + ' ' + billingLastName;
        document.getElementById('billing-address-display').textContent = billingAddress1 + ', ' + billingCity + ', ' + billingPostcode;

        // Hier wird versucht, den Titel und das Icon der ausgewählten Zahlungsmethode basierend auf dem Wert aus dem LocalStorage zu erhalten.
        var paymentMethodDisplay = document.getElementById('payment-method-display');
        var paymentMethodTitle = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").text();
        var paymentMethodIcon = jQuery("label[for='payment_method_" + selectedPaymentMethod + "'] img").clone();

        console.log("Gefundener Titel: ", paymentMethodTitle);
        console.log("Gefundenes Icon: ", paymentMethodIcon.length > 0 ? "Icon vorhanden" : "Kein Icon");

        // Wenn ein Icon für die Zahlungsmethode vorhanden ist, wird es zusammen mit dem Titel angezeigt.
        if (paymentMethodIcon.length) {
            paymentMethodIcon[0].style.width = '50px'; // Setzt die Breite des Icons auf 50px
            paymentMethodDisplay.innerHTML = '';
            paymentMethodDisplay.appendChild(paymentMethodIcon[0]);
            var labelText = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").clone().children().remove().end().text(); // Entfernt das Icon aus dem Label-Text
            paymentMethodDisplay.append(' ' + labelText.trim());
        } else {
            // Wenn kein Icon vorhanden ist, wird nur der Titel angezeigt.
            paymentMethodDisplay.textContent = paymentMethodTitle;
        }

        // Der Rabattcode wird im Überprüfungsbereich angezeigt.
        document.getElementById('coupon-code-display').textContent = couponCode;
    });
</script>
<style>
    .wmc-review-section {
        border: 1px solid #f5f5f5;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .wmc-review-section h3 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .wmc-review-section p {
        font-size: 16px;
    }

    .edit-link {
        cursor: pointer;
        color: blue;
        text-decoration: underline;
    }

    .hidden {
        display: none;
    }

    .wmc-label {
        color: #c3c3c3;
    }

    .wmc-value {
        font-weight: bold;
    }
</style>