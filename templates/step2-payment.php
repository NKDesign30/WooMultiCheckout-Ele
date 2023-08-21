<div class="wmc-step wmc-step2">
    <h2><?php _e('Schritt 2: Zahlung', 'woomulticheckout'); ?></h2>
    <form id="wmc-payment-form">
        <div class="wmc-field">
            <label><?php _e('Zahlungsmethode', 'woomulticheckout'); ?></label>
            <select id="wmc-payment-method" name="payment_method" required>
                <!-- Add options for payment methods here -->
            </select>
        </div>
        <div class="wmc-field">
            <label for="wmc-coupon-code"><?php _e('Gutscheincode', 'woomulticheckout'); ?></label>
            <input type="text" id="wmc-coupon-code" name="coupon_code">
            <button type="button" id="wmc-apply-coupon"><?php _e('Gutschein anwenden', 'woomulticheckout'); ?></button>
        </div>
        <button type="button" id="wmc-next-step"><?php _e('Weiter', 'woomulticheckout'); ?></button>
    </form>
</div>
