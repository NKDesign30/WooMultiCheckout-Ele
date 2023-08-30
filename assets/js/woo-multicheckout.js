jQuery(document).ready(function($) {
  $('input.qty').on('change', function() {
      var item_key = $(this).closest('.cart_item').data('key');
      var quantity = $(this).val();

      var cart_data = {};
      cart_data[item_key] = { qty: quantity };

      $.ajax({
          type: 'POST',
          url: wc_cart_params.ajax_url,
          data: {
              action: 'woocommerce_update_cart',
              cart: cart_data
          },
          success: function(response) {
              if (response.success) {
                  // Aktualisieren Sie den Gesamtpreis des Warenkorbs und andere relevante Teile
                  $.each(response.data.fragments, function(key, value) {
                      $(key).replaceWith(value);
                  });
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
