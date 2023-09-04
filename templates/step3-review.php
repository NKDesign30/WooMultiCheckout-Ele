<div class="wmc-step wmc-step3">
    <h2><?php _e('Schritt 1: Adressdaten', 'woomulticheckout'); ?></h2>
    <div id="step1">
        <?php do_action('woocommerce_checkout_billing'); ?>
        <?php do_action('woocommerce_checkout_shipping'); ?>
        <button id="goToStep2" class="wmc-next-step"><?php _e('Weiter zu Zahlungsdienst', 'woomulticheckout'); ?></button>
    </div>

    <h2><?php _e('Schritt 2: Zahlungsdienst', 'woomulticheckout'); ?></h2>
    <div id="step2" style="display: none;">
        <div class="checkout-step" id="payment-only">
            <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>
        <button id="goToStep3" class="wmc-next-step"><?php _e('Weiter zur Übersicht', 'woomulticheckout'); ?></button>
    </div>

    <h2><?php _e('Schritt 3: Übersicht und Bestellung', 'woomulticheckout'); ?></h2>
    <div id="step3" style="display: none;">
        <?php do_action('woocommerce_checkout_order_review'); ?>
        <button id="placeOrder" class="wmc-next-step"><?php _e('Bestellen', 'woomulticheckout'); ?></button>
    </div>
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

    .wmc-next-step {
        background-color: #333;
        color: #fff;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
        margin-top: 20px;
    }

    .wmc-next-step:hover {
        background-color: #555;
    }
</style>