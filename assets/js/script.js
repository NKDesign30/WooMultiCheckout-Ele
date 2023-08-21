jQuery(document).ready(function($) {
    // Switch to the next step
    $('#wmc-next-step').on('click', function() {
        $('.wmc-step').hide();
        $(this).closest('.wmc-step').next('.wmc-step').show();
    });

    // Apply coupon code
    $('#wmc-apply-coupon').on('click', function() {
        var couponCode = $('#wmc-coupon-code').val();
        // Send AJAX request to apply the coupon code
    });

    // Place the order
    $('#wmc-place-order').on('click', function() {
        var shippingForm = $('#wmc-shipping-form').serialize();
        var paymentForm = $('#wmc-payment-form').serialize();
        // Send AJAX request to place the order
    });

    // Validate the inputs
    $('input, select').on('blur', function() {
        if ($(this).val() === '') {
            $(this).addClass('wmc-error');
        } else {
            $(this).removeClass('wmc-error');
        }
    });
});
