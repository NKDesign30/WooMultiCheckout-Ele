<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;
?>

<!-- Step 1: Adressdaten -->
<div id="step1">
    <?php do_action('woocommerce_checkout_billing'); ?>
    <?php do_action('woocommerce_checkout_shipping'); ?>
    <button id="goToStep2">Weiter zu Zahlungsdienst</button>
</div>

<!-- Step 2: Zahlungsdienst -->
<div id="step2" style="display: none;">
    <div class="checkout-step" id="payment-only">
        <?php do_action('woocommerce_checkout_order_review'); ?>
    </div>
    <button id="goToStep3">Weiter zur Übersicht</button>
</div>

<!-- Step 3: Übersicht und Bestellung -->
<div id="step3" style="display: none;">
    <div class="wmc-review-container">

        <!-- Linke Seite: Zahlungsmethode, Rabattcode, Adressen -->
        <div class="wmc-review-left wmc-review-section">
            <!-- Zahlungsmethode -->
            <div class="wmc-section">
                <h3>Zahlungsmethode</h3>
                <p><?php echo WC()->session->get('chosen_payment_method'); ?></p>
            </div>

            <!-- Rabattcode -->
            <div class="wmc-section">
                <h3>Rabattcode</h3>
                <?php if (WC()->cart->get_coupon_discount_totals()) : ?>
                    <?php foreach (WC()->cart->get_coupon_discount_totals() as $code => $amount) : ?>
                        <p><?php echo esc_html($code); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Lieferadresse -->
            <div class="wmc-section">
                <h3>Lieferadresse</h3>
                <address>
                    <?php echo ($address = WC()->customer->get_shipping_address()) ? $address : 'Nicht festgelegt'; ?>
                </address>
            </div>

            <!-- Rechnungsadresse -->
            <div class="wmc-section">
                <h3>Rechnungsadresse</h3>
                <address>
                    <?php echo ($address = WC()->customer->get_billing_address()) ? $address : 'Nicht festgelegt'; ?>
                </address>
            </div>
        </div>

        <!-- Rechte Seite: Warenkorb -->
        <div class="wmc-review-right wmc-review-section">
            <h3>Warenkorb</h3>
            <?php do_action('woocommerce_checkout_before_order_review'); ?>
            <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>

        <!-- Clear float -->
        <div style="clear: both;"></div>
    </div>

    <button id="placeOrder">Bestellen</button>
</div>

<!-- Styling -->
<style>
    /* Hier kommt Ihr Styling-Code */
</style>


<!-- JavaScript for navigation -->
<script>
    jQuery(document).ready(function($) {
        $('#goToStep2').click(function() {
            $('#step1').hide();
            $('#step2').show();
        });

        $('#goToStep3').click(function() {
            $('#step2').hide();
            $('#step3').show();
        });
    });
    jQuery(document).ready(function($) {
        // Wenn eine Zahlungsmethode in Schritt 2 ausgewählt wird
        $('body').on('change', 'input[name="payment_method"]', function() {
            // Speichern Sie die ausgewählte Zahlungsmethode
            var selectedPaymentMethod = $(this).val();
            localStorage.setItem('selectedPaymentMethod', selectedPaymentMethod);
        });

        // Wenn zu Schritt 3 gewechselt wird
        $('#goToStep3').click(function() {
            // Holen Sie sich die zuvor gespeicherte Zahlungsmethode
            var selectedPaymentMethod = localStorage.getItem('selectedPaymentMethod');

            if (selectedPaymentMethod) {
                // Wählen Sie die entsprechende Zahlungsmethode in Schritt 3 aus
                $('input[name="payment_method"][value="' + selectedPaymentMethod + '"]').prop('checked', true);
            }
        });
    });
</script>

<!-- Additional Styling -->
<style>
    #step1,
    #step2,
    #step3 {
        padding: 20px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    #payment-only .woocommerce-checkout-review-order-table,
    #payment-only .woocommerce-checkout-review-order {
        display: none;
    }

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