jQuery(document).ready(function($) {
    // Switch to the next step
    $('#wmc-next-step').on('click', function() {
        $('.wmc-step').hide();
        $(this).closest('.wmc-step').next('.wmc-step').show();
    });

    // Apply coupon code
    $('#wmc-apply-coupon').on('click', function() {
        var couponCode = $('#wmc-coupon-code').val();
        $.ajax({
            url: wmc_params.ajax_url,
            type: 'POST',
            data: {
                action: 'wmc_apply_coupon',
                coupon_code: couponCode
            },
            success: function(response) {
                // Handle the response here
            }
        });
    });

    // Place the order
    $('#wmc-place-order').on('click', function() {
        var shippingForm = $('#wmc-shipping-form').serialize();
        var paymentForm = $('#wmc-payment-form').serialize();
        $.ajax({
            url: wmc_params.ajax_url,
            type: 'POST',
            data: {
                action: 'wmc_process_checkout',
                shipping_info: shippingForm,
                payment_info: paymentForm
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                } else {
                    // Handle the error
                }
            }
        });
    });
 /*   $('input[name="cart_qty"]').on('change', function() {
        var product_id = $(this).data('product-id'); 
        var quantity = $(this).val();
    
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'wmc_update_cart_total',
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $('#cart_total').text(response.data.cart_total); 
                } else {
                    console.error("Es gab einen Fehler bei der AJAX-Anfrage:", error);
                }
            }
        });
    });
    
});*/
