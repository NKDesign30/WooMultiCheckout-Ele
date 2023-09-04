<!-- Step 1: Adressdaten -->
<div id="step1" class="step1-form-container">
    <h2>Wohin sollen wir dein Paket schicken?</h2>
    <div class="step1-form-box">
        <?php do_action('woocommerce_checkout_billing'); ?>
        <?php do_action('woocommerce_checkout_shipping'); ?>
        <button id="goToStep2" class="wmc-next-step">Weiter zu Zahlungsdienst</button>
    </div>
</div>

<!-- Step 2: Zahlungsdienst -->
<div id="step2" class="step2-payment" style="display: none;">
    <h2>Zahlung</h2>
    <p>Bitte wählen Sie Ihre bevorzugte Zahlungsmethode aus:</p>
    <div class="checkout-step" id="payment-only">
        <?php do_action('woocommerce_checkout_order_review'); ?>
    </div>
    <button id="goToStep3" class="wmc-next-step">Weiter zur Übersicht</button>
</div>

<!-- Step 3: Übersicht und Bestellung -->
<div id="step3" class="wmc-step wmc-step3" style="display: none;">
    <h2><?php _e('Schritt 3: Übersicht und Bestellung', 'woomulticheckout'); ?></h2>
    <?php do_action('woocommerce_checkout_order_review'); ?>
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

    .step1-form-container,
    .step2-payment,
    .wmc-step {
        font-size: 16px;
        border: 1px solid #f5f5f5;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
    }
</style>