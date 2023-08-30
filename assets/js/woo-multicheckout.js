jQuery(document).ready(function($) {
  $('input.qty').on('change', function() {
      var item_key = $(this).closest('.cart_item').data('key');
      var quantity = $(this).val();

      $.ajax({
          type: 'POST',
          url: wc_cart_params.ajax_url,
          data: {
              action: 'woocommerce_update_cart',
              cart: { [item_key]: { qty: quantity } }
          },
          success: function(response) {
              if (response.success) {
                  // Aktualisieren Sie den Gesamtpreis des Warenkorbs
                  $('.cart_totals .amount').text(response.data.fragments['.cart_totals .amount']);
              } else {
                  // Fehlermeldung anzeigen
                  alert(response.data.messages);
              }
          },
          error: function() {
              alert('Es gab einen Fehler beim Aktualisieren des Warenkorbs.');
          }
      });
  });
});
