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

<!-- Step 3: Übersicht und Bestellung -->
<div id="step3" style="display: none;">
    <h2><?php _e('Schritt 3: Übersicht und Bestellung', 'woomulticheckout'); ?></h2>
    <div class="wmc-step3-content">
        <div class="wmc-step3-left">
            <h3>Zahlungsmethode</h3>
            <!-- Hier wird die ausgewählte Zahlungsmethode angezeigt -->
            <div id="selected-payment-method"></div>

            <h3>Rabattcode</h3>
            <!-- Hier wird der Rabattcode angezeigt, falls vorhanden -->
            <?php if (WC()->cart->get_coupon_discount_totals()) : ?>
                <div id="applied-coupons">
                    <?php foreach (WC()->cart->get_coupon_discount_totals() as $code => $amount) : ?>
                        <span><?php echo esc_html($code); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h3>Lieferadresse</h3>
            <!-- Hier wird die Lieferadresse angezeigt -->
            <div id="shipping-address">
                <?php echo WC()->customer->get_shipping_address(); ?>
            </div>

            <h3>Rechnungsadresse</h3>
            <!-- Hier wird die Rechnungsadresse angezeigt -->
            <div id="billing-address">
                <?php echo WC()->customer->get_billing_address(); ?>
            </div>
        </div>

        <div class="wmc-step3-right">
            <h3>Warenkorb</h3>
            <!-- Hier wird der Warenkorb angezeigt -->
            <?php do_action('woocommerce_review_order_before_cart'); ?>
            <?php woocommerce_order_review(); ?>
            <?php do_action('woocommerce_review_order_after_cart'); ?>
        </div>
    </div>
    <button id="placeOrder" class="wmc-next-step">Bestellen</button>
</div>

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

    .wmc-step3-content {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .wmc-step3-left,
    .wmc-step3-right {
        width: 48%;
        /* Anpassen, je nach Bedarf */
    }

    #selected-payment-method,
    #applied-coupons,
    #shipping-address,
    #billing-address {
        margin-bottom: 20px;
    }
</style>