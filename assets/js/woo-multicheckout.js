jQuery(document).ready(function($) {
    $(document).on('change', '.quantity .qty', function() {
        var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var item_quantity = $(this).val();
        var currentVal = parseFloat(item_quantity);

        if (currentVal === "" || currentVal === "NaN") currentVal = 0;
        if (currentVal < 0) currentVal = 0;

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'update_cart',
                hash: item_hash,
                quantity: currentVal
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
