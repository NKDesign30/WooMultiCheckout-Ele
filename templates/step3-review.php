<div class="wmc-step wmc-step3">
    <h2>Schritt 3: Überprüfung</h2>
    <div class="wmc-review-section">
        <h3>Zahlungsmethode</h3>
        <p id="wmc-review-payment-method"><!-- Display selected payment method here --></p>
    </div>
    <div class="wmc-review-section">
        <h3>Rabattcode</h3>
        <p id="wmc-review-coupon-code"><!-- Display applied coupon code here --></p>
    </div>
    <div class="wmc-review-section">
        <h3>Lieferadresse</h3>
        <p id="wmc-review-shipping-address"><!-- Display shipping address here --></p>
    </div>
    <div class="wmc-review-section">
        <h3>Rechnungsadresse</h3>
        <p id="wmc-review-billing-address"><!-- Display billing address here --></p>
    </div>
    <div class="wmc-review-section">
        <h3>Bestellung</h3>
        <div id="wmc-review-order"><!-- Display order details here --></div>
    </div>
    <button type="button" id="wmc-place-order">Jetzt bestellen</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the elements from the previous steps
        var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        var couponCode = document.getElementById('coupon_code').value;
        var shippingAddress = document.getElementById('shipping_address').value;
        var billingAddress = document.getElementById('billing_address').value;
        var orderDetails = document.getElementById('order_details').innerHTML;

        // Get the placeholders in the review step
        var reviewPaymentMethod = document.getElementById('wmc-review-payment-method');
        var reviewCouponCode = document.getElementById('wmc-review-coupon-code');
        var reviewShippingAddress = document.getElementById('wmc-review-shipping-address');
        var reviewBillingAddress = document.getElementById('wmc-review-billing-address');
        var reviewOrder = document.getElementById('wmc-review-order');

        // Insert the values into the placeholders
        reviewPaymentMethod.textContent = paymentMethod;
        reviewCouponCode.textContent = couponCode;
        reviewShippingAddress.textContent = shippingAddress;
        reviewBillingAddress.textContent = billingAddress;
        reviewOrder.innerHTML = orderDetails;
    });
</script>