jQuery(document).ready(function($) {
  $('input.qty').on('change', function() {
      var item_key = $(this).data('key');
      var quantity = $(this).val();

      $.ajax({
          type: 'POST',
          url: wc_cart_params.ajax_url,
          data: {
              action: 'woocommerce_update_cart',
              item_key: item_key,
              quantity: quantity
          },
          success: function(response) {
              if (response.success) {
                  // Aktualisieren Sie den Gesamtpreis des Warenkorbs
                  $('.cart_totals .amount').text(response.data.total);
              }
          }
      });
  });
});
