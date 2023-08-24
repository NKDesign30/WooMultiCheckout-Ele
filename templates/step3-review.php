<div class="wmc-step wmc-step3">
    <h2><?php _e('Schritt 3: Überprüfung', 'woomulticheckout'); ?></h2>
    <form id="wmc-step3-form" method="post">
        <?php $available_gateways = WC()->payment_gateways->get_available_payment_gateways(); ?>

        <div class="wmc-review-container">
            <!-- Linke Seite -->
            <div class="wmc-review-left">
                <!-- Zahlungsmethode -->
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

                <!-- Rabattcode -->
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

                <!-- Lieferadresse -->
                <div class="wmc-review-section">
                    <h3><?php _e('Lieferadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="shipping-address">bearbeiten</span></h3>
                    <div id="shipping-address-display" style="display: flex; justify-content: space-between;">
                        <div class="wmc-label-container">
                            <span class="wmc-label">Name:</span>
                            <span class="wmc-label">Adresse:</span>
                            <span class="wmc-label">PLZ/Ort:</span>
                        </div>
                        <div class="wmc-value-container">
                            <span class="wmc-value" id="shipping-name-display"><?php echo esc_html(WC()->session->get('shipping_first_name') . ' ' . WC()->session->get('shipping_last_name')); ?></span>
                            <span class="wmc-value" id="shipping-address-line1-display"><?php echo esc_html(WC()->session->get('shipping_address_1')); ?></span>
                            <span class="wmc-value" id="shipping-postcode-city-display"><?php echo esc_html(WC()->session->get('shipping_postcode') . ' ' . WC()->session->get('shipping_city')); ?></span>
                        </div>
                    </div>
                    <?php
                    $shipping_address = WC()->session->get('shipping_first_name') . ' ' . WC()->session->get('shipping_last_name') . "\n" . WC()->session->get('shipping_address_1') . "\n" . WC()->session->get('shipping_postcode') . ' ' . WC()->session->get('shipping_city');
                    ?>
                    <textarea name="shipping_address" id="shipping-address" class="hidden" rows="4"><?php echo esc_textarea($shipping_address); ?></textarea>
                    <button type="button" id="confirm-shipping-address" class="hidden">Bestätigen</button>
                </div>

                <!-- Rechnungsadresse -->
                <div class="wmc-review-section">
                    <h3><?php _e('Rechnungsadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="billing-address">bearbeiten</span></h3>
                    <p id="billing-address-display">
                        <span class="wmc-label">Name:</span> <span class="wmc-value" id="billing-name-display"><?php echo esc_html(WC()->session->get('billing_first_name') . ' ' . WC()->session->get('billing_last_name')); ?></span><br>
                        <span class="wmc-label">Adresse:</span> <span class="wmc-value" id="billing-address-display"><?php echo esc_html(WC()->session->get('billing_address_1') . ', ' . WC()->session->get('billing_city') . ', ' . WC()->session->get('billing_postcode')); ?></span>
                    </p>
                    <textarea name="billing_address" id="billing-address" class="hidden"><?php echo esc_textarea($billing_address); ?></textarea>
                </div>
            </div>

            <!-- Rechte Seite -->
            <div class="wmc-review-right">
                <!-- Warenkorb -->
                <div class="wmc-review-section">
                    <h3><?php _e('Warenkorb', 'woomulticheckout'); ?> <span>bearbeiten</span></h3>
                    <div id="wmc-review-order">
                        <!-- Display cart items -->
                        <?php
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                            echo '<div class="wmc-cart-item">';
                            echo '<div class="wmc-cart-item-image">' . $_product->get_image() . '</div>';
                            echo '<div class="wmc-cart-item-details">';
                            echo '<div class="wmc-cart-item-title">' . $_product->get_name() . '</div>';
                            echo '<div class="wmc-cart-item-quantity">x ' . $cart_item['quantity'] . '</div>';
                            echo '<div class="wmc-cart-item-price">' . wc_price($_product->get_price() * $cart_item['quantity']) . '</div>';
                            echo '</div></div>';
                        }
                        ?>

                        <!-- Display the shortcode -->
                        <div class="wmc-shortcode">
                            <?php echo do_shortcode('[elementor-template id="34712"]'); ?>
                        </div>

                        <!-- Display cart totals -->
                        <div class="wmc-cart-totals">
                            <?php
                            if (class_exists('WooCommerce')) {
                                // Daten abrufen
                                $subtotal = WC()->cart->subtotal;
                                $shipping_total_value = WC()->cart->shipping_total;
                                $tax_total = WC()->cart->tax_total;
                                $total_without_discount = WC()->cart->total;
                                $manual_discount = $subtotal - $total_without_discount;
                                $final_total = $subtotal - $manual_discount;
                            ?>
                                <div class="custom-cart-totals-box">
                                    <div class="cart-row">
                                        <span>Zwischensumme:</span>
                                        <span><?php echo wc_price($subtotal); ?></span>
                                    </div>
                                    <div class="cart-row">
                                        <span>Versand:</span>
                                        <span><?php
                                                if ($shipping_total_value == 0) {
                                                    echo "Kostenlos!";
                                                } else {
                                                    echo wc_price($shipping_total_value);
                                                }
                                                ?></span>
                                    </div>
                                    <div class="cart-row">
                                        <span>MwSt:</span>
                                        <span><?php echo wc_price($tax_total); ?></span>
                                    </div>
                                    <div class="cart-row rabatt">
                                        <span>Rabatt:</span>
                                        <span><?php echo wc_price($manual_discount); ?></span>
                                    </div>

                                    <div class="cart-row">
                                        <span>Gesamt:</span>
                                        <span><?php echo wc_price($final_total); ?></span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
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
        var_dump(WC() - > session - > get('shipping_first_name'));
        var_dump(WC() - > session - > get('shipping_last_name'));

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

            // Extrahiert den Text aus dem Label, entfernt aber das Bild-Tag
            var labelText = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").clone().children().remove().end().text().trim();
            paymentMethodDisplay.append(' ' + labelText);
        } else {
            // Wenn kein Icon vorhanden ist, wird nur der Titel angezeigt.
            paymentMethodDisplay.textContent = paymentMethodTitle;
        }
        // Der Rabattcode wird im Überprüfungsbereich angezeigt.
        document.getElementById('coupon-code-display').textContent = couponCode;

        // Event-Listener für den "bearbeiten"-Link der Zahlungsmethode
        document.querySelector('.edit-link[data-edit="payment-method"]').addEventListener('click', function() {
            document.getElementById('payment-method-display').style.display = 'none';
            document.getElementById('payment-method').style.display = 'block';
        });

        // Event-Listener für die Auswahl einer Zahlungsmethode
        document.getElementById('payment-method').addEventListener('change', function() {
            document.getElementById('payment-method-display').textContent = this.options[this.selectedIndex].text;
            this.style.display = 'none';
            document.getElementById('payment-method-display').style.display = 'block';
        });

        // Event-Listener für den "bearbeiten"-Link des Rabattcodes
        document.querySelector('.edit-link[data-edit="coupon-code"]').addEventListener('click', function() {
            document.getElementById('coupon-code-display').style.display = 'none';
            document.getElementById('coupon-code').style.display = 'block';
        });

        // Event-Listener für den "bearbeiten"-Link der Lieferadresse
        document.querySelector('.edit-link[data-edit="shipping-address"]').addEventListener('click', function() {
            document.getElementById('shipping-address-display').style.display = 'none';
            document.getElementById('shipping-address').style.display = 'block';
        });

        // Event-Listener für den "bearbeiten"-Link der Rechnungsadresse
        document.querySelector('.edit-link[data-edit="billing-address"]').addEventListener('click', function() {
            document.getElementById('billing-address-display').style.display = 'none';
            document.getElementById('billing-address').style.display = 'block';
        });
        // Event-Listener für den "Bestätigen"-Button der Lieferadresse
        document.getElementById('confirm-shipping-address').addEventListener('click', function() {
            var updatedAddress = document.getElementById('shipping-address').value.split("\n");
            document.getElementById('shipping-name-display').textContent = updatedAddress[0];
            document.getElementById('shipping-address-line1-display').textContent = updatedAddress[1];
            document.getElementById('shipping-postcode-city-display').textContent = updatedAddress[2];
            document.getElementById('shipping-address').style.display = 'none';
            document.getElementById('confirm-shipping-address').style.display = 'none';
            document.getElementById('shipping-address-display').style.display = 'block';
        });

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

    .wmc-cart-item-title,
    .wmc-cart-item-price {
        font-weight: bold;
    }

    .wmc-value {
        font-weight: bold;
    }

    .custom-cart-totals-box {
        width: 100%;
    }

    .wmc-cart-item-image img {
        width: 50px;
        height: auto;
    }

    .wmc-cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .wmc-cart-item-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .wmc-cart-item-title {
        flex: 1;
    }

    .wmc-cart-item-price {
        flex: 0;
    }

    .wmc-cart-totals {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .wmc-cart-totals .cart-row {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .wmc-cart-totals .cart-row span:first-child {
        font-weight: bold;
    }

    .wmc-cart-totals .cart-row:last-child span:first-child,
    .wmc-cart-totals .cart-row:last-child span:last-child {
        font-weight: bold;
    }

    .wmc-cart-totals .cart-row.rabatt span:last-child {
        color: red;
    }

    .progress-bar-text {
        margin-top: 15px;
        width: 100%;
        font-size: 12px;
    }

    @media (min-width: 768px) {
        .wmc-review-container {
            display: flex;
            justify-content: space-between;
        }

        .wmc-review-left,
        .wmc-review-right {
            width: 48%;
            /* Ein wenig weniger als 50%, um einen kleinen Abstand zwischen den Spalten zu lassen */
        }

        .wmc-cart-item-image img {
            width: 70px;
            /* Größere Bilder für Desktop */
        }

        .wmc-label-container,
        .wmc-value-container {
            display: flex;
            flex-direction: column;
        }

        .wmc-label-container .wmc-label,
        .wmc-value-container .wmc-value {
            margin-bottom: 5px;
        }
    }
</style>