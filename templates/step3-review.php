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
                    <button id="confirm-payment-method" class="hidden">Änderungen übernehmen</button>
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
                    <button id="confirm-coupon-code" class="hidden">Änderungen übernehmen</button>
                </div>

                <!-- Lieferadresse -->
                <div class="wmc-review-section">
                    <h3><?php _e('Lieferadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="shipping-address">bearbeiten</span></h3>
                    <p class="shipping-address-container">
                    <div class="shipping-address-content">
                        <div class="address-line">
                            <span class="wmc-label">Name:</span>
                            <span class="wmc-value" id="shipping-name-display"><?php echo esc_html(WC()->session->get('shipping_first_name') . ' ' . WC()->session->get('shipping_last_name')); ?></span>
                        </div>
                        <div class="address-line">
                            <span class="wmc-label">Adresse:</span>
                            <span class="wmc-value" id="shipping-address-display"><?php echo esc_html(WC()->session->get('shipping_address_1') . ', ' . WC()->session->get('shipping_city') . ', ' . WC()->session->get('shipping_postcode')); ?></span>
                        </div>
                    </div>
                    </p>
                    <textarea name="shipping_address_1" id="shipping-address" class="hidden"><?php echo esc_textarea($shipping_address_1); ?></textarea>
                </div>

                <!-- Rechnungsadresse -->
                <div class="wmc-review-section">
                    <h3><?php _e('Rechnungsadresse', 'woomulticheckout'); ?> <span class="edit-link" data-edit="billing-address">bearbeiten</span></h3>
                    <p id="billing-address-display">
                        <span class="wmc-label">Name:</span> <span class="wmc-value" id="billing-name-display"><?php echo esc_html(WC()->session->get('billing_first_name') . ' ' . WC()->session->get('billing_last_name')); ?></span><br>
                        <span class="wmc-label">Adresse:</span> <span class="wmc-value" id="billing-address-display"><?php echo esc_html(WC()->session->get('billing_address_1') . ', ' . WC()->session->get('billing_city') . ', ' . WC()->session->get('billing_postcode')); ?></span>
                    </p>
                    <textarea name="billing_address_1" id="billing-address" class="hidden"><?php echo esc_textarea($billing_address_1); ?></textarea>
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

                            echo '<div class="wmc-cart-item" data-product-id="' . $product_id . '" data-cart-item-key="' . $cart_item_key . '">';

                            echo '<div class="wmc-cart-item-image">' . $_product->get_image() . '</div>';
                            echo '<div class="wmc-cart-item-title">' . $_product->get_name() . '</div>';
                            echo '<div class="wmc-cart-item-dropdown">';
                            echo '<select class="wmc-cart-item-quantity">';
                            for ($i = 1; $i <= 10; $i++) {
                                echo '<option value="' . $i . '"' . ($cart_item['quantity'] == $i ? ' selected' : '') . '>' . $i . '</option>';
                            }
                            echo '</select>';
                            echo '</div>';
                            echo '<div class="wmc-cart-item-price">' . wc_price($_product->get_price() * $cart_item['quantity']) . '</div>';
                            echo '<div class="wmc-cart-item-button"><button class="wmc-cart-item-remove">X</button></div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Retrieving shipping information from LocalStorage.
        var shippingFirstName = localStorage.getItem('shipping_first_name');
        var shippingLastName = localStorage.getItem('shipping_last_name');
        var shippingAddress1 = localStorage.getItem('shipping_address_1');
        var shippingCity = localStorage.getItem('shipping_city');
        var shippingPostcode = localStorage.getItem('shipping_postcode');
        var shippingCountry = localStorage.getItem('shipping_country');

        // Retrieving billing information from LocalStorage.
        var billingFirstName = localStorage.getItem('billing_first_name');
        var billingLastName = localStorage.getItem('billing_last_name');
        var billingAddress1 = localStorage.getItem('billing_address_1');
        var billingCity = localStorage.getItem('billing_city');
        var billingPostcode = localStorage.getItem('billing_postcode');
        var billingCountry = localStorage.getItem('billing_country');

        // Retrieving the selected payment method and discount code from LocalStorage.
        var selectedPaymentMethod = localStorage.getItem('payment_method');
        var couponCode = localStorage.getItem('coupon_code');

        // Displaying the retrieved shipping information in the review section.
        document.getElementById('shipping-name-display').textContent = shippingFirstName + ' ' + shippingLastName;
        document.getElementById('shipping-address-display').textContent = shippingAddress1 + ', ' + shippingCity + ', ' + shippingPostcode;

        // Displaying the retrieved billing information in the review section.
        document.getElementById('billing-name-display').textContent = billingFirstName + ' ' + billingLastName;
        document.getElementById('billing-address-display').textContent = billingAddress1 + ', ' + billingCity + ', ' + billingPostcode;

        // Trying to get the title and icon of the selected payment method based on the value from LocalStorage.
        var paymentMethodDisplay = document.getElementById('payment-method-display');
        var paymentMethodTitle = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").text();
        var paymentMethodIcon = jQuery("label[for='payment_method_" + selectedPaymentMethod + "'] img").clone();

        // If an icon for the payment method is present, it is displayed along with the title.
        if (paymentMethodIcon.length) {
            paymentMethodIcon[0].style.width = '50px'; // Setting the width of the icon to 50px
            paymentMethodDisplay.innerHTML = '';
            paymentMethodDisplay.appendChild(paymentMethodIcon[0]);

            // Extracting the text from the label but removing the image tag
            var labelText = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").clone().children().remove().end().text().trim();
            paymentMethodDisplay.append(' ' + labelText);
        } else {
            // If no icon is present, only the title is displayed.
            paymentMethodDisplay.textContent = paymentMethodTitle;
        }

        // Displaying the discount code in the review section.
        document.getElementById('coupon-code-display').textContent = couponCode;

        // Function to update the payment method
        document.querySelector('[data-edit="payment-method"]').addEventListener('click', function() {
            var paymentDisplay = document.getElementById('payment-method-display');
            var paymentSelect = document.getElementById('payment-method');
            var confirmButton = document.getElementById('confirm-payment-method');

            paymentDisplay.classList.add('hidden');
            paymentSelect.classList.remove('hidden');
            confirmButton.classList.remove('hidden');

            confirmButton.addEventListener('click', function() {
                var selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
                paymentDisplay.textContent = selectedOption.textContent;
                localStorage.setItem('payment_method', selectedOption.value);

                paymentDisplay.classList.remove('hidden');
                paymentSelect.classList.add('hidden');
                confirmButton.classList.add('hidden');
            });
        });

        // Function to update the discount code
        document.querySelector('[data-edit="coupon-code"]').addEventListener('click', function() {
            var couponDisplay = document.getElementById('coupon-code-display');
            var couponInput = document.getElementById('coupon-code');
            var confirmButton = document.getElementById('confirm-coupon-code');

            couponDisplay.classList.add('hidden');
            couponInput.classList.remove('hidden');
            confirmButton.classList.remove('hidden');

            confirmButton.addEventListener('click', function() {
                couponDisplay.textContent = couponInput.value;
                localStorage.setItem('coupon_code', couponInput.value);

                couponDisplay.classList.remove('hidden');
                couponInput.classList.add('hidden');
                confirmButton.classList.add('hidden');
            });
        });

        var ajax_url = wc_add_to_cart_params.ajax_url; // WooCommerce AJAX URL
        var cartItems = document.querySelectorAll('.wmc-cart-item');
        if (cartItems.length > 0) {
            cartItems.forEach(function(cartItem, index) {
                // Change quantity
                var quantitySelect = cartItem.querySelector('.wmc-cart-item-quantity');
                var priceDisplay = cartItem.querySelector('.wmc-cart-item-price');
                var productPrice = parseFloat(priceDisplay.textContent.replace(/[^0-9.,]/g, '').replace(',', '.'));

                if (quantitySelect) {
                    quantitySelect.addEventListener('change', function() {
                        var newQuantity = parseInt(quantitySelect.value);
                        var newPrice = productPrice * newQuantity;
                        priceDisplay.textContent = newPrice.toFixed(2) + ' €';

                        var cartItem = event.target.closest('.wmc-cart-item');
                        var productId = cartItem.dataset.productId;

                        jQuery.ajax({
                            type: 'POST',
                            url: ajax_url,
                            data: {
                                action: 'wmc_update_cart_total',
                                product_id: productId,
                                quantity: newQuantity
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update the cart's total price based on the response  
                                } else {
                                    console.error('Error updating the cart: ' + response.data);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log("Error sending the AJAX request:");
                                console.log("HTTP Status: " + jqXHR.status);
                                console.log("Error text: " + textStatus);
                                console.log("Exception: " + errorThrown);
                                alert("Error sending the AJAX request. Please check the developer console for more information.");
                            }
                        });
                    });
                }

                // Remove item
                var removeButton = cartItem.querySelector('.wmc-cart-item-remove');
                if (removeButton) {
                    removeButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        cartItem.remove();

                        jQuery.post(ajax_url, {
                            action: 'remove_cart_item',
                            cart_key: index
                        }, function(response) {
                            if (response.success) {
                                console.log('Item successfully removed');
                            } else {
                                console.error('Error removing the item');
                            }
                        });
                    });
                }
            });
        }
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
        margin: 15px;
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
        }

        .wmc-cart-item-image img {
            width: 50px;
            /* Reduzierte Bildgröße */
        }

        .address-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wmc-label {
            flex: 0;
        }

        .wmc-value {
            flex: 1;
            text-align: right;
        }

        .wmc-cart-item {
            display: flex;
            align-items: center;
        }

        .wmc-cart-item-image {
            flex: 0.5;
            /* Reduzierte Flex-Basis für Bilder */
            margin: 0 10px;
        }

        .wmc-cart-item-title {
            flex: 2;
            /* Erhöhte Flex-Basis für den Titel */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0 10px;
        }

        .wmc-cart-item-dropdown {
            flex: 0.5;
            /* Reduzierte Flex-Basis für Dropdown */
            margin: 0 10px;
        }

        .wmc-cart-item-price,
        .wmc-cart-item-button {
            flex: 1;
            margin: 0 10px;
        }

        .wmc-cart-item-quantity {
            width: 80px;
            /* Reduzierte Dropdown-Breite */
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            color: #333;
            background-color: #fff;
            text-align: center;
        }

        .wmc-cart-item-quantity:hover {
            border-color: #999;
            background-color: #f7f7f7;
        }

        .wmc-cart-item-quantity:focus {
            outline: none;
            box-shadow: none;
        }

        .wmc-cart-item-remove {
            background-color: transparent;
            /* Entfernt den Hintergrund */
            color: #f44336;
            /* Setzt die Farbe des "X" auf Rot */
            padding: 5px 8px;
            /* Passt die Polsterung an, um den Button kleiner zu machen */
            border: none;
            border-radius: 50%;
            /* Macht den Button kreisförmig */
            font-weight: bold;
            /* Macht das "X" fett */
            font-size: 18px;
            /* Erhöht die Schriftgröße des "X" */
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: flex;
            justify-content: flex-end;
            /* Fügt eine Übergangsfarbe hinzu */
        }

        .wmc-cart-item-remove:hover {
            background-color: #f44336;
            /* Setzt den Hintergrund beim Überfahren auf Rot */
            color: #fff;
            /* Setzt die Farbe des "X" beim Überfahren auf Weiß */
        }
    }
</style>