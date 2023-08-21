<div class="wmc-step wmc-step3">
    <h2><?php _e('Schritt 3: Überprüfung', 'woomulticheckout'); ?></h2>
    <div class="wmc-review-section">
        <h3><?php _e('Zahlungsmethode', 'woomulticheckout'); ?></h3>
        <p id="wmc-review-payment-method"><!-- Display selected payment method here --></p>
    </div>
    <div class="wmc-review-section">
        <h3><?php _e('Rabattcode', 'woomulticheckout'); ?></h3>
        <p id="wmc-review-coupon-code"><!-- Display applied coupon code here --></p>
    </div>
    <div class="wmc-review-section">
        <h3><?php _e('Lieferadresse', 'woomulticheckout'); ?></h3>
        <p id="wmc-review-shipping-address"><!-- Display shipping address here --></p>
    </div>
    <div class="wmc-review-section">
        <h3><?php _e('Rechnungsadresse', 'woomulticheckout'); ?></h3>
        <p id="wmc-review-billing-address"><!-- Display billing address here --></p>
    </div>
    <div class="wmc-review-section">
        <h3><?php _e('Bestellung', 'woomulticheckout'); ?></h3>
        <div id="wmc-review-order"><!-- Display order details here --></div>
    </div>
    <button type="button" id="wmc-place-order"><?php _e('Jetzt bestellen', 'woomulticheckout'); ?></button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the selected payment method from step 2
        var paymentMethod = localStorage.getItem('paymentMethod');
        document.getElementById('wmc-review-payment-method').textContent = paymentMethod;

        // Get the applied coupon code from step 2
        var couponCode = localStorage.getItem('couponCode');
        document.getElementById('wmc-review-coupon-code').textContent = couponCode;

        // Get the shipping address from step 1
        var shippingAddress = localStorage.getItem('shippingAddress');
        document.getElementById('wmc-review-shipping-address').textContent = shippingAddress;

        // Get the billing address from step 1
        var billingAddress = localStorage.getItem('billingAddress');
        document.getElementById('wmc-review-billing-address').textContent = billingAddress;

        // Get the order details from the cart
        // Note: You may need to implement this part depending on how you store and display the order details
        // var orderDetails = ...;
        // document.getElementById('wmc-review-order').innerHTML = orderDetails;
    });
</script>