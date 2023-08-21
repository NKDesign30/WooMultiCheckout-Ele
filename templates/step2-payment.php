<div class="step2-payment">
    <h2>Zahlung</h2>
    <p>Bitte wählen Sie Ihre bevorzugte Zahlungsmethode aus:</p>
    <form id="payment-form" method="post">
        <?php
        // Get available payment gateways
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        if (!empty($available_gateways)) {
            foreach ($available_gateways as $gateway) {
                echo '<div class="payment-option">';
                echo '<input type="radio" name="payment_method" value="' . esc_attr($gateway->id) . '" id="payment_method_' . esc_attr($gateway->id) . '">';
                echo '<label for="payment_method_' . esc_attr($gateway->id) . '">' . esc_html($gateway->get_title()) . '</label>';
                echo '</div>';
            }
        }
        ?>
        <div class="coupon-field">
            <label for="coupon_code">Gutscheincode:</label>
            <input type="text" name="coupon_code" id="coupon_code" placeholder="Gutscheincode eingeben">
            <button type="submit" name="apply_coupon" value="Gutschein anwenden">Gutschein anwenden</button>
        </div>
    </form>
</div>