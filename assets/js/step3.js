   // Dieser Code wird ausgeführt, sobald das Dokument vollständig geladen ist.
   document.addEventListener('DOMContentLoaded', function() {

    // Hier werden die Versandinformationen aus dem LocalStorage geholt.
    var shippingFirstName = localStorage.getItem('shipping_first_name');
    var shippingLastName = localStorage.getItem('shipping_last_name');
    var shippingAddress1 = localStorage.getItem('shipping_address_1');
    var shippingCity = localStorage.getItem('shipping_city');
    var shippingPostcode = localStorage.getItem('shipping_postcode');
    var shippingCountry = localStorage.getItem('shipping_country');

    // Hier werden die Rechnungsinformationen aus dem LocalStorage geholt.
    var billingFirstName = localStorage.getItem('billing_first_name');
    var billingLastName = localStorage.getItem('billing_last_name');
    var billingAddress1 = localStorage.getItem('billing_address_1');
    var billingCity = localStorage.getItem('billing_city');
    var billingPostcode = localStorage.getItem('billing_postcode');
    var billingCountry = localStorage.getItem('billing_country');

    // Hier wird die ausgewählte Zahlungsmethode und der Rabattcode aus dem LocalStorage geholt.
    var selectedPaymentMethod = localStorage.getItem('payment_method');
    console.log("Aus LocalStorage: ", selectedPaymentMethod);

    var couponCode = localStorage.getItem('coupon_code');

    // Die geholten Versandinformationen werden im Überprüfungsbereich angezeigt.
    document.getElementById('shipping-name-display').textContent = shippingFirstName + ' ' + shippingLastName;
    document.getElementById('shipping-address-display').textContent = shippingAddress1 + ', ' + shippingCity + ', ' + shippingPostcode;

    // Die geholten Rechnungsinformationen werden im Überprüfungsbereich angezeigt.
    document.getElementById('billing-name-display').textContent = billingFirstName + ' ' + billingLastName;
    document.getElementById('billing-address-display').textContent = billingAddress1 + ', ' + billingCity + ', ' + billingPostcode;

    // Hier wird versucht, den Titel und das Icon der ausgewählten Zahlungsmethode basierend auf dem Wert aus dem LocalStorage zu erhalten.
    var paymentMethodDisplay = document.getElementById('payment-method-display');
    var paymentMethodTitle = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").text();
    var paymentMethodIcon = jQuery("label[for='payment_method_" + selectedPaymentMethod + "'] img").clone();

    console.log("Gefundener Titel: ", paymentMethodTitle);
    console.log("Gefundenes Icon: ", paymentMethodIcon.length > 0 ? "Icon vorhanden" : "Kein Icon");

    // Wenn ein Icon für die Zahlungsmethode vorhanden ist, wird es zusammen mit dem Titel angezeigt.
    if (paymentMethodIcon.length) {
        paymentMethodIcon[0].style.width = '50px'; // Setzt die Breite des Icons auf 50px
        paymentMethodDisplay.innerHTML = '';
        paymentMethodDisplay.appendChild(paymentMethodIcon[0]);

        // Extrahiert den Text aus dem Label, entfernt aber das Bild-Tag
        var labelText = jQuery("label[for='payment_method_" + selectedPaymentMethod + "']").clone().children().remove().end().text().trim();
        paymentMethodDisplay.append(' ' + labelText);
    } else {
        // Wenn kein Icon vorhanden ist, wird nur der Titel angezeigt.
        paymentMethodDisplay.textContent = paymentMethodTitle;
    }

    // Der Rabattcode wird im Überprüfungsbereich angezeigt.
    document.getElementById('coupon-code-display').textContent = couponCode;

    // Funktion zum Aktualisieren der Zahlungsmethode
    document.querySelector('[data-edit="payment-method"]').addEventListener('click', function() {
        var paymentDisplay = document.getElementById('payment-method-display');
        var paymentSelect = document.getElementById('payment-method');
        var confirmButton = document.getElementById('confirm-payment-method');

        paymentDisplay.classList.add('hidden');
        paymentSelect.classList.remove('hidden');
        confirmButton.classList.remove('hidden');

        confirmButton.addEventListener('click', function() {
            var selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
            paymentDisplay.textContent = selectedOption.textContent;
            localStorage.setItem('payment_method', selectedOption.value);

            paymentDisplay.classList.remove('hidden');
            paymentSelect.classList.add('hidden');
            confirmButton.classList.add('hidden');
        });
    });

    // Funktion zum Aktualisieren des Rabattcodes
    document.querySelector('[data-edit="coupon-code"]').addEventListener('click', function() {
        var couponDisplay = document.getElementById('coupon-code-display');
        var couponInput = document.getElementById('coupon-code');
        var confirmButton = document.getElementById('confirm-coupon-code');

        couponDisplay.classList.add('hidden');
        couponInput.classList.remove('hidden');
        confirmButton.classList.remove('hidden');

        confirmButton.addEventListener('click', function() {
            couponDisplay.textContent = couponInput.value;
            localStorage.setItem('coupon_code', couponInput.value);

            couponDisplay.classList.remove('hidden');
            couponInput.classList.add('hidden');
            confirmButton.classList.add('hidden');
        });
    });
    var ajax_url = wc_add_to_cart_params.ajax_url; // WooCommerce AJAX-URL
    var cartItems = document.querySelectorAll('.wmc-cart-item');
    cartItems.forEach(function(cartItem, index) {
        // Menge ändern
        var quantitySelect = cartItem.querySelector('.wmc-cart-item-quantity');
        var priceDisplay = cartItem.querySelector('.wmc-cart-item-price');
        var productPrice = parseFloat(priceDisplay.textContent.replace(/[^0-9.,]/g, '').replace(',', '.'));

        quantitySelect.addEventListener('change', function() {
            var newQuantity = parseInt(quantitySelect.value);
            var newPrice = productPrice * newQuantity;
            priceDisplay.textContent = newPrice.toFixed(2) + ' €';

            var cartItem = event.target.closest('.wmc-cart-item');
            var productId = cartItem.dataset.productId;

            jQuery.ajax({
                type: 'POST',
                url: ajax_url,
                data: {
                    action: 'wmc_update_cart_total',
                    product_id: productId,
                    quantity: newQuantity
                },
                success: function(response) {
                    if (response.success) {
                        // Aktualisieren Sie den Gesamtpreis des Warenkorbs basierend auf der Antwort  
                    } else {
                        console.error('Fehler beim Aktualisieren des Warenkorbs: ' + response.data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Fehler beim Senden der AJAX-Anforderung:");
                    console.log("HTTP-Status: " + jqXHR.status);
                    console.log("Fehlertext: " + textStatus);
                    console.log("Ausnahme: " + errorThrown);
                    alert("Fehler beim Senden der AJAX-Anforderung. Bitte überprüfen Sie die Entwicklerkonsole für weitere Informationen.");
                }
            });
        });

        // Artikel entfernen
        var removeButton = cartItem.querySelector('.wmc-cart-item-remove');
        removeButton.addEventListener('click', function(e) {
            e.preventDefault();
            cartItem.remove();

            jQuery.post(ajax_url, {
                action: 'remove_cart_item',
                cart_key: index
            }, function(response) {
                if (response.success) {
                    console.log('Artikel erfolgreich entfernt');
                } else {
                    console.error('Fehler beim Entfernen des Artikels');
                }
            });
        });
    });
});